<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/found/index.js" defer></script>
</head>
<body class="font-poppins bg-white text-primary min-h-screen">
<?php require __DIR__ . "/../mainpages/header.php"?>
<main class="mx-auto max-w-[1327px] px-4 py-10 sm:px-6">
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
        <ul class="flex items-center gap-8 text-md font-semibold">
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

    <?php /*
    // Bulk archive UI is temporarily cut during the staged Figma implementation.
    // Bring it back once the matching UI section is designed.
    <style>
        .bulk-archive-box,
        .bulk-archive-submit {
            display: none;
        }

        .bulk-archive-mode .bulk-archive-box,
        .bulk-archive-mode .bulk-archive-submit {
            display: block;
        }
    </style>
    */ ?>

    <?php if (!empty($flash['success'])): ?>
        <article style="border-left: 4px solid #2ecc71; padding: 1rem;">
            <strong>Success:</strong> <?= htmlspecialchars($flash['success']) ?>
        </article>
    <?php elseif (!empty($flash['error'])): ?>
        <article style="border-left: 4px solid #e74c3c; padding: 1rem;">
            <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
        </article>
    <?php endif; ?>

    <?php
        // Only show bulk archive mode if at least one post belongs to the current user.
        $hasBulkArchivable = false;
        foreach ($foundItems ?? [] as $bulkItem) {
            if (!empty($bulkItem['can_archive'])) {
                $hasBulkArchivable = true;
                break;
            }
        }
    ?>

    <?php /*
    // Action buttons: Post Found Item and Archive (bulk mode).
    // Bring them back once the matching UI section is designed.
    <div class="mb-8 flex flex-wrap items-center justify-center gap-3">
        <a
            href="/found/post"
            role="button"
            class="inline-flex items-center justify-center rounded-2xl bg-primary-500 px-5 py-3 text-sm font-semibold text-white-50 transition-colors hover:bg-primary-600"
            style="margin:0;"
        >
            Post a Found Item
        </a>
        <?php if ($hasBulkArchivable): ?>
            <button
                type="button"
                id="toggle-bulk-archive"
                class="inline-flex items-center justify-center rounded-2xl border border-primary-500 px-5 py-3 text-sm font-semibold text-primary-500 transition-colors hover:bg-primary-50"
                onclick="toggleBulkArchiveMode()"
                style="margin:0;"
            >
                Archive Found Items
            </button>
        <?php endif; ?>
    </div>
    */ ?>

    <!--FOUND ITEM CARDS -->
    <?php if (empty($foundItems)): ?>
        <p>No found items reported yet.</p>
    <?php else: ?>
        <?php /*
        // Bulk archive form is temporarily cut during the staged Figma implementation.
        // Bring it back once the matching UI section is designed.
        <?php if ($hasBulkArchivable): ?>
            <!-- Standalone form so it does not clash with the forms inside each modal. -->
            <form id="bulk-archive-form" method="POST" action="/found/archive" onsubmit="return confirm('Archive the selected found items?');">
                <?php \App\Core\Router::setCsrf(); ?>
            </form>
        <?php endif; ?>
        */ ?>

        <section class="flex flex-wrap justify-center gap-6">
            <?php foreach ($foundItems as $item): ?>
                <article class="item-card flex h-full w-full max-w-[405px] flex-col items-start gap-4 overflow-hidden rounded-[32px] border border-[#d9d9d9] bg-white px-[22px] py-6 shadow-[0_4px_16px_0_rgba(0,0,0,0.20)]">
                    <?php /*
                    // Bulk archive checkbox is temporarily cut during the staged Figma implementation.
                    // Bring it back once the matching UI section is designed.
                    <?php if (!empty($item['can_archive'])): ?>
                        <label class="bulk-archive-box text-sm text-secondary" style="margin-bottom:0.75rem;">
                            <input type="checkbox" name="item_ids[]" value="<?= (int)$item['id'] ?>" form="bulk-archive-form">
                            Select for bulk archive
                        </label>
                    <?php endif; ?>
                    */ ?>

                    <header class="flex w-full flex-col items-start gap-4">
                        <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[124px] bg-white-600 text-sm font-semibold text-primary">
                            <?= strtoupper(substr((string)($item['name'] ?: 'A'), 0, 1)) ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-lg font-semibold text-primary">
                                <span class="mr-1 text-green-800">[Found]</span><?= htmlspecialchars($item['title']) ?>
                            </p>
                            <p class="text-sm font-normal text-primary"><?= htmlspecialchars(!empty($item['date_found']) ? preg_replace('/(\d{4})\s+(\d{1,2}:\d{2}(?::\d{2})?\s*[APMapm]*)$/', '$1 at $2', (string) $item['date_found']) : 'Date unavailable') ?></p>
                        </div>
                        </div>
                    </header>

                    <div class="w-full max-w-[362px] self-center border-t border-secondary"></div>
                    
                    <?php if ($item['image_url']): ?>
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="h-[260.188px] w-full max-w-[362px] rounded-2xl object-cover">
                    <?php else: ?>
                        <div class="flex h-[260.188px] w-full max-w-[362px] items-center justify-center rounded-2xl border border-dashed border-white-700 bg-white-50 text-sm text-secondary">
                            No Image
                        </div>
                    <?php endif; ?>

                    <div class="space-y-3 text-sm text-secondary">
                        <div class="flex items-start gap-2 text-sm font-normal text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="none" class="mt-0.5 h-[19.314px] w-4 shrink-0">
                                <path d="M14.6569 14.6569C13.7202 15.5935 11.7616 17.5521 10.4138 18.8999C9.63275 19.681 8.36768 19.6814 7.58663 18.9003C6.26234 17.576 4.34159 15.6553 3.34315 14.6569C0.218951 11.5327 0.218951 6.46734 3.34315 3.34315C6.46734 0.218951 11.5327 0.218951 14.6569 3.34315C17.781 6.46734 17.781 11.5327 14.6569 14.6569Z" stroke="#0A0A0A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 9C12 10.6569 10.6569 12 9 12C7.34315 12 6 10.6569 6 9C6 7.34315 7.34315 6 9 6C10.6569 6 12 7.34315 12 9Z" stroke="#0A0A0A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Last seen at <?= htmlspecialchars($item['location'] ?: 'Unknown location') ?></span>
                        </div>

                        <p class="text-sm font-normal text-primary"><?= htmlspecialchars($item['description']) ?></p>
                    </div>
                    
                    <footer class="mt-auto flex w-full flex-wrap justify-end gap-3 pt-2">
                        <?php if (($item['status'] ?? '') !== 'Recovered'): ?>
                            <button class="ml-auto inline-flex items-center justify-center rounded-2xl bg-primary-500 px-5 py-3 text-sm font-semibold text-white-50 transition-colors hover:bg-primary-600" onclick="openModal('contact-modal-<?= $item['id'] ?>')">
                                Contact Finder
                            </button>
                        <?php endif; ?>
                        
                        <?php /*
                        // Recover action UI is temporarily cut during the staged Figma implementation.
                        // Bring it back once the matching UI section is designed.
                        <?php if (!empty($item['can_recover'])): ?>
                            <button type="button"
                                    class="inline-flex items-center justify-center rounded-2xl border border-primary-500 px-5 py-3 text-sm font-semibold text-primary-500 transition-colors hover:bg-primary-50"
                                    onclick="openModal('recover-modal-<?= $item['id'] ?>')">
                                Mark as Recovered
                            </button>
                        <?php endif; ?>
                        */ ?>
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

                    <?php /*
                    // Recover modal UI is temporarily cut during the staged Figma implementation.
                    // Bring it back once the matching UI section is designed.
                    <?php if (!empty($item['can_recover'])): ?>
                        <dialog id="recover-modal-<?= $item['id'] ?>">
                            <article>
                                <header>
                                    <button aria-label="Close" rel="prev" onclick="closeModal('recover-modal-<?= $item['id'] ?>')"></button>
                                    <h3>Confirm Recovery</h3>
                                </header>
                                <p>
                                    Are you sure you want to mark this found item as recovered? This will update its status for everyone.
                                    <?php if (!empty($item['archive_date'])): ?>
                                        <br><small>This post will be archived on <strong><?= htmlspecialchars($item['archive_date']) ?></strong>.</small>
                                    <?php endif; ?>
                                </p>
                                <footer>
                                    <form method="POST" action="/found/recover" style="display:inline-block; margin-right: 0.5rem;">
                                        <?php \App\Core\Router::setCsrf(); ?>
                                        <input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit">
                                            Yes, mark as recovered
                                        </button>
                                    </form>

                                    <form method="POST" action="/found/archive" style="display:inline-block; margin-left: 0.5rem;">
                                        <?php \App\Core\Router::setCsrf(); ?>
                                        <input type="hidden" name="item_ids[]" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="secondary outline" onclick="return confirm('Are you sure you want to archive this item?');">
                                            Archive
                                        </button>
                                    </form>

                                    <form method="POST" action="/found/delay-archive" style="display:inline-block; margin-left: 0.5rem;">
                                        <?php \App\Core\Router::setCsrf(); ?>
                                        <input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>">
                                        <input type="hidden" name="delay_days" value="7">
                                        <button type="submit" class="outline" data-tooltip="Adds 7 days to auto-archive date">
                                            Delay Archiving
                                        </button>
                                    </form>
                                </footer>
                            </article>
                        </dialog>
                    <?php endif; ?>
                    */ ?>
                </article>
            <?php endforeach; ?>
        </section>

        <?php /*
        // Bulk archive submit UI is temporarily cut during the staged Figma implementation.
        // Bring it back once the matching UI section is designed.
        <?php if ($hasBulkArchivable): ?>
            <button type="submit" form="bulk-archive-form" class="secondary bulk-archive-submit" style="margin-top: 1rem;">
                Archive Selected
            </button>
        <?php endif; ?>
        */ ?>
    <?php endif; ?>
</main>

</body>
</html>
