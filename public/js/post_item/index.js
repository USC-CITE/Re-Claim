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
    
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                const video = document.getElementById('camera-video');
                const cameraBlock = document.getElementById('camera-block');
                const captureBtn = document.getElementById('capture-btn');
                const stopBtn = document.getElementById('stop-btn');
                const statusSelect = document.getElementById('status-select');
                
                video.srcObject = stream;
                cameraBlock.style.display = 'block';

                captureBtn.onclick = function(e) {
                    e.preventDefault();
                    
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0);

                    canvas.toBlob(function(blob) {
                        const dt = new DataTransfer();
                        
                        const now = new Date();
                        const timestamp = now.getFullYear() +
                            String(now.getMonth() + 1).padStart(2, '0') +
                            String(now.getDate()).padStart(2, '0') + '_' +
                            String(now.getHours()).padStart(2, '0') +
                            String(now.getMinutes()).padStart(2, '0') +
                            String(now.getSeconds()).padStart(2, '0');
                            
                        const isFound = statusSelect.value === 'Found';
                        const prefix = isFound ? 'FND' : 'LST';
                        const uniqueId = prefix + Math.random().toString(36).substr(2, 6).toUpperCase();
                        const fileName = (isFound ? 'found_' : 'lost_') + timestamp + '_' + uniqueId + '.png';
                        
                        const file = new File([blob], fileName, { type: 'image/png' });
                        dt.items.add(file);
                        document.getElementById('item_image').files = dt.files;

                        const img = document.getElementById('preview-image');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.src = e.target.result;
                            img.style.display = 'block';
                        }
                        reader.readAsDataURL(file);

                        stream.getTracks().forEach(track => track.stop());
                        cameraBlock.style.display = 'none';
                    }, 'image/png');
                };

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

const requiresRoom = new Set([
    'Quezon Hall',
    'Lopez Jaena Building / ULRC',
    'PESCAR Building / Ramon Magsaysay Hall',
    'New Academic Building'
]);

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
updateRoomField(); 

// Set the Date & Time fields to local time on first load
const dateInput = document.querySelector('input[name="event_date"]');
const timeInput = document.querySelector('input[name="event_time"]');

if (dateInput && timeInput) {
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

// Status specific behavior updates
const statusSelect = document.getElementById('status-select');
const locationLabel = document.getElementById('location-label');
const dateLabel = document.getElementById('date-label');
const timeLabel = document.getElementById('time-label');

function updateLabels() {
    if (statusSelect.value === 'Found') {
        locationLabel.textContent = 'Location where item was Found:';
        dateLabel.textContent = 'Date Item was Found:';
        timeLabel.textContent = 'Time Item was Found:';
        document.querySelectorAll('.required-for-lost').forEach(el => el.required = false);
    } else {
        locationLabel.textContent = 'Location where item was Lost:';
        dateLabel.textContent = 'Date Item was Lost:';
        timeLabel.textContent = 'Time Item was Lost:';
        document.querySelectorAll('.required-for-lost').forEach(el => el.required = true);
    }
}

statusSelect.addEventListener('change', updateLabels);
updateLabels(); // Initialize

function addSocialLinkRow() {
    const container = document.getElementById('social-links-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 social-link-row';
    const reqClass = statusSelect.value === 'Lost' ? 'required-for-lost' : '';
    div.innerHTML = `<input type="text" name="social_links[]" placeholder="facebook.com/yourprofile" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 bg-white ${reqClass}"><button type="button" onclick="removeSocialLinkRow(this)" class="px-3 py-2 border border-gray-300 rounded-xl text-sm hover:bg-red-100 transition shrink-0">✕</button>`;
    if (statusSelect.value === 'Lost') {
        div.querySelector('input').required = true;
    }
    container.appendChild(div);
}

function removeSocialLinkRow(button) {
    const container = document.getElementById('social-links-container');
    const rows = container.querySelectorAll('.social-link-row');
    
    // Only enforce minimum 1 if they are reporting a Lost item
    if (statusSelect.value === 'Lost' && rows.length === 1) {
        let errorMsg = document.getElementById('social-links-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.id = 'social-links-error';
            errorMsg.className = 'text-red-500 text-sm mt-1';
            container.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = 'You must keep at least one social link for lost items.';
        return;
    }
    
    const existingError = document.getElementById('social-links-error');
    if (existingError) existingError.remove();
    
    button.closest('.social-link-row').remove();
}
