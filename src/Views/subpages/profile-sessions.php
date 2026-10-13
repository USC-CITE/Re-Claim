<?php
$pageTitle = 'Persistent Sessions — WVSU Re:Claim';
$pageDescription = 'Review and revoke your remembered (persistent) login sessions.';
$canonicalUrl = APP_URL . '/profile/sessions';
$extraHead = '<script src="https://cdn.tailwindcss.com"></script>';
require __DIR__ . '/../partials/head.php';
?>
</head>

<body>

    <?php require __DIR__ . "/../mainpages/header.php"; ?>

    <main class="max-w-5xl mx-auto mt-16 px-6">
        <?php if (!empty($flash) && !empty($flash['success'])): ?>
            <div class="mb-4 max-w-2xl mx-auto p-3 bg-green-100 text-green-700 rounded-lg">
                <?= htmlspecialchars($flash['success']) ?>
            </div>
        <?php elseif (!empty($flash) && !empty($flash['error'])): ?>
            <div class="mb-4 max-w-2xl mx-auto p-3 bg-red-100 text-red-700 rounded-lg">
                <?= htmlspecialchars($flash['error']) ?>
            </div>
        <?php endif; ?>

        <header class="pb-4 mb-8">
            <a class="flex gap-2 text-md font-semibold text-[#5B5B5B] mb-6" href="/profile/settings">
                &larr; Return to Account Settings
            </a>
            <h1 class="text-4xl font-semibold">Persistent Sessions</h1>
            <p class="mt-2 text-gray-600">
                These are the devices where you checked &ldquo;Remember Me&rdquo; at login.
                Revoking a session signs that device out on its next visit.
            </p>
        </header>

        <section class="max-w-2xl mx-auto space-y-4 mb-10">
            <?php if (empty($rememberTokens)): ?>
                <p class="p-4 bg-gray-100 rounded-lg text-gray-700">
                    You have no active persistent sessions.
                </p>
            <?php else: ?>
                <?php foreach ($rememberTokens as $token): ?>
                    <?php $isCurrent = isset($currentSelector) && hash_equals((string)$currentSelector, (string)$token['selector']); ?>
                    <div class="flex items-center justify-between gap-4 p-4 border border-gray-300 rounded-lg">
                        <div>
                            <p class="font-semibold">
                                Session <?= htmlspecialchars(substr((string)$token['selector'], 0, 8)) ?>&hellip;
                                <?php if ($isCurrent): ?>
                                    <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded">This device</span>
                                <?php endif; ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                Created <?= htmlspecialchars((string)$token['created_at']) ?>
                                &middot; Expires <?= htmlspecialchars((string)$token['expires_at']) ?>
                            </p>
                        </div>
                        <form action="/profile/sessions/revoke" method="post">
                            <?php \App\Core\Router::setCsrf(); ?>
                            <input type="hidden" name="selector" value="<?= htmlspecialchars((string)$token['selector'], ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Revoke
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>

                <form action="/profile/sessions/revoke-others" method="post" class="pt-2">
                    <?php \App\Core\Router::setCsrf(); ?>
                    <button type="submit" class="px-4 py-2 border border-red-600 text-red-700 rounded-lg hover:bg-red-50">
                        Revoke all other sessions
                    </button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <?php require __DIR__ . "/../mainpages/footer.php"; ?>

</body>
</html>
