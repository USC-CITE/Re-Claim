<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lost Items</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body class="font-poppins bg-white text-primary min-h-screen">

<main class="container px-6 py-10">
  <?php require __DIR__ . "/../mainpages/header.php"?>
  <hgroup class="mb-8 space-y-2 text-center">
        <h1 class="text-display-md font-semibold text-primary">Lost Items</h1>
        <p class="text-sm text-secondary">Recent items reported as lost by the community.</p>
    </hgroup>

  <section class="mb-8 flex justify-center">
    <div class="flex w-full max-w-xl items-center gap-3">
      <label for="lost-search" class="sr-only">Search lost items</label>
      <div class="relative flex-1">
        <input
          id="lost-search"
          type="search"
          placeholder="Search lost items"
          class="w-full rounded-xl border border-white-700 bg-white px-4 py-3 pr-12 text-sm text-primary placeholder:text-secondary shadow-100"
        >
        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-secondary" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
          </svg>
        </span>
      </div>
      <button
        type="button"
        aria-label="Filter lost items"
        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white-700 bg-white text-primary shadow-100 transition-colors hover:bg-white-50"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6h15m-12 6h9m-6 6h3" />
        </svg>
      </button>
    </div>
  </section>

  <nav aria-label="Listing type" class="mb-10 flex justify-center">
    <div class="flex items-center gap-8 text-sm font-semibold">
      <a href="/lost" class="border-b-2 border-primary-500 pb-1 text-primary-500">
        Lost Items
      </a>
      <a href="/found" class="border-b-2 border-transparent pb-1 text-secondary transition-colors hover:text-primary">
        Found Items
      </a>
    </div>
  </nav>

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
  <?php endif; ?>

  <?php if (!empty($flash['error'])): ?>
    <article style="border-left: 4px solid #e74c3c; padding: 1rem;">
      <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
    </article>
  <?php endif; ?>

  <?php
    // Only show bulk archive mode if at least one post belongs to the current user.
    $hasBulkArchivable = false;
    foreach ($lostItems ?? [] as $bulkItem) {
      if (!empty($bulkItem['can_archive'])) {
        $hasBulkArchivable = true;
        break;
      }
    }
  ?>

  <?php /*
  // Action buttons: Post Lost Item and Archive (bulk mode).
  // Bring them back once the matching UI section is designed.
  <div class="mb-8 flex flex-wrap items-center justify-center gap-3">
    <a
      href="/lost/post"
      role="button"
      class="inline-flex items-center justify-center rounded-2xl bg-primary-500 px-5 py-3 text-sm font-semibold text-white-50 transition-colors hover:bg-primary-600"
      style="margin:0;"
    >
      Post a Lost Item
    </a>
    <?php if ($hasBulkArchivable): ?>
      <button
        type="button"
        id="toggle-bulk-archive"
        class="inline-flex items-center justify-center rounded-2xl border border-primary-500 px-5 py-3 text-sm font-semibold text-primary-500 transition-colors hover:bg-primary-50"
        onclick="toggleBulkArchiveMode()"
        style="margin:0;"
      >
        Archive Lost Items
      </button>
    <?php endif; ?>
  </div>
  */ ?>

  <?php if (empty($lostItems)): ?>
    <p>No lost items posted yet.</p>
  <?php else: ?>
    <?php if ($hasBulkArchivable): ?>
      <!-- Standalone form so it does not clash with the forms inside each modal. -->
      <form id="bulk-archive-form" method="POST" action="/lost/archive" onsubmit="return confirm('Archive the selected lost items?');">
        <?php \App\Core\Router::setCsrf(); ?>
      </form>
    <?php endif; ?>

    <div class="grid">
      <?php foreach ($lostItems as $item): ?>
        <article>
          <?php if (!empty($item['can_archive'])): ?>
            <label class="bulk-archive-box" style="margin-bottom:0.75rem;">
              <input type="checkbox" name="item_ids[]" value="<?= (int)$item['id'] ?>" form="bulk-archive-form">
              Select for bulk archive
            </label>
          <?php endif; ?>

          <header>
            <div class="grid">
              <strong><?= htmlspecialchars($item['item_name'] ?: 'Lost Item') ?></strong>
              <div style="text-align:right;">
                <span data-tooltip="Status" data-placement="left">
                  <mark><?= htmlspecialchars($item['status'] ?? 'Unrecovered') ?></mark>
                </span>
              </div>
            </div>
          </header>

          <?php if (!empty($item['image_url'])): ?>
            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Lost item image" style="width:100%; height:220px; object-fit:cover; border-radius:8px;">
          <?php else: ?>
            <div style="height:220px; display:flex; align-items:center; justify-content:center; border:1px dashed #777; border-radius:8px;">
              <small>No image</small>
            </div>
          <?php endif; ?>

          <p>
            <strong>Date Lost:</strong>
            <?= htmlspecialchars($item['event_date'] ?: 'N/A') ?>
            <br>
            <strong>Location:</strong>
            <?= htmlspecialchars($item['location'] ?: 'Unknown location') ?>
            <br>
            <strong>Posted by:</strong>
            <?= htmlspecialchars($item['name'] ?: 'Anonymous') ?>
            <?php if (($item['status'] ?? 'Unrecovered') === 'Unrecovered' && !empty($item['archive_date'])): ?>
              <br>
              <strong>Auto-archives on:</strong>
              <?= htmlspecialchars($item['archive_date']) ?>
            <?php endif; ?>
            
          </p>

          <?php if (!empty($item['categories'])): ?>
            <p>
              <?php foreach ($item['categories'] as $cat): ?>
                <small style="padding: .2rem .5rem; border:1px solid #666; border-radius:999px; margin-right:.25rem;">
                  <?= htmlspecialchars($cat) ?>
                </small>
              <?php endforeach; ?>
            </p>
          <?php endif; ?>

          <p><?= htmlspecialchars($item['description']) ?></p>

          <details>
            <summary>Contact</summary>
            <p><?= htmlspecialchars($item['contact_info'] ?: 'No contact details.') ?></p>
          </details>

  <!-- Show recover button if item is unrecovered and user is the original poster -->
  <?php if (!empty($item['can_recover'])): ?>
    <button type="button"
            class="secondary outline"
            onclick="openModal('recover-modal-<?= $item['id'] ?>')">
      Mark as Recovered
    </button>
  <?php endif; ?>

  <?php if (!empty($item['can_recover'])): ?>
    <dialog id="recover-modal-<?= $item['id'] ?>">
      <article>
        <header>
          <button aria-label="Close" rel="prev" onclick="closeModal('recover-modal-<?= $item['id'] ?>')"></button>
          <h3>Confirm Lost Item Recovery</h3>
        </header>
        <p>
          Are you sure you want to mark this lost item as recovered? This will update its status for everyone.
          <?php if (!empty($item['archive_date'])): ?>
            <br><small>This post will be archived on <strong><?= htmlspecialchars($item['archive_date']) ?></strong>.</small>
          <?php endif; ?>
        </p>
        <footer>
          <form method="POST" action="/lost/recover" style="display:inline-block; margin-right:0.5rem;">
            <?php \App\Core\Router::setCsrf(); ?>
            <input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>">
            <button type="submit">Yes, mark as recovered</button>
          </form>

          <form method="POST" action="/lost/archive" style="display:inline-block; margin-left: 0.5rem;">
            <?php \App\Core\Router::setCsrf(); ?>
            <input type="hidden" name="item_ids[]" value="<?= (int)$item['id'] ?>">
            <button type="submit" class="secondary outline" onclick="return confirm('Are you sure you want to archive this item?');">
              Archive
            </button>
          </form>

          <form method="POST" action="/lost/delay-archive" style="display:inline-block; margin-left: 0.5rem;">
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

<script src="/js/lost/index.js"></script>

</body>
</html>


