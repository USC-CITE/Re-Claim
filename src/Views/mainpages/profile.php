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
            color: #044177;
            border-bottom: 2px solid #044177;
        }
    </style>
   
</head>
<body>
    <?php require __DIR__ . "/../mainpages/header.php"; ?>
    
    <main class="max-w-5xl mx-auto px-6">

        <?php if (!empty($flash['success'])): ?>
            <article class="border-l-4 border-green-500 p-4 bg-green-50 mb-4">
                <strong>Success:</strong> <?= htmlspecialchars($flash['success']) ?>
            </article>
        <?php elseif (!empty($flash['error'])): ?>
            <article class="border-l-4 border-green-500 p-4 bg-green-50 mb-4">
                <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
            </article>
        <?php endif; ?>
        <header class="flex w-full max-w-2xl justify-between items-center">

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

        <section class="w-full">
            <!-- Profile Tab Buttons -->
            <nav class="flex gap-12 justify-center border-b border-gray-400 pb-4 mb-6">
                <button type="button" class="tab-btn py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="account">
                    Account Details
                </button>

                <button type="button" class="tab-btn py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition "data-tab="lost">
                    Posted Lost Items
                </button>

                <button type="button" class="tab-btn py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="found">
                    Posted Found Items
                </button>

                <button type="button" class="tab-btn py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="archive">
                    Archive Items
                </button>
            </nav>

            <!-- Tab Content Section -->
            <section class="tab-content mt-12  max-w-3xl w-full mx-auto" id="account">
                <article class="px-6 py-6">
                    <article class="flex justify-between">
                        <div>
                            <h4 class="text-md font-semibold">First Name</h4>
                            <p class="text-sm mt-1"><?= htmlspecialchars(($_SESSION['first_name'])) ?></p>
                        </div>
                        <div>
                            <h4 class="text-md font-semibold">Last Name</h4>
                            <p class="text-sm mt-1"><?= htmlspecialchars(($_SESSION['last_name'])) ?></p>
                        </div>
                        <div>
                            <h4 class="text-md font-semibold">Contact Details</h4>
                            <ul class="space-y-2 mt-2">
                                <li class="flex items-center gap-2">
                                    <img src="/assets/phone.svg" class="h-5 w-5 text-gray-400">
                                    <p class="text-sm"><?= htmlspecialchars($_SESSION['phone_number']) ?></p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <img src="/assets/link.svg" class="h-5 w-5 text-gray-200">
                                    <p class="text-sm"><?= htmlspecialchars($_SESSION['social_link']) ?></p>
                                </li>
                            </ul>
                            
                        </div>
                    </article>
                    <article class="mt-4">
                        <h4 class="text-md font-semibold">WVSU Email Address</h4>
                        <p class="text-sm"><?= htmlspecialchars(($_SESSION['wvsu_email'])) ?></p>
                    </article>
                </article>
            </section>

             <section class="tab-content mt-12" id="lost">
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

            <section class="tab-content mt-12" id="found">
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

            <section class="tab-content mt-12" id="archive">
                <article>
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
