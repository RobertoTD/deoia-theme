/**
 * DEOIA Theme - UX: navbar flotante + smooth scroll al widget de reservas.
 * No depende del plugin (aa-wpagenda-kernel).
 */
if (typeof console !== 'undefined' && console.log) {
  console.log('[Deoia theme-ux] archivo cargado');
}
function deoiaThemeUxInit() {
  const navbar = document.getElementById('deoia-navbar');
  if (!navbar) return;

  const containerReservar = document.getElementById('reservar');
  const navbarCta = document.getElementById('deoia-navbar-cta');

  // Scroll suave al widget cuando se hace clic en "Agendar Cita" (widget se resuelve al hacer clic)
  if (navbarCta) {
    navbarCta.addEventListener('click', function (e) {
      e.preventDefault();
      const widget =
        document.querySelector('.deoia-premium-widget') || document.getElementById('reservar');
      if (!widget) return;
      const widgetRect = widget.getBoundingClientRect();
      const windowHeight = window.innerHeight;
      const widgetHeight = widget.offsetHeight;
      const scrollTarget = window.scrollY + widgetRect.top - windowHeight / 2 + widgetHeight / 2;
      window.scrollTo({
        top: Math.max(0, scrollTarget),
        behavior: 'smooth'
      });
    });
  }

  function initDetector(bookBtn) {
    const sentinel = document.createElement('div');
    sentinel.id = 'deoia-navbar-sentinel';
    sentinel.style.height = '1px';
    bookBtn.parentNode.insertBefore(sentinel, bookBtn);

    let lastZonaCruce = null;

    const observer = new IntersectionObserver(
      function (entries) {
        const entry = entries[0];
        const isIntersecting = entry.isIntersecting;
        const zonaCruce = isIntersecting ? 'arriba' : 'abajo';

        if (lastZonaCruce !== zonaCruce) {
          lastZonaCruce = zonaCruce;
          if (typeof console !== 'undefined' && console.log) {
            if (zonaCruce === 'abajo') {
              console.log('[Deoia theme-ux] estamos Abajo');
            } else {
              console.log('[Deoia theme-ux] por arriba');
            }
          }
          if (zonaCruce === 'abajo') {
            navbar.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
            navbar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
          } else {
            navbar.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
            navbar.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
          }
        }
      },
      { threshold: 0, root: null }
    );
    observer.observe(sentinel);
  }

  function waitForTrigger() {
    if (!containerReservar) return;

    const bookBtn = containerReservar.querySelector('[data-role="deoia-book-btn"]');
    if (bookBtn) {
      initDetector(bookBtn);
      return;
    }

    const mo = new MutationObserver(function () {
      const btn = containerReservar.querySelector('[data-role="deoia-book-btn"]');
      if (btn) {
        mo.disconnect();
        initDetector(btn);
      }
    });
    mo.observe(containerReservar, { childList: true, subtree: true });
  }

  waitForTrigger();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', deoiaThemeUxInit);
} else {
  deoiaThemeUxInit();
}
