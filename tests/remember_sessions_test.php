<?php
/**
 * Hermetic integration tests for Persistent Session Management (remember-me tokens).
 *
 * Requires a disposable MySQL/MariaDB — NEVER a real database:
 *   TEST_DB_HOST, TEST_DB_PORT, TEST_DB_NAME, TEST_DB_USER, TEST_DB_PASS
 *
 * Covers the 7 cases from SPEC_ReClaim_Persistent_Session_Management.md.
 * Prints one PASS/FAIL line per case; exit code 0 only when all pass.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $file = $root . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Database;
use App\Core\Router;
use App\Models\UserModel;

$failures = 0;
function check(string $name, bool $cond): void
{
    global $failures;
    echo ($cond ? 'PASS' : 'FAIL') . " - $name\n";
    if (!$cond) {
        $failures++;
    }
}

$config = [
    'db' => [
        'host' => getenv('TEST_DB_HOST') ?: '127.0.0.1',
        'port' => (int)(getenv('TEST_DB_PORT') ?: 3306),
        'name' => getenv('TEST_DB_NAME') ?: 'reclaim_test',
        'user' => getenv('TEST_DB_USER') ?: 'root',
        'pass' => getenv('TEST_DB_PASS') ?: 'testpass',
        'charset' => 'utf8mb4',
    ],
];

$model = new UserModel($config);
$pdo = Database::connect($config['db']);
$pdo->exec('DROP TABLE IF EXISTS user_remember_tokens');

$u1 = 101;
$u2 = 102;
$future = date('Y-m-d H:i:s', time() + 86400);
$past = date('Y-m-d H:i:s', time() - 3600);
$hash = hash('sha256', 'validator');

$model->storeRememberToken($u1, 'sel-a', $hash, $future);
$model->storeRememberToken($u1, 'sel-b', $hash, $future);
$model->storeRememberToken($u1, 'sel-c', $hash, $future);
$model->storeRememberToken($u2, 'sel-d', $hash, $future);
$model->storeRememberToken($u1, 'sel-expired', $hash, $past);

// Case 1: list shows only the owner's live tokens, and never leaks validator_hash.
$list = $model->listRememberTokensByUserId($u1);
$selectors = array_column($list, 'selector');
sort($selectors);
check('1. list returns only own live tokens, no validator_hash',
    $selectors === ['sel-a', 'sel-b', 'sel-c']
    && !array_key_exists('validator_hash', $list[0]));

// Case 2: revoking an own token deletes it.
check('2. revoke own token deletes it',
    $model->deleteRememberTokenForUser($u1, 'sel-b') === true
    && $model->findRememberTokenBySelector('sel-b') === null);

// Case 3: revoking another user's selector fails and deletes nothing.
check('3. revoke other user token is refused',
    $model->deleteRememberTokenForUser($u1, 'sel-d') === false
    && $model->findRememberTokenBySelector('sel-d') !== null);

// Case 4: revoke-all-others keeps only the current selector.
// (u1 holds sel-c live + sel-expired at this point, so 2 rows are deleted.)
$deleted = $model->deleteOtherRememberTokens($u1, 'sel-a');
$remaining = array_column($model->listRememberTokensByUserId($u1), 'selector');
check('4. revoke-all-others keeps current session only',
    $deleted === 2 && $remaining === ['sel-a']);

// Case 5: prune removes expired tokens and nothing else.
$model->storeRememberToken($u2, 'sel-expired-2', $hash, $past);
$pruned = $model->pruneExpiredRememberTokens();
$expiredRows = (int)$pdo->query("SELECT COUNT(*) FROM user_remember_tokens WHERE expires_at <= NOW()")->fetchColumn();
check('5. prune removes expired tokens only',
    $pruned >= 1 && $expiredRows === 0
    && $model->findRememberTokenBySelector('sel-a') !== null
    && $model->findRememberTokenBySelector('sel-d') !== null);

// Case 6 (subprocess): unauthenticated request to the sessions page is
// redirected before any output/DB work — the guard script must not survive.
$guardOut = [];
$guardCode = 0;
exec(PHP_BINARY . ' ' . escapeshellarg(__DIR__ . '/guard_sessions_test.php') . ' 2>&1', $guardOut, $guardCode);
check('6. unauthenticated sessions page is blocked by auth guard',
    !in_array('MARKER_ALIVE', $guardOut, true));

// Case 7: CSRF gate used by Router::dispatch and the revoke handlers.
$_SESSION['csrf'] = 'expected-token';
$_POST['csrf'] = 'wrong-token';
$badCsrf = Router::isCsrfValid();
$_POST['csrf'] = 'expected-token';
$goodCsrf = Router::isCsrfValid();
$_POST = [];
$missingCsrf = Router::isCsrfValid();
check('7. CSRF validation rejects bad/missing, accepts correct',
    $badCsrf === false && $missingCsrf === false && $goodCsrf === true);

echo $failures === 0 ? "ALL 7 TESTS PASSED\n" : "$failures TEST(S) FAILED\n";
exit($failures === 0 ? 0 : 1);
