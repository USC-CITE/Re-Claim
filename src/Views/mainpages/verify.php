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
        <input type="text" name="verification_code" placeholder="Enter OTP" required>
        <button type="submit">Verify</button>
    </form>

</body>
</html>