<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>WVSU ReClaim</title>
     <script>
        // This would handle the page javascript status if class is 'js' then works if still 'no-js' does not work
        document.documentElement.classList.remove('no-js');
        document.documentElement.classList.add('js');
    </script>
    <style>
        /* Default: show everything */
        .no-js .tab-content {
            display: block;
        }

        /* If JS is active */
        .js .tab-content {
            display: none;
        }

        .js .tab-content.active {
            display: block;
        }
        .js .tab-btn.active {
            background-color: #698389;
            color: white;
        }
    </style>
   
</head>
<body>
    <main class="container">
        <?php require __DIR__ . "/../mainpages/header.php"; ?>
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
                    <article class="grid">
                        <div>
                            <h4>First Name</h4>
                            <?= htmlspecialchars(($_SESSION['first_name'])) ?>
                        </div>
                        <div>
                            <h4>Last Name</h4>
                            <?= htmlspecialchars(($_SESSION['last_name'])) ?>
                        </div>
                        <div>
                            <h4>Contact Details</h4>
                            <?= htmlspecialchars(($_SESSION['phone_number'])) ?>
                            <br>
                            <?= htmlspecialchars(($_SESSION['social_link'])) ?>
                        </div>
                    </article>
                    <article>
                        <h4>WVSU Email Address</h4>
                        <?= htmlspecialchars(($_SESSION['wvsu_email'])) ?>
                    </article>
                </article>
            </section>

             <section class="tab-content" id="lost">
                <article>
                <h4>Posted Lost Items</h4>
                    <?php if (!empty($lostItems)): ?>
                        <ul>
                        <?php foreach ($lostItems as $item): ?>    
                            <li>
                                <h5><?= htmlspecialchars($item['item_name']) ?></h5>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No lost items posted yet.</p>
                    <?php endif; ?>
                </article>
            </section>

            <section class="tab-content" id="found">
                <article>
                <h4>Found Items (Including Archived)</h4>
                    <?php if (!empty($foundItems)): ?>
                        <!-- Form for bulk deletion of archived items -->
                        <form method="POST" action="/found/delete" onsubmit="return confirm('Are you sure you want to permanently delete the selected archived items?');">
                            <?php \App\Core\Router::setCsrf(); ?>
                            <ul>
                            <?php foreach ($foundItems as $item): ?>    
                                <li style="margin-bottom: 1rem; border-bottom: 1px solid #ccc; padding-bottom: 1rem;">
                                    <h5><?= htmlspecialchars($item['item_name']) ?></h5>
                                    <p>Status: <mark><?= htmlspecialchars($item['status']) ?></mark></p>
                                    <p><?= htmlspecialchars($item['description']) ?></p>
                                    
                                    <?php if (($item['status'] ?? '') === 'Archived'): ?>
                                        <label>
                                            <input type="checkbox" name="item_ids[]" value="<?= (int)$item['id'] ?>"> 
                                            Select to permanently delete
                                        </label>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                            
                            <!-- Check if any item is archived to show delete button -->
                            <?php 
                                $hasArchivedFound = false;
                                foreach ($foundItems as $i) {
                                    if (($i['status'] ?? '') === 'Archived') {
                                        $hasArchivedFound = true;
                                        break;
                                    }
                                }
                            ?>

                            <?php if ($hasArchivedFound): ?>
                                <button type="submit" class="secondary" style="background-color: #e74c3c; color: white;">
                                    Delete Selected Archived Items
                                </button>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <p>No found items posted yet.</p>
                    <?php endif; ?>
                </article>
            </section>
        </section>
    </main>
    <script src="/js/profile/tabs.js"></script>
</body>
</html>