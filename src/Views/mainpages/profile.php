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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.3792 15.6405L15.8352 15.1875L14.7762 14.1235L14.3222 14.5765L15.3792 15.6405ZM17.3642 14.9975L19.2752 16.0365L19.9902 14.7185L18.0802 13.6805L17.3642 14.9975ZM19.6422 18.1005L18.2222 19.5135L19.2792 20.5765L20.6992 19.1645L19.6422 18.1005ZM17.3562 19.9675C15.9062 20.1035 12.1562 19.9825 8.09417 15.9445L7.03617 17.0075C11.4682 21.4145 15.6872 21.6305 17.4962 21.4615L17.3562 19.9675ZM8.09417 15.9445C4.22317 12.0945 3.58117 8.85747 3.50117 7.45247L2.00317 7.53747C2.10317 9.30547 2.89817 12.8935 7.03617 17.0075L8.09417 15.9445ZM9.46917 9.76447L9.75617 9.47847L8.70017 8.41547L8.41317 8.70047L9.46917 9.76447ZM9.98417 5.84347L8.72417 4.15947L7.52317 5.05947L8.78317 6.74247L9.98417 5.84347ZM4.48317 3.79247L2.91317 5.35247L3.97117 6.41647L5.54017 4.85647L4.48317 3.79247ZM8.94117 9.23247C8.41117 8.70047 8.41117 8.70047 8.41117 8.70247H8.40917L8.40617 8.70647C8.35865 8.75439 8.3161 8.80699 8.27917 8.86347C8.22517 8.94347 8.16617 9.04847 8.11617 9.18147C7.99445 9.5248 7.96412 9.89388 8.02817 10.2525C8.16217 11.1175 8.75817 12.2605 10.2842 13.7785L11.3422 12.7145C9.91317 11.2945 9.57317 10.4305 9.51017 10.0225C9.48017 9.82847 9.51117 9.73247 9.52017 9.71047C9.52617 9.69714 9.52617 9.69514 9.52017 9.70447C9.51126 9.71827 9.50122 9.73132 9.49017 9.74347L9.48017 9.75347L9.47017 9.76247L8.94117 9.23247ZM10.2842 13.7785C11.8112 15.2965 12.9602 15.8885 13.8262 16.0205C14.2692 16.0885 14.6262 16.0345 14.8972 15.9335C15.049 15.8779 15.1908 15.7983 15.3172 15.6975L15.3672 15.6525L15.3742 15.6465L15.3772 15.6435L15.3782 15.6415C15.3782 15.6415 15.3792 15.6405 14.8502 15.1085C14.3202 14.5765 14.3232 14.5755 14.3232 14.5755L14.3252 14.5735L14.3272 14.5715L14.3332 14.5665L14.3432 14.5565L14.3812 14.5265C14.3905 14.5205 14.3882 14.5211 14.3742 14.5285C14.3492 14.5375 14.2512 14.5685 14.0542 14.5385C13.6402 14.4745 12.7702 14.1345 11.3422 12.7145L10.2842 13.7785ZM8.72417 4.15847C7.70417 2.79847 5.70017 2.58247 4.48317 3.79247L5.54017 4.85647C6.07217 4.32747 7.01617 4.38247 7.52317 5.05947L8.72417 4.15847ZM3.50217 7.45347C3.48217 7.10747 3.64117 6.74547 3.97117 6.41747L2.91217 5.35347C2.37517 5.88747 1.95217 6.64347 2.00317 7.53747L3.50217 7.45347ZM18.2222 19.5135C17.9482 19.7875 17.6522 19.9415 17.3572 19.9685L17.4962 21.4615C18.2312 21.3925 18.8322 21.0225 19.2802 20.5775L18.2222 19.5135ZM9.75617 9.47847C10.7412 8.49947 10.8142 6.95247 9.98517 5.84447L8.78417 6.74347C9.18717 7.28247 9.12717 7.98947 8.69917 8.41647L9.75617 9.47847ZM19.2762 16.0375C20.0932 16.4815 20.2202 17.5275 19.6432 18.1015L20.7012 19.1645C22.0412 17.8315 21.6282 15.6085 19.9912 14.7195L19.2762 16.0375ZM15.8352 15.1885C16.2192 14.8065 16.8372 14.7125 17.3652 14.9985L18.0812 13.6815C16.9972 13.0915 15.6532 13.2545 14.7772 14.1245L15.8352 15.1885Z" fill="#5B5B5B"/>
                                </svg>
                                <p class="text-sm"><?= htmlspecialchars($_SESSION['phone_number']) ?></p>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17C5.61667 17 4.43767 16.5123 3.463 15.537C2.48833 14.5617 2.00067 13.3827 2 12C1.99933 10.6173 2.487 9.43833 3.463 8.463C4.439 7.48767 5.618 7 7 7H10C10.2833 7 10.521 7.096 10.713 7.288C10.905 7.48 11.0007 7.71733 11 8C10.9993 8.28267 10.9033 8.52033 10.712 8.713C10.5207 8.90567 10.2833 9.00133 10 9H7C6.16667 9 5.45833 9.29167 4.875 9.875C4.29167 10.4583 4 11.1667 4 12C4 12.8333 4.29167 13.5417 4.875 14.125C5.45833 14.7083 6.16667 15 7 15H10C10.2833 15 10.521 15.096 10.713 15.288C10.905 15.48 11.0007 15.7173 11 16C10.9993 16.2827 10.9033 16.5203 10.712 16.713C10.5207 16.9057 10.2833 17.0013 10 17H7ZM9 13C8.71667 13 8.47933 12.904 8.288 12.712C8.09667 12.52 8.00067 12.2827 8 12C7.99933 11.7173 8.09533 11.48 8.288 11.288C8.48067 11.096 8.718 11 9 11H15C15.2833 11 15.521 11.096 15.713 11.288C15.905 11.48 16.0007 11.7173 16 12C15.9993 12.2827 15.9033 12.5203 15.712 12.713C15.5207 12.9057 15.2833 13.0013 15 13H9ZM14 17C13.7167 17 13.4793 16.904 13.288 16.712C13.0967 16.52 13.0007 16.2827 13 16C12.9993 15.7173 13.0953 15.48 13.288 15.288C13.4807 15.096 13.718 15 14 15H17C17.8333 15 18.5417 14.7083 19.125 14.125C19.7083 13.5417 20 12.8333 20 12C20 11.1667 19.7083 10.4583 19.125 9.875C18.5417 9.29167 17.8333 9 17 9H14C13.7167 9 13.4793 8.904 13.288 8.712C13.0967 8.52 13.0007 8.28267 13 8C12.9993 7.71733 13.0953 7.48 13.288 7.288C13.4807 7.096 13.718 7 14 7H17C18.3833 7 19.5627 7.48767 20.538 8.463C21.5133 9.43833 22.0007 10.6173 22 12C21.9993 13.3827 21.5117 14.562 20.537 15.538C19.5623 16.514 18.3833 17.0013 17 17H14Z" fill="#5B5B5B"/>
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
