<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Lost Items</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>

<main class="container">
  <hgroup>
        <h1>Lost Items</h1>
        <p>Recent items reported as lost by the community.</p>
    </hgroup>

    <a href="/lost/post" role="button">Post a Lost Item</a>

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

  <?php if (empty($lostItems)): ?>
    <p>No lost items posted yet.</p>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($lostItems as $item): ?>
        <article>
          <?php if (!empty($item['image_url'])): ?>
            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Lost item image" style="width:100%; height:220px; object-fit:cover; border-radius:8px;">
          <?php else: ?>
            <div style="height:220px; display:flex; align-items:center; justify-content:center; border:1px dashed #777; border-radius:8px;">
              <small>No image</small>
            </div>
          <?php endif; ?>

          <h4 style="margin-top: 1rem;">
            <?= htmlspecialchars($item['location'] ?: 'Unknown location') ?>
          </h4>

          <p>
            <strong>Status:</strong>
            <mark><?= htmlspecialchars($item['status'] ?? 'Unrecovered') ?></mark>
          </p>

          <p>
            <strong>Date Lost:</strong>
            <?= htmlspecialchars($item['event_date'] ?: 'N/A') ?>
            <br>
            <strong>Posted by:</strong>
            <?= htmlspecialchars($item['name'] ?: 'Anonymous') ?>
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
          <h3>Confirm Recovery</h3>
        </header>
        <p>Are you sure you want to mark this lost item as recovered? This will update its status for everyone.</p>
        <footer>
          <form method="POST" action="/lost/recover" style="display:inline-block; margin-right:0.5rem;">
            <?php \App\Core\Router::setCsrf(); ?>
            <input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>">
            <button type="submit">Yes, mark as recovered</button>
          </form>
        </footer>
      </article>
    </dialog>
  <?php endif; ?>

        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

<script src="/js/lost/index.js"></script>

</body>
</html>