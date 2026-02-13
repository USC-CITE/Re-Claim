<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>WVSU ReClaim</title>
</head>
<body>
    <main class="container">
        <header style="display:flex; justify-content:space-between; align-items:center;">

            <div style="display:flex; align-items:center; gap:1rem;">
                <!-- Temporary Placeholder for avatar -->
                <img src="/images/profile.jpg"
                    alt="Profile"
                    width="60"
                    height="60"
                    style="border-radius:50%; object-fit:cover;">

                <div>
                    <strong>
                        <?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?>
                    </strong>
                    <br>
                    <p><?= htmlspecialchars($_SESSION['wvsu_email'] ?? '') ?></p>
                </div>
            </div>

            <a href="/profile/edit" role="button">
                Edit Profile
            </a>

        </header>

        <section>
            <!-- Profile Tab Buttons -->
            <nav>
                <button type="button" class="tab-btn" data-tab="account">
                    Account Details
                </button>

                <button type="button" class="tab-btn" data-tab="lost">
                    Posted Lost Items
                </button>

                <button type="button" class="tab-btn" data-tab="found">
                    Posted Found Items
                </button>
            </nav>

            <!-- Tab Content Section -->
            <section class="tab-content" id="account">
                <article>
                    <div>
                        <div>
                            <h4>First Name</h4>
                            //first name
                        </div>
                        <div>
                            <h4>Last Name</h4>
                            //last name
                        </div>
                        <div>
                            <h4>Contact Details</h4>
                            // phone number
                            // social link
                        </div>
                    </div>
                    <div>
                        <h4>WVSU Email Address</h4>
                        // address
                    </div>
                </article>
            </section>

             <section class="tab-content" id="lost" hidden>
                <article>
                <h4>Posted Lost Items</h4>
                <p>Lost items you posted.</p>
                </article>
            </section>

            <section class="tab-content" id="found" hidden>
                <article>
                <h4>Found Items</h4>
                <p>Found items you posted.</p>
                </article>
            </section>
        </section>
    </main>
    <script src="/js/profile/tabs.js"></script>
</body>
</html>