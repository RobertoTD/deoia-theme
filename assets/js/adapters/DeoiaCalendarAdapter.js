/**
 * DeoiaCalendarAdapter - Adaptador premium de calendario para WPAgenda
 *
 * Genera un widget de calendario con estilos premium Tailwind,
 * incluyendo wrapper con glows decorativos, header del widget,
 * y estructura visual idéntica al prototipo del hero.
 *
 * Compatible con WPAgenda.registerCalendarAdapter().
 */

(function (global) {
  "use strict";

  function create() {
    let container = null;
    let originalContainer = null; // Referencia al contenedor original del plugin
    let wrapperEl = null; // Wrapper premium que envuelve todo
    let calendarInnerEl = null; // Contenedor interno del calendario
    let selectedDate = null;
    let viewDate = new Date();
    let config = {};
    let isWrapped = false;
    const { ymd } = global.DateUtils || {};

    // =========================================================================
    // Lógica de fechas deshabilitadas (equivalente al adaptador default)
    // =========================================================================

    function isDateDisabled(date) {
      if (config.minDate) {
        const minDateNorm = new Date(config.minDate);
        minDateNorm.setHours(0, 0, 0, 0);
        if (date < minDateNorm) return true;
      }
      if (config.maxDate) {
        const maxDateNorm = new Date(config.maxDate);
        maxDateNorm.setHours(23, 59, 59, 999);
        if (date > maxDateNorm) return true;
      }
      if (config.disableDateFn && typeof config.disableDateFn === "function") {
        return config.disableDateFn(date);
      }
      return false;
    }

    // =========================================================================
    // Generación del Wrapper Premium (tarjeta con glows)
    // =========================================================================

    function createPremiumWrapper() {
      // Si ya existe el wrapper, no crear otro
      if (wrapperEl) return;

      // Buscar el formulario padre del calendario (estructura del shortcode)
      const form = originalContainer.closest("form");
      if (!form) {
        console.warn("[DeoiaCalendarAdapter] No se encontró formulario padre");
        return;
      }

      // Buscar el slot container del plugin
      const pluginSlotContainer = form.querySelector("#slot-container");

      // Crear el wrapper premium
      wrapperEl = document.createElement("div");
      wrapperEl.className =
        "deoia-premium-widget bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 lg:p-8 shadow-2xl shadow-slate-900/30 border border-slate-700/50 relative overflow-hidden";
      wrapperEl.setAttribute("data-deoia-premium", "true");

      wrapperEl.innerHTML = `
        <!-- Decorative Glows -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <!-- Widget Content -->
        <div class="relative z-10" data-role="deoia-widget-content">
          <!-- Widget Header -->
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-indigo-500 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-white font-semibold">Reservar Cita</h3>
                <p class="text-slate-400 text-sm">Selecciona motivo, fecha y hora</p>
              </div>
            </div>
            <span class="text-xs bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full font-medium">En línea</span>
          </div>

          <!-- Service Select Placeholder (se moverá el select original aquí) -->
          <div data-role="deoia-service-placeholder" class="mb-4"></div>

          <!-- Calendar Container (se llenará dinámicamente) -->
          <div data-role="deoia-calendar-container"></div>

          <!-- Slots Wrapper -->
          <div data-role="deoia-slots-wrapper" class="mb-4">
            <div data-role="deoia-slot-title-placeholder"></div>
            <div data-role="deoia-slots-placeholder"></div>
          </div>

          <!-- Book Button Premium (siempre clickeable para mostrar validaciones) -->
          <button type="button" data-role="deoia-book-btn" class="w-full bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold py-4 rounded-2xl shadow-xl shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2" data-ready="false">
            Reservar
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
          </button>

          <!-- Widget Badge -->
          <p class="text-center text-slate-500 text-xs mt-4">
            Potenciado por <span class="text-violet-400 font-medium">Deoia</span>
          </p>
        </div>
      `;

      // Insertar el wrapper antes del calendario original
      originalContainer.parentNode.insertBefore(wrapperEl, originalContainer);

      // Obtener referencia al contenedor interno del calendario
      calendarInnerEl = wrapperEl.querySelector(
        '[data-role="deoia-calendar-container"]'
      );

      // Mover el select de servicio al wrapper premium y aplicar estilos
      const servicioSelect = form.querySelector("#servicio");
      const servicePlaceholder = wrapperEl.querySelector(
        '[data-role="deoia-service-placeholder"]'
      );
      if (servicioSelect && servicePlaceholder) {
        // Aplicar clases premium al select
        servicioSelect.className =
          "bg-slate-800/80 border border-slate-700/50 rounded-xl py-3 px-4 " +
          "text-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500/50 " +
          "transition-all duration-200 w-full appearance-none cursor-pointer " +
          "hover:border-slate-600 hover:bg-slate-800";

        // Crear wrapper para el select con icono de dropdown
        const selectWrapper = document.createElement("div");
        selectWrapper.className = "relative";
        selectWrapper.innerHTML = `
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        `;

        // Mover el select al wrapper con icono
        selectWrapper.insertBefore(servicioSelect, selectWrapper.firstChild);

        // Insertar en el placeholder
        servicePlaceholder.appendChild(selectWrapper);
      }

      // Mover el slot container del plugin al wrapper premium
      if (pluginSlotContainer) {
        const slotsPlaceholder = wrapperEl.querySelector(
          '[data-role="deoia-slots-placeholder"]'
        );
        if (slotsPlaceholder) {
          slotsPlaceholder.parentNode.replaceChild(
            pluginSlotContainer,
            slotsPlaceholder
          );
        }
      }

      // Ocultar el calendario original
      originalContainer.style.display = "none";

      // Mover el título de slots del plugin al wrapper premium y aplicar estilos
      const slotTitle = document.getElementById("aa-slot-title");
      const slotTitlePlaceholder = wrapperEl.querySelector(
        '[data-role="deoia-slot-title-placeholder"]'
      );
      if (slotTitle && slotTitlePlaceholder) {
        // Aplicar estilos premium al título
        slotTitle.className = "text-slate-400 text-sm mb-3";
        slotTitle.style.display = ""; // Asegurar que no esté oculto
        // Reemplazar el placeholder con el título real
        slotTitlePlaceholder.parentNode.replaceChild(
          slotTitle,
          slotTitlePlaceholder
        );
      }

      // Ocultar campos del formulario original (se usarán desde el modal premium)
      const fieldsToHide = [
        form.querySelector("#nombre"),
        form.querySelector("#telefono"),
        form.querySelector("#correo"),
        form.querySelector('button[type="submit"]'),
      ];
      fieldsToHide.forEach((field) => {
        if (field) field.style.display = "none";
      });

      // Conectar el botón premium al modal
      const bookBtn = wrapperEl.querySelector('[data-role="deoia-book-btn"]');
      if (bookBtn) {
        bookBtn.addEventListener("click", handleBookButtonClick);
      }

      isWrapped = true;
    }

    // =========================================================================
    // Manejo del Botón "Confirmar Reserva" -> Abre Modal Premium
    // =========================================================================

    /**
     * Muestra una advertencia temporal en el widget premium.
     * @param {string} message - Mensaje a mostrar
     */
    function showValidationWarning(message) {
      if (!wrapperEl) return;

      // Buscar o crear el contenedor de advertencias
      let warningEl = wrapperEl.querySelector('[data-role="deoia-warning"]');
      if (!warningEl) {
        warningEl = document.createElement("div");
        warningEl.setAttribute("data-role", "deoia-warning");
        warningEl.className =
          "bg-amber-500/20 border border-amber-500/50 text-amber-400 text-sm px-4 py-3 rounded-xl mb-4 flex items-center gap-2 transition-all duration-300";

        // Insertar antes del botón de confirmación
        const bookBtn = wrapperEl.querySelector('[data-role="deoia-book-btn"]');
        if (bookBtn && bookBtn.parentNode) {
          bookBtn.parentNode.insertBefore(warningEl, bookBtn);
        }
      }

      // Mostrar el mensaje con icono de advertencia
      warningEl.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span>${message}</span>
      `;
      warningEl.classList.remove("hidden");
      warningEl.classList.add("flex");

      // Ocultar después de 3 segundos
      setTimeout(() => {
        if (warningEl) {
          warningEl.classList.add("hidden");
          warningEl.classList.remove("flex");
        }
      }, 3000);
    }

    /**
     * Resalta visualmente un elemento con error.
     * @param {HTMLElement} element - Elemento a resaltar
     */
    function highlightElement(element) {
      if (!element) return;

      // Añadir clases de error (usando clases del safelist)
      element.classList.add("ring-2", "ring-amber-400", "border-amber-400");

      // Remover después de 2.5 segundos
      setTimeout(() => {
        element.classList.remove(
          "ring-2",
          "ring-amber-400",
          "border-amber-400"
        );
      }, 2500);
    }

    function handleBookButtonClick(e) {
      e.preventDefault();
      e.stopPropagation();

      // Verificar que exista el modal adapter
      if (
        !global.WPAgenda ||
        !global.WPAgenda.ui ||
        !global.WPAgenda.ui.modal
      ) {
        console.error("[DeoiaCalendarAdapter] Modal adapter no disponible");
        showValidationWarning(
          "Error interno. Recarga la página e intenta de nuevo."
        );
        return;
      }

      // Obtener servicio seleccionado
      const servicioSelect = document.querySelector("#servicio");
      const servicio = servicioSelect ? servicioSelect.value : "";

      if (!servicio) {
        showValidationWarning("Selecciona el motivo de la cita.");
        highlightElement(servicioSelect);
        return;
      }

      // Verificar fecha seleccionada
      if (!selectedDate) {
        showValidationWarning("Selecciona una fecha en el calendario.");
        return;
      }

      // Obtener slot seleccionado desde el adaptador de slots
      let horaSlot = null;
      if (
        global.WPAgenda.ui.slots &&
        typeof global.WPAgenda.ui.slots.getSelectedSlot === "function"
      ) {
        const slot = global.WPAgenda.ui.slots.getSelectedSlot();
        if (slot instanceof Date) {
          const h = String(slot.getHours()).padStart(2, "0");
          const m = String(slot.getMinutes()).padStart(2, "0");
          horaSlot = `${h}:${m}`;
        }
      }

      if (!horaSlot) {
        showValidationWarning("Selecciona un horario disponible.");
        return;
      }

      // Formatear fecha para mostrar en el modal
      const fechaFormateada = selectedDate.toLocaleDateString("es-MX", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
      });

      // Abrir el modal premium
      global.WPAgenda.ui.modal.open({
        servicio: servicio,
        fecha: fechaFormateada,
        hora: horaSlot,
        onSubmit: (dataCliente) => {
          // Copiar datos al formulario original
          const originalForm = document.querySelector("#agenda-form");
          if (originalForm) {
            const nombreField = originalForm.querySelector("#nombre");
            const telefonoField = originalForm.querySelector("#telefono");
            const correoField = originalForm.querySelector("#correo");

            if (nombreField) nombreField.value = dataCliente.nombre;
            if (telefonoField) telefonoField.value = dataCliente.telefono;
            if (correoField) correoField.value = dataCliente.correo;

            // Disparar submit del formulario original
            originalForm.dispatchEvent(
              new Event("submit", { bubbles: true, cancelable: true })
            );
          }
        },
      });
    }

    // =========================================================================
    // Generación del HTML del Calendario
    // =========================================================================

    function renderHeader() {
      const month = viewDate.toLocaleString("es-MX", { month: "long" });
      const year = viewDate.getFullYear();

      return `
        <div class="flex items-center justify-between mb-4">
          <span class="text-white font-medium capitalize">${month} ${year}</span>
          <div class="flex gap-1">
            <button type="button" data-nav="prev" class="p-1 hover:bg-slate-700 rounded-lg transition-colors">
              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>
            <button type="button" data-nav="next" class="p-1 hover:bg-slate-700 rounded-lg transition-colors">
              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </div>
      `;
    }

    function renderWeekdays() {
      const days = ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"];
      return `
        <div class="grid grid-cols-7 gap-1 text-center text-xs mb-2">
          ${days
            .map((d) => `<span class="text-slate-500 py-1">${d}</span>`)
            .join("")}
        </div>
      `;
    }

    function renderDaysGrid() {
      const year = viewDate.getFullYear();
      const month = viewDate.getMonth();
      const firstDay = new Date(year, month, 1);
      const startDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      let html = `<div class="grid grid-cols-7 gap-1 text-center text-xs" data-role="deoia-calendar-grid">`;

      // Espacios vacíos antes del primer día
      for (let i = 0; i < startDay; i++) {
        html += `<span class="py-2"></span>`;
      }

      // Días del mes
      for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const dateStr = ymd ? ymd(date) : date.toISOString().slice(0, 10);

        const isToday = date.toDateString() === new Date().toDateString();
        const isSelected =
          selectedDate && date.toDateString() === selectedDate.toDateString();
        const isDisabled = isDateDisabled(date);

        // Clases según el prototipo exacto
        let classes = "py-2 rounded-lg text-sm transition-all duration-200";

        if (isDisabled) {
          // Deshabilitado: opacidad baja, sin hover, cursor not-allowed
          classes += " text-slate-600 opacity-30 cursor-not-allowed";
        } else if (isSelected) {
          // Seleccionado: gradiente premium con sombra
          classes +=
            " bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold shadow-lg cursor-pointer";
        } else if (isToday) {
          // Hoy (no seleccionado)
          classes +=
            " bg-slate-700 text-white cursor-pointer hover:bg-slate-600";
        } else {
          // Normal habilitado
          classes += " text-slate-400 hover:bg-slate-700/50 cursor-pointer";
        }

        html += `
          <button type="button" class="${classes}" data-date="${dateStr}" ${
          isDisabled ? 'disabled aria-disabled="true"' : ""
        }>
            ${day}
          </button>
        `;
      }

      html += `</div>`;
      return html;
    }

    // =========================================================================
    // Manejo de Eventos
    // =========================================================================

    function handleDayClick(event) {
      const btn = event.target.closest("button[data-date]");
      if (!btn) return;

      // Verificar si está deshabilitado
      if (
        btn.disabled ||
        btn.hasAttribute("disabled") ||
        btn.classList.contains("opacity-30")
      ) {
        event.preventDefault();
        event.stopPropagation();
        return;
      }

      const dateStr = btn.dataset.date;
      if (!dateStr) return;

      // Parsear fecha desde YYYY-MM-DD
      const [year, month, day] = dateStr.split("-").map(Number);
      const date = new Date(year, month - 1, day);

      // Doble verificación
      if (isDateDisabled(date)) {
        event.preventDefault();
        event.stopPropagation();
        return;
      }

      selectedDate = date;
      renderCalendar();

      if (typeof config.onDateSelected === "function") {
        config.onDateSelected(selectedDate);
      }
    }

    function prevMonth() {
      viewDate = new Date(viewDate.getFullYear(), viewDate.getMonth() - 1, 1);
      renderCalendar();
    }

    function nextMonth() {
      viewDate = new Date(viewDate.getFullYear(), viewDate.getMonth() + 1, 1);
      renderCalendar();
    }

    function attachEvents() {
      const targetEl = calendarInnerEl || container;
      const prevBtn = targetEl.querySelector('[data-nav="prev"]');
      const nextBtn = targetEl.querySelector('[data-nav="next"]');
      const grid = targetEl.querySelector('[data-role="deoia-calendar-grid"]');

      prevBtn?.addEventListener("click", prevMonth);
      nextBtn?.addEventListener("click", nextMonth);
      grid?.addEventListener("click", handleDayClick);
    }

    // =========================================================================
    // Renderizado Principal
    // =========================================================================

    function renderCalendar() {
      const targetEl = calendarInnerEl || container;
      if (!targetEl) return;

      targetEl.innerHTML = `
        <div class="bg-slate-800/50 rounded-2xl p-4 mb-4 backdrop-blur-sm border border-slate-700/50">
          ${renderHeader()}
          ${renderWeekdays()}
          ${renderDaysGrid()}
        </div>
      `;

      attachEvents();
    }

    // =========================================================================
    // API Pública del Adaptador
    // =========================================================================

    return {
      render(cfg) {
        config = cfg || {};
        originalContainer =
          cfg.container instanceof HTMLElement
            ? cfg.container
            : document.querySelector(cfg.container);

        if (!originalContainer) {
          console.error("[DeoiaCalendarAdapter] Contenedor no encontrado");
          return;
        }

        // Crear el wrapper premium si no existe
        if (!isWrapped) {
          createPremiumWrapper();
        }

        // Usar el contenedor interno del calendario
        container = calendarInnerEl || originalContainer;

        viewDate = config.minDate ? new Date(config.minDate) : new Date();
        renderCalendar();
      },

      setDate(date, triggerChange = false) {
        if (!(date instanceof Date)) return;
        selectedDate = date;
        viewDate = new Date(date);
        renderCalendar();

        if (triggerChange && typeof config.onDateSelected === "function") {
          config.onDateSelected(selectedDate);
        }
      },

      getSelectedDate() {
        return selectedDate;
      },

      destroy() {
        // Limpiar el wrapper premium si existe
        if (wrapperEl && wrapperEl.parentNode) {
          wrapperEl.parentNode.removeChild(wrapperEl);
        }
        // Restaurar visibilidad del contenedor original
        if (originalContainer) {
          originalContainer.style.display = "";
        }
        wrapperEl = null;
        calendarInnerEl = null;
        container = null;
        originalContainer = null;
        selectedDate = null;
        config = {};
        isWrapped = false;
      },

      /**
       * Habilita o deshabilita el botón de confirmación premium.
       * @param {boolean} enabled - true para habilitar, false para deshabilitar
       */
      setBookButtonEnabled(enabled) {
        if (!wrapperEl) return;
        const btn = wrapperEl.querySelector('[data-role="deoia-book-btn"]');
        if (!btn) return;

        if (enabled) {
          btn.disabled = false;
          btn.classList.remove("opacity-50", "cursor-not-allowed");
          btn.classList.add("hover:shadow-violet-500/50", "hover:scale-[1.02]");
        } else {
          btn.disabled = true;
          btn.classList.add("opacity-50", "cursor-not-allowed");
          btn.classList.remove(
            "hover:shadow-violet-500/50",
            "hover:scale-[1.02]"
          );
        }
      },

      /**
       * Registra un callback para el botón de confirmación.
       * @param {Function} callback - Función a ejecutar al hacer click
       */
      onBookClick(callback) {
        if (!wrapperEl) return;
        const btn = wrapperEl.querySelector('[data-role="deoia-book-btn"]');
        if (!btn) return;
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          if (!btn.disabled && typeof callback === "function") {
            callback();
          }
        });
      },

      /**
       * Obtiene el wrapper premium para permitir acceso a elementos internos.
       * @returns {HTMLElement|null}
       */
      getWrapper() {
        return wrapperEl;
      },
    };
  }

  global.deoiaCalendarAdapter = { create };

  console.log(
    "✅ DeoiaCalendarAdapter.js cargado (versión premium con wrapper)"
  );
})(window);
