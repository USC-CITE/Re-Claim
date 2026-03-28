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
        <h1 class="text-display-md font-semibold text-primary">Found Items</h1>
        <p class="text-sm text-secondary">Recent items reported by the community.</p>
    </hgroup>

    <section class="mb-8 flex justify-center">
        <form class="flex w-full max-w-xl items-center gap-3" role="search">
            <label for="found-search" class="sr-only">Search found items</label>
            <section class="relative flex-1">
                <input
                    id="found-search"
                    type="search"
                    placeholder="Search found items"
                    class="w-full rounded-xl border border-white-700 bg-white px-4 py-3 pr-12 text-sm text-primary placeholder:text-secondary shadow-100"
                >
                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-secondary" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </span>
            </section>
            <button
                type="button"
                aria-label="Filter found items"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white-700 bg-white text-primary shadow-100 transition-colors hover:bg-white-50"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6h15m-12 6h9m-6 6h3" />
                </svg>
            </button>
        </form>
    </section>

    <nav aria-label="Listing type" class="mb-10 flex justify-center">
        <ul class="flex items-center gap-8 text-sm font-semibold">
            <li>
                <a href="/lost" class="border-b-2 border-transparent pb-1 text-secondary transition-colors hover:text-primary">
                    Lost Items
                </a>
            </li>
            <li>
                <a href="/found" class="border-b-2 border-primary-500 pb-1 text-primary-500">
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
                <article class="item-card flex h-full flex-col gap-4 overflow-hidden rounded-[28px] border border-[#d9d9d9] bg-white p-5 shadow-[0_6px_18px_rgba(10,10,10,0.12)]">
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

                    <header class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white-600 text-xs font-semibold text-primary">
                            <?= strtoupper(substr((string)($item['name'] ?: 'A'), 0, 1)) ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-md font-semibold text-primary">
                                <span class="mr-1 text-primary-500">[Found]</span><?= htmlspecialchars($item['title']) ?>
                            </p>
                            <p class="text-xs text-secondary"><?= htmlspecialchars($item['date_found'] ?: 'Date unavailable') ?></p>
                        </div>
                    </header>

                    <div class="border-t border-white-600"></div>
                    
                    <?php if ($item['image_url']): ?>
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="h-56 w-full rounded-2xl object-cover">
                    <?php else: ?>
                        <div class="flex h-56 items-center justify-center rounded-2xl border border-dashed border-white-700 bg-white-50 text-sm text-secondary">
                            No Image
                        </div>
                    <?php endif; ?>

                    <div class="space-y-3 text-sm text-secondary">
                        <div class="flex items-start gap-2 text-[13px] leading-5 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-4.35 6-10a6 6 0 1 0-12 0c0 5.65 6 10 6 10Z" />
                                <circle cx="12" cy="11" r="2.25" />
                            </svg>
                            <span>Last seen at <?= htmlspecialchars($item['location'] ?: 'Unknown location') ?></span>
                        </div>

                        <p class="text-[13px] leading-6 text-secondary"><?= htmlspecialchars($item['description']) ?></p>
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
