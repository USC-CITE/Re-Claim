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
    <div class="w-full max-w-105 mx-auto">        
        <!-- Logo -->
        <div class="flex justify-center">
            <img src="/assets/reclaim-logo.svg" alt="Re:Claim Logo" class="h-20 object-contain">
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-display-md text-primary font-semibold">Welcome Back</h1>
            <p class="text-secondary text-sm">
                Enter your credentials to log-in.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="/login" class="space-y-5">
            <!-- WVSU Email Address -->
            <div>
                <label class="text-md font-medium text-primary">WVSU Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    required 
                    placeholder="example@wvsu.edu.ph"
                    class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white focus:outline-none focus:border-none focus:ring-primary-500 focus:ring-2 placeholder-secondary"
                >
            </div>

            <!-- Password -->
            <div>
                <div class="mb-1.5 flex items-center justify-between">
                    <label class="text-sm font-semibold text-primary">Password</label>
                    <a href="/forgot-password" class="text-md font-medium text-primary-500 hover:underline">Forgot password?</a>
                </div>
                <div class="relative">
                    <input 
                        id="password"
                        type="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                    class="w-full px-4 py-2.5 text-sm border border-white-700 rounded-lg bg-white focus:outline-none focus:border-none focus:ring-primary-500 focus:ring-2 placeholder-secondary"
                    >
                    <!-- Eye Icon matching design -->
                    <button
                        id="toggle_password"
                        type="button"
                        aria-label="Show password"
                        aria-pressed="false"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-primary hover:text-black-300"
                    >
                        <svg id="eye_open_icon" xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                            <path d="M1.8125 10.1633C1.10417 9.24333 0.75 8.7825 0.75 7.41667C0.75 6.05 1.10417 5.59083 1.8125 4.67C3.22667 2.83333 5.59833 0.75 9.08333 0.75C12.5683 0.75 14.94 2.83333 16.3542 4.67C17.0625 5.59167 17.4167 6.05083 17.4167 7.41667C17.4167 8.78333 17.0625 9.2425 16.3542 10.1633C14.94 12 12.5683 14.0833 9.08333 14.0833C5.59833 14.0833 3.22667 12 1.8125 10.1633Z" stroke="black" stroke-width="1.5"/>
                            <path d="M11.5833 7.41667C11.5833 8.07971 11.3199 8.71559 10.8511 9.18443C10.3823 9.65327 9.74637 9.91667 9.08333 9.91667C8.42029 9.91667 7.78441 9.65327 7.31557 9.18443C6.84673 8.71559 6.58333 8.07971 6.58333 7.41667C6.58333 6.75363 6.84673 6.11774 7.31557 5.6489C7.78441 5.18006 8.42029 4.91667 9.08333 4.91667C9.74637 4.91667 10.3823 5.18006 10.8511 5.6489C11.3199 6.11774 11.5833 6.75363 11.5833 7.41667Z" stroke="black" stroke-width="1.5"/>
                        </svg>
                        <svg id="eye_closed_icon" xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none" class="hidden">
                            <path d="M11.0374 5.73793L9.49432 3.62063M6.3614 6.67313V4.49099M1.68539 5.73793L3.22473 3.62562M0.750183 0.750183C2.99467 5.73793 9.72812 5.73793 11.9726 0.750183" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-3">
                <input
                    id="remember_me"
                    name="remember_me"
                    type="checkbox"
                    class="h-5 w-5 rounded-xs border border-white-900 text-primary-500 focus:ring-primary-500"
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
        <div class="mt-4 text-left text-sm text-secondary">
            No account yet? <a href="/register" class="text-primary text-sm font-bold hover:underline">Sign up</a>
        </div>
        
    </div>
</body>
<script src="/js/login/login.js"></script>
</html>
