document.addEventListener("DOMContentLoaded", function () {
    console.log("This load");
    const buttons = document.querySelectorAll(".tab-btn");
    const tabs = document.querySelectorAll(".tab-content");
    const pageTitle = document.getElementById('page-title');

    const input = document.getElementById("avatarInput");
    const fileName = document.getElementById("file-name");  
    // Variables for Delete Avatar Button
    const deleteBtn = document.getElementById("deleteAvatarBtn");
    const deleteInput = document.getElementById("deleteAvatarInput");

    // Delete state flag
    let isDeleted = false;

    // Delete button delete/undo logic
    deleteBtn.addEventListener('click', () => {
        isDeleted = !isDeleted;

        if (isDeleted) {
            deleteInput.value = "1";
            deleteBtn.textContent = "Undo Remove Avatar";
            deleteBtn.classList.remove("text-red-500", "border-red-500", "hover:bg-red-100");
            deleteBtn.classList.add("text-gray-600", "border-gray-400", "hover:bg-gray-200");
        } else {
            deleteInput.value = "0";
            deleteBtn.textContent = "Remove Avatar";
            deleteBtn.classList.add("hover:bg-red-100");
            deleteBtn.classList.remove("text-gray-600", "border-gray-400", "hover:bg-gray-200");
        }
    });

    input.addEventListener('change', () => {
        fileName.textContent = input.files.length > 0 ?  input.files[0].name : '';
    })
    
    function activateTab(tabId) {
    console.log("Activating:", tabId);

    const targetTab = document.getElementById(tabId);
    const targetBtn = document.querySelector(`[data-tab="${tabId}"]`);

    // 🚨 If not found, fallback
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
});