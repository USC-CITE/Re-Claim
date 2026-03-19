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
    <title>WVSU ReClaim</title>
</head>
<body class="font-poppins bg-white min-h-screen flex flex-col items-center justify-center p-4">
    <main class="w-full max-w-105 mx-auto">        
        <!-- Logo -->
        <section class="flex justify-center">
            <img src="/assets/reclaim-logo.svg" alt="Re:Claim Logo" class="h-20 object-contain">
        </section>

        <!-- Header -->
        <section class="text-center mb-8">
            <h1 class="text-display-md text-primary font-semibold">Welcome Back</h1>
            <p class="text-secondary text-sm">
                Enter your credentials to log-in.
            </p>
        </section>

        <!-- Form -->
        <form method="POST" action="/login" class="space-y-5">
            <!-- WVSU Email Address -->
            <div>
                <label class="text-md font-medium text-primary" for="email">WVSU Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    required 
                    class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white focus:outline-none focus:border-none placeholder-secondary"
                >
            </div>

            <!-- Password -->
            <div>
                <div class="mb-1.5 flex items-center justify-between">
                    <label class="text-sm font-semibold text-primary" for="password">Password</label>
                    <a href="/forgot-password" class="text-md font-medium text-primary-500 hover:underline">Forgot password?</a>
                </div>
                <div class="relative">
                    <input 
                        id="password"
                        type="password" 
                        name="password" 
                        required 
                        class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white focus:outline-none focus:border-none placeholder-secondary"
                    >
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-3">
                <input
                    id="remember_me"
                    name="remember_me"
                    type="checkbox"
                    class="h-5 w-5 rounded-xs border border-white-900 text-primary-500"
                >
                <label for="remember_me" class="text-sm text-primary">Remember Me</label>
            </div>

            <!-- Submit Button -->
            <div class="pt-1">
                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white-50 font-semibold rounded-2xl py-3.5 flex items-center justify-center transition-colors text-md">
                    Log-in
                    <!-- Arrow Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-5 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Footer -->
        <footer class="mt-4 text-left text-sm text-secondary">
            No account yet? <a href="/register" class="text-primary text-sm font-bold hover:underline">Sign up</a>
        </footer>
        
    </main>
</body>
<script src="/js/login/login.js" defer type="module"></script>
</html>
