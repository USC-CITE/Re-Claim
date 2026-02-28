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

        /* Temporary styling for Archived Items Tab*/
        .archived-list-item {
            list-style: none;
            margin-bottom: 1rem;
        }

        .archived-item-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            width: 100%;
        }

        .archived-item-label {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            flex: 1;
            margin: 0;
        }

        .archived-item-content {
            flex: 1;
        }

        .archived-item-type {
            margin-left: 0.5rem;
        }

        .archived-delete-form {
            margin: 0 0 0 auto;
        }

        .archived-delete-button {
            margin: 0;
        }
    </style>
   
</head>
<body>
    <main class="container">
        <?php require __DIR__ . "/../mainpages/header.php"; ?>
        <?php if (!empty($flash['success'])): ?>
            <article style="border-left: 4px solid #2ecc71; padding: 1rem;">
                <strong>Success:</strong> <?= htmlspecialchars($flash['success']) ?>
            </article>
        <?php elseif (!empty($flash['error'])): ?>
            <article style="border-left: 4px solid #e74c3c; padding: 1rem;">
                <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
            </article>
        <?php endif; ?>
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

                <button type="button" class="tab-btn" data-tab="archived">
                    Archived Items
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
                <h4>Found Items</h4>
                    <?php if (!empty($foundItems)): ?>
                        <ul>
                        <?php foreach ($foundItems as $item): ?>    
                            <li>
                                <h5><?= htmlspecialchars($item['item_name']) ?></h5>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No found items posted yet.</p>
                    <?php endif; ?>
                </article>
            </section>

            <section class="tab-content" id="archived">
                <article>
                    <h4>My Archived Posts</h4>
                    <?php if (!empty($archivedItems)): ?>
                        <form id="bulk-delete-archived-form" method="POST" action="/profile/archived/delete" onsubmit="return confirm('Delete the selected archived items permanently? This cannot be undone.');">
                            <?php \App\Core\Router::setCsrf(); ?>
                        </form>
                        <ul>
                        <?php foreach ($archivedItems as $item): ?>
                            <li class="archived-list-item">
                                <div class="archived-item-row">
                                    <label class="archived-item-label">
                                        <input type="checkbox" name="item_ids[]" value="<?= (int)$item['id'] ?>" form="bulk-delete-archived-form">
                                        <span class="archived-item-content">
                                            <h5>
                                                <?= htmlspecialchars($item['item_name']) ?>
                                                <small class="archived-item-type">
                                                    <mark><?= htmlspecialchars($item['item_type']) ?></mark>
                                                </small>
                                            </h5>

                                            <p><?= htmlspecialchars($item['description']) ?></p>
                                            <small>
                                                <strong>Status:</strong> <?= htmlspecialchars($item['status']) ?>
                                                <br>
                                                <strong>Archived On:</strong> <?= htmlspecialchars($item['archive_date']) ?>
                                            </small>
                                        </span>
                                    </label>

                                    <form method="POST" action="/profile/archived/delete" class="archived-delete-form" onsubmit="return confirm('Delete this archived item permanently? This cannot be undone.');">
                                        <?php \App\Core\Router::setCsrf(); ?>
                                        <input type="hidden" name="item_ids[]" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="secondary outline archived-delete-button" aria-label="Delete permanently" title="Delete permanently">
                                            &#128465;
                                        </button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>

                        <button type="submit" form="bulk-delete-archived-form" class="secondary">Delete Selected</button>
                    <?php else: ?>
                        <p>No archived posts yet.</p>
                    <?php endif; ?>
                </article>
            </section>
        </section>
    </main>
    <script src="/js/profile/tabs.js"></script>
</body>
</html>
