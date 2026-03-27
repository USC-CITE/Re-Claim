<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WVSU ReClaim</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <?php require __DIR__ . "/header.php"?>
    <main class="w-full flex flex-col items-center">
        <!-- Hero Section -->
        <section class="w-full flex flex-col items-center justify-center py-24 px-4 text-center bg-white">
            <div class="max-w-5xl">
                <h1 class="text-display-md font-bold text-black mb-6">
                    Seamlessly Track and Recover <br class="hidden md:block"> Your Belongings
                </h1>
                <p class="text-lg mb-10 max-w-3xl mx-auto">
                    Re:Claim is a centralized lost and found tracking system for <br class="hidden md:block"> West Visayas State University - Main Campus.
                </p>
                <div class="flex justify-center">
                    <a href="/lost" class="group flex items-center justify-center px-8 py-3 bg-primary-500 hover:bg-primary-600 text-white text-md font-semibold rounded-2xl transition-all duration-300 gap-3">
                        Find Your Lost Item
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ReClaim Features Section-->
        <section class="container mx-auto py-16 px-4">
            <h2 class="text-3xl font-bold mb-10 text-center">Why Use Reclaim?</h2>

            <!-- Feature Cards -->
            <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
                <div>
                    <img src="/assets/temp.png" style="width: 80%">
                    <h6>Let people help you: post the item that you lost</h6>
                    <p>Ensure fast recovery by distributing information online.</p>
                </div>
                <div>
                    <img src="/assets/temp.png" style="width: 80%">
                    <h6>Let people help you: post the item that you lost</h6>
                    <p>Ensure fast recovery by distributing information online.</p>
                </div>
                <div>
                    <img src="/assets/temp.png" style="width: 80%">
                    <h6>Let people help you: post the item that you lost</h6>
                    <p>Ensure fast recovery by distributing information online.</p>
                </div>
            </div>
        </section>
        <!-- Issue Section -->
        <section class="container mx-auto py-20 px-4 flex flex-col md:flex-row items-center gap-12">
            <!-- Github Screenshot-->
                <img src="/assets/temp.png" style="width: 50%;">
            <div>
                <h2>Want to Contribute in Improving the System?</h2>
                <p>Re:Claim is open source! Place an issue on GitHub and we’ll review it.</p>
                <a href="https://github.com/USC-CITE/Re-Claim/issues" target="_blank">
                    <button>Place an issue</button>
                </a>
            </div>
        </section>
    </main>
</body>
</html>