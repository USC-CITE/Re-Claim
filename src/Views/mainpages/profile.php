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
    
    <main class="max-w-6xl mx-auto mt-16 px-6 flex flex-col items-center">

        <?php if (!empty($flash['success'])): ?>
            <article class="border-l-4 border-green-500 p-4 bg-green-50 mb-4">
                <strong>Success:</strong> <?= htmlspecialchars($flash['success']) ?>
            </article>
        <?php elseif (!empty($flash['error'])): ?>
            <article class="border-l-4 border-green-500 p-4 bg-green-50 mb-4">
                <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
            </article>
        <?php endif; ?>
        <header class="flex w-full mb-12 justify-center">
            <div class="flex items-center gap-6 w-full max-w-lg self-center">
                <!-- Temporary Placeholder for avatar -->
                <div class="w-24 h-24 rounded-full overflow-hidden self-start">
                    <img src="/assets/temp.png"
                    alt="Profile"
                    class="w-full h-full object-cover">
                </div>

                <div class="flex flex-col w-[375px]">
                    <p class="text-3xl font-semibold">
                        <?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?>
                    </p>
                    <p class="text-md mb-4"><?= htmlspecialchars($_SESSION['wvsu_email'] ?? '') ?></p>

                    <a href="/profile/edit" role="button" class="group flex w-fit items-center gap-2 text-sm font-medium border px-3 py-1.5 rounded-full border-gray-900 bg-white hover:bg-gray-100 hover:border-gray-400 hover:shadow-sm transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="w-4 h-4 transition-transform group-hover:translate-x-0.5"
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2.5" 
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                        </svg>
                        <span class="text-sm font-semibold">
                            Edit Profile
                        </span>
                        
                    </a>
                </div>
            </div>
        </header>

        <section class="w-full">
            <!-- Profile Tab Buttons -->
            <nav class="flex gap-6 sm:gap-12 justify-center border-b border-gray-400 pb-4 mb-6 overflow-x-auto whitespace-nowrap">
                <button type="button" class="tab-btn shrink-0 py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="account">
                    Account Details
                </button>

                <button type="button" class="tab-btn shrink-0 py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="lost">
                    Posted Lost Items
                </button>

                <button type="button" class="tab-btn shrink-0 py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="found">
                    Posted Found Items
                </button>

                <button type="button" class="tab-btn shrink-0 py-2 text-lg font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="archive">
                    Archive Items
                </button>
            </nav>

            <!-- Tab Content Section -->
            <section class="tab-content mt-12 max-w-3xl w-full mx-auto" id="account">
                <article class="flex flex-col md:flex-row justify-between px-6 py-6 w-full gap-6">
                    <!-- Left Column -->
                    <div class="flex flex-col md:w-3/5 gap-4">
                        <!-- Name Row -->
                        <div class="flex flex-row justify-between gap-6">
                            <div>
                                <h4 class="text-md font-semibold">First Name</h4>
                                <p class="text-sm mt-1"><?= htmlspecialchars($_SESSION['first_name']) ?></p>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold">Last Name</h4>
                                <p class="text-sm mt-1"><?= htmlspecialchars($_SESSION['last_name']) ?></p>
                            </div>
                        </div>

                        <!-- Email Row -->
                        <div>
                            <h4 class="text-md font-semibold">WVSU Email Address</h4>
                            <p class="text-sm"><?= htmlspecialchars($_SESSION['wvsu_email']) ?></p>
                        </div>
                    </div>

                    <!-- Right Column: Contact Details -->
                    <div class="md:w-auto md:mt-0">
                        <h4 class="text-md font-semibold">Contact Details</h4>
                        <ul class="space-y-2 mt-2">
                            <li class="flex items-center gap-2 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21c1.21.48 2.53.73 3.88.73a1 1 0 011 1v3.5a1 1 0 01-1 1C10.49 22 2 13.51 2 3.5a1 1 0 011-1H6.5a1 1 0 011 1c0 1.35.25 2.67.73 3.88.13.28.08.61-.21 1.11l-2.2 2.2z"/>
                                </svg>
                                <p class="text-sm"><?= htmlspecialchars($_SESSION['phone_number']) ?></p>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12a3 3 0 0 1 0-4.24l3-3a3 3 0 0 1 4.24 4.24l-1.5 1.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 12a3 3 0 0 1 0 4.24l-3 3a3 3 0 0 1-4.24-4.24l1.5-1.5"/>
                                </svg>
                                <p class="text-sm"><?= htmlspecialchars($_SESSION['social_link']) ?></p>
                            </li>
                        </ul>
                    </div>

                </article>
            </section>

             <section class="tab-content mt-12" id="lost">
                <article class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full px-4 justify-items-center">
                    <?php if (!empty($lostItems)): ?>
                        <?php foreach ($lostItems as $item): ?>    
                            <!-- Item Card-->
                            <div class="border rounded-xl p-4 shadow-sm bg-white w-full">
                                <!-- Card Header -->
                                <div class="py-2 border-b-2 border-[#5B5B5B]">
                                    <h3 class="font-semibold text-lg"><span class="text-red-500">[ Lost ]</span> <?= htmlspecialchars($item['item_name']) ?></h3>
                                    <p><?= date("F, j, Y", strtotime($item['event_date'])) ?></p>
                                </div>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($item['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No lost items posted yet.</p>
                    <?php endif; ?>
                </article>
            </section>

            <section class="tab-content mt-12" id="found">
                <article class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full px-4 justify-items-center">
                    <?php if (!empty($foundItems)): ?>
                        <?php foreach ($foundItems as $item): ?>    
                            <!-- Item Card-->
                            <div class="border rounded-xl p-4 shadow-sm bg-white w-full">
                                <!-- Card Header -->
                                <div class="py-2 border-b-2 border-[#5B5B5B]">
                                    <h3 class="font-semibold text-lg"><span class="text-green-500">[ Found ]</span> <?= htmlspecialchars($item['item_name']) ?></h3>
                                    <p><?= date("F, j, Y", strtotime($item['event_date'])) ?></p>
                                </div>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($item['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
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
