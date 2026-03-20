<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>WVSU ReClaim</title>
</head>
<body>
    <?php require __DIR__ . "/header.php";?>
    <main class="max-w-7xl mx-auto px-6 py-20">
        <!-- Contact Layout -->
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <!-- Contact Info -->
            <section>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">We're Here to Help</h2>
                <p class="text-gray-900 mb-8">If you have questions, problems, or suggestions related to Re:Claim, send a message.</p>

                <!-- Contact Links-->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-10 h-10"
                            fill="#055BA8">

                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 7l9 6 9-6"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                fill="none"/>

                        </svg>
                        <a class="text-black text-[16px] hover:text-blue-500 hover:underline transition"
                            href="mailto:spark.hub@wvsu.edu.ph?subject=ReClaim Inquiry">
                            <span>spark.hub@wvsu.edu.ph</span>
                        </a>
                        
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-10 h-10"
                            fill="#055BA8">

                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 7l9 6 9-6"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                fill="none"/>

                        </svg>
                        <a href="mailto:usc.cite@wvsu.edu.ph?subject=ReClaim Inquiry"
                        class="text-black text-[16px] hover:text-blue-500 hover:underline transition"> 
                            <span>usc.cite@wvsu.edu.ph</span>
                        </a>
                        
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-10 h-10"
                            fill="#055BA8">

                        <rect x="2" y="2" width="20" height="20" rx="10"/>
                        <path d="M14 8h2V5h-2c-2.2 0-3 1.3-3 3v2H9v3h2v6h3v-6h2.2l.3-3H14V8c0-.6.2-1 1-1z"
                                fill="white"/>

                        </svg>
                        <a href="https://web.facebook.com/WVSUSparkHub" target="_blank"
                        class="text-black text-[16px] hover:text-blue-500 hover:underline transition">
                            <span>WVSU - Spark Hub</span>
                        </a>
                        
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-10 h-10"
                            fill="#055BA8">

                        <rect x="2" y="2" width="20" height="20" rx="10"/>
                        <path d="M14 8h2V5h-2c-2.2 0-3 1.3-3 3v2H9v3h2v6h3v-6h2.2l.3-3H14V8c0-.6.2-1 1-1z"
                                fill="white"/>

                        </svg>
                        <a href="https://web.facebook.com/profile.php?id=61564071784342" target="_blank"
                        class="text-black text-[16px] hover:text-blue-500 hover:underline transition">
                            <span>WVSU - CITE</span>
                        </a>
                    </div>

                </div>
            </section>

            <!-- Message Card -->
            <section class="bg-white border border-gray-200 rounded-2xl p-8 shadow-[0_4px_4px_rgba(0,0,0,0.24)] w-full">
                <h3 class="text-[30px] font-semibold text-gray-900 mb-6">Send us a message</h3>

                <!-- Message Form -->
                <form method="post" action="/contact/send" class="space-y-2">
                    <label class="block text-[16px] font-medium text-gray-900" for="name">Name </label>
                    <input name="name" type="text" placeholder="Juan Dela Cruz" required
                    class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-sm
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <!-- Inline error message -->
                    <p class="text-red-600 text-sm">
                        <?= $response['errors']['name'] ?? '' ?>
                    </p>

                    <label class="block text-[16px] font-medium text-gray-900" for="email">WVSU Email Address</label>
                    <input name="wvsu-email" type="email" placeholder="juandela.cruz@wvsu.edu.ph" required
                    class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-sm
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <!-- Inline error message -->
                    <p class="text-red-600 text-sm">
                        <?= $response['errors']['wvsu-email'] ?? '' ?>
                    </p>

                    <label for="message" class="block text-[16px] font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="message" placeholder="This is a message..." rows="5" maxlength="1000"required class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-sm 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    <!-- Inline error message -->
                    <p class="text-red-600 text-sm">
                        <?= $response['errors']['message'] ?? '' ?>
                    </p>

                    <?php if(!empty($response['error'])): ?>
                        <p class="text-red-600 text-sm"><?= htmlspecialchars($response['error']) ?></p>
                    <?php elseif(!empty($response['success'])): ?>
                        <p class="text-green-600 text-sm"><?= htmlspecialchars($response['success']) ?></p>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg text-md font-medium
                    hover:bg-blue-500 transition duration-200 flex items-center gap-2">Send Message <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="w-4 h-4">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 12h14M13 6l6 6-6 6"/>

                    </svg></button>
                </form>
            </section>
        </div>
        
    </main>
    
    
</body>
</html>