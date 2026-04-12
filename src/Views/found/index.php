<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Found Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
<main class="container">
    <?php require __DIR__ . "/../mainpages/header.php"?>
    <hgroup>
        <h1>Found Items</h1>
        <p>Recent items reported by the community.</p>
    </hgroup>

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

    <div style="display:flex; gap:0.75rem; align-items:stretch; flex-wrap:wrap; margin-bottom:1rem;">
        <a href="/found/post" role="button" style="margin:0; display:inline-flex; align-items:center;">Post a Found Item</a>
        <?php if ($hasBulkArchivable): ?>
            <button type="button" id="toggle-bulk-archive" class="secondary outline" onclick="toggleBulkArchiveMode()" style="margin:0; display:inline-flex; align-items:center;">
                Archive Found Items
            </button>
        <?php endif; ?>
    </div>

    <?php if (empty($foundItems)): ?>
        <p>No found items reported yet.</p>
    <?php else: ?>
        <?php if ($hasBulkArchivable): ?>
            <!-- Standalone form so it does not clash with the forms inside each modal. -->
            <form id="bulk-archive-form" method="POST" action="/found/archive" onsubmit="return confirm('Archive the selected found items?');">
                <?php \App\Core\Router::setCsrf(); ?>
            </form>
        <?php endif; ?>

        <div class="grid">
            <?php foreach ($foundItems as $item): ?>
                <article class="item-card">
                    <?php if (!empty($item['can_archive'])): ?>
                        <label class="bulk-archive-box" style="margin-bottom:0.75rem;">
                            <input type="checkbox" name="item_ids[]" value="<?= (int)$item['id'] ?>" form="bulk-archive-form">
                            Select for bulk archive
                        </label>
                    <?php endif; ?>

                    <header>
                        <div class="grid">
                            <strong><?= htmlspecialchars($item['title']) ?></strong>
                            <div style="text-align:right;">
                                <span data-tooltip="Status" data-placement="left">
                                    <mark><?= htmlspecialchars($item['status']) ?></mark>
                                </span>
                            </div>
                        </div>
                    </header>
                    
                    <?php if ($item['image_url']): ?>
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="width:100%; height:200px; object-fit:cover; border-radius:4px;">
                    <?php else: ?>
                        <div style="height:200px; background:#f4f4f4; display:flex; align-items:center; justify-content:center; color:#888; border-radius:4px;">
                            No Image
                        </div>
                    <?php endif; ?>

                    <p style="margin-top: 1rem;">
                        <small>
                            <strong>Date:</strong> <?= htmlspecialchars($item['date_found']) ?><br>
                            <strong>Location:</strong> <?= htmlspecialchars($item['location']) ?><br>
                            <strong>Posted by:</strong> <?= htmlspecialchars($item['name'] ?: 'Anonymous') ?>
                            <?php if (($item['status'] ?? 'Unrecovered') === 'Unrecovered' && !empty($item['archive_date'])): ?>
                                <br><strong>Auto-archives on:</strong> <?= htmlspecialchars($item['archive_date']) ?>
                            <?php endif; ?>
                        </small>
                    </p>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    
                    <footer>
                        <?php if (($item['status'] ?? '') !== 'Recovered'): ?>
                            <button class="outline" onclick="openModal('modal-<?= $item['id'] ?>')">
                                Contact Finder
                            </button>
                        <?php endif; ?>
                    </footer>

                    <?php if (($item['status'] ?? '') !== 'Recovered'): ?>
                        <dialog id="modal-<?= $item['id'] ?>">
                            <article>
                                <header>
                                    <button aria-label="Close" rel="prev" onclick="closeModal('modal-<?= $item['id'] ?>')"></button>
                                    <h3>Contact Details</h3>
                                </header>
                                <p>
                                    You can reach the finder at:
                                    <strong><?= htmlspecialchars($item['contact_info']) ?></strong>
                                </p>
                                <footer>
                                    <button role="button" class="secondary" onclick="closeModal('modal-<?= $item['id'] ?>')">Close</button>
                                </footer>
                            </article>
                        </dialog>
                    <?php endif; ?>

                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($hasBulkArchivable): ?>
            <button type="submit" form="bulk-archive-form" class="secondary bulk-archive-submit" style="margin-top: 1rem;">
                Archive Selected
            </button>
        <?php endif; ?>
    <?php endif; ?>
</main>

<script src="/js/found/index.js"></script>
</body>
</html>