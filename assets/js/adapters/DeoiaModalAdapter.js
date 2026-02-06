/**
 * DeoiaModalAdapter - Adaptador premium de modal para WPAgenda
 *
 * Modal de confirmación con estilos Tailwind premium,
 * idénticos al prototipo del widget de reservas.
 *
 * Compatible con WPAgenda.registerModalAdapter().
 */

(function (global) {
  'use strict';

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
        <div class="deoia-modal-overlay fixed inset-0 bg-white/20 backdrop-blur-sm" style="z-index: 99998;"></div>
        
        <!-- Modal Container - z-index aún más alto -->
        <div class="deoia-modal fixed inset-0 flex items-center justify-center p-4" style="z-index: 99999;">
          <div class="deoia-modal-content rounded-3xl p-6 lg:p-8 shadow-2xl relative overflow-hidden w-full max-w-md transform transition-all duration-300 scale-100" style="background: linear-gradient(to bottom right, var(--deoia-bg-card), color-mix(in srgb, var(--deoia-bg-card) 80%, black)); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); border: 1px solid color-mix(in srgb, var(--deoia-border) 50%, transparent);">
            
            <!-- Decorative Glows -->
            <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background-color: var(--deoia-bg-glow-1); opacity: 0.2;"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background-color: var(--deoia-bg-glow-2); opacity: 0.2;"></div>
            
            <!-- Modal Content -->
            <div class="relative z-10">
              
              <!-- Close Button -->
              <button type="button" data-role="deoia-modal-close" class="absolute top-0 right-0 p-2 rounded-xl transition-all duration-200 deoia-close-btn" style="color: var(--deoia-muted);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
              
              <!-- Header -->
              <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary));">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <div>
                  <h3 class="text-xl text-white font-semibold">Confirmar Reserva</h3>
                  <p class="text-sm" style="color: var(--deoia-muted);">Completa tus datos</p>
                </div>
              </div>
              
              <!-- Reservation Summary -->
              <div class="rounded-2xl p-4 mb-6" style="background-color: color-mix(in srgb, var(--deoia-bg-card-alt) 50%, transparent); border: 1px solid color-mix(in srgb, var(--deoia-border) 50%, transparent);">
                <p class="text-xs uppercase tracking-wider mb-3" style="color: var(--deoia-muted);">Resumen de tu cita</p>
                <div class="space-y-2">
                  <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" style="color: var(--deoia-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white text-sm font-medium">${
                      servicio
                        ? String(servicio)
                            .replace(/^fixed::/, '')
                            .trim() || 'Servicio no especificado'
                        : 'Servicio no especificado'
                    }</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" style="color: var(--deoia-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white text-sm">${fecha || ''}</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" style="color: var(--deoia-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-white text-sm">${hora || ''}</span>
                  </div>
                </div>
              </div>
              
              <!-- Form -->
              <form data-role="deoia-modal-form" class="space-y-4">
                <!-- Nombre -->
                <div>
                  <label for="deoia-nombre" class="block text-sm mb-2" style="color: var(--deoia-muted);">Nombre completo</label>
                  <input 
                    type="text" 
                    id="deoia-nombre" 
                    name="nombre"
                    required
                    placeholder="Tu nombre"
                    class="w-full rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                    style="background-color: color-mix(in srgb, var(--deoia-bg-card-alt) 80%, transparent); border: 1px solid color-mix(in srgb, var(--deoia-border) 50%, transparent); color: var(--deoia-text); --tw-ring-color: color-mix(in srgb, var(--deoia-primary) 50%, transparent);"
                  >
                </div>
                
                <!-- Teléfono -->
                <div>
                  <label for="deoia-telefono" class="block text-sm mb-2" style="color: var(--deoia-muted);">Teléfono</label>
                  <input 
                    type="tel" 
                    id="deoia-telefono" 
                    name="telefono"
                    required
                    placeholder="Tu número de teléfono"
                    class="w-full rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                    style="background-color: color-mix(in srgb, var(--deoia-bg-card-alt) 80%, transparent); border: 1px solid color-mix(in srgb, var(--deoia-border) 50%, transparent); color: var(--deoia-text); --tw-ring-color: color-mix(in srgb, var(--deoia-primary) 50%, transparent);"
                  >
                </div>
                
                <!-- Correo -->
                <div>
                  <label for="deoia-correo" class="block text-sm mb-2" style="color: var(--deoia-muted);">Correo electrónico</label>
                  <input 
                    type="email" 
                    id="deoia-correo" 
                    name="correo"
                    required
                    placeholder="tu@correo.com"
                    class="w-full rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                    style="background-color: color-mix(in srgb, var(--deoia-bg-card-alt) 80%, transparent); border: 1px solid color-mix(in srgb, var(--deoia-border) 50%, transparent); color: var(--deoia-text); --tw-ring-color: color-mix(in srgb, var(--deoia-primary) 50%, transparent);"
                  >
                </div>
                
                <!-- Submit Button -->
                <button 
                  type="submit" 
                  data-role="deoia-modal-submit"
                  class="w-full text-white font-semibold py-4 rounded-2xl shadow-xl hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 mt-6 deoia-btn-primary"
                  style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);"
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
              <p class="text-center text-xs mt-4" style="color: var(--deoia-muted-dark);">
                Potenciado por <span class="font-medium" style="color: var(--deoia-accent);">Deoia</span>
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

      const nombre = modalEl.querySelector('#deoia-nombre').value.trim();
      const telefono = modalEl.querySelector('#deoia-telefono').value.trim();
      const correo = modalEl.querySelector('#deoia-correo').value.trim();

      // Validación
      if (!nombre || !telefono || !correo) {
        // Mostrar error visual en campos vacíos
        if (!nombre) highlightField('#deoia-nombre');
        if (!telefono) highlightField('#deoia-telefono');
        if (!correo) highlightField('#deoia-correo');
        return;
      }

      // Ejecutar callback - el callback es responsable de:
      // 1. Copiar datos al formulario original
      // 2. Disparar el submit del formulario original
      if (onSubmitCallback && typeof onSubmitCallback === 'function') {
        onSubmitCallback({ nombre, telefono, correo });
      } else {
        console.warn('[DeoiaModalAdapter] No se proporcionó callback onSubmit');
      }
    }

    /**
     * Resalta un campo con error.
     * @param {string} selector
     */
    function highlightField(selector) {
      const field = modalEl.querySelector(selector);
      if (!field) return;

      field.classList.add('ring-2', 'ring-red-500/50', 'border-red-500/50');

      // Remover después de 2 segundos
      setTimeout(() => {
        field.classList.remove('ring-2', 'ring-red-500/50', 'border-red-500/50');
      }, 2000);
    }

    /**
     * Cierra el modal con animación.
     */
    function closeWithAnimation() {
      if (!modalEl) return;

      const content = modalEl.querySelector('.deoia-modal-content');
      if (content) {
        content.classList.add('scale-95', 'opacity-0');
      }

      if (overlayEl) {
        overlayEl.classList.add('opacity-0');
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

      // Remover listener de evento de reserva procesada
      window.removeEventListener('aa:reservation:processed', handleReservationProcessed);

      // Restaurar visibilidad de #respuesta-agenda
      const respuestaAgenda = document.getElementById('respuesta-agenda');
      if (respuestaAgenda) {
        respuestaAgenda.style.display = '';
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
      document.body.style.overflow = '';
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
      if (e.key === 'Escape') {
        closeWithAnimation();
      }
    }

    /**
     * Maneja el evento aa:reservation:processed para mostrar éxito premium en el modal.
     * Oculta el formulario y renderiza el mensaje de confirmación con info de correo.
     * @param {CustomEvent} e
     */
    function handleReservationProcessed(e) {
      if (!modalEl) return;

      // Cancelar auto-redirect del plugin (flujo premium usa botón manual)
      e.preventDefault();

      const { correo, whatsappUrl } = e.detail || {};

      // Desconectar MutationObserver — el evento directo toma precedencia
      if (responseObserver) {
        responseObserver.disconnect();
        responseObserver = null;
      }

      // Ocultar el formulario del modal
      const formEl = modalEl.querySelector('[data-role="deoia-modal-form"]');
      if (formEl) formEl.style.display = 'none';

      // Fase 1: Mostrar spinner de procesamiento (1 segundo)
      if (responseEl) {
        responseEl.innerHTML = `
          <div class="flex flex-col items-center justify-center py-6">
            <svg class="w-10 h-10 animate-spin mb-3" style="color: var(--deoia-primary);" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-sm" style="color: var(--deoia-muted);">Procesando tu reserva…</p>
          </div>
        `;
        responseEl.className = 'text-sm text-center mt-4 transition-all duration-300';
      }

      // Fase 2: Después de 1s, mostrar éxito + botón "Continuar a WhatsApp"
      setTimeout(() => {
        if (!responseEl || !modalEl) return;

        const correoBlock = correo
          ? `<p class="mt-2" style="color: var(--deoia-text-secondary);">Te enviaremos un correo a <strong style="color: var(--deoia-text);">${correo}</strong> con los detalles.</p>
             <p style="color: var(--deoia-text-secondary);">Desde ese correo podrás confirmar tu asistencia con un clic.</p>
             <p class="text-xs mt-1" style="color: var(--deoia-muted);">Si no llega en 2–3 minutos, revisa Spam/Promociones.</p>`
          : '';

        responseEl.innerHTML = `
          <div class="space-y-2 py-2">
            <p class="text-base font-semibold" style="color: var(--deoia-success);">✅ Tu solicitud de reserva fue registrada.</p>
            ${correoBlock}
            <button
              type="button"
              data-role="deoia-whatsapp-btn"
              class="w-full text-white font-semibold py-4 rounded-2xl shadow-xl hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 mt-4 deoia-btn-primary"
              style="background-image: linear-gradient(135deg, #25D366, #128C7E); box-shadow: 0 10px 15px -3px rgba(37, 211, 102, 0.3);"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              Continuar a WhatsApp
            </button>
          </div>
        `;
        responseEl.className = 'text-sm text-center mt-4 transition-all duration-300';

        // Asignar click al botón de WhatsApp
        const waBtn = responseEl.querySelector('[data-role="deoia-whatsapp-btn"]');
        if (waBtn && whatsappUrl) {
          waBtn.addEventListener('click', () => {
            window.location.href = whatsappUrl;
          });
        }
      }, 1000);
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
        const wrapper = document.createElement('div');
        wrapper.innerHTML = buildModalHTML(options);

        overlayEl = wrapper.querySelector('.deoia-modal-overlay');
        modalEl = wrapper.querySelector('.deoia-modal');
        submitBtn = modalEl.querySelector('[data-role="deoia-modal-submit"]');
        responseEl = modalEl.querySelector('[data-role="deoia-response"]');

        // Insertar en el DOM
        document.body.appendChild(overlayEl);
        document.body.appendChild(modalEl);

        // Prevenir scroll del body
        document.body.style.overflow = 'hidden';

        // Ocultar #respuesta-agenda del plugin para evitar duplicados
        const respuestaAgenda = document.getElementById('respuesta-agenda');
        if (respuestaAgenda) {
          respuestaAgenda.style.display = 'none';
        }

        // Vaciar el contenedor de respuesta premium
        if (responseEl) {
          responseEl.textContent = '';
          responseEl.className =
            'text-sm text-center mt-4 min-h-[24px] transition-all duration-300';
        }

        // Configurar MutationObserver para capturar respuesta del plugin
        if (respuestaAgenda) {
          responseObserver = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
              if (mutation.type === 'childList' || mutation.type === 'characterData') {
                const texto = respuestaAgenda.textContent || respuestaAgenda.innerText;
                if (texto && texto.trim() && responseEl) {
                  // Detectar si es éxito o error
                  const isSuccess =
                    texto.includes('✅') || texto.toLowerCase().includes('correctamente');
                  const isError = texto.includes('❌') || texto.toLowerCase().includes('error');

                  // Aplicar estilos según el tipo de mensaje
                  if (isSuccess) {
                    responseEl.className =
                      'text-sm text-center mt-4 min-h-[24px] transition-all duration-300 deoia-response-success';
                    responseEl.style.color = 'var(--deoia-success)';
                  } else if (isError) {
                    responseEl.className =
                      'text-sm text-center mt-4 min-h-[24px] transition-all duration-300';
                    responseEl.style.color = 'var(--deoia-error)';
                  } else {
                    responseEl.className =
                      'text-sm text-center mt-4 min-h-[24px] transition-all duration-300';
                    responseEl.style.color = 'var(--deoia-text-secondary)';
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
            subtree: true
          });
        }

        // Event listeners
        overlayEl.addEventListener('click', handleOverlayClick);
        modalEl
          .querySelector('[data-role="deoia-modal-close"]')
          ?.addEventListener('click', closeWithAnimation);
        modalEl
          .querySelector('[data-role="deoia-modal-form"]')
          ?.addEventListener('submit', handleSubmit);
        document.addEventListener('keydown', handleEscapeKey);
        window.addEventListener('aa:reservation:processed', handleReservationProcessed);

        // Animación de entrada
        requestAnimationFrame(() => {
          const content = modalEl.querySelector('.deoia-modal-content');
          if (content) {
            content.classList.remove('scale-95', 'opacity-0');
          }
        });

        // Focus en el primer campo
        setTimeout(() => {
          modalEl.querySelector('#deoia-nombre')?.focus();
        }, 100);
      },

      /**
       * Cierra el modal y limpia el DOM.
       */
      close() {
        document.removeEventListener('keydown', handleEscapeKey);
        window.removeEventListener('aa:reservation:processed', handleReservationProcessed);
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
          submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
          submitBtn.classList.remove('hover:scale-[1.02]');

          if (btnText) btnText.textContent = 'Procesando...';
          if (btnIcon) btnIcon.classList.add('hidden');
          if (btnSpinner) btnSpinner.classList.remove('hidden');

          // Mostrar mensaje de procesamiento en el contenedor de respuesta
          if (responseEl) {
            responseEl.textContent = 'Procesando la reserva…';
            responseEl.className =
              'text-sm text-center mt-4 min-h-[24px] transition-all duration-300';
            responseEl.style.color = 'var(--deoia-muted)';
          }
        } else {
          submitBtn.disabled = false;
          submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
          submitBtn.classList.add('hover:scale-[1.02]');

          if (btnText) btnText.textContent = 'Reservar ahora';
          if (btnIcon) btnIcon.classList.remove('hidden');
          if (btnSpinner) btnSpinner.classList.add('hidden');
        }
      }
    };
  }

  // =========================================================================
  // Exportar globalmente
  // =========================================================================

  global.deoiaModalAdapter = { create };

  console.log('✅ DeoiaModalAdapter.js cargado (versión premium)');
})(window);
