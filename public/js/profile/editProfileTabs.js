document.addEventListener("DOMContentLoaded", function () {

    const buttons = document.querySelectorAll(".tab-btn");
    const tabs = document.querySelectorAll(".tab-content");
    const pageTitle = document.getElementById('page-title');

    const input = document.getElementById("avatarInput");
    const fileName = document.getElementById("file-name");  
    // Variables for Delete Avatar Button
    const deleteBtn = document.getElementById("deleteAvatarBtn");
    const deleteInput = document.getElementById("deleteAvatarInput");

    // Avatar Preview
    const avatarPreview = document.getElementById("avatarPreview");

    // Delete state flag
    let isDeleted = false;

    // Delete button delete/undo logic
    deleteBtn.addEventListener('click', () => {
        isDeleted = !isDeleted;

        if (isDeleted) {
            deleteInput.value = "1";
            deleteBtn.textContent = "Undo Remove Avatar";

            // Clear image and file name states
            avatarPreview.src = "/avatars/default.png";
            fileName.textContent = '';
            input.value = '';

            deleteBtn.classList.remove("text-red-500", "border-red-500", "hover:bg-red-100");
            deleteBtn.classList.add("text-gray-900", "border-gray-400", "hover:bg-red-100");
        } else {
            deleteInput.value = "0";
            deleteBtn.textContent = "Remove Avatar";

            avatarPreview.src = originalAvatar;
            deleteBtn.classList.add("hover:bg-red-100");
            deleteBtn.classList.remove("text-gray-600", "border-gray-400", "hover:bg-gray-200");
        }
    });

    input.addEventListener('change', () => {
        const file = input.files[0];

        // Handles the file name preview
        fileName.textContent = file ? file.name : '';

        if(file){
            const reader = new FileReader();

            reader.onload = function(e){
                avatarPreview.src = e.target.result;
            }

            reader.readAsDataURL(file);

            // Reset delete state if user uploads new image
            isDeleted = false;
            deleteInput.value = "0";
            deleteBtn.textContent = "Remove Avatar";
        }
    })
    
    function activateTab(tabId) {
    console.log("Activating:", tabId);

    const targetTab = document.getElementById(tabId);
    const targetBtn = document.querySelector(`[data-tab="${tabId}"]`);

    // If not found, fallback
    if (!targetTab || !targetBtn) {
        console.warn("Tab not found:", tabId);

        tabId = "edit-profile";
    }

    // reset again using safe tabId
    tabs.forEach(tab => tab.classList.remove("active"));
    buttons.forEach(btn => btn.classList.remove("active"));

    document.getElementById(tabId).classList.add("active");
    document.querySelector(`[data-tab="${tabId}"]`).classList.add("active");
}

    const hash = window.location.hash.substring(1);
    console.log("HASH:", hash);
    if(hash){
        activateTab(hash);
    }else{
        // default tab
        activateTab("edit-profile");
    }
    

    // click events
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            activateTab(this.dataset.tab);

            history.replaceState(null, "", `#${this.dataset.tab}`);
        });
    });

    /* =========================
    SOCIAL LINKS SYSTEM (MAX 3 TOTAL)
    ========================= */

    const MAX_LINKS = 3;
    const container = document.getElementById("socialLinksContainer");
    const addBtn = document.getElementById("addLinkBtn");

    if (container && addBtn) {

        function getCount() {
            return container.querySelectorAll("input[name='social_links[]']").length;
        }

        function updateState() {
            const count = getCount();

            if (count >= MAX_LINKS) {
                addBtn.disabled = true;
                addBtn.innerText = "Max 3 links reached";
                addBtn.classList.add("opacity-50", "cursor-not-allowed");
            } else {
                addBtn.disabled = false;
                addBtn.innerText = "+ Add another social media account";
                addBtn.classList.remove("opacity-50", "cursor-not-allowed");
            }
        }

        window.addLink = function () {
            if (getCount() >= MAX_LINKS) return;

            const row = document.createElement("div");
            row.className = "flex gap-2";

            row.innerHTML = `
                <input type="text"
                    name="social_links[]"
                    class="w-full border rounded-lg px-3 py-2 border-gray-300 text-sm"
                    placeholder="facebook.com/yourprofile" />

                <button type="button"
                    onclick="removeLink(this)"
                    class="px-3 py-2 border rounded-lg text-sm hover:bg-red-100">
                    ✕
                </button>
            `;

            container.appendChild(row);
            updateState();
        };

        window.removeLink = function (btn) {
            btn.parentElement.remove();
            updateState();
        };

        // initialize on page load (IMPORTANT for session-loaded links)
        updateState();
    }

    const originalState = {
        firstName: document.querySelector("[name='first_name']").value,
        lastName: document.querySelector("[name='last_name']").value,
        phone: document.querySelector("[name='phone_number']").value,
        social: document.querySelector("[name='social_link']").value,
        avatar: avatarPreview.src,
        socialLinks: Array.from(
            document.querySelectorAll("input[name='social_links[]']")
        ).map(input => input.value)
    };

    const cancelBtn = document.getElementById("cancelBtn");

    cancelBtn.addEventListener("click", () => {

        // Restore text fields
        document.querySelector("[name='first_name']").value = originalState.firstName;
        document.querySelector("[name='last_name']").value = originalState.lastName;
        document.querySelector("[name='phone_number']").value = originalState.phone;
        document.querySelector("[name='social_link']").value = originalState.social;

        // Restore avatar
        avatarPreview.src = originalState.avatar;
        input.value = "";
        fileName.textContent = "";
        deleteInput.value = "0";

        // Reset delete state
        isDeleted = false;
        deleteBtn.textContent = "Remove Avatar";

        // Restore social links
        const container = document.getElementById("socialLinksContainer");
        container.innerHTML = "";

        originalState.socialLinks.forEach(link => {
            const row = document.createElement("div");
            row.className = "flex gap-2";

            row.innerHTML = `
                <input type="text" name="social_links[]"
                    value="${link}"
                    placeholder="facebook.com/yourprofile"
                    class="w-full border rounded-lg px-3 py-2 border-gray-300 text-sm">

                <button type="button"
                    onclick="removeLink(this)"
                    class="px-3 py-2 border rounded-lg text-sm hover:bg-red-100">
                    ✕
                </button>
            `;

            container.appendChild(row);
        });

        // re-sync button state
        if (typeof updateState === "function") {
            updateState();
        }
    });

    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("otpModal");

    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
    })

    // Tab Navigation for Upload Avatar
    const avatarLabel = document.querySelector('label[for="avatarInput"');

    avatarLabel.addEventListener("keydown", (e) => {
        if(e.key === 'Enter' || e.key === ' '){
            e.preventDefault();
            input.click();
        }
    })
});