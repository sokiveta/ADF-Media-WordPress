// Print button on left-side of cases and press releases
document.addEventListener('DOMContentLoaded', () => {
  const printButton = document.querySelector('.print-btn');
  if (printButton) {
    printButton.addEventListener('click', () => window.print());
  }
});

// Share button on left-side of cases and press releases
document.addEventListener('DOMContentLoaded', function () {
  const pageURL = window.location.href;
  const postTitle = document.title;

  // facebook
  const facebookButton = document.querySelector('.facebook-share-btn');
  if (facebookButton) {
    facebookButton.setAttribute(
      'href',
      `https://www.facebook.com/dialog/share?app_id=119697833097399&display=page&href=${encodeURIComponent(
        pageURL
      )}&redirect_uri=${encodeURIComponent(pageURL)}`
    );
  }

  // twitter
  const twitterButton = document.querySelector('.twitter-share-btn');
  if (twitterButton) {
    twitterButton.setAttribute(
      'href',
      `https://x.com/share?text=${encodeURIComponent(
        postTitle
      )}&url=${encodeURIComponent(pageURL)}`
    );
  }

  // linkedin
  const linkedinButton = document.querySelector('.linkedin-share-btn');
  if (linkedinButton) {
    linkedinButton.setAttribute(
      'href',
      `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(
        pageURL
      )}`
    );
  }

  // email
  const subject = `${postTitle}`;
  const body = `${pageURL}`;
  const emailButton = document.querySelector('.email-share-btn');
  if (emailButton) {
    emailButton.setAttribute(
      'href',
      `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(
        body
      )}`
    );
  }
});
