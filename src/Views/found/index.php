<?php #Page is purely for visual debugging rn ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Found Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
<main class="container">
    <h1>Found Items</h1>
    <a href="/found/post" role="button">Post a Found Item</a>
    <hr>

    <div class="grid">
        <?php if (empty($foundItems)): ?>
            <p>No found items reported yet.</p>
        <?php else: ?>
            <?php foreach ($foundItems as $item): ?>
                <?php 
                    // Decode category
                    $cats = json_decode($item['category'], true);
                    $catString = is_array($cats) ? implode(', ', $cats) : $item['category'];
                    $title = $item['item_name'] ? htmlspecialchars($item['item_name']) : "Found " . htmlspecialchars($catString);
                ?>
                <article class="item-card">
                    <header>
                        <strong><?= $title ?></strong>
                        <span class="status-tag"><?= htmlspecialchars($item['status']) ?></span>
                    </header>
                    
                    <?php if (!empty($item['image_path'])): ?>
                        <img src="/<?= htmlspecialchars($item['image_path']) ?>" alt="Item Image" class="item-img">
                    <?php else: ?>
                        <div class="item-img" style="display:flex;align-items:center;justify-content:center;">No Image</div>
                    <?php endif; ?>

                    <p>
                        <strong>Date Found:</strong> <?= htmlspecialchars($item['date_found']) ?><br>
                        <strong>Location:</strong> <?= htmlspecialchars($item['location_name']) ?><br>
                        <strong>Description:</strong> <?= htmlspecialchars($item['description'] ?? 'No description provided.') ?>
                    </p>
                    
                    <?php #TODO: Add a popup that shows the author's details ?>
                    <footer>
                        <a <?= htmlspecialchars($item['contact_details']) ?>" role="button" class="outline">
                            Contact Finder
                        </a>
                    </footer>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
</body>
</html>