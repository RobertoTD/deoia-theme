/**
 * DeoiaModalAdapter - Adaptador premium de modal para WPAgenda
 *
 * Modal de confirmación con estilos Tailwind premium,
 * idénticos al prototipo del widget de reservas.
 *
 * Compatible con WPAgenda.registerModalAdapter().
 */

(function (global) {
  "use strict";

  /**
   * Crea una instancia del adaptador de modal premium.
   * @returns {Object} Adaptador con métodos open, close, setLoading.
   */
  function create() {
    let overlayEl = null;
    let modalEl = null;
    let submitBtn = null;
    let responseEl = null;
    let onSubmitCallback = null;
    let isLoading = false;
    let responseObserver = null;

    // =========================================================================
    // Generación del HTML del Modal Premium
    // =========================================================================

    /**
     * Genera el HTML del modal premium.
     * @param {Object} options - { servicio, fecha, hora }
     * @returns {string}
     */
    function buildModalHTML(options) {
      const { servicio, fecha, hora } = options;

      return `
        <!-- Overlay - z-index muy alto para cubrir todo incluyendo header sticky/fixed -->
        <div class="deoia-modal-overlay fixed inset-0 bg-slate-900/60 backdrop-blur-sm" style="z-index: 99998;"></div>
        
        <!-- Modal Container - z-index aún más alto -->
        <div class="deoia-modal fixed inset-0 flex items-center justify-center p-4" style="z-index: 99999;">
          <div class="deoia-modal-content bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 lg:p-8 shadow-2xl shadow-slate-900/40 border border-slate-700/50 relative overflow-hidden w-full max-w-md transform transition-all duration-300 scale-100">
            
            <!-- Decorative Glows -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <!-- Modal Content -->
            <div class="relative z-10">
              
              <!-- Close Button -->
              <button type="button" data-role="deoia-modal-close" class="absolute top-0 right-0 p-2 text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
              
              <!-- Header -->
              <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-indigo-500 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <div>
                  <h3 class="text-xl text-white font-semibold">Confirmar Reserva</h3>
                  <p class="text-slate-400 text-sm">Completa tus datos</p>
                </div>
              </div>
              
              <!-- Reservation Summary -->
              <div class="bg-slate-800/50 rounded-2xl p-4 mb-6 border border-slate-700/50">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-3">Resumen de tu cita</p>
                <div class="space-y-2">
                  <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white text-sm font-medium">${
                      servicio || "Servicio no especificado"
                    }</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white text-sm">${fecha || ""}</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-white text-sm">${hora || ""}</span>
                  </div>
                </div>
              </div>
              
              <!-- Form -->
              <form data-role="deoia-modal-form" class="space-y-4">
                <!-- Nombre -->
                <div>
                  <label for="deoia-nombre" class="block text-slate-400 text-sm mb-2">Nombre completo</label>
                  <input 
                    type="text" 
                    id="deoia-nombre" 
                    name="nombre"
                    required
                    placeholder="Tu nombre"
                    class="w-full bg-slate-800/80 border border-slate-700/50 rounded-xl py-3 px-4 text-white text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition-all duration-200"
                  >
                </div>
                
                <!-- Teléfono -->
                <div>
                  <label for="deoia-telefono" class="block text-slate-400 text-sm mb-2">Teléfono</label>
                  <input 
                    type="tel" 
                    id="deoia-telefono" 
                    name="telefono"
                    required
                    placeholder="Tu número de teléfono"
                    class="w-full bg-slate-800/80 border border-slate-700/50 rounded-xl py-3 px-4 text-white text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition-all duration-200"
                  >
                </div>
                
                <!-- Correo -->
                <div>
                  <label for="deoia-correo" class="block text-slate-400 text-sm mb-2">Correo electrónico</label>
                  <input 
                    type="email" 
                    id="deoia-correo" 
                    name="correo"
                    required
                    placeholder="tu@correo.com"
                    class="w-full bg-slate-800/80 border border-slate-700/50 rounded-xl py-3 px-4 text-white text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition-all duration-200"
                  >
                </div>
                
                <!-- Submit Button -->
                <button 
                  type="submit" 
                  data-role="deoia-modal-submit"
                  class="w-full bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold py-4 rounded-2xl shadow-xl shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 mt-6"
                >
                  <span data-role="btn-text">Reservar ahora</span>
                  <svg class="w-5 h-5" data-role="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <!-- Spinner (hidden by default) -->
                  <svg class="w-5 h-5 animate-spin hidden" data-role="btn-spinner" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                </button>
              </form>
              
              <!-- Response Container Premium -->
              <div data-role="deoia-response" class="text-sm text-center mt-4 min-h-[24px] transition-all duration-300"></div>
              
              <!-- Footer -->
              <p class="text-center text-slate-500 text-xs mt-4">
                Potenciado por <span class="text-violet-400 font-medium">Deoia</span>
              </p>
            </div>
          </div>
        </div>
      `;
    }

    // =========================================================================
    // Manejo de Eventos
    // =========================================================================

    /**
     * Maneja el envío del formulario del modal.
     * Valida los campos y llama al callback onSubmit con los datos.
     * El callback es responsable de copiar datos y enviar el formulario original.
     * @param {Event} e
     */
    function handleSubmit(e) {
      e.preventDefault();
      e.stopPropagation();

      if (isLoading) return;

      const nombre = modalEl.querySelector("#deoia-nombre").value.trim();
      const telefono = modalEl.querySelector("#deoia-telefono").value.trim();
      const correo = modalEl.querySelector("#deoia-correo").value.trim();

      // Validación
      if (!nombre || !telefono || !correo) {
        // Mostrar error visual en campos vacíos
        if (!nombre) highlightField("#deoia-nombre");
        if (!telefono) highlightField("#deoia-telefono");
        if (!correo) highlightField("#deoia-correo");
        return;
      }

      // Ejecutar callback - el callback es responsable de:
      // 1. Copiar datos al formulario original
      // 2. Disparar el submit del formulario original
      if (onSubmitCallback && typeof onSubmitCallback === "function") {
        onSubmitCallback({ nombre, telefono, correo });
      } else {
        console.warn("[DeoiaModalAdapter] No se proporcionó callback onSubmit");
      }
    }

    /**
     * Resalta un campo con error.
     * @param {string} selector
     */
    function highlightField(selector) {
      const field = modalEl.querySelector(selector);
      if (!field) return;

      field.classList.add("ring-2", "ring-red-500/50", "border-red-500/50");

      // Remover después de 2 segundos
      setTimeout(() => {
        field.classList.remove(
          "ring-2",
          "ring-red-500/50",
          "border-red-500/50"
        );
      }, 2000);
    }

    /**
     * Cierra el modal con animación.
     */
    function closeWithAnimation() {
      if (!modalEl) return;

      const content = modalEl.querySelector(".deoia-modal-content");
      if (content) {
        content.classList.add("scale-95", "opacity-0");
      }

      if (overlayEl) {
        overlayEl.classList.add("opacity-0");
      }

      // Esperar animación antes de remover del DOM
      setTimeout(() => {
        removeFromDOM();
      }, 200);
    }

    /**
     * Remueve el modal del DOM.
     */
    function removeFromDOM() {
      // Desconectar observer si existe
      if (responseObserver) {
        responseObserver.disconnect();
        responseObserver = null;
      }

      // Restaurar visibilidad de #respuesta-agenda
      const respuestaAgenda = document.getElementById("respuesta-agenda");
      if (respuestaAgenda) {
        respuestaAgenda.style.display = "";
      }

      if (overlayEl && overlayEl.parentNode) {
        overlayEl.parentNode.removeChild(overlayEl);
      }
      if (modalEl && modalEl.parentNode) {
        modalEl.parentNode.removeChild(modalEl);
      }
      overlayEl = null;
      modalEl = null;
      submitBtn = null;
      responseEl = null;
      onSubmitCallback = null;
      isLoading = false;

      // Restaurar scroll del body
      document.body.style.overflow = "";
    }

    /**
     * Maneja el click en el overlay para cerrar.
     * @param {Event} e
     */
    function handleOverlayClick(e) {
      if (e.target === overlayEl) {
        closeWithAnimation();
      }
    }

    /**
     * Maneja tecla Escape para cerrar.
     * @param {Event} e
     */
    function handleEscapeKey(e) {
      if (e.key === "Escape") {
        closeWithAnimation();
      }
    }

    // =========================================================================
    // API Pública del Adaptador
    // =========================================================================

    return {
      /**
       * Abre el modal con la información de la reserva.
       * @param {Object} options - { servicio, fecha, hora, onSubmit }
       */
      open(options) {
        // Cerrar modal previo si existe
        this.close();

        const { onSubmit } = options || {};
        onSubmitCallback = onSubmit;

        // Crear contenedor temporal para parsear HTML
        const wrapper = document.createElement("div");
        wrapper.innerHTML = buildModalHTML(options);

        overlayEl = wrapper.querySelector(".deoia-modal-overlay");
        modalEl = wrapper.querySelector(".deoia-modal");
        submitBtn = modalEl.querySelector('[data-role="deoia-modal-submit"]');
        responseEl = modalEl.querySelector('[data-role="deoia-response"]');

        // Insertar en el DOM
        document.body.appendChild(overlayEl);
        document.body.appendChild(modalEl);

        // Prevenir scroll del body
        document.body.style.overflow = "hidden";

        // Ocultar #respuesta-agenda del plugin para evitar duplicados
        const respuestaAgenda = document.getElementById("respuesta-agenda");
        if (respuestaAgenda) {
          respuestaAgenda.style.display = "none";
        }

        // Vaciar el contenedor de respuesta premium
        if (responseEl) {
          responseEl.textContent = "";
          responseEl.className =
            "text-sm text-center mt-4 min-h-[24px] transition-all duration-300";
        }

        // Configurar MutationObserver para capturar respuesta del plugin
        if (respuestaAgenda) {
          responseObserver = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
              if (
                mutation.type === "childList" ||
                mutation.type === "characterData"
              ) {
                const texto =
                  respuestaAgenda.textContent || respuestaAgenda.innerText;
                if (texto && texto.trim() && responseEl) {
                  // Detectar si es éxito o error
                  const isSuccess =
                    texto.includes("✅") ||
                    texto.toLowerCase().includes("correctamente");
                  const isError =
                    texto.includes("❌") ||
                    texto.toLowerCase().includes("error");

                  // Aplicar estilos según el tipo de mensaje
                  if (isSuccess) {
                    responseEl.className =
                      "text-sm text-center mt-4 min-h-[24px] transition-all duration-300 text-emerald-400";
                  } else if (isError) {
                    responseEl.className =
                      "text-sm text-center mt-4 min-h-[24px] transition-all duration-300 text-red-400";
                  } else {
                    responseEl.className =
                      "text-sm text-center mt-4 min-h-[24px] transition-all duration-300 text-slate-300";
                  }

                  responseEl.textContent = texto.trim();

                  // Si es éxito, cerrar modal después de 2 segundos
                  if (isSuccess) {
                    setTimeout(() => {
                      closeWithAnimation();
                    }, 2000);
                  }
                }
              }
            }
          });

          responseObserver.observe(respuestaAgenda, {
            childList: true,
            characterData: true,
            subtree: true,
          });
        }

        // Event listeners
        overlayEl.addEventListener("click", handleOverlayClick);
        modalEl
          .querySelector('[data-role="deoia-modal-close"]')
          ?.addEventListener("click", closeWithAnimation);
        modalEl
          .querySelector('[data-role="deoia-modal-form"]')
          ?.addEventListener("submit", handleSubmit);
        document.addEventListener("keydown", handleEscapeKey);

        // Animación de entrada
        requestAnimationFrame(() => {
          const content = modalEl.querySelector(".deoia-modal-content");
          if (content) {
            content.classList.remove("scale-95", "opacity-0");
          }
        });

        // Focus en el primer campo
        setTimeout(() => {
          modalEl.querySelector("#deoia-nombre")?.focus();
        }, 100);
      },

      /**
       * Cierra el modal y limpia el DOM.
       */
      close() {
        document.removeEventListener("keydown", handleEscapeKey);
        closeWithAnimation();
      },

      /**
       * Establece el estado de carga del botón submit.
       * @param {boolean} loading
       */
      setLoading(loading) {
        isLoading = loading;

        if (!submitBtn) return;

        const btnText = submitBtn.querySelector('[data-role="btn-text"]');
        const btnIcon = submitBtn.querySelector('[data-role="btn-icon"]');
        const btnSpinner = submitBtn.querySelector('[data-role="btn-spinner"]');

        if (loading) {
          submitBtn.disabled = true;
          submitBtn.classList.add("opacity-70", "cursor-not-allowed");
          submitBtn.classList.remove("hover:scale-[1.02]");

          if (btnText) btnText.textContent = "Procesando...";
          if (btnIcon) btnIcon.classList.add("hidden");
          if (btnSpinner) btnSpinner.classList.remove("hidden");

          // Mostrar mensaje de procesamiento en el contenedor de respuesta
          if (responseEl) {
            responseEl.textContent = "Procesando la reserva…";
            responseEl.className =
              "text-sm text-center mt-4 min-h-[24px] transition-all duration-300 text-slate-400";
          }
        } else {
          submitBtn.disabled = false;
          submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
          submitBtn.classList.add("hover:scale-[1.02]");

          if (btnText) btnText.textContent = "Reservar ahora";
          if (btnIcon) btnIcon.classList.remove("hidden");
          if (btnSpinner) btnSpinner.classList.add("hidden");
        }
      },
    };
  }

  // =========================================================================
  // Exportar globalmente
  // =========================================================================

  global.deoiaModalAdapter = { create };

  console.log("✅ DeoiaModalAdapter.js cargado (versión premium)");
})(window);
