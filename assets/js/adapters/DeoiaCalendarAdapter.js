(function (global) {
  "use strict";

  function create() {
    let container = null;
    let selectedDate = null;
    let viewDate = new Date();
    let config = {};
    const { ymd } = global.DateUtils || {};

    function isDateDisabled(date) {
      // Lógica equivalente al adaptador default
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

    function renderHeader() {
      const month = viewDate.toLocaleString("es-MX", { month: "long" });
      const year = viewDate.getFullYear();

      return `
        <div class="flex items-center justify-between mb-4">
          <span class="text-white font-medium capitalize">${month} ${year}</span>
          <div class="flex gap-1">
            <button type="button" data-nav="prev" class="p-1 hover:bg-slate-700 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>

            <button type="button" data-nav="next" class="p-1 hover:bg-slate-700 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </div>
      `;
    }

    function renderWeekdays() {
      const days = ["L", "M", "X", "J", "V", "S", "D"];
      return `
        <div class="grid grid-cols-7 text-center text-xs text-slate-400 mb-2">
          ${days.map((d) => `<div>${d}</div>`).join("")}
        </div>
      `;
    }

    function renderDaysGrid() {
      const year = viewDate.getFullYear();
      const month = viewDate.getMonth();
      const firstDay = new Date(year, month, 1);
      const startDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      let html = `<div class="grid grid-cols-7 gap-1" data-role="deoia-calendar-grid">`;

      for (let i = 0; i < startDay; i++) {
        html += `<div></div>`;
      }

      for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const dateStr = ymd ? ymd(date) : date.toISOString().slice(0, 10);

        const isToday = date.toDateString() === new Date().toDateString();
        const isSelected =
          selectedDate && date.toDateString() === selectedDate.toDateString();
        const isDisabled = isDateDisabled(date);

        // Clases base del botón
        let classes = `w-8 h-8 rounded-xl text-xs flex items-center justify-center transition`;

        if (isDisabled) {
          // Estado deshabilitado: texto muy tenue, sin hover, cursor-not-allowed, menor opacidad
          classes += ` text-slate-600 opacity-30 cursor-not-allowed pointer-events-none`;
        } else if (isSelected) {
          // Estado seleccionado: gradiente violeta/indigo premium
          classes += ` bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 text-white cursor-pointer shadow-lg shadow-violet-500/25`;
        } else if (isToday) {
          // Día actual (no seleccionado)
          classes += ` bg-slate-700 text-white cursor-pointer hover:bg-slate-600`;
        } else {
          // Día normal habilitado
          classes += ` text-slate-400 cursor-pointer hover:bg-slate-700/50 hover:text-slate-300`;
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

    function handleDayClick(event) {
      const btn = event.target.closest("button[data-date]");
      if (!btn) return;

      // Verificar si el botón está deshabilitado (por atributo o clase)
      if (
        btn.disabled ||
        btn.hasAttribute("disabled") ||
        btn.classList.contains("pointer-events-none")
      ) {
        event.preventDefault();
        event.stopPropagation();
        return;
      }

      const dateStr = btn.dataset.date;
      if (!dateStr) return;

      // Parsear la fecha desde el string YYYY-MM-DD para evitar problemas de timezone
      const [year, month, day] = dateStr.split("-").map(Number);
      const date = new Date(year, month - 1, day);

      // Doble verificación: no seleccionar si está deshabilitado
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
      const prevBtn = container.querySelector('[data-nav="prev"]');
      const nextBtn = container.querySelector('[data-nav="next"]');
      const grid = container.querySelector('[data-role="deoia-calendar-grid"]');

      prevBtn?.addEventListener("click", prevMonth);
      nextBtn?.addEventListener("click", nextMonth);
      grid?.addEventListener("click", handleDayClick);
    }

    function renderCalendar() {
      if (!container) return;

      container.innerHTML = `
        <div class="bg-slate-800/50 rounded-2xl p-4 mb-4 backdrop-blur-sm border border-slate-700/50">
          ${renderHeader()}
          ${renderWeekdays()}
          ${renderDaysGrid()}
        </div>
      `;

      attachEvents();
    }

    return {
      render(cfg) {
        config = cfg || {};
        container =
          cfg.container instanceof HTMLElement
            ? cfg.container
            : document.querySelector(cfg.container);

        if (!container) {
          console.error("[DeoiaCalendarAdapter] Contenedor no encontrado");
          return;
        }

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
        if (container) container.innerHTML = "";
        container = null;
        selectedDate = null;
        config = {};
      },
    };
  }

  global.deoiaCalendarAdapter = { create };
})(window);
