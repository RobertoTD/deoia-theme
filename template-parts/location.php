<!-- ═══════════════════════════════════════════════════════════════════════
     SECCIÓN UBICACIÓN / DIRECCIÓN
════════════════════════════════════════════════════════════════════════ -->
<?php
/**
 * Sección de Ubicación - Deoia Citas
 * 
 * Valores editables desde Apariencia > Personalizar > DEOIA Branding > Ubicación
 * - $location_address: Dirección completa
 * - $location_city: Ciudad y estado
 * - $location_postal: Código postal
 * - $location_reference: Referencia o punto cercano
 * - $location_hours: Horario de atención
 * - $maps_url: URL de Google Maps
 */

// ══════════════════════════════════════════════════════════════════════
// VALORES DESDE CUSTOMIZER
// ══════════════════════════════════════════════════════════════════════

$location_address   = get_theme_mod( 'deoia_location_address', 'Av. Principal 1234, Col. Centro' );
$location_city      = get_theme_mod( 'deoia_location_city', 'Ciudad de México, CDMX' );
$location_postal    = get_theme_mod( 'deoia_location_postal', 'CP 06000' );
$location_reference = get_theme_mod( 'deoia_location_reference', 'A una cuadra del Metro Zócalo, frente al Parque Central' );
$location_hours     = get_theme_mod( 'deoia_location_hours', 'Lun - Sáb: 9:00 AM - 7:00 PM' );
$maps_url           = get_theme_mod( 'deoia_location_maps_url', 'https://maps.google.com/?q=19.4326,-99.1332' );
?>

<section class="py-16 lg:py-20 px-6" id="ubicacion">
    <div class="max-w-7xl mx-auto">
        
        <!-- Card principal -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-0">
                
                <!-- Columna izquierda: Mapa placeholder visual -->
                <div class="lg:col-span-2 relative min-h-[160px] lg:min-h-full" style="background-color: var(--deoia-bg-card-alt);">
                    
                    <!-- Patrón decorativo de fondo -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <defs>
                                <pattern id="grid-pattern" width="10" height="10" patternUnits="userSpaceOnUse">
                                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" style="color: var(--deoia-primary);"/>
                                </pattern>
                            </defs>
                            <rect width="100" height="100" fill="url(#grid-pattern)"/>
                        </svg>
                    </div>
                    
                    <!-- Pin central con animación -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative">
                            <!-- Círculo pulsante -->
                            <div class="absolute inset-0 w-20 h-20 rounded-full animate-ping opacity-20" style="background-color: var(--deoia-primary);"></div>
                            <div class="absolute inset-0 w-20 h-20 rounded-full opacity-30" style="background-color: var(--deoia-primary);"></div>
                            
                            <!-- Contenedor del pin -->
                            <div class="relative w-20 h-20 rounded-full flex items-center justify-center" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 30px -5px color-mix(in srgb, var(--deoia-primary) 50%, transparent);">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Badge inferior -->
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full" style="background-color: color-mix(in srgb, var(--deoia-bg-card) 80%, transparent); color: var(--deoia-muted);">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background-color: var(--deoia-success);"></span>
                            Abierto ahora
                        </div>
                    </div>
                </div>
                
                <!-- Columna derecha: Información -->
                <div class="lg:col-span-3 p-8 lg:p-12">
                    
                    <!-- Header -->
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-2 font-medium text-sm px-4 py-2 rounded-full mb-4" style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent); color: var(--deoia-primary);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Nuestra Ubicación
                        </span>
                        
                    </div>
                    
                    <!-- Información de ubicación -->
                    <div class="space-y-6 mb-8">
                        
                        <!-- Dirección -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent);">
                                <svg class="w-5 h-5" style="color: var(--deoia-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: var(--deoia-bg-card);">
                                    <?php echo esc_html( $location_address ); ?>
                                </p>
                                <p class="text-sm" style="color: var(--deoia-muted);">
                                    <?php echo esc_html( $location_city ); ?> · <?php echo esc_html( $location_postal ); ?>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Referencia -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent);">
                                <svg class="w-5 h-5" style="color: var(--deoia-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-sm" style="color: var(--deoia-muted-dark);">Referencia</p>
                                <p class="text-sm" style="color: var(--deoia-muted);">
                                    <?php echo esc_html( $location_reference ); ?>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Horario -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: color-mix(in srgb, var(--deoia-secondary) 15%, transparent);">
                                <svg class="w-5 h-5" style="color: var(--deoia-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-sm" style="color: var(--deoia-muted-dark);">Horario de atención</p>
                                <p class="text-sm" style="color: var(--deoia-muted);">
                                    <?php echo esc_html( $location_hours ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo esc_url( $maps_url ); ?>" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-2 text-white font-semibold px-6 py-3.5 rounded-2xl shadow-xl hover:scale-105 transition-all duration-300"
                           style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Ver en Google Maps
                        </a>
                        
                        <a href="#reservar" 
                           class="inline-flex items-center justify-center gap-2 font-semibold px-6 py-3.5 rounded-2xl hover:scale-105 transition-all duration-300"
                           style="background-color: color-mix(in srgb, var(--deoia-bg-card) 10%, white); color: var(--deoia-bg-card);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Agendar Cita
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</section>
