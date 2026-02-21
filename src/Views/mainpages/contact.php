<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>WVSU ReClaim</title>
</head>
<body>
    <?php require __DIR__ . "/header.php";?>
    <main class="container-flow" style="background-color: white;">
        <div style="display: flex; gap: 2rem; color: black; padding: 8rem;">
            <!-- Social Links and Help Card -->
            <div style="width: 50%;">
                <h2 style="color: black;">We're Here to Help</h2>
                <p style="color: black;">If you have questions, problems, or suggestions related to Re:Claim, send a message.</p>

                <div class="container">
                    
                    <div>
                        <img src="/assets/envelope.svg" alt="envelope icon" width="20">
                        <span>spark.hub@wvsu.edu.ph</span>
                    </div>

                    <div>
                        <img src="/assets/envelope.svg" alt="envelope icon" width="20" style="color: white;">
                        <span>usc.cite@wvsu.edu.ph</span>
                    </div>

                    <div>
                        <img src="/assets/facebook.svg" alt="facebook icon" width="20" style="color: white;">
                        <span>WVSU - Spark Hub</span>
                    </div>

                    <div>
                        <img src="/assets/facebook.svg" alt="facebook icon" width="20" style="color: white;">
                        <span>WVSU - CITE</span>
                    </div>

                </div>

            </div>

            <!-- Message Card -->
            <div style="width: 50%; padding: 0.75rem; border: 1px solid black; border-radius: 24px;">
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
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
        
    </main>
    
    
</body>
</html>