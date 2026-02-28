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
  toggleButton.textContent = isActive ? "Cancel Archive Selection" : "Archive Lost Items";

  // Bulk checkboxes and submit button live outside the form, so they are toggled manually here.
  bulkBoxes.forEach(function (box) {
    box.style.display = isActive ? "block" : "none";
  });

  if (bulkSubmit) {
    bulkSubmit.style.display = isActive ? "block" : "none";
  }

  if (!isActive) {
    // Clear previous selections when archive mode is cancelled.
    bulkForm.querySelectorAll('input[name="item_ids[]"]').forEach(function (checkbox) {
      checkbox.checked = false;
    });
  }
}
