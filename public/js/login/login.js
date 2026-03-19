const initPasswordToggle = () => {
  const passwordInput = document.getElementById("password");

  if (passwordInput) {
    const container = passwordInput.parentElement;

    if (container && container.classList.contains("relative")) {
      // Avoid duplicate injection
      if (document.getElementById("toggle_password")) return;

      // Create button
      const toggleButton = document.createElement("button");
      toggleButton.type = "button";
      toggleButton.id = "toggle_password";

      toggleButton.className =
        "absolute right-0 inset-y-0 pr-3.5 flex items-center cursor-pointer z-10 outline-none border-none focus:shadow-none";
      toggleButton.style.zIndex = "10";
      toggleButton.setAttribute("aria-label", "Show password");
      toggleButton.setAttribute("aria-pressed", "false");

      // Insert the SVGs into the button with currentColor
      toggleButton.innerHTML = `
        <svg id="eye_open_icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <svg id="eye_closed_icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
          <path d="M11.0374 5.73793L9.49432 3.62063M6.3614 6.67313V4.49099M1.68539 5.73793L3.22473 3.62562M0.750183 0.750183C2.99467 5.73793 9.72812 5.73793 11.9726 0.750183" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      `;

      // Append button to container
      container.appendChild(toggleButton);

      const eyeOpenIcon = document.getElementById("eye_open_icon");
      const eyeClosedIcon = document.getElementById("eye_closed_icon");

      toggleButton.addEventListener("click", function () {
        const isHidden = passwordInput.type === "password";
        passwordInput.type = isHidden ? "text" : "password";

        eyeOpenIcon.classList.toggle("hidden", isHidden);
        eyeClosedIcon.classList.toggle("hidden", !isHidden);

        toggleButton.setAttribute("aria-pressed", String(isHidden));
        toggleButton.setAttribute(
          "aria-label",
          isHidden ? "Hide password" : "Show password",
        );
      });
      console.log("Password toggle successfully initialized");
    }
  }
};

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initPasswordToggle);
} else {
  initPasswordToggle();
}
