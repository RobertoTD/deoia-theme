/**
 * DEOIA Theme - UX: navbar flotante + smooth scroll al widget de reservas.
 * No depende del plugin (aa-wpagenda-kernel).
 */
document.addEventListener('DOMContentLoaded', function () {
  const navbar = document.getElementById('deoia-navbar');
  const navbarCta = document.getElementById('deoia-navbar-cta');
  const widget = document.querySelector('.deoia-premium-widget');
  const bookBtn = document.querySelector('[data-role="deoia-book-btn"]');

  if (!navbar || !widget) return;

  // Función para mostrar/ocultar navbar basado en scroll
  function handleScroll() {
    const triggerElement = bookBtn || widget;
    const triggerRect = triggerElement.getBoundingClientRect();

    // Mostrar navbar cuando el botón "Reservar" (o widget) sale de la vista por arriba
    if (triggerRect.bottom <= 0) {
      navbar.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
      navbar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
    } else {
      navbar.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
      navbar.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
    }
  }

  // Scroll suave al widget cuando se hace clic en "Agendar Cita"
  if (navbarCta) {
    navbarCta.addEventListener('click', function (e) {
      e.preventDefault();
      const widgetRect = widget.getBoundingClientRect();
      const windowHeight = window.innerHeight;
      const widgetHeight = widget.offsetHeight;

      // Calcular posición para centrar el widget en pantalla
      const scrollTarget = window.scrollY + widgetRect.top - windowHeight / 2 + widgetHeight / 2;

      window.scrollTo({
        top: Math.max(0, scrollTarget),
        behavior: 'smooth'
      });
    });
  }

  // Escuchar scroll
  window.addEventListener('scroll', handleScroll, { passive: true });

  // Ejecutar al cargar por si ya hay scroll
  handleScroll();
});
