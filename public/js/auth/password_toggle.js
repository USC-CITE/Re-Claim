/**
 * Password Visibility Toggle
 * Injected automatically into any input[type="password"] that's wrapped in a .relative container.
 */
const initPasswordToggle = () => {
  // Select all password inputs that need a toggle
  const passwordInputs = document.querySelectorAll('input[type="password"]');

  passwordInputs.forEach((passwordInput, index) => {
    const container = passwordInput.parentElement;
    if (!container || !container.classList.contains("relative")) return;

    // Avoid duplicate injection
    const existingToggle = container.querySelector(".password-toggle-btn");
    if (existingToggle) return;

    const toggleButton = document.createElement("button");
    toggleButton.type = "button";
    toggleButton.className =
      "password-toggle-btn absolute right-0 inset-y-0 pr-3.5 flex items-center cursor-pointer z-10 outline-none border-none focus:shadow-none";
    toggleButton.setAttribute("aria-label", "Show password");
    toggleButton.setAttribute("aria-pressed", "false");
    toggleButton.tabIndex = -1;

    toggleButton.id = `toggle_password_${index}`;

    // SVG Icons
    toggleButton.innerHTML = `
            <svg class="eye-open-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg class="eye-closed-icon hidden" xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
                <path d="M11.0374 5.73793L9.49432 3.62063M6.3614 6.67313V4.49099M1.68539 5.73793L3.22473 3.62562M0.750183 0.750183C2.99467 5.73793 9.72812 5.73793 11.9726 0.750183" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        `;

    const openIcon = toggleButton.querySelector(".eye-open-icon");
    const closedIcon = toggleButton.querySelector(".eye-closed-icon");

    toggleButton.addEventListener("click", () => {
      const wasPassword = passwordInput.type === "password";
      passwordInput.type = wasPassword ? "text" : "password";

      openIcon.classList.toggle("hidden", wasPassword);
      closedIcon.classList.toggle("hidden", !wasPassword);

      toggleButton.setAttribute("aria-pressed", wasPassword ? "true" : "false");
      toggleButton.setAttribute(
        wasPassword ? "Hide password" : "Show password",
      );
    });

    container.appendChild(toggleButton);
  });
};

document.addEventListener("DOMContentLoaded", initPasswordToggle);
