/**
 * DEOIA Theme - UX: navbar con microcopy narrador + smooth scroll.
 * Navbar siempre visible, mensajes dinámicos según zona de scroll.
 */
if (typeof console !== 'undefined' && console.log) {
  console.log('[Deoia theme-ux] archivo cargado');
}

function deoiaThemeUxInit() {
  const navbar = document.getElementById('deoia-navbar');
  if (!navbar) return;

  const containerReservar = document.getElementById('reservar');
  const navbarCta = document.getElementById('deoia-navbar-cta');
  const navbarMessage = document.getElementById('deoia-navbar-message');
  const navbarMessageSpan = navbarMessage ? navbarMessage.querySelector('span') : null;

  // Mensajes para cada zona (bajando y subiendo)
  const messages = {
    down: ['No pierdas citas.', 'Agenda automática 24/7.', 'Deja de estar pegado al WhatsApp.'],
    up: [
      'Confirmaciones y recordatorios automáticos.',
      'Control simple desde un panel.',
      'Obtén un sitio como este.'
    ]
  };

  // Estado inicial -1 para forzar render en primera detección
  let currentZone = -1;
  let lastScrollY = window.scrollY;
  let isScrollingDown = true;

  // =========================================================================
  // Funciones de UI
  // =========================================================================

  function setMessage(text) {
    if (!navbarMessageSpan) return;

    // Fade out
    navbarMessageSpan.classList.add('opacity-0', 'translate-y-1');
    navbarMessageSpan.classList.remove('opacity-100', 'translate-y-0');

    setTimeout(function () {
      navbarMessageSpan.textContent = text;
      // Fade in
      navbarMessageSpan.classList.remove('opacity-0', 'translate-y-1');
      navbarMessageSpan.classList.add('opacity-100', 'translate-y-0');
    }, 150);
  }

  function showCta() {
    if (!navbarCta || !navbarMessage) return;
    // Ocultar mensaje, mostrar CTA
    navbarMessage.classList.add('hidden');
    navbarCta.classList.remove('hidden');
  }

  function hideCta() {
    if (!navbarCta || !navbarMessage) return;
    // Ocultar CTA, mostrar mensaje
    navbarCta.classList.add('hidden');
    navbarMessage.classList.remove('hidden');
  }

  // =========================================================================
  // Lógica de Zonas
  // =========================================================================

  function updateNavbarState(newZone) {
    if (newZone === currentZone) return;

    currentZone = newZone;

    console.log('[Deoia theme-ux] Zona:', newZone, isScrollingDown ? '↓' : '↑');

    // Zona 0: inicio de página
    if (newZone === 0) {
      hideCta();
      setMessage(messages.down[0]); // Mensaje inicial
      return;
    }

    // Zona 1: pasó el widget
    if (newZone === 1) {
      hideCta();
      setMessage(isScrollingDown ? messages.down[0] : messages.up[2]);
      return;
    }

    // Zona 2: pasó sección servicios
    if (newZone === 2) {
      hideCta();
      setMessage(isScrollingDown ? messages.down[1] : messages.up[1]);
      return;
    }

    // Zona 3: llegó al footer - mostrar CTA
    if (newZone === 3) {
      setMessage(isScrollingDown ? messages.down[2] : messages.up[0]);
      // Pequeño delay para que se vea la transición del mensaje antes del CTA
      setTimeout(function () {
        if (currentZone === 3) {
          showCta();
        }
      }, 200);
    }
  }

  // =========================================================================
  // Scroll suave al widget (CTA)
  // =========================================================================

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

  // =========================================================================
  // Detectores de Cruce (IntersectionObserver)
  // =========================================================================

  function initDetectors(bookBtn) {
    const sentinels = [];
    const sentinelStates = [];

    // Sentinel 1: Botón Reservar
    const sentinel1 = document.createElement('div');
    sentinel1.id = 'deoia-sentinel-widget';
    sentinel1.style.cssText =
      'height:1px;position:absolute;top:0;left:0;right:0;pointer-events:none;';
    bookBtn.parentNode.insertBefore(sentinel1, bookBtn);
    sentinels.push({ el: sentinel1, zoneWhenAbove: 1 });
    sentinelStates.push(false);

    // Sentinel 2: Sección Servicios (#para-quien)
    const seccionServicios = document.getElementById('para-quien');
    if (seccionServicios) {
      const sentinel2 = document.createElement('div');
      sentinel2.id = 'deoia-sentinel-servicios';
      sentinel2.style.cssText =
        'height:1px;position:absolute;top:0;left:0;right:0;pointer-events:none;';
      seccionServicios.style.position = 'relative';
      seccionServicios.insertBefore(sentinel2, seccionServicios.firstChild);
      sentinels.push({ el: sentinel2, zoneWhenAbove: 2 });
      sentinelStates.push(false);
    }

    // Sentinel 3: Footer (usa isIntersecting para detectar cuando llega)
    const footer = document.querySelector('footer');
    let footerIndex = -1;
    if (footer) {
      const sentinel3 = document.createElement('div');
      sentinel3.id = 'deoia-sentinel-footer';
      sentinel3.style.cssText =
        'height:1px;position:absolute;top:0;left:0;right:0;pointer-events:none;';
      footer.style.position = 'relative';
      footer.insertBefore(sentinel3, footer.firstChild);
      footerIndex = sentinels.length;
      sentinels.push({ el: sentinel3, zoneWhenAbove: 3, useIntersecting: true });
      sentinelStates.push(false);
    }

    // Calcular zona basada en estados
    function calculateZone() {
      let zone = 0;
      for (let i = sentinels.length - 1; i >= 0; i--) {
        if (sentinelStates[i]) {
          zone = sentinels[i].zoneWhenAbove;
          break;
        }
      }
      return zone;
    }

    // Crear observers
    sentinels.forEach(function (sentinelObj, index) {
      const observer = new IntersectionObserver(
        function (entries) {
          const entry = entries[0];

          // Para el footer: usar isIntersecting (llega a la vista)
          // Para los demás: usar boundingClientRect.bottom <= 0 (pasó arriba)
          if (sentinelObj.useIntersecting) {
            sentinelStates[index] = entry.isIntersecting;
          } else {
            sentinelStates[index] = entry.boundingClientRect.bottom <= 0;
          }

          const zone = calculateZone();
          updateNavbarState(zone);
        },
        { threshold: 0, root: null }
      );
      observer.observe(sentinelObj.el);
    });

    // Detectar dirección de scroll
    window.addEventListener(
      'scroll',
      function () {
        const currentScrollY = window.scrollY;
        isScrollingDown = currentScrollY > lastScrollY;
        lastScrollY = currentScrollY;
      },
      { passive: true }
    );

    // Forzar estado inicial
    updateNavbarState(0);

    console.log('[Deoia theme-ux] Detectores inicializados:', sentinels.length, 'sentinels');
  }

  // =========================================================================
  // Esperar a que el botón del plugin se renderice
  // =========================================================================

  function waitForTrigger() {
    if (!containerReservar) {
      console.log('[Deoia theme-ux] No se encontró #reservar');
      // Forzar mensaje inicial aunque no haya widget
      updateNavbarState(0);
      return;
    }

    const bookBtn = containerReservar.querySelector('[data-role="deoia-book-btn"]');
    if (bookBtn) {
      initDetectors(bookBtn);
      return;
    }

    // Forzar mensaje inicial mientras esperamos
    updateNavbarState(0);

    // Esperar a que el plugin inyecte el botón
    const mo = new MutationObserver(function () {
      const btn = containerReservar.querySelector('[data-role="deoia-book-btn"]');
      if (btn) {
        mo.disconnect();
        initDetectors(btn);
      }
    });
    mo.observe(containerReservar, { childList: true, subtree: true });
  }

  waitForTrigger();
}

// Inicializar
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', deoiaThemeUxInit);
} else {
  deoiaThemeUxInit();
}
