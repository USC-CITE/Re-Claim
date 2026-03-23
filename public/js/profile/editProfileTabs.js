document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".tab-btn");
    const tabs = document.querySelectorAll(".tab-content");
    const pageTitle = document.getElementById('page-title');

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
        const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
        activeBtn.classList.add("active");

        pageTitle.textContent = activeBtn.dataset.title;

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