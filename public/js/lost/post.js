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