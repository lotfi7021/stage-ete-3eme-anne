/* ==========================================================================
   SelectCars — Bascule de thème Red Motorsport (clair / sombre)
   Vanilla JS (sans dépendance). Utilisable front et back.
   La source de vérité est l'attribut html[data-theme="dark"|"light"].
   Sur le back, on maintient aussi le miroir body.dark-mode (AdminLTE natif).
   ========================================================================== */
(function () {
  'use strict';

  var STORAGE_KEY = 'rm-theme';
  var root = document.documentElement;

  function stored() {
    try { return localStorage.getItem(STORAGE_KEY); } catch (e) { return null; }
  }

  function current() {
    return root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  }

  function syncIcons() {
    var dark = current() === 'dark';
    var icons = document.querySelectorAll('.rm-theme-toggle i');
    for (var i = 0; i < icons.length; i++) {
      icons[i].classList.toggle('fa-moon', !dark);
      icons[i].classList.toggle('fa-sun', dark);
    }
  }

  function apply(theme, persist) {
    root.setAttribute('data-theme', theme);
    if (document.body) {
      document.body.classList.toggle('dark-mode', theme === 'dark');
    }
    if (persist) {
      try { localStorage.setItem(STORAGE_KEY, theme); } catch (e) {}
    }
    syncIcons();
    document.dispatchEvent(new CustomEvent('rm:themechange', { detail: { theme: theme } }));
  }

  // Listener DÉLÉGUÉ : indispensable car le bouton du front est cloné
  // dans le menu mobile par script.js (donc hors de portée d'un bind direct).
  document.addEventListener('click', function (e) {
    var trigger = e.target && e.target.closest ? e.target.closest('.rm-theme-toggle') : null;
    if (!trigger) { return; }
    e.preventDefault();
    apply(current() === 'dark' ? 'light' : 'dark', true);
  });

  // Suit le thème système tant que l'utilisateur n'a pas fait de choix explicite.
  try {
    var mq = window.matchMedia('(prefers-color-scheme: dark)');
    var onChange = function (e) {
      if (!stored()) { apply(e.matches ? 'dark' : 'light', false); }
    };
    if (mq.addEventListener) { mq.addEventListener('change', onChange); }
    else if (mq.addListener) { mq.addListener(onChange); }
  } catch (e) {}

  if (document.readyState !== 'loading') { syncIcons(); }
  else { document.addEventListener('DOMContentLoaded', syncIcons); }
})();
