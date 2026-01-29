<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deoia - Sistema de Reservas Inteligente</title>
    
    <?php wp_head(); ?> 
</head>
<body <?php body_class( 'bg-slate-50 antialiased' ); ?>>

    <!-- ═══════════════════════════════════════════════════════════════════════
         NAVBAR FLOTANTE (oculto por defecto, aparece al hacer scroll)
    ════════════════════════════════════════════════════════════════════════ -->
    <nav id="deoia-navbar" class="fixed top-0 left-0 right-0 z-50 py-4 -translate-y-full opacity-0 transition-all duration-300 pointer-events-none">
        <div class="w-full flex items-center justify-between bg-white/70 backdrop-blur-xl px-[15px] py-3 shadow-lg shadow-slate-200/50 border-b border-white/50">
            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 group">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="w-8 h-8 rounded-xl overflow-hidden shadow-lg transition-all duration-300" style="box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                        <?php 
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo_image = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                            'class' => 'w-full h-full object-cover',
                        ) );
                        echo $logo_image;
                        ?>
                    </div>
                <?php else : ?>
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shadow-lg transition-all duration-300" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <span class="text-lg font-bold" style="color: var(--deoia-bg-card);"><?php bloginfo( 'name' ); ?></span>
            </a>

            <!-- CTA Button -->
            <a href="#reservar" id="deoia-navbar-cta" class="inline-flex items-center gap-1 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg hover:scale-105 transition-all duration-300" style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Agendar Cita
            </a>
        </div>
    </nav>
