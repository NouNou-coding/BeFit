// Cookie functions (keep these)
function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
  document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

function getCookie(name) {
  const cookies = document.cookie.split(';');
  for (let cookie of cookies) {
    const [cookieName, cookieValue] = cookie.trim().split('=');
    if (cookieName === name) return cookieValue;
  }
  return null;
}

// Initialize when DOM loads
document.addEventListener('DOMContentLoaded', function() {
  const cookieBanner = document.getElementById('cookie-consent');
  
  // Only show banner if no consent decision exists
  if (!getCookie('cookie_consent')) {
    cookieBanner.style.display = 'flex';
  }

  // Accept handler
  document.getElementById('accept-cookies').addEventListener('click', () => {
    setCookie('cookie_consent', 'accepted', 365);
    cookieBanner.style.display = 'none';
    window.location.reload(); // Refresh to apply analytics
  });

  // Decline handler
  document.getElementById('decline-cookies').addEventListener('click', () => {
    setCookie('cookie_consent', 'declined', 30);
    cookieBanner.style.display = 'none';
    window.location.reload(); // Refresh to remove analytics
  });
});
