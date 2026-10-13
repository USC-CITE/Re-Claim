<!--
    * Layer: View
    * Purpose: UI rendering and templates
    * Rules: No business logic or DB access
-->

<?php
$pageTitle = 'Verify Email - WVSU Re:Claim';
$pageDescription = 'Verify your account using the one-time passcode sent to you.';
$canonicalUrl = APP_URL . '/verify';
$extraHead = '<link rel="stylesheet" href="/css/app.css">';
require __DIR__ . '/../partials/head.php';
?>

<body class="font-poppins bg-white min-h-screen flex items-center justify-center p-6 lg:p-10">

    <main class="grid grid-cols-1 lg:grid-cols-2 gap-10 w-full max-w-7xl mx-auto h-full items-center">

        <!-- Left Side: Verification Form -->
        <section class="w-full max-w-105 mx-auto lg:mx-0 lg:ml-auto">

            <!-- Header -->
            <header class="text-center mb-6">

                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="73"
                        height="73"
                        viewBox="0 0 73 73"
                        fill="none">

                        <rect
                            width="73"
                            height="73"
                            rx="36.5"
                            fill="#055BA8" />

                        <path
                            d="M15.1818 50V45.6667H58.8182V50H15.1818ZM17.6909 36.8917L14.8545 35.2667L16.7091 32.0167H13V28.7667H16.7091L14.8545 25.625L17.6909 24L19.5455 27.1417L21.4 24L24.2364 25.625L22.3818 28.7667H26.0909V32.0167H22.3818L24.2364 35.2667L21.4 36.8917L19.5455 33.6417L17.6909 36.8917ZM35.1455 36.8917L32.3091 35.2667L34.1636 32.0167H30.4545V28.7667H34.1636L32.3091 25.625L35.1455 24L37 27.1417L38.8545 24L41.6909 25.625L39.8364 28.7667H43.5455V32.0167H39.8364L41.6909 35.2667L38.8545 36.8917L37 33.6417L35.1455 36.8917ZM52.6 36.8917L49.7636 35.2667L51.6182 32.0167H47.9091V28.7667H51.6182L49.7636 25.625L52.6 24L54.4545 27.1417L56.3091 24L59.1455 25.625L57.2909 28.7667H61V32.0167H57.2909L59.1455 35.2667L56.3091 36.8917L54.4545 33.6417Z"
                            fill="white" />
                    </svg>
                </div>

                <h1 class="text-display-md text-primary font-semibold mb-1">
                    Verify Your Email
                </h1>

                <p class="text-secondary text-sm">
                    Enter the verification code sent to your email.
                </p>

            </header>


            <!-- Error Message -->
            <?php if (isset($_SESSION['error'])): ?>

                <div
                    class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5 shrink-0">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />

                    </svg>

                    <span>
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </span>

                </div>

                <?php unset($_SESSION['error']); ?>

            <?php endif; ?>


            <!-- Success Message -->
            <?php if (isset($_SESSION['success'])): ?>

                <div class="flex justify-center mb-4">
                    <div class="w-[73px] h-[73px] rounded-full bg-primary-500 flex items-center justify-center">
                        <svg
                            width="40"
                            height="39"
                            viewBox="0 0 40 39"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M1.50024 33.4082V15.1392C1.50024 13.7711 2.18722 12.4936 3.33092 11.7347L17.7198 2.18721C19.1007 1.27093 20.8998 1.27093 22.2807 2.18721L36.6696 11.7347C37.8133 12.4936 38.5002 13.7711 38.5002 15.1392V33.4082M1.50024 33.4082C1.50024 35.6681 3.34085 37.5 5.61136 37.5H34.3891C36.6596 37.5 38.5002 35.6681 38.5002 33.4082M1.50024 33.4082L15.3752 24.2018M38.5002 33.4082L24.6252 24.2018M1.50024 14.9953L15.3752 24.2018M15.3752 24.2018L17.7198 25.7574C19.1007 26.6737 20.8998 26.6737 22.2807 25.7574L24.6252 24.2018L38.5002 14.9953"
                                stroke="white"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                </div>

                <?php unset($_SESSION['success']); ?>

            <?php endif; ?>


            <!-- Verification Form -->
            <form method="POST" action="/verify" class="space-y-4">

                <?php \App\Core\Router::setCsrf(); ?>

                <!-- Email -->
                <div class="text-center">
                    <p class="text-sm text-secondary mb-1">
                        Verification code sent to
                    </p>

                    <p class="text-sm font-bold text-primary break-all">
                        <?= htmlspecialchars($_SESSION['pending_email'] ?? '') ?>
                    </p>
                </div>

                <!-- OTP -->
                <div>
                    <label
                        class="text-md font-medium text-primary"
                        for="otp">
                        Verification Code
                    </label>

                    <input
                        type="text"
                        name="otp"
                        id="otp"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        placeholder="Enter your 6-digit code"
                        required
                        class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                </div>


                <!-- Timer -->
                <div
                    id="timer"
                    class="text-center text-sm text-secondary">
                </div>

                <!-- OTP expiration data -->
                <div
                    id="otp-data"
                    data-expires="<?= isset($_SESSION['otp_expires_at'])
                        ? strtotime($_SESSION['otp_expires_at']) * 1000
                        : '' ?>">
                </div>


                <!-- Verify Button -->
                <div class="pt-1">

                    <button
                        type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white-50 font-semibold rounded-2xl py-3.5 flex items-center justify-center transition-colors text-md">

                        Verify Email

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                            stroke="currentColor"
                            class="w-8 h-5 ml-2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />

                        </svg>

                    </button>

                </div>

            </form>


            <!-- Resend OTP -->
            <form
                method="POST"
                action="/resend-otp"
                class="mt-4 text-left text-sm text-secondary">

                <?php \App\Core\Router::setCsrf(); ?>

                <span>
                    Didn't receive the code?
                </span>

                <button
                    type="submit"
                    id="resend-btn"
                    class="resend text-primary font-bold hover:underline">

                    Resend OTP

                </button>

            </form>


        </section>


        <!-- Right Side -->
        <?php require __DIR__ . '/../../auth/hero_panel.php'; ?>

    </main>


    <!-- Verification JavaScript -->
    <script src="/js/verify/index.js"></script>

</body>

</html>