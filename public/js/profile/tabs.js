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
    
    function showDialog(modal) {
        if (!modal) {
            return;
        }

        if (typeof modal.showModal === "function") {
            modal.showModal();
            return;
        }

        if (typeof modal.show === "function") {
            modal.show();
            return;
        }

        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function closeDialog(modal) {
        if (!modal) {
            return;
        }

        if (typeof modal.close === "function") {
            modal.close();
            return;
        }

        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    window.openModal = function (id) {
        const modal = document.getElementById(id);
        showDialog(modal);
    };

    window.closeModal = function (id) {
        const modal = document.getElementById(id);
        closeDialog(modal);
    };

    window.toggleBulkArchiveMode = function (type) {
        const section = document.getElementById(`${type}-items-section`);
        const toggleButton = document.getElementById(`toggle-bulk-archive-${type}`);

        if (!section || !toggleButton) {
            return;
        }

        const isActive = !section.classList.contains('bulk-archive-mode');
        section.classList.toggle('bulk-archive-mode', isActive);
        toggleButton.textContent = isActive
            ? `Cancel ${type === 'lost' ? 'Lost' : 'Found'} archive selection`
            : `Archive ${type === 'lost' ? 'Lost' : 'Found'} Items`;

        const submitButton = document.getElementById(`bulk-archive-submit-${type}`);
        if (submitButton) {
            submitButton.style.display = isActive ? 'inline-flex' : 'none';
        }

        if (!isActive) {
            section.querySelectorAll('input[name="item_ids[]"]').forEach(function (checkbox) {
                checkbox.checked = false;
            });
        }
    };
});