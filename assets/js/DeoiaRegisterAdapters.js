(function () {
  console.log("🔍 Intentando registrar adaptadores premium...");

  if (!window.WPAgenda) {
    console.warn(
      "⚠ WPAgenda todavía no está disponible. Reintentando en 50ms..."
    );
    setTimeout(arguments.callee, 50);
    return;
  }

  // Registrar adaptador premium de calendario
  if (window.deoiaCalendarAdapter) {
    WPAgenda.registerCalendarAdapter(window.deoiaCalendarAdapter.create());
    console.log("✔ Adaptador premium de calendario registrado");
  } else {
    console.warn("⚠ deoiaCalendarAdapter no está disponible");
  }

  // Registrar adaptador premium de slots
  if (window.deoiaSlotsAdapter) {
    WPAgenda.registerSlotsAdapter(window.deoiaSlotsAdapter.create());
    console.log("✔ Adaptador premium de slots registrado");
  } else {
    console.warn("⚠ deoiaSlotsAdapter no está disponible");
  }
})();
