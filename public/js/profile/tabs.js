document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".tab-btn");
    const tabs = document.querySelectorAll(".tab-content");

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
    activateTab("account");

    // click events
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            activateTab(this.dataset.tab);
        });
    });
});