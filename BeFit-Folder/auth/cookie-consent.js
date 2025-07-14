document.addEventListener('DOMContentLoaded', function() {
  const cookieBanner = document.getElementById('cookie-consent');
  
  // Check if cookie decision already exists
  if (!document.cookie.split(';').some(item => item.trim().startsWith('cookie_consent='))) {
    cookieBanner.style.display = 'flex';
  }

  // Accept handler
  document.getElementById('accept-cookies').addEventListener('click', (e) => {
    e.preventDefault();
    document.cookie = "cookie_consent=accepted; path=/BeFit-Folder/; max-age=31536000; SameSite=Lax";
    cookieBanner.style.display = 'none';
    location.reload();
  });

  // Decline handler
  document.getElementById('decline-cookies').addEventListener('click', (e) => {
    e.preventDefault();
    document.cookie = "cookie_consent=declined; path=/BeFit-Folder/; max-age=2592000; SameSite=Lax";
    cookieBanner.style.display = 'none';
    location.reload();
  });
});
