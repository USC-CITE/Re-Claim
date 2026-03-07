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
            <section style="width: 50%;">
                <h2 style="color: black;">We're Here to Help</h2>
                <p style="color: black;">If you have questions, problems, or suggestions related to Re:Claim, send a message.</p>

                <!-- Contact Links-->
                <div class="container">
                    <div>
                        <img src="/assets/envelope.svg" alt="envelope icon" width="20">
                        <a href="mailto:spark.hub@wvsu.edu.ph?subject=ReClaim Inquiry">
                            <span>spark.hub@wvsu.edu.ph</span>
                        </a>
                        
                    </div>

                    <div>
                        <img src="/assets/envelope.svg" alt="envelope icon" width="20" style="color: white;">
                        <a href="mailto:usc.cite@wvsu.edu.ph?subject=ReClaim Inquiry"> 
                            <span>usc.cite@wvsu.edu.ph</span>
                        </a>
                        
                    </div>

                    <div>
                        <img src="/assets/facebook.svg" alt="facebook icon" width="20" style="color: white;">
                        <a href="https://web.facebook.com/WVSUSparkHub" target="_blank">
                            <span>WVSU - Spark Hub</span>
                        </a>
                        
                    </div>

                    <div>
                        <img src="/assets/facebook.svg" alt="facebook icon" width="20" style="color: white;">
                        <a href="https://web.facebook.com/profile.php?id=61564071784342" target="_blank"> 
                            <span>WVSU - CITE</span>
                        </a>
                    </div>

                </div>
            </section>

            <!-- Message Card -->
            <section style="width: 50%; padding: 0.75rem; border: 1px solid black; border-radius: 24px;">
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