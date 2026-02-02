
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

    <div class="timer" id="timer"></div>

    <form method="POST" action="/resend-otp">
        <b>
            <?= htmlspecialchars($_SESSION['resend_message'] ?? '') ?>
            <?php unset($_SESSION['resend_message']); ?>    
        </b>
        <br>
        <button type="submit" id="resendBtn" class="resend">Resend OTP</button>
    </form>

    <script>
        let expiresAt = <?= $expiresAt ? strtotime($expiresAt) * 1000 : 'null' ?>;

        const timerEl   = document.getElementById('timer');
        const resendBtn = document.getElementById('resendBtn');

        function updateTimer() {
            if (!expiresAt) return;

            const now = Date.now();
            let diff = Math.floor((expiresAt - now) / 1000);

            if (diff <= 0) {
                timerEl.textContent = "OTP expired.";
                resendBtn.classList.add('active');
                return;
            }

            const mins = Math.floor(diff / 60);
            const secs = diff % 60;
            timerEl.textContent = `OTP expires in ${mins}:${secs.toString().padStart(2,'0')}`;
        }

        setInterval(updateTimer, 1000);
        updateTimer();
    </script>
</body>
</html>