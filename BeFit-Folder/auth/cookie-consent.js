document.addEventListener('DOMContentLoaded', function() {
  const cookieBanner = document.getElementById('cookie-consent');
  
  // ALWAYS show banner (remove cookie check)
  cookieBanner.style.display = 'flex';

  // Accept handler
  document.getElementById('accept-cookies').addEventListener('click', () => {
    document.cookie = "cookie_consent=accepted; path=/; max-age=31536000"; // 1 year
    cookieBanner.style.display = 'none';
    location.reload();
  });

  // Decline handler
  document.getElementById('decline-cookies').addEventListener('click', () => {
    document.cookie = "cookie_consent=declined; path=/; max-age=2592000"; // 30 days
    cookieBanner.style.display = 'none';
    location.reload();
  });
});
