<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <?php wp_head(); ?> 
</head>
<body <?php body_class( 'antialiased' ); ?>>

    <!-- ═══════════════════════════════════════════════════════════════════════
         NAVBAR FLOTANTE
         - Theme base: CTA siempre visible
         - Con Deoia Demo Mode plugin: microcopy dinámico + CTA al final
    ════════════════════════════════════════════════════════════════════════ -->
    <nav id="deoia-navbar" class="fixed top-0 left-0 right-0 z-50 py-4 transition-all duration-300">
        <div class="w-full flex items-center justify-between bg-white/70 backdrop-blur-xl px-[15px] py-3 shadow-lg shadow-slate-200/50 border-b border-white/50">
            <!-- Logo (izquierda) -->
            <?php
            $deoia_show_title   = (bool) get_theme_mod( 'deoia_show_site_title', true );
            $deoia_isotipo_mode = (bool) get_theme_mod( 'deoia_use_isotipo_mode', true );
            $deoia_svg_logo_id  = get_theme_mod( 'deoia_svg_logo' );
            $deoia_svg_logo_url = $deoia_svg_logo_id ? wp_get_attachment_url( $deoia_svg_logo_id ) : '';
            $deoia_custom_logo_id = get_theme_mod( 'custom_logo' );
            $deoia_has_custom_logo = has_custom_logo();
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 group flex-shrink-0 min-w-0">

                <?php if ( $deoia_isotipo_mode ) : ?>
                    <!-- ══ MODO ISOTIPO: logo dentro del visor cuadrado con glow ══ -->
                    <?php if ( $deoia_svg_logo_url ) : ?>
                        <!-- Prioridad 1: SVG logo (isotipo) -->
                        <div class="w-10 h-10 md:w-8 md:h-8 rounded-xl flex items-center justify-center shadow-lg transition-all duration-300 flex-shrink-0" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                            <img src="<?php echo esc_url( $deoia_svg_logo_url ); ?>" class="w-5 h-5 md:w-4 md:h-4" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </div>
                    <?php elseif ( $deoia_has_custom_logo ) : ?>
                        <!-- Prioridad 2: WP Custom Logo (png/jpg) -->
                        <div class="w-10 h-10 md:w-8 md:h-8 rounded-xl overflow-hidden shadow-lg transition-all duration-300 flex-shrink-0" style="box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                            <?php echo wp_get_attachment_image( $deoia_custom_logo_id, 'full', false, array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        </div>
                    <?php else : ?>
                        <!-- Fallback: icono calendario -->
                        <div class="w-10 h-10 md:w-8 md:h-8 rounded-xl flex items-center justify-center shadow-lg transition-all duration-300 flex-shrink-0" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                            <svg class="w-5 h-5 md:w-4 md:h-4" style="color: var(--deoia-text-inverse);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>

                <?php else : ?>
                    <!-- ══ MODO LOCKUP: logo sin visor, height fijo ══ -->
                    <?php if ( $deoia_has_custom_logo ) : ?>
                        <!-- Prioridad 1: WP Custom Logo -->
                        <?php echo wp_get_attachment_image( $deoia_custom_logo_id, 'full', false, array( 'class' => 'h-8 md:h-7 w-auto object-contain flex-shrink-0 deoia-logo-lockup' ) ); ?>
                    <?php elseif ( $deoia_svg_logo_url ) : ?>
                        <!-- Prioridad 2: SVG logo -->
                        <img src="<?php echo esc_url( $deoia_svg_logo_url ); ?>" class="h-8 md:h-7 w-auto object-contain flex-shrink-0 deoia-logo-lockup" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php else : ?>
                        <!-- Fallback: icono calendario sin visor -->
                        <svg class="h-8 md:h-7 w-auto flex-shrink-0 deoia-logo-lockup" style="color: var(--deoia-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if ( $deoia_show_title ) : ?>
                    <span class="text-base md:text-lg font-bold leading-[1.1] max-w-[180px] md:max-w-none" style="color: var(--deoia-bg-card);"><?php bloginfo( 'name' ); ?></span>
                <?php endif; ?>

            </a>

            <!-- Slot derecho -->
            <div id="deoia-navbar-right" class="flex items-center">
                <!-- Mensaje Narrador (usado por Deoia Demo Mode plugin, vacío por defecto) -->
                <div id="deoia-navbar-message" class="text-right hidden">
                    <span class="inline-block text-sm font-medium transition-all duration-300" style="color: var(--deoia-muted-dark);"></span>
                </div>

                <!-- CTA Button (visible por defecto, el plugin lo controla si está activo) -->
                <a href="#reservar" id="deoia-navbar-cta" class="inline-flex items-center gap-0.5 md:gap-1 text-sm md:text-base font-semibold px-2.5 md:px-4 py-2.5 rounded-xl shadow-lg hover:scale-105 transition-all duration-300 whitespace-nowrap" style="color: var(--deoia-text-inverse); background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Agendar Cita
                </a>
            </div>
        </div>
    </nav>
