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
                            class="w-8 h-8"
                            fill="#2563EB">

                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 7l9 6 9-6"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                fill="none"/>

                        </svg>
                        <a class="text-black text-[16px] hover:text-blue-600 hover:underline transition"
                            href="mailto:spark.hub@wvsu.edu.ph?subject=ReClaim Inquiry">
                            <span>spark.hub@wvsu.edu.ph</span>
                        </a>
                        
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-8 h-8"
                            fill="#2563EB">

                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 7l9 6 9-6"
                                stroke="white"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                fill="none"/>

                        </svg>
                        <a href="mailto:usc.cite@wvsu.edu.ph?subject=ReClaim Inquiry"
                        class="text-black text-[16px] hover:text-blue-600 hover:underline transition"> 
                            <span>usc.cite@wvsu.edu.ph</span>
                        </a>
                        
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-8 h-8"
                            fill="#2563EB">

                        <rect x="2" y="2" width="20" height="20" rx="4"/>
                        <path d="M14 8h2V5h-2c-2.2 0-3 1.3-3 3v2H9v3h2v6h3v-6h2.2l.3-3H14V8c0-.6.2-1 1-1z"
                                fill="white"/>

                        </svg>
                        <a href="https://web.facebook.com/WVSUSparkHub" target="_blank"
                        class="text-black text-[16px] hover:text-blue-600 hover:underline transition">
                            <span>WVSU - Spark Hub</span>
                        </a>
                        
                    </div>

                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-8 h-8"
                            fill="#2563EB">

                        <rect x="2" y="2" width="20" height="20" rx="4"/>
                        <path d="M14 8h2V5h-2c-2.2 0-3 1.3-3 3v2H9v3h2v6h3v-6h2.2l.3-3H14V8c0-.6.2-1 1-1z"
                                fill="white"/>

                        </svg>
                        <a href="https://web.facebook.com/profile.php?id=61564071784342" target="_blank"
                        class="text-black text-[16px] hover:text-blue-600 hover:underline transition">
                            <span>WVSU - CITE</span>
                        </a>
                    </div>

                </div>
            </section>

            <!-- Message Card -->
            <section>
                <h4 style="color: black;">Send us a message</h4>

                <!-- Message Form -->
                <form method="post" action="/contact/send">
                    <label style="color: black;">Name: </label>
                    <input name="name" type="text" placeholder="Juan Dela Cruz">
                    <br>

                    <label style="color: black;">WVSU Email Address:</label>
                    <input name="wvsu-email" type="email" placeholder="juandela.cruz@wvsu.edu.ph">
                    <br>

                    <label style="color: black;">Message:</label>
                    <textarea name="message" placeholder="This is a message..." rows="5"></textarea>
                    <?php if(!empty($response['error'])): ?>
                        <p class="error"><?= htmlspecialchars($response['error']) ?></p>
                    <?php elseif(!empty($response['success'])): ?>
                        <p class="success"><?= htmlspecialchars($response['success']) ?></p>
                    <?php endif; ?>
                    <button type="submit">Send Message</button>
                </form>
            </section>
        </div>
        
    </main>
    
    
</body>
</html>