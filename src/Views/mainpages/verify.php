<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Page</title>
</head>
<body>
    
    <form method="POST" action="/verify">
        <h2>Enter OTP</h2>
        <p>Please enter the verification code we sent to <strong><?= htmlspecialchars($_SESSION['pending_email'] ?? '') ?></strong></p> 
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify</button>
    </form>

    <form method="POST" action="/resend-otp">
        <b>
            <?= htmlspecialchars($_SESSION['resend_message'] ?? '') ?>
            <?php unset($_SESSION['resend_message']); ?>
        </b>
        <br>
        <button type="submit">Resend OTP</button>
    </form>
</body>
</html>