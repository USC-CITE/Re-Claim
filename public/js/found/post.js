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
