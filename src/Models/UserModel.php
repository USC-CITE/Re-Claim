<?php
/**
 * Layer: Model
 * Purpose: Database logic and data handling
 * Rules: No HTTP or view rendering logic; DB logic only
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class UserModel {
    private PDO $db;

    public function __construct(array $config){
        $this->db = Database::connect($config['db']);
    }

    public function create(array $data): int {
        $sql = "INSERT INTO users (first_name, last_name, wvsu_email, password, phone_number, social_link, email_verified, verification_code, verification_expiry) 
                VALUES (:first, :last, :email, :password, :phone, :social, 0, :v_code, :v_expiry)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'first'    => $data['first_name'],
            'last'     => $data['last_name'],
            'email'    => $data['email'],
            'password' => $data['hashedPass'],
            'phone'    => $data['phone_number'] ?? '',
            'social' => $data['social_link'],
            'v_code' => $data['v_code_hashed'],
            'v_expiry' => $data['v_code_expiry']
        ]);
        
        return (int)$this->db->lastInsertId();
    }

    function findByEmail(string $email): ?array{
        // Query the database and return the row of that email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE wvsu_email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    function findById(string $id): ?array{
        // Query the database and return the row of that email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    function verifyOtp(string $email, string $otp): bool{

        // We utilized our findByEmail helper function
        $user = $this->findByEmail($email);

        // If user does not exist
        if(!$user){
            return false;
        }

        // If otp exceeds time expiration
        if($user['verification_expiry'] < date('Y-m-d H:i:s')) return false;

        // If otp sent by user does not match from the otp that we generated
        if(!password_verify($otp, $user['verification_code'])) return false;

        $stmt = $this->db->prepare("
            UPDATE users SET email_verified = 1, verification_code = NULL, verification_expiry = NULL 
            WHERE wvsu_email = :email
        ");
        return $stmt->execute(['email' => $email]);
    }

    public function updateOtp(string $email, string $hashed, string $expires): bool {
        $stmt = $this->db->prepare(
            "UPDATE users SET verification_code = :code, verification_expiry = :expiry WHERE wvsu_email = :email"
        );

        return $stmt->execute([
            'code' => $hashed,
            'expiry' => $expires,
            'email' => $email
        ]);
    }

    public function fetchItems(int $id, string $type){

        $stmt = $this->db->prepare(
            "SELECT * FROM lost_and_found_items
             WHERE user_id = :id
               AND item_type = :type
               AND is_archived = 0
             ORDER BY created_at DESC"
        );

        $stmt->execute([
            'id' => $id,
            'type' => $type
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function fetchArchivedItems(int $id): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM lost_and_found_items
             WHERE user_id = :id
               AND is_archived = 1
             ORDER BY created_at DESC"
        );

        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOwnedArchivedItemsByIds(int $userId, array $itemIds): array
    {
        if (empty($itemIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($itemIds), '?'));
        $stmt = $this->db->prepare(
            "SELECT id, image_path
             FROM lost_and_found_items
             WHERE user_id = ?
               AND is_archived = 1
               AND id IN ($placeholders)"
        );

        $stmt->execute(array_merge([$userId], array_values($itemIds)));

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function deleteArchivedItems(int $userId, array $itemIds): int
    {
        if (empty($itemIds)) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($itemIds), '?'));
        $stmt = $this->db->prepare(
            "DELETE FROM lost_and_found_items
             WHERE user_id = ?
               AND is_archived = 1
               AND id IN ($placeholders)"
        );

        $stmt->execute(array_merge([$userId], array_values($itemIds)));

        return $stmt->rowCount();
    }

    public function updateFullProfile($userId, $data) {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET first_name = ?, last_name = ?, phone_number = ?, social_link = ?, avatar_path = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['phone_number'],
            $data['social_link'],
            $data['avatar_path'],
            $userId
        ]);
    }

    public function getAvatar(int $userId){
        $stmt = $this->db->prepare("SELECT avatar_path FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $avatar = $stmt->fetchColumn();

        return $avatar ?: null;
    }

    public function updatePassword(int $userId, string $password){
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$password, $userId]);
    }

    public function deleteUser(int $userId){
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    public function deleteSocialLinks($userId){
        $stmt = $this->db->prepare("DELETE from users_social_links WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    public function addSocialLinks($userId, $link){
        $stmt = $this->db->prepare(
            "INSERT INTO users_social_links (user_id, social_link) VALUES (?, ?)"
        );
        return $stmt->execute([$userId, $link]);
    }

    public function getSocialLinks($userId){
        $stmt = $this->db->prepare("SELECT social_link FROM users_social_links WHERE user_id = ?");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Store a password-reset token (hashed) with an expiry timestamp. */
    public function storeResetToken(string $email, string $hashedToken, string $expires): bool {
        $stmt = $this->db->prepare(
            "UPDATE users SET verification_code = :token, verification_expiry = :expiry WHERE wvsu_email = :email"
        );

        return $stmt->execute([
            'token'  => $hashedToken,
            'expiry' => $expires,
            'email'  => $email
        ]);
    }

    /* get user whose reset token matches and has not expired. */
    public function findByResetToken(string $token): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE verification_expiry > :now AND verification_code IS NOT NULL"
        );
        $stmt->execute(['now' => date('Y-m-d H:i:s')]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($token, $row['verification_code'])) {
                return $row;
            }
        }

        return null;
    }

    /* Clear the reset token after a successful password change. */
    public function clearResetToken(int $userId): bool {
        $stmt = $this->db->prepare(
            "UPDATE users SET verification_code = NULL, verification_expiry = NULL WHERE id = ?"
        );

        return $stmt->execute([$userId]);
    }

    public function initRememberTokensTable(): void {
        $sql = "CREATE TABLE IF NOT EXISTS user_remember_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            selector VARCHAR(64) NOT NULL UNIQUE,
            validator_hash VARCHAR(128) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_selector (selector)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->exec($sql);
    }

    public function storeRememberToken(int $userId, string $selector, string $validatorHash, string $expiresAt): bool {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare(
            "INSERT INTO user_remember_tokens (user_id, selector, validator_hash, expires_at) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$userId, $selector, $validatorHash, $expiresAt]);
    }

    public function findRememberTokenBySelector(string $selector): ?array {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare(
            "SELECT * FROM user_remember_tokens WHERE selector = ? AND expires_at > NOW() LIMIT 1"
        );
        $stmt->execute([$selector]);
        $token = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $token ?: null;
    }

    public function deleteRememberTokenBySelector(string $selector): bool {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare("DELETE FROM user_remember_tokens WHERE selector = ?");
        return $stmt->execute([$selector]);
    }

    public function deleteRememberTokensByUserId(int $userId): bool {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare("DELETE FROM user_remember_tokens WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    /* List a user's live remember-me tokens. Never exposes validator_hash. */
    public function listRememberTokensByUserId(int $userId): array {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare(
            "SELECT id, selector, expires_at, created_at FROM user_remember_tokens WHERE user_id = ? AND expires_at > NOW() ORDER BY created_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /* Delete one token only when it belongs to the given user (ownership check). */
    public function deleteRememberTokenForUser(int $userId, string $selector): bool {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare("DELETE FROM user_remember_tokens WHERE selector = ? AND user_id = ?");
        $stmt->execute([$selector, $userId]);
        return $stmt->rowCount() > 0;
    }

    /* Delete all of a user's tokens except the kept selector. Returns rows deleted. */
    public function deleteOtherRememberTokens(int $userId, ?string $keepSelector): int {
        $this->initRememberTokensTable();
        if ($keepSelector !== null && $keepSelector !== '') {
            $stmt = $this->db->prepare("DELETE FROM user_remember_tokens WHERE user_id = ? AND selector <> ?");
            $stmt->execute([$userId, $keepSelector]);
        } else {
            $stmt = $this->db->prepare("DELETE FROM user_remember_tokens WHERE user_id = ?");
            $stmt->execute([$userId]);
        }
        return $stmt->rowCount();
    }

    /* Delete every expired token. Returns rows deleted. */
    public function pruneExpiredRememberTokens(): int {
        $this->initRememberTokensTable();
        $stmt = $this->db->prepare("DELETE FROM user_remember_tokens WHERE expires_at <= NOW()");
        $stmt->execute();
        return $stmt->rowCount();
    }
}


