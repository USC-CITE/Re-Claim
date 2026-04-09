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
                    <a href="/found" class="group flex items-center justify-center px-8 py-3 bg-primary-500 hover:bg-primary-600 text-white text-md font-semibold rounded-2xl transition-all duration-300 gap-3">
                        Find Your Lost Item
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ReClaim Features Section -->
        <section class="w-full max-w-7xl mx-auto pb-24 px-6 md:px-12">
            <h2 class="text-display-md font-bold text-black mb-7">Why Use Re:Claim?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Card 1 -->
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-[0_4px_16px_rgba(0,0,0,0.2)] p-4 flex flex-col min-h-[500px] hover:shadow-[0_4px_16px_rgba(0,0,0,0.3)] transition-all duration-300">
                    <div class="w-full aspect-362/274 rounded-3xl overflow-hidden mb-8">
                        <img src="/assets/temp.png" alt="Post lost item" class="w-full h-full object-cover">
                    </div>
                    <div class="px-2 pb-6 grow">
                        <h3 class="text-display-sm font-medium text-black mb-4 leading-snug w-70">
                            Let people help you: post the item that you lost
                        </h3>
                        <p class="text-lg">
                            Ensure fast recovery by distributing information online.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-[0_4px_16px_rgba(0,0,0,0.2)] p-4 flex flex-col min-h-[500px] hover:shadow-[0_4px_16px_rgba(0,0,0,0.3)] transition-all duration-300">
                    <div class="w-full aspect-362/274 rounded-3xl overflow-hidden mb-8">
                        <img src="/assets/temp.png" alt="Find lost item" class="w-full h-full object-cover">
                    </div>
                    <div class="px-2 pb-6 grow">
                        <h3 class="text-display-sm font-medium text-black mb-4 leading-snug w-65">
                            Help others in finding their lost items
                        </h3>
                        <p class="text-lg">
                            Post lost items you have found with no owner.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-[0_4px_16px_rgba(0,0,0,0.2)] p-4 flex flex-col min-h-[500px] hover:shadow-[0_4px_16px_rgba(0,0,0,0.3)] transition-all duration-300">
                    <div class="w-full aspect-362/274 rounded-3xl overflow-hidden mb-8">
                        <img src="/assets/temp.png" alt="Community project" class="w-full h-full object-cover">
                    </div>
                    <div class="px-2 pb-6 grow">
                        <h3 class="text-display-sm font-medium text-black mb-4 leading-snug">
                            Contribute to a community-driven project
                        </h3>
                        <p class="text-lg">
                            Be a part of a community built on mutual recovery.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Issue Section -->
        <section class="w-full max-w-7xl mx-auto py-24 px-6 md:px-12 flex flex-col-reverse md:flex-row items-center gap-16 md:gap-24">
            <!-- Github Screenshot -->
            <div class="flex-1 w-full">
                <div class="rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100">
                    <img src="/assets/temp.png" alt="GitHub Issues Screenshot" class="w-full h-auto">
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 text-left">
                <h2 class="text-display-md font-bold text-black mb-6 leading-tight max-w-lg w-70 md:w-full">
                    Want to Contribute in Improving the System?
                </h2>
                <p class="text-lg mb-10 max-w-md">
                    Re:Claim is open source! Place an issue on GitHub and we’ll review it.
                </p>
                <div class="flex justify-center md:justify-start">
                    <a href="https://github.com/USC-CITE/Re-Claim/issues" target="_blank" class="group flex items-center justify-center px-8 py-3.5 bg-primary-500 hover:bg-primary-600 text-white text-md font-semibold rounded-2xl transition-all duration-300 gap-3">
                        Place an Issue
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        <!-- Collaboration Section -->
        <section class="w-full max-w-5xl mx-auto py-28 px-6 text-center">
            <div class="flex flex-col items-center gap-12">
                <img src="/assets/spark-cite.png" alt="SPARK Hub and USC-CITE" class="h-28 md:h-36 w-auto">
                <p class="text-lg leading-relaxed max-w-4xl">
                    Re:Claim is a collaborative effort between <span class="font-semibold">SPARK Hub</span> and <span class="font-semibold">USC-CITE</span> with the aim of developing systems that contribute to improving digital accessibility.
                </p>
            </div>
        </section>
        <?php require __DIR__ . "/footer.php"?>
    </main>
</body>
</html>