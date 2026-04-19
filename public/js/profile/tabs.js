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

    window.toggleBulkMode = function (type) {
        // type is 'lost', 'found', or 'archived'
        const isDelete = type === 'archived';

        const section   = document.getElementById(`${type}-items-section`);
        const toggleBtn = document.getElementById(isDelete ? 'toggle-bulk-delete-archived' : `toggle-bulk-archive-${type}`);
        const actionBar = document.getElementById(isDelete ? 'bulk-action-bar-archived' : `bulk-action-bar-${type}`);
        const countEl   = document.getElementById(isDelete ? 'bulk-count-archived' : `bulk-count-${type}`);

        if (!section || !toggleBtn) return;

        const modeClass = isDelete ? 'bulk-delete-mode' : 'bulk-archive-mode';
        const isActive  = !section.classList.contains(modeClass);
        section.classList.toggle(modeClass, isActive);

        const labelActive   = isDelete ? 'Cancel Selection' : 'Cancel Archive Selection';
        const labelInactive = isDelete ? 'Delete Archived Items' : `Archive ${type === 'lost' ? 'Lost' : 'Found'} Items`;
        toggleBtn.textContent = isActive ? labelActive : labelInactive;

        if (actionBar) {
            actionBar.classList.toggle('hidden', !isActive);
            actionBar.classList.toggle('flex', isActive);
        }

        const checkboxClass = isDelete ? '.bulk-delete-box' : '.bulk-archive-box';
        section.querySelectorAll(checkboxClass).forEach(lbl => {
            lbl.classList.toggle('hidden', !isActive);
        });

        const checkboxes = section.querySelectorAll('input[name="item_ids[]"]');
        const activeColor = isDelete ? '#dc2626' : '#055BA8';
        const handlerKey  = isDelete ? '_bulkDeleteHandler' : '_bulkChangeHandler';
        const boxClass    = isDelete ? '.bulk-delete-checkbox-box' : '.bulk-checkbox-box';
        const iconClass   = isDelete ? '.bulk-delete-checkbox-icon' : '.bulk-checkbox-icon';
        const cardAttr    = isDelete ? '[data-card-archived]' : '[data-card]';

        if (!isActive) {
            checkboxes.forEach(cb => {
                cb.checked = false;

                const card = cb.closest(cardAttr);
                if (card) card.style.boxShadow = '0 4px 12px rgba(0,0,0,0.20)';

                const box  = cb.closest('label')?.querySelector(boxClass);
                const icon = cb.closest('label')?.querySelector(iconClass);
                if (box)  box.style.backgroundColor = '';
                if (icon) icon.style.opacity = '0';
            });

            if (countEl) countEl.textContent = '0 Items Selected';

        } else {
            checkboxes.forEach(cb => {
                cb.removeEventListener('change', cb[handlerKey]);

                cb[handlerKey] = function () {
                    const card = this.closest(cardAttr);
                    const box  = this.closest('label')?.querySelector(boxClass);
                    const icon = this.closest('label')?.querySelector(iconClass);

                    if (box)  box.style.backgroundColor = this.checked ? activeColor : '';
                    if (icon) icon.style.opacity = this.checked ? '1' : '0';

                    if (card) {
                        card.style.boxShadow = this.checked
                            ? `0 0 0 2px ${activeColor}`
                            : '0 4px 12px rgba(0,0,0,0.20)';
                    }

                    const selected = section.querySelectorAll('input[name="item_ids[]"]:checked').length;
                    if (countEl) {
                        countEl.textContent = `${selected} Item${selected !== 1 ? 's' : ''} Selected`;
                    }
                };

                cb.addEventListener('change', cb[handlerKey]);
            });
        }
    };
});