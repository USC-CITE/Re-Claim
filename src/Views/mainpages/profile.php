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
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;     /* Firefox */
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
            <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6 w-full max-w-lg">
                <!-- Temporary Placeholder for avatar -->
                <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0 ring-2 ring-gray-200">
                    <img src="/assets/temp.png"
                    alt="Profile"
                    class="w-full h-full object-cover">
                </div>

                <div class="flex flex-col w-[375px]">
                    <p class="text-3xl font-semibold">
                        <?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?>
                    </p>
                    <p class="text-md mb-4"><?= htmlspecialchars($_SESSION['wvsu_email'] ?? '') ?></p>

                    <a href="/profile/edit" role="button" class="group flex w-fit items-center gap-2 text-sm font-medium border px-3 py-1 rounded-full border-gray-900 bg-white hover:bg-gray-100 hover:border-gray-400 hover:shadow-sm transition-all duration-200">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#1E1E1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3248 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3248 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2448 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2448 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.258 9.77251 19.9887C9.5799 19.7194 9.31074 19.5143 9 19.4C8.69838 19.2669 8.36381 19.2272 8.03941 19.286C7.71502 19.3448 7.41568 19.4995 7.18 19.73L7.12 19.79C6.93425 19.976 6.71368 20.1235 6.47088 20.2241C6.22808 20.3248 5.96783 20.3766 5.705 20.3766C5.44217 20.3766 5.18192 20.3248 4.93912 20.2241C4.69632 20.1235 4.47575 19.976 4.29 19.79C4.10405 19.6043 3.95653 19.3837 3.85588 19.1409C3.75523 18.8981 3.70343 18.6378 3.70343 18.375C3.70343 18.1122 3.75523 17.8519 3.85588 17.6091C3.95653 17.3663 4.10405 17.1457 4.29 16.96L4.35 16.9C4.58054 16.6643 4.73519 16.365 4.794 16.0406C4.85282 15.7162 4.81312 15.3816 4.68 15.08C4.55324 14.7842 4.34276 14.532 4.07447 14.3543C3.80618 14.1766 3.49179 14.0813 3.17 14.08H3C2.46957 14.08 1.96086 13.8693 1.58579 13.4942C1.21071 13.1191 1 12.6104 1 12.08C1 11.5496 1.21071 11.0409 1.58579 10.6658C1.96086 10.2907 2.46957 10.08 3 10.08H3.09C3.42099 10.0723 3.742 9.96512 4.0113 9.77251C4.28059 9.5799 4.48572 9.31074 4.6 9C4.73312 8.69838 4.77282 8.36381 4.714 8.03941C4.65519 7.71502 4.50054 7.41568 4.27 7.18L4.21 7.12C4.02405 6.93425 3.87653 6.71368 3.77588 6.47088C3.67523 6.22808 3.62343 5.96783 3.62343 5.705C3.62343 5.44217 3.67523 5.18192 3.77588 4.93912C3.87653 4.69632 4.02405 4.47575 4.21 4.29C4.39575 4.10405 4.61632 3.95653 4.85912 3.85588C5.10192 3.75523 5.36217 3.70343 5.625 3.70343C5.88783 3.70343 6.14808 3.75523 6.39088 3.85588C6.63368 3.95653 6.85425 4.10405 7.04 4.29L7.1 4.35C7.33568 4.58054 7.63502 4.73519 7.95941 4.794C8.28381 4.85282 8.61838 4.81312 8.92 4.68H9C9.29577 4.55324 9.54802 4.34276 9.72569 4.07447C9.90337 3.80618 9.99872 3.49179 10 3.17V3C10 2.46957 10.2107 1.96086 10.5858 1.58579C10.9609 1.21071 11.4696 1 12 1C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V3.09C14.0013 3.41179 14.0966 3.72618 14.2743 3.99447C14.452 4.26276 14.7042 4.47324 15 4.6C15.3016 4.73312 15.6362 4.77282 15.9606 4.714C16.285 4.65519 16.5843 4.50054 16.82 4.27L16.88 4.21C17.0657 4.02405 17.2863 3.87653 17.5291 3.77588C17.7719 3.67523 18.0322 3.62343 18.295 3.62343C18.5578 3.62343 18.8181 3.67523 19.0609 3.77588C19.3037 3.87653 19.5243 4.02405 19.71 4.21C19.896 4.39575 20.0435 4.61632 20.1441 4.85912C20.2448 5.10192 20.2966 5.36217 20.2966 5.625C20.2966 5.88783 20.2448 6.14808 20.1441 6.39088C20.0435 6.63368 19.896 6.85425 19.71 7.04L19.65 7.1C19.4195 7.33568 19.2648 7.63502 19.206 7.95941C19.1472 8.28381 19.1869 8.61838 19.32 8.92V9C19.4468 9.29577 19.6572 9.54802 19.9255 9.72569C20.1938 9.90337 20.5082 9.99872 20.83 10H21C21.5304 10 22.0391 10.2107 22.4142 10.5858C22.7893 10.9609 23 11.4696 23 12C23 12.5304 22.7893 13.0391 22.4142 13.4142C22.0391 13.7893 21.5304 14 21 14H20.91C20.5882 14.0013 20.2738 14.0966 20.0055 14.2743C19.7372 14.452 19.5268 14.7042 19.4 15Z" stroke="#1E1E1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-sm font-semibold">
                            Settings
                        </span>
                        
                    </a>
                </div>
            </div>
        </header>

        <section class="w-full">
      
            <!-- Profile Tab Buttons -->
            <nav class="relative w-full border-b border-gray-300 mb-8">
                <div id="fadeLeft" class="pointer-events-none absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white to-transparent z-10 sm:hidden"></div>
    
                <div id="fadeRight" class="pointer-events-none absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent z-10 sm:hidden"></div>
                <div class="flex max-w-6xl mb-2 mx-auto justify-center">
                    <div id="tabScroll" class="flex flex-nowrap overflow-x-auto gap-8 no-scrollbar pb-px scrollbar-hide snap-x select-none">
                        
                        <button type="button" 
                            class="tab-btn active flex-shrink-0 px-5 py-3 text-md sm:text-base font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-800 transition-all snap-start" 
                            data-tab="account">
                            Account Details
                        </button>

                        <button type="button" 
                            class="tab-btn flex-shrink-0 px-5 py-3 text-md sm:text-base font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-800 transition-all snap-start" 
                            data-tab="lost">
                            Lost Items
                        </button>

                        <button type="button" 
                            class="tab-btn flex-shrink-0 px-5 py-3 text-md sm:text-base font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-800 transition-all snap-start" 
                            data-tab="found">
                            Found Items
                        </button>

                        <button type="button" 
                            class="tab-btn flex-shrink-0 px-5 py-3 text-md sm:text-base font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-800 transition-all snap-start" 
                            data-tab="archive">
                            Archive Items
                        </button>

                    </div>
                </div>
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
                            <div class="border rounded-2xl p-4 bg-white w-full min-h-[480px] flex flex-col shadow-[0_4px_12px_rgba(0,0,0,0.20)] hover:shadow-[0_6px_20px_rgba(0,0,0,0.25)] transition-shadow duration-300">
                                <!-- Card Header -->
                                <div class="py-2 mb-4 border-b-2 border-[#5B5B5B]">
                                    <h3 class="font-semibold text-lg"><span class="text-red-500">[ Lost ]</span> <?= htmlspecialchars($item['item_name']) ?></h3>
                                    <p class="text-sm"><?= date("F, j, Y", strtotime($item['event_date'])) ?></p>
                                </div>
                                <!-- Card Content -->
                                <div class="flex flex-col flex-grow">
                                    <img src="<?= htmlspecialchars($item['image_path']) ?>"
                                        alt="<?= htmlspecialchars($item['item_name']) ?>"
                                        class="w-full h-60 object-cover rounded-lg">

                                    <div class="flex items-center gap-1 mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-6 h-5" 
                                            fill="none" 
                                            stroke="currentColor" 
                                            stroke-width="2" 
                                            viewBox="0 0 24 24">
                                        <!-- Pin outline -->
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3c-3.866 0-7 3.134-7 7 0 4.418 7 11 7 11s7-6.582 7-11c0-3.866-3.134-7-7-7z"/>
                                        <!-- Center circle -->
                                        <circle cx="12" cy="10" r="2"/>
                                        </svg>

                                        <p class="text-sm"> Last seen at 
                                            <span class="font-semibold">
                                            <?= htmlspecialchars($item['location_name']) ?>
                                            <!-- Handle if room number is available -->
                                            <?php if (!empty($item['room_number'])): ?>
                                                - Room <?= htmlspecialchars($item['room_number']) ?>
                                            <?php endif; ?>
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <!-- Item Description -->
                                    <p class="text-sm mt-2 mb-2">
                                        <?= htmlspecialchars($item['description'] ?? 'No description provided.') ?>
                                    </p>
                                    <div class="mt-auto flex justify-end">
                                        <button class="px-4 py-2 text-md font-semibold font-medium bg-[#055BA8] text-white rounded-xl hover:bg-blue-700 transition">
                                            Contact Owner
                                        </button>
                                    </div>
                                </div>
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
                            <div class="border rounded-2xl p-4 bg-white w-full min-h-[480px] flex flex-col shadow-[0_4px_12px_rgba(0,0,0,0.20)] hover:shadow-[0_6px_20px_rgba(0,0,0,0.25)] transition-shadow duration-300">
                                <!-- Card Header -->
                                <div class="py-2 mb-4 border-b-2 border-[#5B5B5B]">
                                    <h3 class="font-semibold text-lg"><span class="text-green-500">[ Found ]</span> <?= htmlspecialchars($item['item_name']) ?></h3>
                                    <p class="text-sm"><?= date("F, j, Y", strtotime($item['event_date'])) ?></p>
                                </div>

                                <!-- Card Content -->
                                <div class="flex flex-col flex-grow">
                                    <img src="<?= htmlspecialchars($item['image_path']) ?>"
                                        alt="<?= htmlspecialchars($item['item_name']) ?>"
                                        class="w-full h-48 object-cover rounded-lg">

                                    <div class="flex items-center gap-1 mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-6 h-5" 
                                            fill="none" 
                                            stroke="currentColor" 
                                            stroke-width="2" 
                                            viewBox="0 0 24 24">
                                        <!-- Pin outline -->
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3c-3.866 0-7 3.134-7 7 0 4.418 7 11 7 11s7-6.582 7-11c0-3.866-3.134-7-7-7z"/>
                                        <!-- Center circle -->
                                        <circle cx="12" cy="10" r="2"/>
                                        </svg>

                                        <p class="text-sm"> Last seen at 
                                            <span class="font-semibold">
                                            <?= htmlspecialchars($item['location_name']) ?>
                                            <!-- Handle if room number is available -->
                                            <?php if (!empty($item['room_number'])): ?>
                                                - Room <?= htmlspecialchars($item['room_number']) ?>
                                            <?php endif; ?>
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <!-- Item Description -->
                                    <p class="text-sm mt-2">
                                        <?= htmlspecialchars($item['description'] ?? 'No description provided.') ?>
                                    </p>
                                    <div class="mt-auto flex justify-end">
                                        <button class="px-4 py-2 text-md font-semibold font-medium bg-[#055BA8] text-white rounded-xl hover:bg-blue-700 transition">
                                            Contact Owner
                                        </button>
                                    </div>
                                </div>
                                
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
