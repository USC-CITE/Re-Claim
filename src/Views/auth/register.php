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
    <script src="/js/auth/password-toggle.js" defer type="module"></script>
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
            <form method="POST" action="/register" class="space-y-4">
                <!-- Names Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-primary" for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" required
                               class="w-full px-4 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-primary" for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" required
                               class="w-full px-4 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                </div>

                <!-- WVSU Email Address -->
                <div>
                    <label class="text-sm font-semibold text-primary" for="email">WVSU Email Address</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                </div>

                <!-- Password -->
                <div>
                    <label class="text-sm font-semibold text-primary" for="password">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required 
                               class="w-full pl-4 pr-12 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-sm font-semibold text-primary" for="confirm-pass">Confirm Password</label>
                    <div class="relative">
                        <input id="confirm-password" type="password" name="confirm-pass" required
                               class="w-full pl-4 pr-12 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                </div>

                <!-- Phone and Social Media Link Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-primary" for="phone-num">Mobile Phone No.</label>
                        <input type="text" name="phone-num" id="phone-num" required
                               class="w-full px-4 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-primary" for="social-link">Social Media Link</label>
                        <input type="text" name="social-link" id="social-link" required
                               class="w-full px-4 py-2 text-sm border border-white-700 rounded-lg bg-white placeholder-secondary">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
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
                Already have an account? <a href="/login" class="text-primary text-sm font-bold hover:underline">Log in</a>
            </footer>
        </section>

        <!-- Right Side: Hero Panel -->
        <aside class="hidden lg:flex flex-col justify-start bg-primary-600 rounded-[40px] p-20 min-h-[700px] h-full relative overflow-hidden">
            <!-- Background Logo Watermark -->
            <div class="absolute -top-52 -left-40 w-full h-full pointer-events-none scale-60 transform opacity-3 bg-white"
                 style="-webkit-mask-image: url('/assets/reclaim-logo.svg'); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; mask-image: url('/assets/reclaim-logo.svg'); mask-size: contain; mask-repeat: no-repeat;">
            </div>
            
            <div class="relative z-10">
                <h2 class="text-white text-display-sm font-normal max-w-s">
                    Seamlessly Track and<br>Recover Your<br>Belongings
                </h2>
            </div>
        </aside>
        
    </main>
</body>
</html>
