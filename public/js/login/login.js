const passwordInput = document.getElementById("password");
const togglePasswordButton = document.getElementById("toggle_password");
const eyeOpenIcon = document.getElementById("eye_open_icon");
const eyeClosedIcon = document.getElementById("eye_closed_icon");

if (passwordInput && togglePasswordButton && eyeOpenIcon && eyeClosedIcon) {
  passwordInput.type = "password";
  eyeOpenIcon.classList.remove("hidden");
  eyeClosedIcon.classList.add("hidden");

  togglePasswordButton.addEventListener("click", function () {
    const isHidden = passwordInput.type === "password";
    passwordInput.type = isHidden ? "text" : "password";

    eyeOpenIcon.classList.toggle("hidden", isHidden);
    eyeClosedIcon.classList.toggle("hidden", !isHidden);

    togglePasswordButton.setAttribute("aria-pressed", String(isHidden));
    togglePasswordButton.setAttribute(
      "aria-label",
      isHidden ? "Hide password" : "Show password",
    );
  });
}
