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
    
    <?php if (!empty($flash['error'])): ?>
    <div style="background: #fee; padding: 1rem; border-left: 4px solid #f44; margin-bottom: 1rem;">
        <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
    </div>
    <?php endif; ?>
    
    <form method="POST" action="/found/post" enctype="multipart/form-data">
        <?php \App\Core\Router::setCsrf(); ?>
        
        <fieldset>
            <legend>Item Photo</legend>
            <label>
                Upload Image or Take Photo:
                <input 
                    type="file" 
                    name="item_image" 
                    id="item_image"
                    accept="image/jpeg,image/png,image/webp,image/avif"
                    required
                >
            </label>
            <div id="preview-container">
                <img id="preview-image" alt="Image Preview">
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Location Found</legend>
            <label>
                Select Location:
                <select name="location" id="location" required>
                    <option value="">-- Select Location --</option>
                    <option value="General Services Office|10.713457,122.559756" <?= ($old['location'] ?? '') === 'General Services Office|10.713457,122.559756' ? 'selected' : '' ?>>General Services Office</option>
                    <option value="Office of Student Affairs|10.712972,122.563018" <?= ($old['location'] ?? '') === 'Office of Student Affairs|10.712972,122.563018' ? 'selected' : '' ?>>Office of Student Affairs</option>
                    <option value="WVSU Cooperative|10.712769,122.561156" <?= ($old['location'] ?? '') === 'WVSU Cooperative|10.712769,122.561156' ? 'selected' : '' ?>>WVSU Cooperative</option>
                    <option value="Lopez Jaena Building / ULRC|10.713988,122.561620" <?= ($old['location'] ?? '') === 'Lopez Jaena Building / ULRC|10.713988,122.561620' ? 'selected' : '' ?>>Lopez Jaena Building / ULRC</option>
                    <option value="Quezon Hall|10.713140,122.562691" <?= ($old['location'] ?? '') === 'Quezon Hall|10.713140,122.562691' ? 'selected' : '' ?>>Quezon Hall</option>
                    <option value="Rizal Hall|10.713691,122.561374" <?= ($old['location'] ?? '') === 'Rizal Hall|10.713691,122.561374' ? 'selected' : '' ?>>Rizal Hall</option>
                    <option value="CBM Building / Claro M. Recto Hall|10.712056,122.563951" <?= ($old['location'] ?? '') === 'CBM Building / Claro M. Recto Hall|10.712056,122.563951' ? 'selected' : '' ?>>CBM Building / Claro M. Recto Hall</option>
                    <option value="COM Building / Roxas Hall|10.712829,122.561771" <?= ($old['location'] ?? '') === 'COM Building / Roxas Hall|10.712829,122.561771' ? 'selected' : '' ?>>COM Building / Roxas Hall</option>
                    <option value="CON Building|10.713180,122.560886" <?= ($old['location'] ?? '') === 'CON Building|10.713180,122.560886' ? 'selected' : '' ?>>CON Building</option>
                    <option value="COC Building|10.714665,122.562294" <?= ($old['location'] ?? '') === 'COC Building|10.714665,122.562294' ? 'selected' : '' ?>>COC Building</option>
                    <option value="CICT Building|10.7132169,122.5615582" <?= ($old['location'] ?? '') === 'CICT Building|10.7132169,122.5615582' ? 'selected' : '' ?>>CICT Building</option>
                    <option value="COD Building|10.712382,122.563600" <?= ($old['location'] ?? '') === 'COD Building|10.712382,122.563600' ? 'selected' : '' ?>>COD Building</option>
                    <option value="BINHI TBI|10.712405,122.560322" <?= ($old['location'] ?? '') === 'BINHI TBI|10.712405,122.560322' ? 'selected' : '' ?>>BINHI TBI</option>
                    <option value="WVSU Grandstand|10.713844,122.562986" <?= ($old['location'] ?? '') === 'WVSU Grandstand|10.713844,122.562986' ? 'selected' : '' ?>>WVSU Grandstand</option>
                    <option value="WVSU Cultural Center|10.714734,122.562701" <?= ($old['location'] ?? '') === 'WVSU Cultural Center|10.714734,122.562701' ? 'selected' : '' ?>>WVSU Cultural Center</option>
                    <option value="Center for Teaching Excellence|10.712382,122.563600" <?= ($old['location'] ?? '') === 'Center for Teaching Excellence|10.712382,122.563600' ? 'selected' : '' ?>>Center for Teaching Excellence</option>
                    <option value="Administration Building|10.714665,122.562294" <?= ($old['location'] ?? '') === 'Administration Building|10.714665,122.562294' ? 'selected' : '' ?>>Administration Building</option>
                    <option value="Audio Visual Room|10.714481,122.562312" <?= ($old['location'] ?? '') === 'Audio Visual Room|10.714481,122.562312' ? 'selected' : '' ?>>Audio Visual Room</option>
                    <option value="Mini Forest|10.713539,122.562146" <?= ($old['location'] ?? '') === 'Mini Forest|10.713539,122.562146' ? 'selected' : '' ?>>Mini Forest</option>
                    <option value="Diamond Park|10.713873,122.562240" <?= ($old['location'] ?? '') === 'Diamond Park|10.713873,122.562240' ? 'selected' : '' ?>>Diamond Park</option>
                    <option value="WVSU Multi-Purpose Cooperative|10.715193,122.562688" <?= ($old['location'] ?? '') === 'WVSU Multi-Purpose Cooperative|10.715193,122.562688' ? 'selected' : '' ?>>WVSU Multi-Purpose Cooperative</option>
                    <option value="WVSU Cafeteria|10.712835,122.562814" <?= ($old['location'] ?? '') === 'WVSU Cafeteria|10.712835,122.562814' ? 'selected' : '' ?>>WVSU Cafeteria</option>
                    <option value="WVSU Hometel|10.712835,122.562758" <?= ($old['location'] ?? '') === 'WVSU Hometel|10.712835,122.562758' ? 'selected' : '' ?>>WVSU Hometel</option>
                    <option value="WVSU Research and Extension Building II|10.712846,122.560650" <?= ($old['location'] ?? '') === 'WVSU Research and Extension Building II|10.712846,122.560650' ? 'selected' : '' ?>>WVSU Research and Extension Building II</option>
                    <option value="WVSU Research and Extension Building I|10.712661,122.560491" <?= ($old['location'] ?? '') === 'WVSU Research and Extension Building I|10.712661,122.560491' ? 'selected' : '' ?>>WVSU Research and Extension Building I</option>
                    <option value="PESCAR Building / Ramon Magsaysay Hall|10.712845,122.563332" <?= ($old['location'] ?? '') === 'PESCAR Building / Ramon Magsaysay Hall|10.712845,122.563332' ? 'selected' : '' ?>>PESCAR Building / Ramon Magsaysay Hall</option>
                    <option value="New Academic Building|10.713086,122.563506" <?= ($old['location'] ?? '') === 'New Academic Building|10.713086,122.563506' ? 'selected' : '' ?>>New Academic Building</option>
                </select>
            </label>

            <label id="room-number-wrapper" style="display: none;">
                Room Number:
                <input type="text" name="room_number" id="room_number" placeholder="e.g., 203" value="<?= htmlspecialchars($old['room_number'] ?? '') ?>">
            </label>
        </fieldset>
        <fieldset>
            <legend>Item Details</legend>

            <label>
                Item Name:
                <input type="text" name="item_name" id="item_name"  placeholder="e.g., Black Wallet" value="<?= htmlspecialchars($old['item_name'] ?? '') ?>">
            </label>

            <label>
                Category Tags:
                <select name="category" >
                    <option value="Books" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Books', $old['category']) : $old['category'] === 'Books')) ? 'selected' : '' ?>>Books</option>
                    <option value="Electronics" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Electronics', $old['category']) : $old['category'] === 'Electronics')) ? 'selected' : '' ?>>Electronics</option>
                    <option value="Personal" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Personal', $old['category']) : $old['category'] === 'Personal')) ? 'selected' : '' ?>>Personal</option>
                    <option value="IDs/Documents" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('IDs/Documents', $old['category']) : $old['category'] === 'IDs/Documents')) ? 'selected' : '' ?>>IDs/Documents</option>
                    <option value="Bags" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Bags', $old['category']) : $old['category'] === 'Bags')) ? 'selected' : '' ?>>Bags</option>
                    <option value="Clothing" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Clothing', $old['category']) : $old['category'] === 'Clothing')) ? 'selected' : '' ?>>Clothing</option>
                    <option value="Accessories" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Accessories', $old['category']) : $old['category'] === 'Accessories')) ? 'selected' : '' ?>>Accessories</option>
                    <option value="Stationery" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Stationery', $old['category']) : $old['category'] === 'Stationery')) ? 'selected' : '' ?>>Stationery</option>
                    <option value="Others" <?= (isset($old['category']) && (is_array($old['category']) ? in_array('Others', $old['category']) : $old['category'] === 'Others')) ? 'selected' : '' ?>>Others</option>
                </select>
            </label>

            <label>
                Description:
                <textarea name="description" rows="4" placeholder="Color, brand, or distinguishing marks" ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            </label>

            <label>
                Date & Time Found:
                <input type="datetime-local" name="date_found" value="<?= htmlspecialchars($old['date_found'] ?? date('Y-m-d\TH:i')) ?>" >
            </label>

        </fieldset>
        
        <fieldset>
            <legend>Contact Information</legend>
            <label>
                First Name:
                <input type="text" name="first_name"  value="<?= htmlspecialchars($old['first_name'] ?? ($user['first_name'] ?? '')) ?>">
            </label>

            <label>
                Last Name:
                <input type="text" name="last_name"  value="<?= htmlspecialchars($old['last_name'] ?? ($user['last_name'] ?? '')) ?>">
            </label>

            <label>
                Contact Details:
                <input type="text" name="contact_details"  value="<?= htmlspecialchars($old['contact_details'] ?? ($user['phone_number'] ?? '')) ?>">
            </label>
        </fieldset>

        <div class="grid">
            <button type="submit">Post Item</button>
            <button type="button" class="secondary" onclick="window.location.href='/'">Cancel</button>
        </div>
    </form>
            
</main>
<script src="/js/found/post.js"></script>
</body>
</html>