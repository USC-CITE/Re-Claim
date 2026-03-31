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

        // hide all tabs
        tabs.forEach(tab => {
            tab.classList.remove("active");
        });

        // deactivate all buttons
        buttons.forEach(btn => {
            btn.classList.remove("active");
        });

        // activate selected tab
        document.getElementById(tabId).classList.add("active");
        
        // activate selected button
        document.querySelector(`[data-tab="${tabId}"]`).classList.add("active");

    }

    // default tab
    activateTab("edit-profile");

    // click events
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            activateTab(this.dataset.tab);
        });
    });
});