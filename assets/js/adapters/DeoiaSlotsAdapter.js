/**
 * DeoiaSlotsAdapter - Adaptador premium de slots para WPAgenda
 *
 * Renderiza lista de horarios disponibles con estilos Tailwind premium.
 * Compatible con WPAgenda.registerSlotsAdapter().
 */

(function (global) {
  "use strict";

  /**
   * Crea una instancia del adaptador de slots premium.
   * @returns {Object} Adaptador con métodos render, getSelectedSlot, clear.
   */
  function create() {
    let container = null;
    let selectedSlot = null;
    let onSelectCallback = null;

    /**
     * Formatea un Date a string HH:MM.
     * @param {Date} date
     * @returns {string}
     */
    function formatTime(date) {
      const h = String(date.getHours()).padStart(2, "0");
      const m = String(date.getMinutes()).padStart(2, "0");
      return `${h}:${m}`;
    }

    /**
     * Compara dos fechas por valor de tiempo.
     * @param {Date} a
     * @param {Date} b
     * @returns {boolean}
     */
    function isSameSlot(a, b) {
      if (!a || !b) return false;
      return a.getTime() === b.getTime();
    }

    /**
     * Maneja el click en un slot.
     * @param {Event} e
     * @param {Date[]} slots
     */
    function handleSlotClick(e, slots) {
      const btn = e.target.closest("button[data-slot-index]");
      if (!btn) return;

      const index = parseInt(btn.dataset.slotIndex, 10);
      if (isNaN(index) || !slots[index]) return;

      selectedSlot = slots[index];

      // Re-renderizar para actualizar estilos
      renderSlots(slots);

      if (onSelectCallback && typeof onSelectCallback === "function") {
        onSelectCallback(selectedSlot);
      }
    }

    /**
     * Renderiza el HTML de los slots con estilos premium Tailwind.
     * @param {Date[]} slots
     */
    function renderSlots(slots) {
      if (!container) return;

      if (!slots || slots.length === 0) {
        container.innerHTML = `
                    <p class="text-slate-400 text-sm text-center py-4">
                        No hay horarios disponibles
                    </p>
                `;
        return;
      }

      let html =
        '<div class="grid grid-cols-3 gap-2" data-role="deoia-slots-grid">';

      slots.forEach((slot, index) => {
        const isSelected = isSameSlot(slot, selectedSlot);

        const baseClasses = `
                    py-2 px-3 rounded-xl text-sm font-medium 
                    transition-all duration-200 cursor-pointer
                `;

        const selectedClasses = `
                    bg-gradient-to-r from-violet-600 to-indigo-600 
                    text-white shadow-lg shadow-violet-500/30
                `;

        const normalClasses = `
                    bg-slate-800/80 text-slate-300 
                    hover:bg-slate-700 border border-slate-700/50
                `;

        const classes = isSelected
          ? `${baseClasses} ${selectedClasses}`
          : `${baseClasses} ${normalClasses}`;

        html += `
                    <button class="${classes
                      .replace(/\s+/g, " ")
                      .trim()}" data-slot-index="${index}">
                        ${formatTime(slot)}
                    </button>
                `;
      });

      html += "</div>";
      container.innerHTML = html;

      // Agregar event listener al grid
      const grid = container.querySelector('[data-role="deoia-slots-grid"]');
      grid?.addEventListener("click", (e) => handleSlotClick(e, slots));
    }

    // =====================================================================
    // API Pública del Adaptador
    // =====================================================================

    return {
      /**
       * Renderiza los slots en el contenedor especificado.
       * @param {string|HTMLElement} containerId - Selector o elemento contenedor.
       * @param {Date[]} validSlots - Array de fechas con horarios válidos.
       * @param {Function} onSelectSlot - Callback al seleccionar un slot.
       */
      render(containerId, validSlots, onSelectSlot) {
        container =
          containerId instanceof HTMLElement
            ? containerId
            : document.querySelector(containerId);

        if (!container) {
          console.error("[DeoiaSlotsAdapter] Contenedor no encontrado");
          return;
        }

        onSelectCallback = onSelectSlot;
        selectedSlot = null;
        renderSlots(validSlots);
      },

      /**
       * Obtiene el slot seleccionado actualmente.
       * @returns {Date|null}
       */
      getSelectedSlot() {
        return selectedSlot;
      },

      /**
       * Limpia el contenedor y reinicia el estado.
       */
      clear() {
        if (container) {
          container.innerHTML = "";
        }
        selectedSlot = null;
        onSelectCallback = null;
      },
    };
  }

  // =========================================================================
  // Exportar globalmente
  // =========================================================================

  global.deoiaSlotsAdapter = { create };

  console.log("✅ DeoiaSlotsAdapter.js cargado");
})(window);
