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
                    capture="environment" <?php #opens the camera for mobile devices ?>
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
                    <option value="General Services Office|10.713457,122.559756">General Services Office</option>
                    <option value="Office of Student Affairs|10.712972,122.563018">Office of Student Affairs</option>
                    <option value="WVSU Cooperative|10.712769,122.561156">WVSU Cooperative</option>
                    <option value="Lopez Jaena Building / ULRC|10.713988,122.561620">Lopez Jaena Building / ULRC</option>
                    <option value="Quezon Hall|10.713140,122.562691">Quezon Hall</option>
                    <option value="Rizal Hall|10.713691,122.561374">Rizal Hall</option>
                    <option value="CBM Building / Claro M. Recto Hall|10.712056,122.563951">CBM Building / Claro M. Recto Hall</option>
                    <option value="COM Building / Roxas Hall|10.712829,122.561771">COM Building / Roxas Hall</option>
                    <option value="CON Building|10.713180,122.560886">CON Building</option>
                    <option value="COC Building|10.714665,122.562294">COC Building</option>
                    <option value="CICT Building|10.7132169,122.5615582">CICT Building</option>
                    <option value="COD Building|10.712382,122.563600">COD Building</option>
                    <option value="BINHI TBI|10.712405,122.560322">BINHI TBI</option>
                    <option value="WVSU Grandstand|10.713844,122.562986">WVSU Grandstand</option>
                    <option value="WVSU Cultural Center|10.714734,122.562701">WVSU Cultural Center</option>
                    <option value="Center for Teaching Excellence|10.712382,122.563600">Center for Teaching Excellence</option>
                    <option value="Administration Building|10.714665,122.562294">Administration Building</option>
                    <option value="Audio Visual Room|10.714481,122.562312">Audio Visual Room</option>
                    <option value="Mini Forest|10.713539,122.562146">Mini Forest</option>
                    <option value="Diamond Park|10.713873,122.562240">Diamond Park</option>
                    <option value="WVSU Multi-Purpose Cooperative|10.715193,122.562688">WVSU Multi-Purpose Cooperative</option>
                    <option value="WVSU Cafeteria|10.712835,122.562814">WVSU Cafeteria</option>
                    <option value="WVSU Hometel|10.712835,122.562758">WVSU Hometel</option>
                    <option value="WVSU Research and Extension Building II|10.712846,122.560650">WVSU Research and Extension Building II</option>
                    <option value="WVSU Research and Extension Building I|10.712661,122.560491">WVSU Research and Extension Building I</option>
                    <option value="PESCAR Building / Ramon Magsaysay Hall|10.712845,122.563332">PESCAR Building / Ramon Magsaysay Hall</option>
                    <option value="New Academic Building|10.713086,122.563506">New Academic Building</option>
                </select>
            </label>

            <label id="room-number-wrapper" style="display: none;">
                Room Number:
                <input type="text" name="room_number" id="room_number" placeholder="e.g., 203">
            </label>
        </fieldset>
        <fieldset>
            <legend>Item Details</legend>

            <label>
                Item Name:
                <input type="text" name="item_name" id="item_name" required placeholder="e.g., Black Wallet">
            </label>

            <label>
                Category Tags:
                <select name="category" required>
                    <option value="Books">Books</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Personal">Personal</option>
                    <option value="IDs/Documents">IDs/Documents</option>
                    <option value="Bags">Bags</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Stationery">Stationery</option>
                    <option value="Others">Others</option>
                </select>
            </label>

            <label>
                Description:
                <textarea name="description" rows="4" placeholder="Color, brand, or distinguishing marks" required></textarea>
            </label>

            <label>
                Date & Time Found:
                <input type="datetime-local" name="date_found" value="<?= date('Y-m-d\TH:i'); ?>" required>
            </label>

        </fieldset>
        
        <fieldset>
            <legend>Contact Information</legend>
            <label>
                First Name:
                <input type="text" name="first_name" required value="<?= isset($user['first_name']) ? htmlspecialchars($user['first_name']) : '' ?>">
            </label>

            <label>
                Last Name:
                <input type="text" name="last_name" required value="<?= isset($user['last_name']) ? htmlspecialchars($user['last_name']) : '' ?>">
            </label>

            <label>
                Contact Details:
                <input type="text" name="contact_details" required value="<?= isset($user['phone_number']) ? htmlspecialchars($user['phone_number']) : '' ?>">
            </label>
        </fieldset>

        <div class="grid">
            <button type="submit">Post Item</button>
            <button type="button" class="secondary" onclick="window.location.href='/'">Cancel</button>
        </div>
    </form>
            
</main>
<script>
    // Preview Image Logic
    document.getElementById('item_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-image');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Room Number Logic
    const locationSelect = document.getElementById('location');
    const roomWrapper = document.getElementById('room-number-wrapper');
    const roomInput = document.getElementById('room_number');
    
    // Buildings triggering room number
    const requiresRoom = new Set([
        'Lopez Jaena Building / ULRC',
        'Quezon Hall',
        'PESCAR Building / Ramon Magsaysay Hall',
        'New Academic Building'
    ]);

    locationSelect.addEventListener('change', function() {
        // Extract name before pipe
        const val = this.value.split('|')[0];
        if (requiresRoom.has(val)) {
            roomWrapper.style.display = 'block';
            roomInput.required = true;
        } else {
            roomWrapper.style.display = 'none';
            roomInput.required = false;
        }
    });

    // Set the Date & Time Found field to the browser's local time (fix timezone mismatch)
    const dtInput = document.querySelector('input[name="date_found"]');
    if (dtInput) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        dtInput.value = now.toISOString().slice(0,16);
    }

</script>
</body>
</html>