
<?php
$pageTitle = 'OTP Verification - WVSU Re:Claim';
$pageDescription = 'Verify your account using the one-time passcode sent to you.';
$canonicalUrl = APP_URL . '/verify';
$extraHead = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@latest/css/pico.min.css">';
require __DIR__ . '/../partials/head.php';
?>
<body>
    <main class="container">
        <form method="POST" action="/verify" class="space-y-6">
            <?php \App\Core\Router::setCsrf(); ?>
            <h2>Enter OTP</h2>
            <p>Please enter the verification code we sent to <strong><?= htmlspecialchars($_SESSION['pending_email'] ?? '') ?></strong></p> 
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify</button>
        </form>

        <div class="timer" id="timer"></div>
        <!-- To safely pass PHP data to JS -->
        <div 
            id="otp-data"
            data-expires="<?= isset($_SESSION['otp_expires_at']) 
                ? strtotime($_SESSION['otp_expires_at']) * 1000 
                : '' ?>">
        </div>

        <form method="POST" action="/resend-otp">
            <?php \App\Core\Router::setCsrf(); ?>
            <b>
                <?= htmlspecialchars($_SESSION['resend_message'] ?? '') ?>
                <?php unset($_SESSION['resend_message']); ?>    
            </b>
            <br>
            <button type="submit" id="resend-btn" class="resend">Resend OTP</button>
        </form>
    </main>


    <script src="/js/verify/index.js"></script>
</body>
</html>