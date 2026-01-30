<!--
    * Layer: View
    * Purpose: UI for posting a lost item
    * Rules: No business logic or DB access
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Lost Item</title>
</head>
<body>

<h2>Post a Lost Item</h2>

<form method="POST" action="/lost/post" enctype="multipart/form-data">

    <!-- Image Upload -->
    <label>
        Image of Lost Item:
        <input 
            type="file" 
            name="item_image" 
            accept="image/jpeg,image/png,image/webp,image/avif"
            capture="environment"
            required
        >
    </label>

    <!-- TODO: Update selection method once UI design is finalized -->
    <!-- Location Selection -->
    <label>
        Last Known Location:
        <select name="location" required>
            <option value="">-- Select Location --</option>

            <option value="General Services Office|10.713457,122.559756">
                General Services Office
            </option>

            <option value="Office of Student Affairs|10.712972,122.563018">
                Office of Student Affairs
            </option>

            <option value="WVSU Cooperative|10.712769,122.561156">
                WVSU Cooperative
            </option>

            <option value="Lopez Jaena Building / ULRC|10.713988,122.561620">
                Lopez Jaena Building / University Learning Resource Center
            </option>

            <option value="Quezon Hall|10.713140,122.562691">
                Quezon Hall
            </option>

            <option value="Rizal Hall|10.713691,122.561374">
                Rizal Hall
            </option>

            <option value="CBM Building / Claro M. Recto Hall|10.712056,122.563951">
                CBM Building / Claro M. Recto Hall
            </option>

            <option value="COM Building / Roxas Hall|10.712829,122.561771">
                COM Building / Roxas Hall
            </option>

            <option value="CON Building|10.713180,122.560886">
                CON Building
            </option>

            <option value="COC Building|10.714665,122.562294">
                COC Building
            </option>

            <option value="CICT Building|10.7132169,122.5615582">
                CICT Building
            </option>

            <option value="COD Building|10.712382,122.563600">
                COD Building
            </option>

            <option value="BINHI TBI|10.712405,122.560322">
                BINHI TBI
            </option>

            <option value="WVSU Grandstand|10.713844,122.562986">
                WVSU Grandstand
            </option>

            <option value="WVSU Cultural Center|10.714734,122.562701">
                WVSU Cultural Center
            </option>

            <option value="Center for Teaching Excellence|10.712382,122.563600">
                Center for Teaching Excellence
            </option>

            <option value="Administration Building|10.714665,122.562294">
                Administration Building
            </option>

            <option value="Audio Visual Room|10.714481,122.562312">
                Audio Visual Room
            </option>

            <option value="Mini Forest|10.713539,122.562146">
                Mini Forest
            </option>

            <option value="Diamond Park|10.713873,122.562240">
                Diamond Park
            </option>

            <option value="WVSU Multi-Purpose Cooperative|10.715193,122.562688">
                WVSU Multi-Purpose Cooperative
            </option>

            <option value="WVSU Cafeteria|10.712835,122.562814">
                WVSU Cafeteria
            </option>

            <option value="WVSU Hometel|10.712835,122.562758">
                WVSU Hometel
            </option>

            <option value="WVSU Research and Extension Building II|10.712846,122.560650">
                WVSU Research and Extension Building II
            </option>

            <option value="WVSU Research and Extension Building I|10.712661,122.560491">
                WVSU Research and Extension Building I
            </option>

            <option value="PESCAR Building / Ramon Magsaysay Hall|10.712845,122.563332">
                PESCAR Building / Ramon Magsaysay Hall
            </option>

            <option value="New Academic Building|10.713086,122.563506">
                New Academic Building
            </option>
        </select>

        <!-- Room Number for specified buildings -->
        <label id="room-number-wrapper" style="display: none;">
            Room Number:
            <input type="text" name="room_number" id="room_number" placeholder="e.g., 203">
        </label>
    </label>

    <!-- Date Lost -->
    <label>
        Date Lost:
        <input type="date" name="date_lost" required>
    </label>

    <!-- Optional Description -->
    <label>
        Description (optional):
        <textarea name="description" rows="4"></textarea>
    </label>

    <!-- Category -->
    <label>
        Category Tags (optional):
        <select name="category[]" multiple>
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

    <!-- User Info -->
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
        <input type="text" name="contact_details" required value="<?= isset($user['contact_details']) ? htmlspecialchars($user['contact_details']) : '' ?>">
    </label>

    <button type="submit">Post Lost Item</button>
</form>

<script>
    (function () {
        const locationSelect = document.querySelector('select[name="location"]');
        const roomWrapper = document.getElementById('room-number-wrapper');
        const roomInput = document.getElementById('room_number');

        // Locations that require a room number
        const requiresRoom = new Set([
            'Quezon Hall',
            'Rizal Hall',
            'PESCAR Building / Ramon Magsaysay Hall',
            'New Academic Building'
        ]);

        //TODO: Add logic to validate room numbers based on building
        function updateRoomField() {
            const value = locationSelect.value || '';
            const name = value.includes('|') ? value.split('|')[0] : '';

            if (requiresRoom.has(name)) {
                roomWrapper.style.display = 'block';
                roomInput.required = true;
            } else {
                roomWrapper.style.display = 'none';
                roomInput.required = false;
                roomInput.value = '';
            }
        }

        locationSelect.addEventListener('change', updateRoomField);
        updateRoomField(); // run on load
    })();
</script>
</body>
</html>
