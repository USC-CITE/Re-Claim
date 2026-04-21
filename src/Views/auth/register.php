<!--
    * Layer: View
    * Purpose: UI rendering and templates
    * Rules: No business logic or DB access
-->
<?php 
    $errors = $_SESSION['errors'] ?? [];

    unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/auth/password_toggle.js" defer type="module"></script>
    <title>WVSU ReClaim - Create Account</title>
</head>
<body class="font-poppins bg-white min-h-screen flex items-center justify-center p-6 lg:p-10">
    <main class="grid grid-cols-1 lg:grid-cols-2 gap-10 w-full max-w-7xl mx-auto h-full items-center">
        
        <!-- Left Side: Registration Form -->
        <section class="w-full max-w-sm mx-auto lg:mx-0 lg:ml-auto pr-2 custom-scrollbar">
            <!-- Header -->
            <header class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <img src="/assets/reclaim-logo.svg" alt="Re:Claim Logo" class="h-16 object-contain">
                </div>
                <h1 class="text-display-md text-primary font-semibold">Create Account</h1>
                <p class="text-secondary text-sm px-10">
                    Welcome to Re:Claim! Enter your information below to sign-up.
                </p>
            </header>

            <!-- Form -->
            <form method="POST" action="/register/" class="space-y-4">
                <!-- Names Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-primary" for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" required
                               class="w-full px-4 py-2 text-sm border <?= !empty($errors['first_name']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                        <p class="text-sm text-red-500">
                            <?= $errors['first_name'] ?? '' ?>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-primary" for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" required
                               class="w-full px-4 py-2 text-sm border <?= !empty($errors['last_name']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                        <p class="text-sm text-red-500">
                            <?= $errors['last_name'] ?? '' ?>
                        </p>
                    </div>
                </div>

                <!-- WVSU Email Address -->
                <div>
                    <label class="text-sm font-semibold text-primary" for="email">WVSU Email Address</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 text-sm border <?= !empty($errors['wvsu_email']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                    <p class="text-sm text-red-500">
                        <?= $errors['wvsu_email'] ?? '' ?>
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label class="text-sm font-semibold text-primary" for="password">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               class="w-full pl-4 pr-12 py-2 text-sm border <?= !empty($errors['password']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                    </div>
                    <p class="text-sm text-red-500">
                        <?= $errors['password'] ?? '' ?>
                    </p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-sm font-semibold text-primary" for="confirm-pass">Confirm Password</label>
                    <div class="relative">
                        <input id="confirm-password" type="password" name="confirm-pass" required
                               class="w-full pl-4 pr-12 py-2 text-sm border <?= !empty($errors['confirm_pass']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                       
                    </div>
                    <p class="text-sm text-red-500">
                        <?= $errors['confirm_pass'] ?? '' ?>
                    </p>
                </div>

                <!-- Phone and Social Media Link Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-primary" for="phone-num">Mobile Phone No.</label>
                        <input type="tel" name="phone-num" id="phone-num" placeholder="09XXXXXXXX" required
                               class="w-full px-4 py-2 text-sm border <?= !empty($errors['phone_number']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                        <p class="text-sm text-red-500">
                            <?= $errors['phone_number'] ?? '' ?>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-primary" for="social-link">Social Media Link</label>
                        <input type="url" name="social-link" id="social-link" required
                               class="w-full px-4 py-2 text-sm border <?= !empty($errors['social_link']) ? 'border-red-500 border-2' : 'border-white-700' ?> rounded-lg bg-white placeholder-secondary">
                        <p class="text-sm text-red-500">
                            <?= $errors['social_link'] ?? '' ?>
                        </p>
                    </div>
                </div>

                <!-- Legal Notice -->
                <div class="text-center text-xs text-secondary mt-4">
                    By creating an account, you agree to our
                    <a href="/terms-of-service" class="text-primary-500 hover:underline font-medium">Terms of Service</a>
                    and
                    <a href="/privacy-policy" class="text-primary-500 hover:underline font-medium">Privacy Policy</a>
                </div>

                <!-- Submit Button -->
                <div class="pt-2 mt-4">
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white-50 font-semibold rounded-2xl py-3 flex items-center justify-center transition-colors text-md">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <footer class="mt-4 text-left text-sm text-secondary">
                Already have an account? <a href="/login/" class="text-primary text-sm font-bold hover:underline">Log in</a>
            </footer>
        </section>

        <?php require __DIR__ . '/hero_panel.php'; ?>
        
    </main>
</body>
</html>
