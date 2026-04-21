<!--
    * Layer: View
    * Purpose: UI rendering and templates
    * Rules: No business logic or DB access
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/auth/password_toggle.js" defer type="module"></script>
    <title>WVSU ReClaim - Login</title>
</head>

<body class="font-poppins bg-white min-h-screen flex items-center justify-center p-6 lg:p-10">
    <main class="grid grid-cols-1 lg:grid-cols-2 gap-10 w-full max-w-7xl mx-auto h-full items-center">

        <!-- Left Side: Login Form -->
        <section class="w-full max-w-105 mx-auto lg:mx-0 lg:ml-auto">
            <!-- Header -->
            <header class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <img src="/assets/reclaim-logo.svg" alt="Re:Claim Logo" class="h-20 object-contain">
                </div>
                <h1 class="text-display-md text-primary font-semibold">Welcome Back</h1>
                <p class="text-secondary text-sm">
                    Enter your credentials to log-in.
                </p>
            </header>

            <!-- Form -->
            <?php if (isset($_SESSION['error'])): ?>
            <div
                class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="/login/" class="space-y-4">
                <?php \App\Core\Router::setCsrf(); ?>
                <!-- WVSU Email Address -->
                <div>
                    <label class="text-md font-medium text-primary" for="email">WVSU Email Address</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                </div>

                <!-- Password -->
                <div>
                    <div class="mb-1.5 flex items-center">
                        <label class="text-sm font-semibold text-primary" for="password">Password</label>
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="w-full pl-4 pr-12 py-2.5 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <a href="/forgot-password/" class="text-sm font-medium text-primary-500 hover:underline">Forgot
                            password?</a>

                        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-primary">
                            Remember Me
                            <input id="remember_me" name="remember_me" type="checkbox"
                                class="h-4 w-4 rounded-xs border border-white-900 text-primary-500">
                        </label>
                    </div>
                </div>

                <!-- Legal Notice -->
                <div class="text-center text-xs text-secondary mt-6">
                    By logging in, you agree to our
                    <a href="/terms-of-service" class="text-primary-500 hover:underline font-medium">Terms of Service</a>
                    and
                    <a href="/privacy-policy" class="text-primary-500 hover:underline font-medium">Privacy Policy</a>
                </div>

                <!-- Submit Button -->
                <div class="pt-1 mt-6">
                    <button type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white-50 font-semibold rounded-2xl py-3.5 flex items-center justify-center transition-colors text-md">
                        Log-in
                        <!-- Arrow Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-8 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <footer class="mt-4 text-left text-sm text-secondary">
                No account yet? <a href="/register/" class="text-primary text-sm font-bold hover:underline">Sign up</a>
            </footer>
        </section>

        <?php require __DIR__ . '/hero_panel.php'; ?>

    </main>
</body>

</html>