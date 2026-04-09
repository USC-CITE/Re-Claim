document.addEventListener("DOMContentLoaded", function () {
  var consentKey = "reclaim_cookie_consent";
  var consentVersion = 1;
  var consentExpiryDays = 180;
  var banner = document.getElementById("cookie-consent-banner");

  if (!banner) {
    return;
  }

  function safeGetStorage(key) {
    try {
      return localStorage.getItem(key);
    } catch (error) {
      return null;
    }
  }

  function safeSetStorage(key, value) {
    try {
      localStorage.setItem(key, value);
    } catch (error) {
      // localStorage may be blocked in private mode or strict browsers.
    }
  }

  function readCookie(name) {
    var prefix = name + "=";
    var entries = document.cookie ? document.cookie.split(";") : [];

    for (var index = 0; index < entries.length; index += 1) {
      var cookie = entries[index].trim();
      if (cookie.indexOf(prefix) === 0) {
        return decodeURIComponent(cookie.slice(prefix.length));
      }
    }

    return null;
  }

  function writeCookie(name, value, days) {
    var maxAge = days * 24 * 60 * 60;
    var secureFlag = window.location.protocol === "https:" ? "; Secure" : "";
    document.cookie = name + "=" + encodeURIComponent(value) + "; Max-Age=" + maxAge + "; Path=/; SameSite=Lax" + secureFlag;
  }

  function parseConsent(rawValue) {
    if (!rawValue) {
      return null;
    }

    try {
      var parsed = JSON.parse(rawValue);
      var validStatus = parsed.status === "accepted" || parsed.status === "rejected";
      var validVersion = parsed.version === consentVersion;
      var notExpired = typeof parsed.expiresAt === "number" && Date.now() < parsed.expiresAt;

      if (validStatus && validVersion && notExpired) {
        return parsed;
      }
    } catch (error) {
      return null;
    }

    return null;
  }

  function hideBanner() {
    banner.classList.add("hidden");
    banner.setAttribute("aria-hidden", "true");
  }

  function persistConsent(status) {
    var expiresAt = Date.now() + consentExpiryDays * 24 * 60 * 60 * 1000;
    var record = JSON.stringify({
      status: status,
      version: consentVersion,
      createdAt: Date.now(),
      expiresAt: expiresAt
    });

    safeSetStorage(consentKey, record);
    writeCookie(consentKey, record, consentExpiryDays);
  }

  var storedRecord = parseConsent(safeGetStorage(consentKey));
  if (!storedRecord) {
    storedRecord = parseConsent(readCookie(consentKey));
  }

  if (storedRecord) {
    hideBanner();
    return;
  }

  function setConsent(choice) {
    if (choice !== "accepted" && choice !== "rejected") {
      return;
    }

    persistConsent(choice);
    hideBanner();
  }

  banner.addEventListener("click", function (event) {
    var target = event.target.closest("[data-consent-action]");
    if (!target) {
      return;
    }

    var choice = target.getAttribute("data-consent-action");
    if (choice === "accepted" || choice === "rejected") {
      setConsent(choice);
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && !banner.classList.contains("hidden")) {
      setConsent("rejected");
    }
  });
});
