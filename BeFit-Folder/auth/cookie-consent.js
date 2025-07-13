// Cookie functions
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

// Show banner if no consent yet
if (!getCookie('cookie_consent')) {
  document.getElementById('cookie-consent').style.display = 'flex';
}

// Button handlers
document.getElementById('accept-cookies')?.addEventListener('click', () => {
  setCookie('cookie_consent', 'accepted', 365);
  document.getElementById('cookie-consent').style.display = 'none';
  // Enable analytics/ads cookies here if needed
});

document.getElementById('decline-cookies')?.addEventListener('click', () => {
  setCookie('cookie_consent', 'declined', 30);
  document.getElementById('cookie-consent').style.display = 'none';
  // Disable non-essential cookies
});
