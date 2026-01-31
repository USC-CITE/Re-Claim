<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Found Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        #preview-container { margin-top: 1rem; }
        #preview-image { max-width: 100%; max-height: 300px; display: none; border-radius: 8px; }
    </style>
</head>
<body>

<main class="container">
    <h2>Post a Found Item</h2>
    
    <form method="POST" action="/found/post" enctype="multipart/form-data">
        <fieldset>
            <legend>Item Photo</legend>
            <label>
                Upload Image or Take Photo:
                <input 
                    type="file" 
                    name="item_image" 
                    id="item_image"
                    accept="image/jpeg,image/png,image/webp,image/avif"
                    capture="environment" <?php #opens the camera for mobile devices ?>
                >
            </label>
            <div id="preview-container">
                <img id="preview-image" alt="Image Preview">
            </div>
        </fieldset>
</main>


</body>
</html>