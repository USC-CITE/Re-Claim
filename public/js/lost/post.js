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

// Camera Capture Logic
document.getElementById('camera-button').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Check if browser supports camera access via MediaDevices API
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Request access to rear camera (environment facing)
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                // Get existing video element and show camera block
                const video = document.getElementById('camera-video');
                const cameraBlock = document.getElementById('camera-block');
                const captureBtn = document.getElementById('capture-btn');
                const stopBtn = document.getElementById('stop-btn');
                
                video.srcObject = stream;
                cameraBlock.style.display = 'block';

                // Handle "Capture Photo" button click
                captureBtn.onclick = function(e) {
                    e.preventDefault();
                    
                    // Draw current video frame onto canvas
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0);

                    // Convert canvas to blob (PNG image)
                    canvas.toBlob(function(blob) {
                        const dt = new DataTransfer();
                        
                        // Generate filename (same as image upload): lost_[Ymd_His]_LST[uniqueId].png
                        const now = new Date();
                        const timestamp = now.getFullYear() +
                            String(now.getMonth() + 1).padStart(2, '0') +
                            String(now.getDate()).padStart(2, '0') + '_' +
                            String(now.getHours()).padStart(2, '0') +
                            String(now.getMinutes()).padStart(2, '0') +
                            String(now.getSeconds()).padStart(2, '0');
                        const uniqueId = 'LST' + Math.random().toString(36).substr(2, 6).toUpperCase();
                        const fileName = 'lost_' + timestamp + '_' + uniqueId + '.png';
                        
                        const file = new File([blob], fileName, { type: 'image/png' });
                        dt.items.add(file);
                        document.getElementById('item_image').files = dt.files;

                        // Display captured image in the preview area
                        const img = document.getElementById('preview-image');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.src = e.target.result;
                            img.style.display = 'block';
                        }
                        reader.readAsDataURL(file);

                        // Stop camera stream
                        stream.getTracks().forEach(track => track.stop());
                        
                        // Hide camera UI
                        cameraBlock.style.display = 'none';
                    }, 'image/png');
                };

                // Handle "Stop Camera" button click
                stopBtn.onclick = function(e) {
                    e.preventDefault();
                    stream.getTracks().forEach(track => track.stop());
                    cameraBlock.style.display = 'none';
                };
            })
            .catch(function(err) {
                alert('Camera access denied or unavailable: ' + err.message);
            });
    } else {
        alert('Camera is not supported on this device.');
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


// Set the Date & Time Lost fields to the browser's local time
const dateInput = document.querySelector('input[name="event_date"]');
const timeInput = document.querySelector('input[name="event_time"]');

if (dateInput && timeInput) {
    // Only set defaults if BOTH fields are empty (first load, not form switch)
    if (!dateInput.value && !timeInput.value) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        dateInput.value = `${year}-${month}-${day}`;
        timeInput.value = `${hours}:${minutes}`;
    }
}

// Cross-form status switch
const statusSelect = document.getElementById('status-select');
statusSelect.value = 'Lost';

function handleStatusSwitch() {
    const status = statusSelect.value;
    
    if (status === 'Found') {
            const params = new URLSearchParams();
            params.set('item_name',       document.querySelector('[name="item_name"]').value);
            params.set('location',        document.querySelector('[name="location"]').value);
            params.set('room_number',     document.querySelector('[name="room_number"]').value);
            params.set('category',        document.querySelector('[name="category"]').value);
            params.set('description',     document.querySelector('[name="description"]').value);
            params.set('first_name',      document.querySelector('[name="first_name"]').value);
            params.set('last_name',       document.querySelector('[name="last_name"]').value);
            params.set('contact_details', document.querySelector('[name="contact_details"]').value);
            document.querySelectorAll('[name="social_links[]"]').forEach(function(input) {
                if (input.value.trim()) params.append('social_links[]', input.value.trim());
            });
            params.set('status',          status);

            // Send date/time under both names so the found form can pick them up
            const date = document.querySelector('[name="event_date"]').value;
            const time = document.querySelector('[name="event_time"]').value;
            params.set('event_date',      date);
            params.set('event_time',      time);
            params.set('date_found_date', date);
            params.set('date_found_time', time);

            window.location.href = '/found/post?' + params.toString();
        }
        // If status === 'Lost', do nothing
    }
    statusSelect.addEventListener('change', function () {
    setTimeout(handleStatusSwitch, 100); // Delay to ensure DOM updates on mobile (Safari)
});

function addSocialLinkRow() {
    const container = document.getElementById('social-links-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 social-link-row';
    div.innerHTML = `<input type="url" name="social_links[]" placeholder="https://platform.com/yourprofile" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white"><button type="button" onclick="removeSocialLinkRow(this)" class="px-3 py-2 border border-gray-300 rounded-xl text-sm hover:bg-red-100 transition shrink-0">✕</button>`;
    container.appendChild(div);
}

function removeSocialLinkRow(button) {
    const container = document.getElementById('social-links-container');
    const rows = container.querySelectorAll('.social-link-row');
    
    if (rows.length === 1) {
        // Show error message
        let errorMsg = document.getElementById('social-links-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'social-links-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            container.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'You must keep at least one social link.';
        return;
    }
    
    // Clear error if exists
    const existingError = document.getElementById('social-links-error');
    if (existingError) existingError.remove();
    
    button.closest('.social-link-row').remove();
}