<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>WVSU ReClaim</title>
</head>
<body>
    <main class="container">
        <header style="display:flex; justify-content:space-between; align-items:center;">

            <div style="display:flex; align-items:center; gap:1rem;">
                <!-- Temporary Placeholder for avatar -->
                <img src="/images/profile.jpg"
                    alt="Profile"
                    width="60"
                    height="60"
                    style="border-radius:50%; object-fit:cover;">

                <div>
                    <strong>
                        <?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?>
                    </strong>
                    <br>
                    <p><?= htmlspecialchars($_SESSION['wvsu_email'] ?? '') ?></p>
                </div>
            </div>

            <a href="/profile/edit" role="button">
                Edit Profile
            </a>

        </header>
    </main>
</body>
</html>