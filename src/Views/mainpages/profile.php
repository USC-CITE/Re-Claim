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
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24"  fill="white"/>
                            <path d="M13.5 2L13.9961 1.93798C13.9649 1.68777 13.7522 1.5 13.5 1.5V2ZM10.5 2V1.5C10.2478 1.5 10.0351 1.68777 10.0039 1.93798L10.5 2ZM13.7747 4.19754L13.2786 4.25955C13.3047 4.46849 13.4589 4.63867 13.6642 4.68519L13.7747 4.19754ZM16.2617 5.22838L15.995 5.6513C16.1731 5.76362 16.4024 5.75233 16.5687 5.62306L16.2617 5.22838ZM18.0104 3.86826L18.364 3.51471C18.1857 3.3364 17.9025 3.31877 17.7034 3.47359L18.0104 3.86826ZM20.1317 5.98958L20.5264 6.29655C20.6812 6.09751 20.6636 5.81434 20.4853 5.63603L20.1317 5.98958ZM18.7716 7.73831L18.3769 7.43134C18.2477 7.59754 18.2364 7.82693 18.3487 8.00503L18.7716 7.73831ZM19.8025 10.2253L19.3148 10.3358C19.3613 10.5411 19.5315 10.6953 19.7404 10.7214L19.8025 10.2253ZM22 10.5H22.5C22.5 10.2478 22.3122 10.0351 22.062 10.0039L22 10.5ZM22 13.5L22.062 13.9961C22.3122 13.9649 22.5 13.7522 22.5 13.5H22ZM19.8025 13.7747L19.7404 13.2786C19.5315 13.3047 19.3613 13.4589 19.3148 13.6642L19.8025 13.7747ZM18.7716 16.2617L18.3487 15.995C18.2364 16.1731 18.2477 16.4025 18.3769 16.5687L18.7716 16.2617ZM20.1317 18.0104L20.4853 18.364C20.6636 18.1857 20.6812 17.9025 20.5264 17.7034L20.1317 18.0104ZM18.0104 20.1317L17.7034 20.5264C17.9025 20.6812 18.1857 20.6636 18.364 20.4853L18.0104 20.1317ZM16.2617 18.7716L16.5687 18.3769C16.4024 18.2477 16.1731 18.2364 15.995 18.3487L16.2617 18.7716ZM13.7747 19.8025L13.6642 19.3148C13.4589 19.3613 13.3047 19.5315 13.2786 19.7404L13.7747 19.8025ZM13.5 22V22.5C13.7522 22.5 13.9649 22.3122 13.9961 22.062L13.5 22ZM10.5 22L10.0039 22.062C10.0351 22.3122 10.2478 22.5 10.5 22.5V22ZM10.2253 19.8025L10.7214 19.7404C10.6953 19.5315 10.5411 19.3613 10.3358 19.3148L10.2253 19.8025ZM7.73832 18.7716L8.00504 18.3487C7.82694 18.2364 7.59756 18.2477 7.43135 18.3769L7.73832 18.7716ZM5.98959 20.1317L5.63604 20.4853C5.81435 20.6636 6.09752 20.6812 6.29656 20.5264L5.98959 20.1317ZM3.86827 18.0104L3.4736 17.7034C3.31878 17.9025 3.33641 18.1857 3.51472 18.364L3.86827 18.0104ZM5.22839 16.2617L5.62307 16.5687C5.75234 16.4025 5.76363 16.1731 5.65131 15.995L5.22839 16.2617ZM4.19754 13.7747L4.68519 13.6642C4.63867 13.4589 4.46849 13.3047 4.25955 13.2786L4.19754 13.7747ZM2 13.5H1.5C1.5 13.7522 1.68777 13.9649 1.93798 13.9961L2 13.5ZM2 10.5L1.93798 10.0039C1.68777 10.0351 1.5 10.2478 1.5 10.5H2ZM4.19754 10.2253L4.25955 10.7214C4.46849 10.6953 4.63867 10.5411 4.68519 10.3358L4.19754 10.2253ZM5.22839 7.73831L5.65131 8.00503C5.76363 7.82693 5.75234 7.59755 5.62307 7.43134L5.22839 7.73831ZM3.86827 5.98959L3.51472 5.63603C3.33641 5.81434 3.31878 6.09751 3.47359 6.29656L3.86827 5.98959ZM5.98959 3.86827L6.29656 3.47359C6.09752 3.31878 5.81434 3.33641 5.63604 3.51471L5.98959 3.86827ZM7.73832 5.22839L7.43135 5.62306C7.59755 5.75233 7.82694 5.76363 8.00504 5.6513L7.73832 5.22839ZM10.2253 4.19754L10.3358 4.68519C10.5411 4.63867 10.6953 4.46849 10.7214 4.25955L10.2253 4.19754ZM13.5 1.5H10.5V2.5H13.5V1.5ZM14.2708 4.13552L13.9961 1.93798L13.0039 2.06202L13.2786 4.25955L14.2708 4.13552ZM16.5284 4.80547C15.7279 4.30059 14.8369 3.92545 13.8851 3.70989L13.6642 4.68519C14.503 4.87517 15.2886 5.20583 15.995 5.6513L16.5284 4.80547ZM16.5687 5.62306L18.3174 4.26294L17.7034 3.47359L15.9547 4.83371L16.5687 5.62306ZM17.6569 4.22182L19.7782 6.34314L20.4853 5.63603L18.364 3.51471L17.6569 4.22182ZM19.7371 5.68261L18.3769 7.43134L19.1663 8.04528L20.5264 6.29655L19.7371 5.68261ZM20.2901 10.1149C20.0746 9.16313 19.6994 8.27213 19.1945 7.47158L18.3487 8.00503C18.7942 8.71138 19.1248 9.49695 19.3148 10.3358L20.2901 10.1149ZM22.062 10.0039L19.8645 9.72917L19.7404 10.7214L21.938 10.9961L22.062 10.0039ZM22.5 13.5V10.5H21.5V13.5H22.5ZM19.8645 14.2708L22.062 13.9961L21.938 13.0039L19.7404 13.2786L19.8645 14.2708ZM19.1945 16.5284C19.6994 15.7279 20.0746 14.8369 20.2901 13.8851L19.3148 13.6642C19.1248 14.503 18.7942 15.2886 18.3487 15.995L19.1945 16.5284ZM20.5264 17.7034L19.1663 15.9547L18.3769 16.5687L19.7371 18.3174L20.5264 17.7034ZM18.364 20.4853L20.4853 18.364L19.7782 17.6569L17.6569 19.7782L18.364 20.4853ZM15.9547 19.1663L17.7034 20.5264L18.3174 19.7371L16.5687 18.3769L15.9547 19.1663ZM13.8851 20.2901C14.8369 20.0746 15.7279 19.6994 16.5284 19.1945L15.995 18.3487C15.2886 18.7942 14.503 19.1248 13.6642 19.3148L13.8851 20.2901ZM13.9961 22.062L14.2708 19.8645L13.2786 19.7404L13.0039 21.938L13.9961 22.062ZM10.5 22.5H13.5V21.5H10.5V22.5ZM9.72917 19.8645L10.0039 22.062L10.9961 21.938L10.7214 19.7404L9.72917 19.8645ZM7.4716 19.1945C8.27214 19.6994 9.16314 20.0746 10.1149 20.2901L10.3358 19.3148C9.49696 19.1248 8.71139 18.7942 8.00504 18.3487L7.4716 19.1945ZM6.29656 20.5264L8.04529 19.1663L7.43135 18.3769L5.68262 19.7371L6.29656 20.5264ZM3.51472 18.364L5.63604 20.4853L6.34315 19.7782L4.22183 17.6569L3.51472 18.364ZM4.83372 15.9547L3.4736 17.7034L4.26295 18.3174L5.62307 16.5687L4.83372 15.9547ZM3.70989 13.8851C3.92545 14.8369 4.30059 15.7279 4.80547 16.5284L5.65131 15.995C5.20584 15.2886 4.87517 14.503 4.68519 13.6642L3.70989 13.8851ZM1.93798 13.9961L4.13552 14.2708L4.25955 13.2786L2.06202 13.0039L1.93798 13.9961ZM1.5 10.5V13.5H2.5V10.5H1.5ZM4.13552 9.72917L1.93798 10.0039L2.06202 10.9961L4.25955 10.7214L4.13552 9.72917ZM4.80547 7.47159C4.30059 8.27213 3.92545 9.16313 3.70989 10.1149L4.68519 10.3358C4.87517 9.49696 5.20583 8.71138 5.65131 8.00503L4.80547 7.47159ZM3.47359 6.29656L4.83371 8.04528L5.62307 7.43134L4.26295 5.68262L3.47359 6.29656ZM5.63604 3.51471L3.51472 5.63603L4.22182 6.34314L6.34314 4.22182L5.63604 3.51471ZM8.04529 4.83371L6.29656 3.47359L5.68262 4.26294L7.43135 5.62306L8.04529 4.83371ZM10.1149 3.70989C9.16313 3.92545 8.27214 4.30059 7.4716 4.80547L8.00504 5.6513C8.71139 5.20583 9.49696 4.87517 10.3358 4.68519L10.1149 3.70989ZM10.0039 1.93798L9.72917 4.13552L10.7214 4.25955L10.9961 2.06202L10.0039 1.93798Z" fill="#000000"/>
                            <circle cx="12" cy="12" r="4" stroke="#000000" stroke-linejoin="round"/>
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
            <nav class="w-full border-b border-gray-300 mb-8">
                <div class="flex max-w-6xl mb-2 mx-auto justify-center">
                    <div class="flex flex-nowrap overflow-x-auto gap-8 no-scrollbar pb-px scrollbar-hide snap-x select-none">
                        
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
