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

            <form method="POST" action="/login" class="space-y-5">
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

                <!-- Submit Button -->
                <div class="pt-1">
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

        <!-- Right Side: Hero Panel -->
        <aside
            class="hidden lg:flex flex-col justify-center items-center bg-primary-600 rounded-[40px] p-10 min-h-[700px] h-full relative overflow-hidden">
            <!-- Background Elements -->
            <img src="/assets/reclaim-logo.svg" alt="" class="absolute -top-52 -left-40 w-full h-full object-contain opacity-3 pointer-events-none scale-60 transform brightness-0 invert">

            <div class="relative z-10 w-[90%]">
                <h2 class="text-white text-display-sm leading-tight font-medium">
                    Seamlessly Track and Recover Your Belongings
                </h2>
            </div>

            <div class="relative w-full max-w-lg mt-8 mb-auto h-full min-h-[450px]">

                <!-- Bottom Left Card - Calculator -->
                <div class="absolute left-0 bottom-4 w-72 bg-white rounded-3xl p-5 shadow-2xl z-10 
                            transform transition-transform duration-500 hover:-translate-y-2">
                    <!-- Profile Logo -->
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35"
                                fill="none">
                                <g clip-path="url(#clip0_1293_265)">
                                    <rect width="34.0561" height="34.0561" rx="17.028" fill="#055BA8" />
                                    <path
                                        d="M16.5743 18.3622C19.6979 18.3622 22.23 15.7702 22.23 12.5727C22.23 9.37525 19.6979 6.78319 16.5743 6.78319C13.4507 6.78319 10.9185 9.37525 10.9185 12.5727C10.9185 15.7702 13.4507 18.3622 16.5743 18.3622Z"
                                        fill="#E6EFF6" />
                                    <path
                                        d="M3.37756 35.7308C3.37756 28.2701 9.28594 22.2219 16.5743 22.2219C23.8626 22.2219 29.771 28.2701 29.771 35.7308H3.37756Z"
                                        fill="#E6EFF6" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1293_265">
                                        <rect width="34.0561" height="34.0561" rx="17.028" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-primary text-sm leading-tight">
                                <span class="text-red-500">[Lost]</span> Pink Casio Calculator
                            </h4>
                            <p class="text-xs mt-0.5">February 6, 2026</p>
                        </div>
                    </div>
                    <!-- Image -->
                    <div class="w-full h-36 bg-gray-100 rounded-xl mb-3 overflow-hidden">
                        <img src="/assets/Calculator.png" alt="Lost pink calculator" class="w-full h-full object-cover">
                    </div>
                    <!-- Location -->
                    <div class="flex items-start gap-1.5 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 text-primary mt-0.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <p class="text-xs font-medium text-primary">Last seen at CICT Sheds</p>
                    </div>

                    <p class="text-[10px] text-justify text-primary leading-tight mb-4">
                        Pink Casio scientific calculator. It has a few minor scratches on the hard cover. Left on a desk
                        in the CICT Sheds after a morning class.
                    </p>

                    <button
                        class="w-full bg-primary-600 text-white rounded-xl py-2 text-xs font-medium flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                        Contact Owner
                    </button>

                </div>

                <!-- Top Right Card - Fan -->
                <div class="absolute right-0 top-0 w-72 bg-white rounded-3xl p-5 shadow-2xl z-20
                            transform transition-transform duration-500 hover:-translate-y-2">

                    <!-- Profile Logo -->
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35"
                                fill="none">
                                <g clip-path="url(#clip0_1293_265)">
                                    <rect width="34.0561" height="34.0561" rx="17.028" fill="#055BA8" />
                                    <path
                                        d="M16.5743 18.3622C19.6979 18.3622 22.23 15.7702 22.23 12.5727C22.23 9.37525 19.6979 6.78319 16.5743 6.78319C13.4507 6.78319 10.9185 9.37525 10.9185 12.5727C10.9185 15.7702 13.4507 18.3622 16.5743 18.3622Z"
                                        fill="#E6EFF6" />
                                    <path
                                        d="M3.37756 35.7308C3.37756 28.2701 9.28594 22.2219 16.5743 22.2219C23.8626 22.2219 29.771 28.2701 29.771 35.7308H3.37756Z"
                                        fill="#E6EFF6" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1293_265">
                                        <rect width="34.0561" height="34.0561" rx="17.028" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>

                        <div>
                            <h4 class="font-semibold text-primary text-sm leading-tight">
                                <span class="text-red-500">[Lost]</span> White Portable Fan
                            </h4>
                            <p class="text-xs mt-0.5">March 7, 2026</p>
                        </div>
                    </div>

                    <div class="w-full h-36 bg-gray-100 rounded-xl mb-3 overflow-hidden">
                        <img src="/assets/Minifan.png" alt="White portable fan" class="w-full h-full object-cover">
                    </div>

                    <div class="flex items-start gap-1.5 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 text-primary mt-0.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <p class="text-xs font-medium text-primary">Last seen at Mini-Forest</p>
                    </div>

                    <p class="text-[10px] text-justify text-primary leading-tight mb-4">
                        White Firefly handheld portable fan with a digital battery display. It has a distinctive light
                        blue, white, and yellow beaded lanyard attached to the handle.
                    </p>

                    <button
                        class="w-full bg-primary-600 text-white rounded-xl py-2 text-xs font-medium flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                        Contact Owner
                    </button>

                </div>
            </div>

            <!-- Footer Logos -->
            <div class="mt-auto pt-8 flex w-full flex-col items-center">
                <img src="/assets/spark-cite.svg" alt="Spark Cite Logo" class="mb-4 brightness-0 invert h-14">
                <p class="text-white text-sm font-normal">Re:Claim is a collaborative effort between SPARK Hub and
                    USC-CITE.</p>
            </div>

        </aside>

    </main>
</body>

</html>