<?php 
if(!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WVSU ReClaim</title>
</head>
<body>
        
    <h1>Welcome to WVSU ReClaim</h1>
</body>
</html>