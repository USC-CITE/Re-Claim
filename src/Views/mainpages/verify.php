
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@latest/css/pico.min.css">
    <title>WVSU ReClaim: OTP Verification</title>
</head>
<body>
    <main class="container">
        <form method="POST" action="/verify">
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