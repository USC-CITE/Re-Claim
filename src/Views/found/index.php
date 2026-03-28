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
<main class="container px-6 py-10">
    <hgroup class="mb-8 space-y-2 text-center">
        <h1 class="text-center text-display-md font-bold text-black">Found Items</h1>
    </hgroup>

      <!-- SEARCH AND FILTER -->
    <section class="mb-8 flex justify-center">
        <!-- SEARCH BAR -->
        <form class="flex items-center gap-3" role="search">
            <label for="found-search" class="sr-only">Search found items</label>
            <section class="relative h-[40px] w-[521px] overflow-hidden rounded-[12px] border border-[#212121] bg-transparent">
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6h15m-12 6h9m-6 6h3" />
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

        <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <?php foreach ($foundItems as $item): ?>
                <article class="item-card flex h-full w-[405px] flex-col items-start gap-4 overflow-hidden rounded-[28px] border border-[#d9d9d9] bg-white px-[22px] py-6 shadow-[0_6px_18px_rgba(10,10,10,0.12)]">
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
                            <p class="text-sm font-normal text-primary"><?= htmlspecialchars($item['date_found'] ?: 'Date unavailable') ?></p>
                        </div>
                        </div>
                    </header>

                    <div class="w-[362px] self-center border-t border-secondary"></div>
                    
                    <?php if ($item['image_url']): ?>
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="h-[260.188px] w-[362px] rounded-2xl object-cover">
                    <?php else: ?>
                        <div class="flex h-[260.188px] w-[362px] items-center justify-center rounded-2xl border border-dashed border-white-700 bg-white-50 text-sm text-secondary">
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
                    
                    <footer class="mt-auto flex flex-wrap justify-end gap-3 pt-2">
                        <?php if (($item['status'] ?? '') !== 'Recovered'): ?>
                            <button class="inline-flex items-center justify-center rounded-2xl bg-primary-500 px-5 py-3 text-sm font-semibold text-white-50 transition-colors hover:bg-primary-600" onclick="openModal('contact-modal-<?= $item['id'] ?>')">
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
