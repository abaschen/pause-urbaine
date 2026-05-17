document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('[data-nav-toggle]');
  const nav = document.querySelector('[data-site-nav]');

  if (!toggle || !nav) {
    return;
  }

  const closeNav = () => {
    nav.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
  };

  toggle.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(isOpen));
  });

  nav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeNav);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeNav();
    }
  });

  const languageSwitcher = document.querySelector('[data-language-switcher]');
  const languageToggle = document.querySelector('[data-language-toggle]');
  const languageMenu = document.querySelector('[data-language-menu]');

  if (!languageSwitcher || !languageToggle || !languageMenu) {
    return;
  }

  const closeLanguageMenu = () => {
    languageSwitcher.classList.remove('is-open');
    languageToggle.setAttribute('aria-expanded', 'false');
  };

  languageToggle.addEventListener('click', (event) => {
    event.stopPropagation();
    const isOpen = languageSwitcher.classList.toggle('is-open');
    languageToggle.setAttribute('aria-expanded', String(isOpen));
  });

  document.addEventListener('click', (event) => {
    if (!languageSwitcher.contains(event.target)) {
      closeLanguageMenu();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeLanguageMenu();
    }
  });
});
