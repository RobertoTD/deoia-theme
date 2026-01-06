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
  'use strict';

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
      if (config.disableDateFn && typeof config.disableDateFn === 'function') {
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
      const form = originalContainer.closest('form');
      if (!form) {
        console.warn('[DeoiaCalendarAdapter] No se encontró formulario padre');
        return;
      }

      // Buscar el slot container del plugin
      const pluginSlotContainer = form.querySelector('#slot-container');

      // Crear el wrapper premium
      wrapperEl = document.createElement('div');
      wrapperEl.className =
        'deoia-premium-widget rounded-3xl p-6 lg:p-8 shadow-2xl relative overflow-hidden';
      wrapperEl.style.background =
        'linear-gradient(to bottom right, var(--deoia-bg-card), color-mix(in srgb, var(--deoia-bg-card) 80%, black))';
      wrapperEl.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.3)';
      wrapperEl.style.borderWidth = '1px';
      wrapperEl.style.borderStyle = 'solid';
      wrapperEl.style.borderColor = 'color-mix(in srgb, var(--deoia-border) 50%, transparent)';
      wrapperEl.setAttribute('data-deoia-premium', 'true');

      wrapperEl.innerHTML = `
        <!-- Decorative Glows -->
        <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background-color: var(--deoia-bg-glow-1); opacity: 0.2;"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background-color: var(--deoia-bg-glow-2); opacity: 0.2;"></div>
        
        <!-- Widget Content -->
        <div class="relative z-10" data-role="deoia-widget-content">
          <!-- Widget Header -->
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary));">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold" style="color: var(--deoia-text);">Reservar Cita</h3>
                <p class="text-sm" style="color: var(--deoia-muted);">Selecciona motivo, fecha y hora</p>
              </div>
            </div>
            <span class="text-xs px-3 py-1 rounded-full font-medium" style="background-color: var(--deoia-success-bg); color: var(--deoia-success);">En línea</span>
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
          <button type="button" data-role="deoia-book-btn" class="w-full text-white font-semibold py-4 rounded-2xl shadow-xl hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 deoia-btn-primary" style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);" data-ready="false">
            Reservar
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
          </button>

          <!-- Widget Badge -->
          <p class="text-center text-xs mt-4" style="color: var(--deoia-muted);">
            Potenciado por <span class="font-medium" style="color: var(--deoia-accent);">Deoia</span>
          </p>
        </div>
      `;

      // Insertar el wrapper antes del calendario original
      originalContainer.parentNode.insertBefore(wrapperEl, originalContainer);

      // Obtener referencia al contenedor interno del calendario
      calendarInnerEl = wrapperEl.querySelector('[data-role="deoia-calendar-container"]');

      // Mover el select de servicio al wrapper premium y aplicar estilos
      const servicioSelect = form.querySelector('#servicio');
      const servicePlaceholder = wrapperEl.querySelector('[data-role="deoia-service-placeholder"]');
      if (servicioSelect && servicePlaceholder) {
        // Aplicar clases premium al select
        servicioSelect.className =
          'rounded-xl py-3 px-4 ' +
          'text-sm focus:outline-none focus:ring-2 ' +
          'transition-all duration-200 w-full appearance-none cursor-pointer deoia-input-focus';
        servicioSelect.style.backgroundColor =
          'color-mix(in srgb, var(--deoia-bg-card-alt) 80%, transparent)';
        servicioSelect.style.borderWidth = '1px';
        servicioSelect.style.borderStyle = 'solid';
        servicioSelect.style.borderColor =
          'color-mix(in srgb, var(--deoia-border) 50%, transparent)';
        servicioSelect.style.color = 'var(--deoia-text-secondary)';
        servicioSelect.style.setProperty(
          '--tw-ring-color',
          'color-mix(in srgb, var(--deoia-primary) 50%, transparent)'
        );

        // Crear wrapper para el select con icono de dropdown
        const selectWrapper = document.createElement('div');
        selectWrapper.className = 'relative';
        selectWrapper.innerHTML = `
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
            <svg class="w-4 h-4" style="color: var(--deoia-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        `;

        // Mover el select al wrapper con icono
        selectWrapper.insertBefore(servicioSelect, selectWrapper.firstChild);

        // Insertar en el placeholder
        servicePlaceholder.appendChild(selectWrapper);
      }

      // Mover el selector de staff al wrapper premium (debajo del servicio)
      const staffWrapper = form.querySelector('#staff-selector-wrapper');
      if (staffWrapper && servicePlaceholder) {
        // Mantener estado inicial oculto (ya viene con display:none del PHP)
        staffWrapper.style.display = 'none';

        // Aplicar clases Tailwind al wrapper
        staffWrapper.classList.add('mt-3', 'relative');

        // Aplicar estilos al label
        const label = staffWrapper.querySelector('label');
        if (label) {
          label.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
          label.style.color = 'var(--deoia-text-secondary)';
        }

        // Aplicar estilos al select
        const staffSelect = staffWrapper.querySelector('#staff-selector');
        if (staffSelect) {
          staffSelect.classList.add(
            'rounded-xl',
            'py-3',
            'px-4',
            'text-sm',
            'focus:outline-none',
            'focus:ring-2',
            'transition-all',
            'duration-200',
            'w-full',
            'appearance-none',
            'cursor-pointer',
            'deoia-input-focus'
          );

          // Aplicar inline styles equivalentes al servicio
          staffSelect.style.backgroundColor =
            'color-mix(in srgb, var(--deoia-bg-card-alt) 80%, transparent)';
          staffSelect.style.borderWidth = '1px';
          staffSelect.style.borderStyle = 'solid';
          staffSelect.style.borderColor =
            'color-mix(in srgb, var(--deoia-border) 50%, transparent)';
          staffSelect.style.color = 'var(--deoia-text-secondary)';
          staffSelect.style.setProperty(
            '--tw-ring-color',
            'color-mix(in srgb, var(--deoia-primary) 50%, transparent)'
          );
        }

        // Mover el wrapper al placeholder del servicio
        servicePlaceholder.appendChild(staffWrapper);
      }

      // Mover el slot container del plugin al wrapper premium
      if (pluginSlotContainer) {
        const slotsPlaceholder = wrapperEl.querySelector('[data-role="deoia-slots-placeholder"]');
        if (slotsPlaceholder) {
          slotsPlaceholder.parentNode.replaceChild(pluginSlotContainer, slotsPlaceholder);
        }
      }

      // Ocultar el calendario original
      originalContainer.style.display = 'none';

      // Mover el título de slots del plugin al wrapper premium y aplicar estilos
      const slotTitle = document.getElementById('aa-slot-title');
      const slotTitlePlaceholder = wrapperEl.querySelector(
        '[data-role="deoia-slot-title-placeholder"]'
      );
      if (slotTitle && slotTitlePlaceholder) {
        // Aplicar estilos premium al título
        slotTitle.className = 'text-sm mb-3';
        slotTitle.style.color = 'var(--deoia-muted)';
        slotTitle.style.display = ''; // Asegurar que no esté oculto
        // Reemplazar el placeholder con el título real
        slotTitlePlaceholder.parentNode.replaceChild(slotTitle, slotTitlePlaceholder);
      }

      // Ocultar campos del formulario original (se usarán desde el modal premium)
      const fieldsToHide = [
        form.querySelector('#nombre'),
        form.querySelector('#telefono'),
        form.querySelector('#correo'),
        form.querySelector('button[type="submit"]')
      ];
      fieldsToHide.forEach((field) => {
        if (field) field.style.display = 'none';
      });

      // Conectar el botón premium al modal
      const bookBtn = wrapperEl.querySelector('[data-role="deoia-book-btn"]');
      if (bookBtn) {
        bookBtn.addEventListener('click', handleBookButtonClick);
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
        warningEl = document.createElement('div');
        warningEl.setAttribute('data-role', 'deoia-warning');
        warningEl.className =
          'text-sm px-4 py-3 rounded-xl mb-4 flex items-center gap-2 transition-all duration-300';
        warningEl.style.backgroundColor = 'var(--deoia-warning-bg)';
        warningEl.style.borderWidth = '1px';
        warningEl.style.borderStyle = 'solid';
        warningEl.style.borderColor = 'color-mix(in srgb, var(--deoia-warning) 50%, transparent)';
        warningEl.style.color = 'var(--deoia-warning)';

        // Insertar antes del botón de confirmación
        const bookBtn = wrapperEl.querySelector('[data-role="deoia-book-btn"]');
        if (bookBtn && bookBtn.parentNode) {
          bookBtn.parentNode.insertBefore(warningEl, bookBtn);
        }
      }

      // Mostrar el mensaje con icono de advertencia
      warningEl.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0" style="color: var(--deoia-warning);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span>${message}</span>
      `;
      warningEl.classList.remove('hidden');
      warningEl.classList.add('flex');

      // Ocultar después de 3 segundos
      setTimeout(() => {
        if (warningEl) {
          warningEl.classList.add('hidden');
          warningEl.classList.remove('flex');
        }
      }, 3000);
    }

    /**
     * Resalta visualmente un elemento con error.
     * @param {HTMLElement} element - Elemento a resaltar
     */
    function highlightElement(element) {
      if (!element) return;

      // Añadir estilos de error inline
      element.style.outline = '2px solid var(--deoia-warning)';
      element.style.outlineOffset = '2px';

      // Remover después de 2.5 segundos
      setTimeout(() => {
        element.style.outline = '';
        element.style.outlineOffset = '';
      }, 2500);
    }

    function handleBookButtonClick(e) {
      e.preventDefault();
      e.stopPropagation();

      // Verificar que exista el modal adapter
      if (!global.WPAgenda || !global.WPAgenda.ui || !global.WPAgenda.ui.modal) {
        console.error('[DeoiaCalendarAdapter] Modal adapter no disponible');
        showValidationWarning('Error interno. Recarga la página e intenta de nuevo.');
        return;
      }

      // Obtener servicio seleccionado
      const servicioSelect = document.querySelector('#servicio');
      const servicio = servicioSelect ? servicioSelect.value : '';

      if (!servicio) {
        showValidationWarning('Selecciona el motivo de la cita.');
        highlightElement(servicioSelect);
        return;
      }

      // Verificar fecha seleccionada
      if (!selectedDate) {
        showValidationWarning('Selecciona una fecha en el calendario.');
        return;
      }

      // Obtener slot seleccionado desde el adaptador de slots
      let horaSlot = null;
      if (
        global.WPAgenda.ui.slots &&
        typeof global.WPAgenda.ui.slots.getSelectedSlot === 'function'
      ) {
        const slot = global.WPAgenda.ui.slots.getSelectedSlot();
        if (slot instanceof Date) {
          const h = String(slot.getHours()).padStart(2, '0');
          const m = String(slot.getMinutes()).padStart(2, '0');
          horaSlot = `${h}:${m}`;
        }
      }

      if (!horaSlot) {
        showValidationWarning('Selecciona un horario disponible.');
        return;
      }

      // Formatear fecha para mostrar en el modal
      const fechaFormateada = selectedDate.toLocaleDateString('es-MX', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      });

      // Abrir el modal premium
      global.WPAgenda.ui.modal.open({
        servicio: servicio,
        fecha: fechaFormateada,
        hora: horaSlot,
        onSubmit: (dataCliente) => {
          // Copiar datos al formulario original
          const originalForm = document.querySelector('#agenda-form');
          if (originalForm) {
            const nombreField = originalForm.querySelector('#nombre');
            const telefonoField = originalForm.querySelector('#telefono');
            const correoField = originalForm.querySelector('#correo');

            if (nombreField) nombreField.value = dataCliente.nombre;
            if (telefonoField) telefonoField.value = dataCliente.telefono;
            if (correoField) correoField.value = dataCliente.correo;

            // Disparar submit del formulario original
            originalForm.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
          }
        }
      });
    }

    // =========================================================================
    // Generación del HTML del Calendario
    // =========================================================================

    function renderHeader() {
      const month = viewDate.toLocaleString('es-MX', { month: 'long' });
      const year = viewDate.getFullYear();

      return `
        <div class="flex items-center justify-between mb-4">
          <span class="font-medium capitalize" style="color: var(--deoia-text);">${month} ${year}</span>
          <div class="flex gap-1">
            <button type="button" data-nav="prev" class="p-1 rounded-lg transition-colors deoia-nav-btn">
              <svg class="w-4 h-4" style="color: var(--deoia-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>
            <button type="button" data-nav="next" class="p-1 rounded-lg transition-colors deoia-nav-btn">
              <svg class="w-4 h-4" style="color: var(--deoia-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </div>
      `;
    }

    function renderWeekdays() {
      const days = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
      return `
        <div class="grid grid-cols-7 gap-1 text-center text-xs mb-2">
          ${days
            .map((d) => `<span class="py-1" style="color: var(--deoia-muted);">${d}</span>`)
            .join('')}
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
        const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
        const isDisabled = isDateDisabled(date);

        // Clases según el prototipo exacto
        let classes = 'py-2 rounded-lg text-sm transition-all duration-200';
        let dayInlineStyle = '';

        if (isDisabled) {
          // Deshabilitado: opacidad baja, sin hover, cursor not-allowed
          classes += ' opacity-30 cursor-not-allowed';
          dayInlineStyle = 'style="color: var(--deoia-disabled);"';
        } else if (isSelected) {
          // Seleccionado: gradiente premium con sombra (usando CSS variables)
          classes += ' text-white font-semibold shadow-lg cursor-pointer deoia-day-selected';
          dayInlineStyle =
            'style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); color: white;"';
        } else if (isToday) {
          // Hoy (no seleccionado)
          classes += ' cursor-pointer deoia-day-today';
          dayInlineStyle =
            'style="background-color: var(--deoia-hover); color: var(--deoia-text);"';
        } else {
          // Normal habilitado
          classes += ' cursor-pointer deoia-day-normal';
          dayInlineStyle = 'style="color: var(--deoia-muted);"';
        }

        html += `
          <button type="button" class="${classes}" data-date="${dateStr}" ${dayInlineStyle} ${
          isDisabled ? 'disabled aria-disabled="true"' : ''
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
      const btn = event.target.closest('button[data-date]');
      if (!btn) return;

      // Verificar si está deshabilitado
      if (btn.disabled || btn.hasAttribute('disabled') || btn.classList.contains('opacity-30')) {
        event.preventDefault();
        event.stopPropagation();
        return;
      }

      // Validar que haya servicio seleccionado
      const servicioSelect = document.querySelector('#servicio');
      const servicio = servicioSelect ? servicioSelect.value : '';

      if (!servicio) {
        event.preventDefault();
        event.stopPropagation();

        showValidationWarning('Selecciona el motivo de la cita.');
        highlightElement(servicioSelect);

        return;
      }

      const dateStr = btn.dataset.date;
      if (!dateStr) return;

      // Parsear fecha desde YYYY-MM-DD
      const [year, month, day] = dateStr.split('-').map(Number);
      const date = new Date(year, month - 1, day);

      // Doble verificación
      if (isDateDisabled(date)) {
        event.preventDefault();
        event.stopPropagation();
        return;
      }

      selectedDate = date;

      // Exponer fecha seleccionada en formato YYYY-MM-DD
      window.aa_selected_date = dateStr;
      console.log('📅 [DeoiaCalendarAdapter] Fecha seleccionada:', dateStr);

      // Emitir evento si WPAgenda.emit existe
      if (global.WPAgenda && typeof global.WPAgenda.emit === 'function') {
        global.WPAgenda.emit('dateSelected', { ymd: dateStr, raw: selectedDate });
      }

      renderCalendar();

      if (typeof config.onDateSelected === 'function') {
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

      prevBtn?.addEventListener('click', prevMonth);
      nextBtn?.addEventListener('click', nextMonth);
      grid?.addEventListener('click', handleDayClick);
    }

    // =========================================================================
    // Renderizado Principal
    // =========================================================================

    function renderCalendar() {
      const targetEl = calendarInnerEl || container;
      if (!targetEl) return;

      targetEl.innerHTML = `
        <div class="rounded-2xl p-4 mb-4 backdrop-blur-sm" style="background-color: color-mix(in srgb, var(--deoia-bg-card-alt) 50%, transparent); border: 1px solid color-mix(in srgb, var(--deoia-border) 50%, transparent);">
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

        // =====================================================================
        // OPCIÓN C: Si ya existe el wrapper, solo re-renderizar el calendario
        // No destruir ni recrear el wrapper para preservar elementos movidos
        // =====================================================================
        if (isWrapped && calendarInnerEl) {
          // Ya existe el wrapper premium, solo actualizar el calendario
          container = calendarInnerEl;
          viewDate = config.minDate ? new Date(config.minDate) : new Date();
          renderCalendar();
          console.log('[DeoiaCalendarAdapter] Re-renderizado sobre wrapper existente');
          return;
        }

        // Primera vez: crear wrapper completo
        originalContainer =
          cfg.container instanceof HTMLElement
            ? cfg.container
            : document.querySelector(cfg.container);

        if (!originalContainer) {
          console.error('[DeoiaCalendarAdapter] Contenedor no encontrado');
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

        if (triggerChange && typeof config.onDateSelected === 'function') {
          config.onDateSelected(selectedDate);
        }
      },

      getSelectedDate() {
        return selectedDate;
      },

      destroy() {
        // =====================================================================
        // OPCIÓN C: Solo limpiar contenido del calendario, NO el wrapper completo
        // Esto preserva #servicio, #slot-container y #aa-slot-title en su lugar
        // =====================================================================
        if (calendarInnerEl) {
          calendarInnerEl.innerHTML = '';
        }

        // Reset estado interno pero MANTENER wrapper y elementos movidos
        selectedDate = null;
        config = {};

        // NO resetear: wrapperEl, calendarInnerEl, originalContainer, isWrapped
        // Esto permite que el próximo render() detecte el wrapper existente
        console.log(
          '[DeoiaCalendarAdapter] destroy() - Solo contenido del calendario limpiado, wrapper preservado'
        );
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
          btn.classList.remove('opacity-50', 'cursor-not-allowed');
          btn.classList.add('hover:scale-[1.02]');
        } else {
          btn.disabled = true;
          btn.classList.add('opacity-50', 'cursor-not-allowed');
          btn.classList.remove('hover:scale-[1.02]');
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
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          if (!btn.disabled && typeof callback === 'function') {
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
      }
    };
  }

  global.deoiaCalendarAdapter = { create };

  console.log('✅ DeoiaCalendarAdapter.js cargado (versión premium con wrapper)');
})(window);
