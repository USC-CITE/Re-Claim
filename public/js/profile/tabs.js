document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".tab-btn");
    const tabs = document.querySelectorAll(".tab-content");

    const tabWrapper = document.getElementById("tabScroll");
    const fadeLeft = document.getElementById("fadeLeft");
    const fadeRight = document.getElementById("fadeRight");

    // Activate a tab by ID
    function activateTab(tabId) {
        // hide all tabs
        tabs.forEach(tab => tab.classList.remove("active"));

        // deactivate all buttons
        buttons.forEach(btn => btn.classList.remove("active"));

        // activate selected tab and button
        document.getElementById(tabId).classList.add("active");
        document.querySelector(`[data-tab="${tabId}"]`).classList.add("active");
    }

    // Update fade overlays based on scroll position
    function updateFade() {
        const scrollLeft = tabWrapper.scrollLeft;
        const maxScrollLeft = tabWrapper.scrollWidth - tabWrapper.clientWidth;

        // Smooth opacity calculation (fade in/out gradually)
        const leftOpacity = Math.min(scrollLeft / 30, 1);
        const rightOpacity = Math.min((maxScrollLeft - scrollLeft) / 30, 1);

        fadeLeft.style.opacity = leftOpacity;
        fadeRight.style.opacity = rightOpacity;
    }

    // Event listeners
    tabWrapper.addEventListener("scroll", updateFade);
    window.addEventListener("load", updateFade);
    window.addEventListener("resize", updateFade);

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            activateTab(this.dataset.tab);
        });
    });

    // Default tab
    activateTab("account");
});