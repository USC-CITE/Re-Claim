<!--
    * Layer: View
    * Purpose: UI for posting a lost item
    * Rules: No business logic or DB access
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Lost Item</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/lost/post.js" defer></script>
    <style>
        #preview-image { display: none; max-width: 100%; max-height: 300px; }
        #camera-block { display: none; }
        #camera-video { width: 100%; max-width: 100%; border-radius: 12px; }
        #camera-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.5rem; }
        #room-number-wrapper { display: none; }
    </style>
</head>

<body class="font-poppins bg-white text-primary min-h-screen overflow-x-hidden">

<?php require __DIR__ . "/../mainpages/header.php"; ?>

<main class="w-full px-5 py-8 sm:max-w-lg sm:mx-auto sm:px-6 sm:py-10">

    <h2 class="text-3xl font-bold text-center mb-8">Report a Lost Item</h2>

    <?php if (!empty($flash['error'])): ?>
        <div class="border-l-4 border-red-500 bg-red-100 p-4 mb-6 rounded-lg">
            <strong>Error:</strong> <?= htmlspecialchars($flash['error']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($flash['success'])): ?>
        <div class="border-l-4 border-green-500 bg-green-50 p-4 mb-6 rounded-lg">
            <strong>Success:</strong> <?= htmlspecialchars($flash['success']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/lost/post" enctype="multipart/form-data" class="flex flex-col gap-4">
        <?php \App\Core\Router::setCsrf(); ?>

        <!-- ITEM NAME -->
        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Item Name:</label>
            <input
                type="text"
                name="item_name"
                placeholder="e.g., Black Wallet"
                required
                value="<?= htmlspecialchars($old['item_name'] ?? '') ?>"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
            >
        </div>

        <!-- LOCATION -->
        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Location Item was Lost:</label>
            <select name="location" id="location" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">-- Select Location --</option>
                <option value="General Services Office|10.713457,122.559756" <?= (($old['location'] ?? '') === 'General Services Office|10.713457,122.559756') ? 'selected' : '' ?>>General Services Office</option>
                <option value="Office of Student Affairs|10.712972,122.563018" <?= (($old['location'] ?? '') === 'Office of Student Affairs|10.712972,122.563018') ? 'selected' : '' ?>>Office of Student Affairs</option>
                <option value="WVSU Cooperative|10.712769,122.561156" <?= (($old['location'] ?? '') === 'WVSU Cooperative|10.712769,122.561156') ? 'selected' : '' ?>>WVSU Cooperative</option>
                <option value="Lopez Jaena Building / ULRC|10.713988,122.561620" <?= (($old['location'] ?? '') === 'Lopez Jaena Building / ULRC|10.713988,122.561620') ? 'selected' : '' ?>>Lopez Jaena Building / ULRC</option>
                <option value="Quezon Hall|10.713140,122.562691" <?= (($old['location'] ?? '') === 'Quezon Hall|10.713140,122.562691') ? 'selected' : '' ?>>Quezon Hall</option>
                <option value="Rizal Hall|10.713691,122.561374" <?= (($old['location'] ?? '') === 'Rizal Hall|10.713691,122.561374') ? 'selected' : '' ?>>Rizal Hall</option>
                <option value="CBM Building / Claro M. Recto Hall|10.712056,122.563951" <?= (($old['location'] ?? '') === 'CBM Building / Claro M. Recto Hall|10.712056,122.563951') ? 'selected' : '' ?>>CBM Building / Claro M. Recto Hall</option>
                <option value="COM Building / Roxas Hall|10.712829,122.561771" <?= (($old['location'] ?? '') === 'COM Building / Roxas Hall|10.712829,122.561771') ? 'selected' : '' ?>>COM Building / Roxas Hall</option>
                <option value="CON Building|10.713180,122.560886" <?= (($old['location'] ?? '') === 'CON Building|10.713180,122.560886') ? 'selected' : '' ?>>CON Building</option>
                <option value="COC Building|10.714665,122.562294" <?= (($old['location'] ?? '') === 'COC Building|10.714665,122.562294') ? 'selected' : '' ?>>COC Building</option>
                <option value="CICT Building|10.7132169,122.5615582" <?= (($old['location'] ?? '') === 'CICT Building|10.7132169,122.5615582') ? 'selected' : '' ?>>CICT Building</option>
                <option value="COD Building|10.712382,122.563600" <?= (($old['location'] ?? '') === 'COD Building|10.712382,122.563600') ? 'selected' : '' ?>>COD Building</option>
                <option value="BINHI TBI|10.712405,122.560322" <?= (($old['location'] ?? '') === 'BINHI TBI|10.712405,122.560322') ? 'selected' : '' ?>>BINHI TBI</option>
                <option value="WVSU Grandstand|10.713844,122.562986" <?= (($old['location'] ?? '') === 'WVSU Grandstand|10.713844,122.562986') ? 'selected' : '' ?>>WVSU Grandstand</option>
                <option value="WVSU Cultural Center|10.714734,122.562701" <?= (($old['location'] ?? '') === 'WVSU Cultural Center|10.714734,122.562701') ? 'selected' : '' ?>>WVSU Cultural Center</option>
                <option value="Center for Teaching Excellence|10.712382,122.563600" <?= (($old['location'] ?? '') === 'Center for Teaching Excellence|10.712382,122.563600') ? 'selected' : '' ?>>Center for Teaching Excellence</option>
                <option value="Administration Building|10.714665,122.562294" <?= (($old['location'] ?? '') === 'Administration Building|10.714665,122.562294') ? 'selected' : '' ?>>Administration Building</option>
                <option value="Audio Visual Room|10.714481,122.562312" <?= (($old['location'] ?? '') === 'Audio Visual Room|10.714481,122.562312') ? 'selected' : '' ?>>Audio Visual Room</option>
                <option value="Mini Forest|10.713539,122.562146" <?= (($old['location'] ?? '') === 'Mini Forest|10.713539,122.562146') ? 'selected' : '' ?>>Mini Forest</option>
                <option value="Diamond Park|10.713873,122.562240" <?= (($old['location'] ?? '') === 'Diamond Park|10.713873,122.562240') ? 'selected' : '' ?>>Diamond Park</option>
                <option value="WVSU Multi-Purpose Cooperative|10.715193,122.562688" <?= (($old['location'] ?? '') === 'WVSU Multi-Purpose Cooperative|10.715193,122.562688') ? 'selected' : '' ?>>WVSU Multi-Purpose Cooperative</option>
                <option value="WVSU Cafeteria|10.712835,122.562814" <?= (($old['location'] ?? '') === 'WVSU Cafeteria|10.712835,122.562814') ? 'selected' : '' ?>>WVSU Cafeteria</option>
                <option value="WVSU Hometel|10.712835,122.562758" <?= (($old['location'] ?? '') === 'WVSU Hometel|10.712835,122.562758') ? 'selected' : '' ?>>WVSU Hometel</option>
                <option value="WVSU Research and Extension Building II|10.712846,122.560650" <?= (($old['location'] ?? '') === 'WVSU Research and Extension Building II|10.712846,122.560650') ? 'selected' : '' ?>>WVSU Research and Extension Building II</option>
                <option value="WVSU Research and Extension Building I|10.712661,122.560491" <?= (($old['location'] ?? '') === 'WVSU Research and Extension Building I|10.712661,122.560491') ? 'selected' : '' ?>>WVSU Research and Extension Building I</option>
                <option value="PESCAR Building / Ramon Magsaysay Hall|10.712845,122.563332" <?= (($old['location'] ?? '') === 'PESCAR Building / Ramon Magsaysay Hall|10.712845,122.563332') ? 'selected' : '' ?>>PESCAR Building / Ramon Magsaysay Hall</option>
                <option value="New Academic Building|10.713086,122.563506" <?= (($old['location'] ?? '') === 'New Academic Building|10.713086,122.563506') ? 'selected' : '' ?>>New Academic Building</option>
            </select>
        </div>

        <!-- ROOM NUMBER (hidden by default, shown via JS) -->
        <div id="room-number-wrapper" class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Room Number:</label>
            <input
                type="text"
                name="room_number"
                id="room_number"
                placeholder="e.g., 203"
                value="<?= htmlspecialchars($old['room_number'] ?? '') ?>"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
            >
        </div>

        <!-- DATE & TIME -->
        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Date Item was Lost:</label>
            <div class="w-full overflow-hidden rounded-xl border border-gray-300">
            <input
                type="date"
                name="event_date"
                id="event_date"
                required
                value="<?= htmlspecialchars(explode(' ', ($old['event_date'] ?? ''))[0] ?? '') ?>"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
            >
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Time Item was Lost:</label>
            <div class="w-full overflow-hidden rounded-xl border border-gray-300">
            <input
                type="time"
                name="event_time"
                id="event_time"
                required
                value="<?= htmlspecialchars(
                    !empty($old['event_date']) ? 
                    date('H:i', strtotime(explode(' ', ($old['event_date'] ?? ''))[1] ?? '12:00:00')) : 
                    ''
                ) ?>"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
            >
            </div>
        </div>

        <!-- CATEGORY -->
        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Category:</label>
            <select name="category" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">-- Select Category --</option>
                <option value="Books" <?= (($old['category'] ?? '') === 'Books') ? 'selected' : '' ?>>Books</option>
                <option value="Electronics" <?= (($old['category'] ?? '') === 'Electronics') ? 'selected' : '' ?>>Electronics</option>
                <option value="Personal" <?= (($old['category'] ?? '') === 'Personal') ? 'selected' : '' ?>>Personal</option>
                <option value="IDs/Documents" <?= (($old['category'] ?? '') === 'IDs/Documents') ? 'selected' : '' ?>>IDs/Documents</option>
                <option value="Bags" <?= (($old['category'] ?? '') === 'Bags') ? 'selected' : '' ?>>Bags</option>
                <option value="Clothing" <?= (($old['category'] ?? '') === 'Clothing') ? 'selected' : '' ?>>Clothing</option>
                <option value="Accessories" <?= (($old['category'] ?? '') === 'Accessories') ? 'selected' : '' ?>>Accessories</option>
                <option value="Stationery" <?= (($old['category'] ?? '') === 'Stationery') ? 'selected' : '' ?>>Stationery</option>
                <option value="Others" <?= (($old['category'] ?? '') === 'Others') ? 'selected' : '' ?>>Others</option>
            </select>
        </div>

        <!-- STATUS TAG-->
        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Status Tag:</label>
            <select name="status" id="status-select" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white">
                
                <option value="Lost" <?= (($old['status'] ?? 'Lost') !== 'Found') ? 'selected' : '' ?>>Lost</option>
                <option value="Found" <?= (($old['status'] ?? '') === 'Found') ? 'selected' : '' ?>>Found</option>
                
            </select>
        </div>
        
        <!-- ITEM DESCRIPTION -->
        <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black">Item Description:</label>
            <textarea
                name="description"
                rows="4"
                placeholder="Color, brand, or any distinguishing marks."
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white resize"
            ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <!-- ITEM PHOTO -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-black">Item Photo:</label>
                <label for="item_image" class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white flex items-center justify-center gap-3 cursor-pointer hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="shrink-0">
                        <path d="M11 16V7.85L8.4 10.45L7 9L12 4L17 9L15.6 10.45L13 7.85V16H11ZM6 20C5.45 20 4.97933 19.8043 4.588 19.413C4.19667 19.0217 4.00067 18.5507 4 18V15H6V18H18V15H20V18C20 18.55 19.8043 19.021 19.413 19.413C19.0217 19.805 18.5507 20.0007 18 20H6Z" fill="black"/>
                    </svg>
                    <input type="file" id="item_image" name="item_image" accept="image/jpeg,image/png,image/webp,image/avif" required class="hidden">
                </label>
                <small class="text-xs text-gray-500">Accepts: JPG, JPEG, PNG, WEBP, AVIF</small>
                <div id="preview-container" class="w-full">
                    <img id="preview-image" alt="Image Preview" class="w-full rounded-lg object-cover">
                </div>
            </div>

            <button type="button" id="camera-button"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold bg-white hover:bg-gray-100 transition">
                Open Camera
            </button>

            <div id="camera-block" class="flex flex-col gap-2">
                <video id="camera-video" autoplay class="w-full rounded-xl"></video>
                <div id="camera-buttons" class="grid grid-cols-2 gap-2">
                    <button type="button" id="capture-btn"
                        class="border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold bg-white hover:bg-gray-100 transition">
                        Capture Photo
                    </button>
                    <button type="button" id="stop-btn"
                        class="border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold bg-white hover:bg-gray-100 transition">
                        Stop Camera
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTACT INFORMATION -->
        <div class="flex flex-col gap-4">
            <h3 class="text-sm font-semibold text-black">Contact Information</h3>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-black">First Name:</label>
                <input
                    type="text"
                    name="first_name"
                    required
                    value="<?= htmlspecialchars($old['first_name'] ?? ($user['first_name'] ?? '')) ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
                >
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-black">Last Name:</label>
                <input
                    type="text"
                    name="last_name"
                    required
                    value="<?= htmlspecialchars($old['last_name'] ?? ($user['last_name'] ?? '')) ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
                >
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-black">Contact Details:</label>
                <input
                    type="text"
                    name="contact_details"
                    required
                    value="<?= htmlspecialchars($old['contact_details'] ?? ($user['phone_number'] ?? ($user['email'] ?? ''))) ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"
                >
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex flex-row gap-8 mt-2 justify-center">
            <button type="button"
                onclick="window.location.href='/lost'"
                class="flex items-center justify-center px-6 py-3 rounded-2xl border border-black bg-white text-black font-semibold text-sm transition hover:bg-gray-100">
                Reset
            </button>
            <button type="submit"
                class="flex items-center justify-center px-6 py-3 rounded-2xl bg-[#E6BA05] text-white font-semibold text-sm transition hover:bg-yellow-500">
                Submit
            </button>
        </div>
    </form>
</main>
</body>
</html>