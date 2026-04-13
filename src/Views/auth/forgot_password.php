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
    <title>WVSU ReClaim - Forgot Password</title>
</head>

<body class="font-poppins bg-white min-h-screen flex items-center justify-center p-6 lg:p-10">
    <main class="grid grid-cols-1 lg:grid-cols-2 gap-10 w-full max-w-7xl mx-auto h-full items-center">

        <!-- Left Side: Forgot Password Form -->
        <section class="w-full max-w-105 mx-auto lg:mx-0 lg:ml-auto">
            <!-- Header -->
            <header class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="73" height="73" viewBox="0 0 73 73" fill="none">
                        <rect width="73" height="73" rx="36.5" fill="#055BA8" />
                        <path
                            d="M15.1818 50V45.6667H58.8182V50H15.1818ZM17.6909 36.8917L14.8545 35.2667L16.7091 32.0167H13V28.7667H16.7091L14.8545 25.625L17.6909 24L19.5455 27.1417L21.4 24L24.2364 25.625L22.3818 28.7667H26.0909V32.0167H22.3818L24.2364 35.2667L21.4 36.8917L19.5455 33.6417L17.6909 36.8917ZM35.1455 36.8917L32.3091 35.2667L34.1636 32.0167H30.4545V28.7667H34.1636L32.3091 25.625L35.1455 24L37 27.1417L38.8545 24L41.6909 25.625L39.8364 28.7667H43.5455V32.0167H39.8364L41.6909 35.2667L38.8545 36.8917L37 33.6417L35.1455 36.8917ZM52.6 36.8917L49.7636 35.2667L51.6182 32.0167H47.9091V28.7667H51.6182L49.7636 25.625L52.6 24L54.4545 27.1417L56.3091 24L59.1455 25.625L57.2909 28.7667H61V32.0167H57.2909L59.1455 35.2667L56.3091 36.8917L54.4545 33.6417L52.6 36.8917Z"
                            fill="white" />
                    </svg>
                </div>
                <h1 class="text-display-md text-primary font-semibold">Forgot Password?</h1>
                <p class="text-secondary text-sm">
                    Please enter your WVSU email for password reset.
                </p>
            </header>

            <!-- Form -->
            <form method="POST" action="/forgot-password" class="space-y-5">
                <!-- WVSU Email Address -->
                <div>
                    <label class="text-md font-medium text-primary" for="email">WVSU Email Address</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                </div>

                <!-- Submit Button -->
                <div class="pt-1">
                    <button type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white-50 font-semibold rounded-2xl py-3.5 flex items-center justify-center transition-colors text-md">
                        Reset Password
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
                Password remembered? <a href="/login/" class="text-primary text-sm font-bold hover:underline">Log-in</a>
            </footer>
        </section>

        <?php require __DIR__ . '/hero_panel.php'; ?>
    </main>
</body>

</html>