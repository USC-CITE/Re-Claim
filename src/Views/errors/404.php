<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | ReClaim</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@400;600;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mesh-bg {
            background-color: #ffffff;
            background-image:
                radial-gradient(at 0% 0%, hsla(210, 100%, 95%, 1) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(230, 100%, 95%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(190, 100%, 95%, 1) 0, transparent 50%);
        }
    </style>
</head>

<body class="mesh-bg min-h-screen flex flex-col antialiased">
    <?php require __DIR__ . "/../mainpages/header.php" ?>

    <main class="flex-grow flex items-center justify-center py-16 px-6 relative overflow-hidden">
        <!-- Abstract background elements -->
        <div
            class="absolute top-1/4 -left-24 w-96 h-96 bg-primary-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse">
        </div>
        <div class="absolute bottom-1/4 -right-24 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="max-w-4xl w-full relative z-10 flex flex-col items-center">

            <div class="glass-card rounded-[3rem] p-8 md:p-16 w-full text-center relative overflow-hidden">
                <!-- Top Badge -->
                <div
                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-primary-50 border border-primary-100 mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-primary-500 mr-2 animate-ping"></span>
                    <span class="text-xs font-semibold text-primary-600 uppercase tracking-wider">Oops! We have lost
                        this page</span>
                </div>

                <!-- 404 Visual -->
                <div class="relative mb-8 flex justify-center">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-5 select-none font-outfit text-[15rem] font-extrabold -translate-y-4">
                        404
                    </div>
                    <div class="animate-float relative z-10">
                        <svg class="h-40 w-40 text-primary-500 transition-all duration-500 hover:scale-110" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.75">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                </div>

                <div class="max-w-xl mx-auto">
                    <h1 class="font-outfit text-5xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                        Page <span class="text-gradient">Not Found</span>
                    </h1>
                    <p class="text-lg text-gray-500 mb-10 leading-relaxed font-light">
                        We scanned everywhere but couldn't find the item you're looking for. It might have been moved,
                        deleted, or never existed in the first place.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="/"
                            class="group w-full sm:w-auto flex items-center justify-center px-10 py-5 bg-gray-900 hover:bg-black text-white text-md font-semibold rounded-2xl transition-all duration-300 shadow-xl hover:shadow-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 transition-transform group-hover:-translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Home
                        </a>
                        <a href="/contact"
                            class="w-full sm:w-auto flex items-center justify-center px-10 py-5 bg-white border border-gray-200 hover:border-primary-300 text-gray-700 hover:text-primary-600 text-md font-semibold rounded-2xl transition-all duration-300 hover:shadow-lg">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require __DIR__ . "/../mainpages/footer.php" ?>
</body>

</html>