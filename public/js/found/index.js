function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.showModal();
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.close();
}

function toggleBulkArchiveMode() {
    const toggleButton = document.getElementById("toggle-bulk-archive");
    const bulkForm = document.getElementById("bulk-archive-form");
    const bulkBoxes = document.querySelectorAll(".bulk-archive-box");
    const bulkSubmit = document.querySelector(".bulk-archive-submit");

    if (!toggleButton || !bulkForm) return;

    const isActive = !bulkForm.classList.contains("bulk-archive-mode");
    bulkForm.classList.toggle("bulk-archive-mode", isActive);
    toggleButton.textContent = isActive ? "Cancel Archive Selection" : "Archive Found Items";

    // Bulk checkboxes and submit button live outside the form, so they are toggled manually here.
    bulkBoxes.forEach(function (box) {
        box.style.display = isActive ? "block" : "none";
    });

    if (bulkSubmit) {
        bulkSubmit.style.display = isActive ? "block" : "none";
    }

    if (!isActive) {
        // Clear previous selections when archive mode is cancelled.
        document.querySelectorAll('input[name="item_ids[]"]').forEach(function (checkbox) {
            checkbox.checked = false;
        });
    }
}

function setupTitleSearch(inputId) {
    const searchInput = document.getElementById(inputId);
    const cards = Array.from(document.querySelectorAll(".item-card"));
    const emptyState = document.querySelector("[data-empty-search-state]");
    const listingGrid = document.querySelector("[data-listing-grid]");

    if (!searchInput || !cards.length) return;

    const updateResults = function () {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(function (card) {
            const titleElement = card.querySelector(".item-card-title");
            const title = titleElement ? titleElement.textContent.toLowerCase() : "";
            const isMatch = query === "" || title.includes(query);

            card.style.display = isMatch ? "" : "none";
            if (isMatch) visibleCount += 1;
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? "block" : "none";
        }

        if (listingGrid) {
            listingGrid.style.display = visibleCount === 0 ? "none" : "flex";
        }
    };

    if (searchInput.form) {
        searchInput.form.addEventListener("submit", function (event) {
            event.preventDefault();
        });
    }

    searchInput.addEventListener("input", updateResults);
    updateResults();
}

document.addEventListener("DOMContentLoaded", function () {
    setupTitleSearch("found-search");
});
