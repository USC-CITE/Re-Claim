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