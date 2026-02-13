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
const locationSelect = document.querySelector('select[name="location"]');
const roomWrapper = document.getElementById('room-number-wrapper');
const roomInput = document.getElementById('room_number');

// Locations that require a room number
const requiresRoom = new Set([
    'Quezon Hall',
    'Lopez Jaena Building / ULRC',
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