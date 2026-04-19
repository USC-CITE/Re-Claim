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
  toggleButton.textContent = isActive
    ? "Cancel Archive Selection"
    : "Archive Lost Items";

  // Bulk checkboxes and submit button live outside the form, so they are toggled manually here.
  bulkBoxes.forEach(function (box) {
    box.style.display = isActive ? "block" : "none";
  });

  if (bulkSubmit) {
    bulkSubmit.style.display = isActive ? "block" : "none";
  }

  if (!isActive) {
    // Clear previous selections when archive mode is cancelled.
    bulkForm
      .querySelectorAll('input[name="item_ids[]"]')
      .forEach(function (checkbox) {
        checkbox.checked = false;
      });
  }
}

function setupListingFilters(config) {
  const searchInput = document.getElementById(config.searchInputId);
  const statusFilter = document.getElementById(config.statusFilterId);
  const locationFilter = document.getElementById(config.locationFilterId);
  const categoryFilter = document.getElementById(config.categoryFilterId);
  const filterToggle = document.querySelector("[data-filter-toggle]");
  const filterPanel = document.querySelector("[data-filter-panel]");
  const cards = Array.from(document.querySelectorAll(".item-card"));
  const emptyState = document.querySelector("[data-empty-search-state]");
  const listingGrid = document.querySelector("[data-listing-grid]");

  if (!searchInput || !cards.length) return;

  const appendOptions = function (selectElement, values) {
    if (!selectElement) return;

    values.forEach(function (value) {
      const option = document.createElement("option");
      option.value = value;
      option.textContent = value;
      selectElement.appendChild(option);
    });
  };

  const uniqueLocations = Array.from(
    new Set(
      cards
        .map(function (card) {
          return (card.dataset.itemLocation || "").trim();
        })
        .filter(Boolean),
    ),
  ).sort();

  const categoryValues = [];
  cards.forEach(function (card) {
    (card.dataset.itemCategories || "")
      .split("|")
      .map(function (category) {
        return category.trim().replace(/^"+|"+$/g, "");
      })
      .filter(Boolean)
      .forEach(function (category) {
        categoryValues.push(category);
      });
  });

  const uniqueCategories = Array.from(new Set(categoryValues)).sort();

  appendOptions(locationFilter, uniqueLocations);
  appendOptions(categoryFilter, uniqueCategories);

  const updateResults = function () {
    const query = searchInput.value.trim().toLowerCase();
    const statusValue = statusFilter ? statusFilter.value : "";
    const locationValue = locationFilter ? locationFilter.value : "";
    const categoryValue = categoryFilter ? categoryFilter.value : "";
    let visibleCount = 0;

    cards.forEach(function (card) {
      const titleElement = card.querySelector(".item-card-title");
      const title = titleElement ? titleElement.textContent.toLowerCase() : "";
      const statusOrType = config.isRecovered
        ? (card.dataset.itemType || "").trim()
        : (card.dataset.itemStatus || "").trim();

      const location = (card.dataset.itemLocation || "").trim();
      const categories = (card.dataset.itemCategories || "")
        .split("|")
        .map(function (category) {
          return category.trim();
        })
        .filter(Boolean);

      const matchesSearch = query === "" || title.includes(query);
      const matchesStatusOrType =
        statusValue === "" || statusOrType === statusValue;
      const matchesLocation =
        locationValue === "" || location === locationValue;
      const matchesCategory =
        categoryValue === "" || categories.includes(categoryValue);
      const isMatch =
        matchesSearch &&
        matchesStatusOrType &&
        matchesLocation &&
        matchesCategory;

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
  if (statusFilter) statusFilter.addEventListener("change", updateResults);
  if (locationFilter) locationFilter.addEventListener("change", updateResults);
  if (categoryFilter) categoryFilter.addEventListener("change", updateResults);

  if (filterToggle && filterPanel) {
    filterToggle.addEventListener("click", function () {
      filterPanel.classList.toggle("hidden");
    });
  }

  updateResults();
}

document.addEventListener("DOMContentLoaded", function () {
  const isRecoveredPage = !!document.getElementById("recovered-search");

  if (isRecoveredPage) {
    setupListingFilters({
      searchInputId: "recovered-search",
      statusFilterId: "recovered-type-filter", // map 'type' filter to 'status' logic
      locationFilterId: "recovered-location-filter",
      categoryFilterId: "recovered-category-filter",
      isRecovered: true,
    });
  } else if (document.getElementById("lost-search")) {
    setupListingFilters({
      searchInputId: "lost-search",
      statusFilterId: "lost-status-filter",
      locationFilterId: "lost-location-filter",
      categoryFilterId: "lost-category-filter",
    });
  } else if (document.getElementById("found-search")) {
    setupListingFilters({
      searchInputId: "found-search",
      statusFilterId: "found-status-filter",
      locationFilterId: "found-location-filter",
      categoryFilterId: "found-category-filter",
    });
  }
});
