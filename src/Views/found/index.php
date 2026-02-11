<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Found Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
<main class="container">
    <hgroup>
        <h1>Found Items</h1>
        <p>Recent items reported by the community.</p>
    </hgroup>

    <?php if (!empty($flash['success'])): ?>
        <article>
            <strong>✅ Success:</strong> <?= htmlspecialchars($flash['success']) ?>
        </article>
    <?php elseif (!empty($flash['error'])): ?>
        <article>
            <strong>❌ Error:</strong> <?= htmlspecialchars($flash['error']) ?>
        </article>
    <?php endif; ?>

    <a href="/found/post" role="button">Post a Found Item</a>
    <hr>

    <div class="grid">
        <?php if (empty($foundItems)): ?>
            <article>
                <p>No found items reported yet.</p>
            </article>
        <?php else: ?>
            <?php foreach ($foundItems as $item): ?>
                <article class="item-card">
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
                            <strong>Location:</strong> <?= htmlspecialchars($item['location']) ?>
                        </small>
                    </p>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    
                    <footer>
                        <button class="outline" onclick="openModal('modal-<?= $item['id'] ?>')">
                            Contact Finder
                        </button>

                        <?php if (!empty($item['can_recover'])): ?>
                            <form method="POST" action="/found/recover" style="display:inline-block; margin-left: 0.5rem;">
                                <?php \App\Core\Router::setCsrf(); ?>
                                <input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>">
                                <button type="submit" class="secondary outline">
                                    Mark as Recovered
                                </button>
                            </form>
                        <?php endif; ?>
                    </footer>

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
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<script src="/js/found/index.js"></script>
</body>
</html>