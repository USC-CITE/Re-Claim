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
        const section      = document.getElementById(`${type}-items-section`);
        const toggleButton = document.getElementById(`toggle-bulk-archive-${type}`);
        const actionBar    = document.getElementById(`bulk-action-bar-${type}`);
        const countEl      = document.getElementById(`bulk-count-${type}`);

        if (!section || !toggleButton) return;

        const isActive = !section.classList.contains("bulk-archive-mode");
        section.classList.toggle("bulk-archive-mode", isActive);

        const label = type === "lost" ? "Lost" : "Found";
        toggleButton.textContent = isActive
            ? `Cancel Archive Selection`
            : `Archive ${label} Items`;

        // Show / hide inline action bar
        if (actionBar) {
            if (isActive) {
                actionBar.classList.remove("hidden");
                actionBar.classList.add("flex");
            } else {
                actionBar.classList.add("hidden");
                actionBar.classList.remove("flex");
            }
        }

        // Show / hide per-card checkbox labels
        section.querySelectorAll(".bulk-archive-box").forEach(lbl => {
            lbl.classList.toggle("hidden", !isActive);
        });

        const checkboxes = section.querySelectorAll(`input[name="item_ids[]"]`);

        if (!isActive) {
            checkboxes.forEach(cb => {
                cb.checked = false;

                const card = cb.closest("[data-card]");
                if (card) card.style.boxShadow = "0 4px 12px rgba(0,0,0,0.20)";

                const box  = cb.closest("label")?.querySelector(".bulk-checkbox-box");
                const icon = cb.closest("label")?.querySelector(".bulk-checkbox-icon");
                if (box)  box.style.backgroundColor = "";
                if (icon) icon.style.opacity = "0";
            });

            if (countEl) countEl.textContent = "0 Items Selected";

        } else {
            checkboxes.forEach(cb => {
                cb.removeEventListener("change", cb._bulkChangeHandler);

                cb._bulkChangeHandler = function () {
                    const card = this.closest("[data-card]");
                    const box  = this.closest("label").querySelector(".bulk-checkbox-box");
                    const icon = this.closest("label").querySelector(".bulk-checkbox-icon");

                    if (box)  box.style.backgroundColor = this.checked ? "#055BA8" : "";
                    if (icon) icon.style.opacity = this.checked ? "1" : "0";

                    if (card) {
                        card.style.boxShadow = this.checked
                            ? "0 0 0 2px #055BA8"
                            : "0 4px 12px rgba(0,0,0,0.20)";
                    }

                    const selected = section.querySelectorAll(`input[name="item_ids[]"]:checked`).length;
                    if (countEl) {
                        countEl.textContent = `${selected} Item${selected !== 1 ? "s" : ""} Selected`;
                    }
                };

                cb.addEventListener("change", cb._bulkChangeHandler);
            });
        }
    };
});