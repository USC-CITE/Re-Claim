<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
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
        <?php if (!empty($flash['success'])): ?>
            <article class="border-l-4 border-green-500 p-4 bg-green-50 mb-4">
                <strong>Success:</strong> <?= htmlspecialchars($flash['success']) ?>
            </article>
        <?php elseif (!empty($flash['error'])): ?>
            <article class="border-l-4 border-green-500 p-4 bg-green-50 mb-4">
                <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
            </article>
        <?php endif; ?>
        <header class="flex justify-between items-center">

            <div class="flex items-center gap-4">
                <!-- Temporary Placeholder for avatar -->
                <img src="/images/profile.jpg"
                    alt="Profile"
                    class="w-14 h-14 rounded-full object-cover">

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
            <nav class="flex gap-2 border-b pb-2 mb-4">
                <button type="button" class="tab-btn px-4 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-300" data-tab="account">
                    Account Details
                </button>

                <button type="button" class="tab-btn px-4 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-300"data-tab="lost">
                    Posted Lost Items
                </button>

                <button type="button" class="tab-btn px-4 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-300" data-tab="found">
                    Posted Found Items
                </button>

                <button type="button" class="tab-btn px-4 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-300" data-tab="archive">
                    Archive Items
                </button>
            </nav>

            <!-- Tab Content Section -->
            <section class="tab-content mt-6" id="account">
                <article class="bg-white shadow rounded-lg p-6">
                    <article class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

             <section class="tab-content mt-6" id="lost">
                <article class="bg-white shadow rounded-lg p-6">
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

            <section class="tab-content mt-6" id="found">
                <article class="bg-white shadow rounded-lg p-6">
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

            <section class="tab-content mt-6" id="archive">
                <article class="bg-white shadow rounded-lg p-6">
                    <h4>My Archived Posts</h4>
                    <?php if (!empty($archivedItems)): ?>
                        <form id="bulk-delete-archived-form" method="POST" action="/profile/archived/delete" onsubmit="return confirm('Delete the selected archived items permanently? This cannot be undone.');">
                            <?php \App\Core\Router::setCsrf(); ?>
                        </form>
                        <ul>
                        <?php foreach ($archivedItems as $item): ?>
                            <li class="archived-list-item">
                                <div class="flex items-start justify-between gap-4 w-full">
                                    <label class="flex items-start gap-3 flex-1">
                                        <input type="checkbox" name="item_ids[]" value="<?= (int)$item['id'] ?>" form="bulk-delete-archived-form">
                                        <span class="flex-1">
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

                                    <form method="POST" action="/profile/archived/delete" class="ml-auto" onsubmit="return confirm('Delete this archived item permanently? This cannot be undone.');">
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
