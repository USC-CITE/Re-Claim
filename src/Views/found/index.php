<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/found/index.js" defer></script>
</head>
<body class="font-poppins bg-white text-primary min-h-screen overflow-x-hidden">
<?php require __DIR__ . "/../mainpages/header.php"?>
<main class="mx-auto max-w-[1327px] px-4 py-8 sm:px-6 sm:py-10">
    <hgroup class="mb-8 space-y-2 text-center">
        <h1 class="text-center text-display-md font-bold text-black">Found Items</h1>
    </hgroup>

      <!-- SEARCH AND FILTER -->
    <section class="mb-8 flex justify-center">
        <!-- SEARCH BAR -->
        <form class="flex w-full max-w-[575px] items-center justify-center gap-3" role="search">
            <label for="found-search" class="sr-only">Search found items</label>
            <section class="relative h-[40px] min-w-0 flex-1 max-w-[521px] overflow-hidden rounded-[12px] border border-[#212121] bg-transparent">
                <input
                    id="found-search"
                    type="search"
                    placeholder="Search found items"
                    class="h-full w-full border-0 bg-transparent pl-4 pr-14 text-sm text-primary shadow-none outline-none placeholder:text-secondary focus:border-0 focus:ring-0"
                >
                <span class="pointer-events-none absolute right-0 top-0 flex h-[38px] w-[43.417px] items-center justify-center rounded-r-[10px] bg-[#E5E5E5]" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none" class="h-[20px] w-[17.367px]">
                        <path d="M17.3667 18.0383L12.8406 12.8675C13.6919 11.53 14.1952 9.885 14.1952 8.10833C14.1952 3.6375 11.0113 0 7.09722 0C3.1839 0 0 3.6375 0 8.10833C0 12.58 3.1839 16.2167 7.09722 16.2167C8.58085 16.2167 9.95872 15.6942 11.0995 14.8017L15.6496 20L17.3667 18.0383ZM2.08175 8.10833C2.08175 4.94833 4.332 2.3775 7.09795 2.3775C9.86389 2.3775 12.1141 4.94833 12.1141 8.10833C12.1141 11.2683 9.86389 13.8392 7.09795 13.8392C4.33127 13.8392 2.08175 11.2683 2.08175 8.10833Z" fill="#212121"/>
                    </svg>
                </span>
            </section>
            
            <!--FILTER -->
            <button
                type="button"
                aria-label="Filter found items"
                data-filter-toggle
                class="flex h-[38px] w-[38px] shrink-0 items-center justify-center gap-[10px] rounded-2xl border border-black bg-white p-[9px_10px]"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14" fill="none">
                    <path d="M3.80952 1.52568C3.60745 1.52568 3.41366 1.60595 3.27078 1.74883C3.12789 1.89172 3.04762 2.08551 3.04762 2.28758C3.04762 2.48965 3.12789 2.68344 3.27078 2.82633C3.41366 2.96921 3.60745 3.04949 3.80952 3.04949C4.01159 3.04949 4.20539 2.96921 4.34827 2.82633C4.49116 2.68344 4.57143 2.48965 4.57143 2.28758C4.57143 2.08551 4.49116 1.89172 4.34827 1.74883C4.20539 1.60595 4.01159 1.52568 3.80952 1.52568ZM1.65333 1.52568C1.81074 1.07956 2.10266 0.693245 2.48884 0.419992C2.87502 0.14674 3.33645 0 3.80952 0C4.2826 0 4.74403 0.14674 5.13021 0.419992C5.51639 0.693245 5.8083 1.07956 5.96571 1.52568H11.4286C11.6306 1.52568 11.8244 1.60595 11.9673 1.74883C12.1102 1.89172 12.1905 2.08551 12.1905 2.28758C12.1905 2.48965 12.1102 2.68344 11.9673 2.82633C11.8244 2.96921 11.6306 3.04949 11.4286 3.04949H5.96571C5.8083 3.49561 5.51639 3.88192 5.13021 4.15517C4.74403 4.42842 4.2826 4.57516 3.80952 4.57516C3.33645 4.57516 2.87502 4.42842 2.48884 4.15517C2.10266 3.88192 1.81074 3.49561 1.65333 3.04949H0.761905C0.559835 3.04949 0.366042 2.96921 0.223157 2.82633C0.080272 2.68344 0 2.48965 0 2.28758C0 2.08551 0.080272 1.89172 0.223157 1.74883C0.366042 1.60595 0.559835 1.52568 0.761905 1.52568H1.65333ZM8.38095 6.09711C8.17888 6.09711 7.98509 6.17738 7.8422 6.32026C7.69932 6.46315 7.61905 6.65694 7.61905 6.85901C7.61905 7.06108 7.69932 7.25487 7.8422 7.39776C7.98509 7.54064 8.17888 7.62091 8.38095 7.62091C8.58302 7.62091 8.77682 7.54064 8.9197 7.39776C9.06258 7.25487 9.14286 7.06108 9.14286 6.85901C9.14286 6.65694 9.06258 6.46315 8.9197 6.32026C8.77682 6.17738 8.58302 6.09711 8.38095 6.09711ZM6.22476 6.09711C6.38217 5.65099 6.67409 5.26467 7.06027 4.99142C7.44645 4.71817 7.90788 4.57143 8.38095 4.57143C8.85403 4.57143 9.31546 4.71817 9.70164 4.99142C10.0878 5.26467 10.3797 5.65099 10.5371 6.09711H11.4286C11.6306 6.09711 11.8244 6.17738 11.9673 6.32026C12.1102 6.46315 12.1905 6.65694 12.1905 6.85901C12.1905 7.06108 12.1102 7.25487 11.9673 7.39776C11.8244 7.54064 11.6306 7.62091 11.4286 7.62091H10.5371C10.3797 8.06704 10.0878 8.45335 9.70164 8.7266C9.31546 8.99985 8.85403 9.14659 8.38095 9.14659C7.90788 9.14659 7.44645 8.99985 7.06027 8.7266C6.67409 8.45335 6.38217 8.06704 6.22476 7.62091H0.761905C0.559835 7.62091 0.366042 7.54064 0.223157 7.39776C0.080272 7.25487 0 7.06108 0 6.85901C0 6.65694 0.080272 6.46315 0.223157 6.32026C0.366042 6.17738 0.559835 6.09711 0.761905 6.09711H6.22476ZM3.80952 10.6685C3.60745 10.6685 3.41366 10.7488 3.27078 10.8917C3.12789 11.0346 3.04762 11.2284 3.04762 11.4304C3.04762 11.6325 3.12789 11.8263 3.27078 11.9692C3.41366 12.1121 3.60745 12.1923 3.80952 12.1923C4.01159 12.1923 4.20539 12.1121 4.34827 11.9692C4.49116 11.8263 4.57143 11.6325 4.57143 11.4304C4.57143 11.2284 4.49116 11.0346 4.34827 10.8917C4.20539 10.7488 4.01159 10.6685 3.80952 10.6685ZM1.65333 10.6685C1.81074 10.2224 2.10266 9.8361 2.48884 9.56285C2.87502 9.2896 3.33645 9.14286 3.80952 9.14286C4.2826 9.14286 4.74403 9.2896 5.13021 9.56285C5.51639 9.8361 5.8083 10.2224 5.96571 10.6685H11.4286C11.6306 10.6685 11.8244 10.7488 11.9673 10.8917C12.1102 11.0346 12.1905 11.2284 12.1905 11.4304C12.1905 11.6325 12.1102 11.8263 11.9673 11.9692C11.8244 12.1121 11.6306 12.1923 11.4286 12.1923H5.96571C5.8083 12.6385 5.51639 13.0248 5.13021 13.298C4.74403 13.5713 4.2826 13.718 3.80952 13.718C3.33645 13.718 2.87502 13.5713 2.48884 13.298C2.10266 13.0248 1.81074 12.6385 1.65333 12.1923H0.761905C0.559835 12.1923 0.366042 12.1121 0.223157 11.9692C0.080272 11.8263 0 11.6325 0 11.4304C0 11.2284 0.080272 11.0346 0.223157 10.8917C0.366042 10.7488 0.559835 10.6685 0.761905 10.6685H1.65333Z" fill="#212121"/>
                </svg>
            </button>
        </form>
    </section>

    <!-- LOST AND FOUND TABS -->
    <nav aria-label="Listing type" class="mb-10 flex justify-center">
        <ul class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-md font-semibold sm:gap-8">
            <li>
                <a href="/lost" class="border-b-2 border-transparent pb-1 text-secondary transition-colors hover:text-secondary">
                    Lost Items
                </a>
            </li>
            <li>
                <a href="/found" class="border-b-2 border-primary-500 pb-1 text-primary-700">
                    Found Items
                </a>
            </li>
        </ul>
    </nav>

    <section class="mx-auto mb-8 hidden w-full max-w-[840px] rounded-[24px] border border-[#d9d9d9] bg-white p-5 shadow-[0_4px_16px_0_rgba(0,0,0,0.08)]" data-filter-panel>
        <div class="grid gap-4 md:grid-cols-3">
            <label class="flex flex-col gap-2 text-sm font-medium text-primary">
                Recovery status
                <select id="found-status-filter" class="rounded-2xl border border-[#d9d9d9] bg-white px-4 py-3 text-sm text-primary">
                    <option value="">All statuses</option>
                    <option value="Unrecovered">Unrecovered</option>
                    <option value="Recovered">Recovered</option>
                </select>
            </label>
            <label class="flex flex-col gap-2 text-sm font-medium text-primary">
                Location
                <select id="found-location-filter" class="rounded-2xl border border-[#d9d9d9] bg-white px-4 py-3 text-sm text-primary">
                    <option value="">All locations</option>
                </select>
            </label>
            <label class="flex flex-col gap-2 text-sm font-medium text-primary">
                Category tag
                <select id="found-category-filter" class="rounded-2xl border border-[#d9d9d9] bg-white px-4 py-3 text-sm text-primary">
                    <option value="">All categories</option>
                </select>
            </label>
        </div>
    </section>

    <?php if (!empty($flash['success'])): ?>
        <div role="status" class="mx-auto mb-8 flex w-full max-w-[405px] items-center gap-3 rounded-3xl border border-green-100 bg-green-50 px-5 py-4 text-sm text-primary shadow-[0_4px_16px_0_rgba(0,0,0,0.08)] sm:max-w-[840px]">
            <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-800 text-xs font-semibold leading-none text-white">!</span>
            <p class="leading-none"><strong class="font-semibold text-green-800">Success:</strong> <?= htmlspecialchars($flash['success']) ?></p>
        </div>
    <?php elseif (!empty($flash['error'])): ?>
        <div role="alert" class="mx-auto mb-8 flex w-full max-w-[405px] items-center gap-3 rounded-3xl border border-red-100 bg-red-50 px-5 py-4 text-sm text-primary shadow-[0_4px_16px_0_rgba(0,0,0,0.08)] sm:max-w-[840px]">
            <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-600 text-xs font-semibold leading-none text-white">!</span>
            <p class="leading-none"><strong class="font-semibold text-red-600">Error:</strong> <?= htmlspecialchars($flash['error']) ?></p>
        </div>
    <?php endif; ?>

    <!--FOUND ITEM CARDS -->
    <?php if (empty($foundItems)): ?>
        <p>No found items reported yet.</p>
    <?php else: ?>
        <section class="flex flex-wrap justify-center gap-6" data-listing-grid>
            <?php foreach ($foundItems as $item): ?>
                <article class="item-card flex h-full w-full max-w-[405px] min-w-0 flex-col items-start gap-4 overflow-hidden rounded-[32px] border border-[#d9d9d9] bg-white px-4 py-5 shadow-[0_4px_16px_0_rgba(0,0,0,0.20)] sm:px-[22px] sm:py-6" data-item-status="<?= htmlspecialchars((string)($item['status'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-item-location="<?= htmlspecialchars((string)($item['location'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-item-categories="<?= htmlspecialchars(implode('|', $item['categories'] ?? []), ENT_QUOTES, 'UTF-8') ?>">
                    <header class="flex w-full flex-col items-start gap-4">
                        <div class="flex w-full items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[124px] bg-white-600 text-sm font-semibold text-primary">
                            <?= strtoupper(substr((string)($item['name'] ?: 'A'), 0, 1)) ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="item-card-title break-words text-lg font-semibold text-primary">
                                <span class="mr-1 status-tag-<?= strtolower($item['status_tag']) ?>"> [<?= htmlspecialchars($item['status_tag']) ?>] </span> 
                                <?= htmlspecialchars($item['title']) ?>
                            </p>
                            <p class="text-sm font-normal text-primary"><?= htmlspecialchars(!empty($item['date_found']) ? preg_replace('/(\d{4})\s+(\d{1,2}:\d{2}(?::\d{2})?\s*[APMapm]*)$/', '$1 at $2', (string) $item['date_found']) : 'Date unavailable') ?></p>

                            <?php if (!empty($item['categories'])): ?>
                              <div class="mt-3 flex flex-wrap gap-2">
                                <?php foreach ($item['categories'] as $category): ?>
                                  <span class="inline-flex items-center justify-center rounded-[12px] border border-[#03325C] bg-[#E6EFF6] px-3 text-sm font-medium text-[#044177]" style="height:30px; min-width:121px;"><?= htmlspecialchars(trim($category, '"')) ?></span>
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>
                        </div>
                        </div>
                    </header>
                        </div>
                        </div>
                    </header>

                    <div class="w-full self-center border-t border-secondary"></div>
                    
                    <?php if ($item['image_url']): ?>
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="h-auto max-h-[420px] w-full rounded-2xl object-cover sm:h-[260.188px] sm:max-w-[362px] sm:self-center">
                    <?php else: ?>
                        <div class="flex h-[260.188px] w-full items-center justify-center rounded-2xl border border-dashed border-white-700 bg-white-50 text-sm text-secondary sm:max-w-[362px] sm:self-center">
                            No Image
                        </div>
                    <?php endif; ?>

                    <div class="space-y-3 text-sm text-secondary">
                        <div class="flex items-start gap-2 text-sm font-normal text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="none" class="mt-0.5 h-[19.314px] w-4 shrink-0">
                                <path d="M14.6569 14.6569C13.7202 15.5935 11.7616 17.5521 10.4138 18.8999C9.63275 19.681 8.36768 19.6814 7.58663 18.9003C6.26234 17.576 4.34159 15.6553 3.34315 14.6569C0.218951 11.5327 0.218951 6.46734 3.34315 3.34315C6.46734 0.218951 11.5327 0.218951 14.6569 3.34315C17.781 6.46734 17.781 11.5327 14.6569 14.6569Z" stroke="#0A0A0A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 9C12 10.6569 10.6569 12 9 12C7.34315 12 6 10.6569 6 9C6 7.34315 7.34315 6 9 6C10.6569 6 12 7.34315 12 9Z" stroke="#0A0A0A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Last seen at <span class="font-medium text-primary"><?= htmlspecialchars($item['location'] ?: 'Unknown location') ?></span></span>
                        </div>

                        <p class="text-sm font-normal text-primary"><?= htmlspecialchars($item['description']) ?></p>
                    </div>
                    
                    <footer class="mt-auto flex w-full flex-wrap justify-end gap-3 pt-2">
                        <?php if (($item['status'] ?? '') !== 'Recovered'): ?>
                            <button class="ml-auto inline-flex w-full items-center justify-center gap-[10px] self-center rounded-[16px] bg-primary-500 px-6 py-3 text-md font-semibold text-white-500 transition-colors hover:bg-primary-600 sm:max-w-[362px]" onclick="openModal('contact-modal-<?= $item['id'] ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21" fill="none" class="h-[21px] w-6 shrink-0" aria-hidden="true">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24 10.5C24 16.299 18.6274 21 12 21C9.76254 21 7.66811 20.4642 5.87515 19.5312L0 21L2.00745 16.3159C0.739202 14.6509 0 12.651 0 10.5C0 4.70101 5.37258 0 12 0C18.6274 0 24 4.70101 24 10.5ZM7.5 9H4.5V12H7.5V9ZM19.5 9H16.5V12H19.5V9ZM10.5 9H13.5V12H10.5V9Z" fill="white"/>
                                </svg>
                                Contact Finder
                            </button>
                        <?php endif; ?>
                    </footer>

                    <?php if (($item['status'] ?? '') !== 'Recovered'): ?>
                        <dialog id="contact-modal-<?= $item['id'] ?>" class="w-full max-w-xl rounded-[28px] border-none bg-transparent p-0 backdrop:bg-black/30" style="left:50%; top:50%; transform:translate(-50%, -50%);">
                            <article class="w-full rounded-[28px] bg-white p-6 text-primary shadow-[0_12px_32px_rgba(10,10,10,0.18)]">
                                <header class="mb-4 flex items-start justify-between gap-4">
                                    <h3 class="text-display-sm font-semibold text-primary">Contact Finder</h3>
                                    <button type="button" aria-label="Close" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white-700 text-primary transition-colors hover:bg-white-50" onclick="closeModal('contact-modal-<?= $item['id'] ?>')">
                                        <span class="text-lg leading-none">&times;</span>
                                    </button>
                                </header>
                                <p class="text-sm leading-7 text-secondary">
                                    You can contact the finder at:
                                    <strong class="text-primary"><?= htmlspecialchars($item['contact_info'] ?: 'No contact details.') ?></strong>
                                </p>
                                <footer class="mt-6 flex justify-end">
                                    <button type="button" class="inline-flex items-center justify-center rounded-2xl bg-primary-500 px-5 py-3 text-sm font-semibold text-white-50 transition-colors hover:bg-primary-600" onclick="closeModal('contact-modal-<?= $item['id'] ?>')">Close</button>
                                </footer>
                            </article>
                        </dialog>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </section>
        <p class="hidden py-10 text-center text-md text-secondary" data-empty-search-state>No found items match your search.</p>
    <?php endif; ?>
</main>
<?php require __DIR__ . "/../mainpages/footer.php"?>

</body>
</html>
