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

    // Camera Capture Logic
const cameraButton = document.getElementById('camera-button');
if (cameraButton) {
    cameraButton.addEventListener('click', function(e) {
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
                            
                            // Generate filename: found_[Ymd_His]_FND[uniqueId].png
                            const now = new Date();
                            const timestamp = now.getFullYear() +
                                String(now.getMonth() + 1).padStart(2, '0') +
                                String(now.getDate()).padStart(2, '0') + '_' +
                                String(now.getHours()).padStart(2, '0') +
                                String(now.getMinutes()).padStart(2, '0') +
                                String(now.getSeconds()).padStart(2, '0');
                            const uniqueId = 'FND' + Math.random().toString(36).substr(2, 6).toUpperCase();
                            const fileName = 'found_' + timestamp + '_' + uniqueId + '.png';
                            
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
}

// Cross-form status switch
document.getElementById('status-select').addEventListener('change', function () {
    const status = this.value;
    if (!status) return;

    const params = new URLSearchParams();
    params.set('item_name',       document.querySelector('[name="item_name"]').value);
    params.set('location',        document.querySelector('[name="location"]').value);
    params.set('room_number',     document.querySelector('[name="room_number"]').value);
    params.set('category',        document.querySelector('[name="category"]').value);
    params.set('description',     document.querySelector('[name="description"]').value);
    params.set('first_name',      document.querySelector('[name="first_name"]').value);
    params.set('last_name',       document.querySelector('[name="last_name"]').value);
    params.set('contact_details', document.querySelector('[name="contact_details"]').value);
    params.set('status',          status);

    // Send date/time under both names so the lost form can pick them up
    const date = document.querySelector('[name="date_found_date"]').value;
    const time = document.querySelector('[name="date_found_time"]').value;
    params.set('date_found_date', date);
    params.set('date_found_time', time);
    params.set('event_date',      date);
    params.set('event_time',      time);

    window.location.href = '/lost/post?' + params.toString();
});