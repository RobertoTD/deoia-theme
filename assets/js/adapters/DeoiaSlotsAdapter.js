/**
 * DeoiaSlotsAdapter - Adaptador premium de slots para WPAgenda
 *
 * Renderiza lista de horarios disponibles con estilos Tailwind premium,
 * idénticos al prototipo del hero.
 *
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
    let currentSlots = [];

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
     */
    function handleSlotClick(e) {
      const btn = e.target.closest("button[data-slot-index]");
      if (!btn) return;

      // Evitar propagación que pueda disparar submit
      e.preventDefault();
      e.stopPropagation();

      const index = parseInt(btn.dataset.slotIndex, 10);
      if (isNaN(index) || !currentSlots[index]) return;

      selectedSlot = currentSlots[index];

      // Re-renderizar para actualizar estilos
      renderSlots(currentSlots);

      // Habilitar botón de confirmación visualmente si está disponible el adaptador de calendario
      if (global.deoiaCalendarAdapter) {
        // Buscar instancia del calendario para habilitar el botón visualmente
        const wrapper = document.querySelector('[data-deoia-premium="true"]');
        if (wrapper) {
          const bookBtn = wrapper.querySelector('[data-role="deoia-book-btn"]');
          if (bookBtn) {
            // Solo cambiar estilos visuales, no disabled (para permitir validaciones)
            bookBtn.classList.remove("opacity-50");
            bookBtn.setAttribute("data-ready", "true");
          }
        }
      }

      if (onSelectCallback && typeof onSelectCallback === "function") {
        onSelectCallback(selectedSlot);
      }
    }

    /**
     * Renderiza el HTML de los slots con estilos premium Tailwind.
     * Usa clases idénticas al prototipo del hero.
     * @param {Date[]} slots
     */
    function renderSlots(slots) {
      if (!container) return;

      currentSlots = slots || [];

      if (!slots || slots.length === 0) {
        container.innerHTML = `
          <p class="text-slate-400 text-sm text-center py-4">
            No hay horarios disponibles
          </p>
        `;
        return;
      }

      // Grid idéntico al prototipo: grid grid-cols-3 gap-2
      let html =
        '<div class="grid grid-cols-3 gap-2" data-role="deoia-slots-grid">';

      slots.forEach((slot, index) => {
        const isSelected = isSameSlot(slot, selectedSlot);

        // Clases exactas del prototipo
        let classes;
        let inlineStyle = "";
        if (isSelected) {
          // Slot seleccionado - usando CSS variables
          classes =
            "py-2 px-3 rounded-xl text-sm font-medium transition-all duration-200 text-white shadow-lg cursor-pointer deoia-slot-selected";
          inlineStyle =
            'style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);"';
        } else {
          // Slot normal - clases del prototipo
          classes =
            "py-2 px-3 rounded-xl text-sm font-medium transition-all duration-200 bg-slate-800/80 text-slate-300 hover:bg-slate-700 border border-slate-700/50 cursor-pointer";
        }

        // IMPORTANTE: type="button" para evitar submit del formulario
        html += `
          <button type="button" class="${classes}" ${inlineStyle} data-slot-index="${index}">
            ${formatTime(slot)}
          </button>
        `;
      });

      html += "</div>";
      container.innerHTML = html;

      // Agregar event listener al grid
      const grid = container.querySelector('[data-role="deoia-slots-grid"]');
      grid?.addEventListener("click", handleSlotClick);
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
        currentSlots = [];

        // Resetear estilos visuales del botón de confirmación (sin usar disabled)
        const wrapper = document.querySelector('[data-deoia-premium="true"]');
        if (wrapper) {
          const bookBtn = wrapper.querySelector('[data-role="deoia-book-btn"]');
          if (bookBtn) {
            bookBtn.classList.add("opacity-50");
            bookBtn.setAttribute("data-ready", "false");
          }
        }
      },
    };
  }

  // =========================================================================
  // Exportar globalmente
  // =========================================================================

  global.deoiaSlotsAdapter = { create };

  console.log("✅ DeoiaSlotsAdapter.js cargado (versión premium)");
})(window);
