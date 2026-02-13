document.addEventListener("DOMContentLoaded", function () {

    const otpData = document.getElementById("otp-data");
    if (!otpData) return;

    const expiresAt = otpData.dataset.expires
        ? parseInt(otpData.dataset.expires)
        : null;

    const timerEl = document.getElementById("timer");
    const resendBtn = document.getElementById("resend-btn");

    if (!timerEl || !resendBtn) return;

    function updateTimer() {
        if (!expiresAt) {
            return;
        }

        const now = Date.now();
        let diff = Math.floor((expiresAt - now) / 1000);

        if (diff <= 0) {
            timerEl.textContent = "OTP expired.";
            return;
        }   

        const mins = Math.floor(diff / 60);
        const secs = diff % 60;

        timerEl.textContent =
            `OTP expires in ${mins}:${secs.toString().padStart(2, '0')}`;
    }


    setInterval(updateTimer, 1000);
    updateTimer();
});
