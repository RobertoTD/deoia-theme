<?php

/**
 * Configuración del tema
 */
function deoia_theme_setup() {
    // Soporte para logo personalizado (WaaS)
    add_theme_support( 'custom-logo', array(
        'height'               => 36,
        'width'                => 36,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => false,
    ) );

    // Soporte para título del sitio
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'deoia_theme_setup' );

/**
 * Permitir subida de archivos SVG solo para administradores
 */
add_filter( 'upload_mimes', function( $mimes ) {
    if ( current_user_can( 'manage_options' ) ) {
        $mimes['svg'] = 'image/svg+xml';
    }
    return $mimes;
} );

/**
 * Sanitización para el control Logo SVG (attachment ID).
 * Solo acepta attachments cuyo mime sea image/svg+xml.
 */
function deoia_sanitize_svg_attachment( $attachment_id ) {
    $attachment_id = absint( $attachment_id );
    if ( ! $attachment_id ) {
        return '';
    }
    $mime = get_post_mime_type( $attachment_id );
    if ( 'image/svg+xml' !== $mime ) {
        return '';
    }
    return $attachment_id;
}

/**
 * Sanitización para rango de opacidad del patrón (0–100)
 */
function deoia_sanitize_opacity_range( $value ) {
    $value = absint( $value );
    return max( 0, min( 100, $value ) );
}

/**
 * Sanitización para blend mode del patrón
 */
function deoia_sanitize_blend_mode( $value ) {
    $valid = array( 'normal', 'multiply', 'overlay', 'soft-light', 'screen', 'darken', 'lighten' );
    return in_array( $value, $valid, true ) ? $value : 'normal';
}

/**
 * Sanitización para color base del patrón (clave de variable CSS o vacío)
 */
function deoia_sanitize_pattern_color( $value ) {
    $valid = array( '', 'primary', 'secondary', 'accent', 'muted', 'muted-light', 'muted-dark' );
    return in_array( $value, $valid, true ) ? $value : '';
}

/**
 * Personalizador: Logo SVG + Redes Sociales
 */
function deoia_customize_register( $wp_customize ) {
    // ── Logo SVG (dentro del marco del navbar) ──────────────────────────────
    $wp_customize->add_setting( 'deoia_svg_logo', array(
        'default'           => '',
        'sanitize_callback' => 'deoia_sanitize_svg_attachment',
    ) );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'deoia_svg_logo', array(
        'label'       => __( 'Logo SVG', 'deoia' ),
        'description' => __( 'Sube un archivo SVG. Se muestra dentro del marco del navbar cuando no hay Custom Logo.', 'deoia' ),
        'section'     => 'title_tagline',
        'mime_type'   => 'image/svg+xml',
        'priority'    => 9,
    ) ) );

    // Twitter URL
    $wp_customize->add_setting( 'twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'twitter_url', array(
        'label'       => __( 'URL de Twitter / X', 'deoia' ),
        'section'     => 'title_tagline',
        'type'        => 'url',
        'priority'    => 50,
    ) );

    // Instagram URL
    $wp_customize->add_setting( 'instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'instagram_url', array(
        'label'       => __( 'URL de Instagram', 'deoia' ),
        'section'     => 'title_tagline',
        'type'        => 'url',
        'priority'    => 51,
    ) );

    // LinkedIn URL
    $wp_customize->add_setting( 'linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'linkedin_url', array(
        'label'       => __( 'URL de LinkedIn', 'deoia' ),
        'section'     => 'title_tagline',
        'type'        => 'url',
        'priority'    => 52,
    ) );
}
add_action( 'customize_register', 'deoia_customize_register' );

/**
 * ════════════════════════════════════════════════════════════════════════════
 * DEOIA Identity Section - Customizer Controls
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Registrar controles de identidad visual del header
 */
function deoia_identity_customizer( $wp_customize ) {

    // ═══════════════════════════════════════════════════════════════════════
    // SECTION: Identidad de Marca
    // ═══════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'deoia_identity', array(
        'title'       => __( 'Identidad de Marca', 'deoia' ),
        'panel'       => 'deoia_branding',
        'priority'    => 5,
        'description' => __( 'Controla cómo se muestra el logo y el nombre del sitio en el header.', 'deoia' ),
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Toggle: Mostrar título del sitio en header
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_show_site_title', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_show_site_title', array(
        'label'       => __( 'Mostrar título del sitio en header', 'deoia' ),
        'description' => __( 'Muestra el nombre del sitio junto al logo en la barra de navegación.', 'deoia' ),
        'section'     => 'deoia_identity',
        'type'        => 'checkbox',
        'priority'    => 10,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Toggle: Usar modo isotipo (logo en visor)
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_use_isotipo_mode', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_use_isotipo_mode', array(
        'label'       => __( 'Usar modo isotipo (logo en visor)', 'deoia' ),
        'description' => __( 'ON: muestra el logo dentro del visor cuadrado con glow y fondo degradado. OFF: muestra el logo sin visor, como lockup horizontal.', 'deoia' ),
        'section'     => 'deoia_identity',
        'type'        => 'checkbox',
        'priority'    => 20,
    ) );
}
add_action( 'customize_register', 'deoia_identity_customizer' );

/**
 * Personalizador: Hero Section
 */
function deoia_hero_customizer( $wp_customize ) {
    // Sección: Configuración del Hero
    $wp_customize->add_section( 'hero_settings', array(
        'title'       => __( 'Configuración del Hero', 'deoia' ),
        'priority'    => 30,
        'description' => __( 'Personaliza los textos y métricas de la sección principal.', 'deoia' ),
    ) );

    // Badge Text
    $wp_customize->add_setting( 'hero_badge_text', array(
        'default'           => 'Sistema de Reservas #1',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_badge_text', array(
        'label'    => __( 'Texto del Badge', 'deoia' ),
        'section'  => 'hero_settings',
        'type'     => 'text',
        'priority' => 10,
    ) );

    // Headline Principal
    $wp_customize->add_setting( 'hero_headline_main', array(
        'default'           => 'Automatiza tu agenda y',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_headline_main', array(
        'label'    => __( 'Título Principal (línea 1)', 'deoia' ),
        'section'  => 'hero_settings',
        'type'     => 'text',
        'priority' => 20,
    ) );

    // Headline Accent (con gradiente)
    $wp_customize->add_setting( 'hero_headline_accent', array(
        'default'           => 'multiplica tus ingresos',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_headline_accent', array(
        'label'    => __( 'Título Destacado (con gradiente)', 'deoia' ),
        'section'  => 'hero_settings',
        'type'     => 'text',
        'priority' => 30,
    ) );

    // Subheadline
    $wp_customize->add_setting( 'hero_subheadline', array(
        'default'           => 'Olvídate de las llamadas perdidas y las citas olvidadas. Deja que tus clientes reserven 24/7 mientras tú te enfocas en lo que mejor haces.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'hero_subheadline', array(
        'label'    => __( 'Subtítulo / Descripción', 'deoia' ),
        'section'  => 'hero_settings',
        'type'     => 'textarea',
        'priority' => 40,
    ) );

    // CTA Botón Principal
    $wp_customize->add_setting( 'hero_cta_text_1', array(
        'default'           => 'Comenzar Gratis',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_cta_text_1', array(
        'label'    => __( 'Texto Botón Principal', 'deoia' ),
        'section'  => 'hero_settings',
        'type'     => 'text',
        'priority' => 50,
    ) );

    // Métrica: Negocios Activos
    $wp_customize->add_setting( 'hero_trust_count', array(
        'default'           => '2,500',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_trust_count', array(
        'label'       => __( 'Número de Negocios Activos', 'deoia' ),
        'description' => __( 'Ej: 2,500', 'deoia' ),
        'section'     => 'hero_settings',
        'type'        => 'text',
        'priority'    => 60,
    ) );

    // Mostrar signo + en negocios activos
    $wp_customize->add_setting( 'hero_trust_show_plus', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'hero_trust_show_plus', array(
        'label'    => __( 'Mostrar signo + antes del número', 'deoia' ),
        'section'  => 'hero_settings',
        'type'     => 'checkbox',
        'priority' => 65,
    ) );

    // Sufijo/texto después del indicador
    $wp_customize->add_setting( 'hero_trust_suffix', array(
        'default'           => 'negocios activos',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_trust_suffix', array(
        'label'       => __( 'Texto después del indicador (sufijo)', 'deoia' ),
        'description' => __( 'Ej: negocios activos. Vacío = ocultar.', 'deoia' ),
        'section'     => 'hero_settings',
        'type'        => 'text',
        'priority'    => 66,
    ) );

    // Métrica: Reseñas
    $wp_customize->add_setting( 'hero_review_count', array(
        'default'           => '850',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_review_count', array(
        'label'       => __( 'Número de Reseñas', 'deoia' ),
        'description' => __( 'Ej: 850', 'deoia' ),
        'section'     => 'hero_settings',
        'type'        => 'text',
        'priority'    => 70,
    ) );

    // Mostrar calendario en Hero
    $wp_customize->add_setting( 'deoia_show_calendar_in_hero', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'deoia_show_calendar_in_hero', array(
        'label'       => __( 'Mostrar calendario en Hero', 'deoia' ),
        'description' => __( 'Activa para mostrar el widget de reservas en la sección hero de la página principal.', 'deoia' ),
        'section'     => 'hero_settings',
        'type'        => 'checkbox',
        'priority'    => 80,
    ) );
}
add_action( 'customize_register', 'deoia_hero_customizer' );

/**
 * ════════════════════════════════════════════════════════════════════════════
 * DEOIA Premium Palette System - Customizer Controls
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Definición de presets de paletas por industria
 */
function deoia_get_palette_presets() {
    return array(
        'deoia-default' => array(
            'name'      => 'DEOIA Default',
            'primary'   => '#8B5CF6',   // violet-500
            'secondary' => '#6366F1',   // indigo-500
            'accent'    => '#F472B6',   // pink-400
            'bg_card'   => '#0F172A',   // slate-900
            'glow_1'    => '#8B5CF6',   // violet-500
            'glow_2'    => '#6366F1',   // indigo-500
        ),
        'consultorios' => array(
            'name'      => 'Consultorios Médicos',
            'primary'   => '#0EA5E9',   // sky-500 - confianza médica
            'secondary' => '#0284C7',   // sky-600
            'accent'    => '#22D3EE',   // cyan-400
            'bg_card'   => '#0C1425',   // slate oscuro azulado
            'glow_1'    => '#0EA5E9',   // sky-500
            'glow_2'    => '#0284C7',   // sky-600
        ),
        'psicologos' => array(
            'name'      => 'Psicólogos / Terapeutas',
            'primary'   => '#10B981',   // emerald-500 - calma y bienestar
            'secondary' => '#059669',   // emerald-600
            'accent'    => '#34D399',   // emerald-400
            'bg_card'   => '#0A1612',   // slate oscuro verdoso
            'glow_1'    => '#10B981',   // emerald-500
            'glow_2'    => '#059669',   // emerald-600
        ),
        'despachos' => array(
            'name'      => 'Despachos / Abogados',
            'primary'   => '#64748B',   // slate-500 - profesionalismo
            'secondary' => '#475569',   // slate-600
            'accent'    => '#F59E0B',   // amber-500 - distinción
            'bg_card'   => '#0F1419',   // slate muy oscuro
            'glow_1'    => '#64748B',   // slate-500
            'glow_2'    => '#475569',   // slate-600
        ),
        'estetica-mujeres' => array(
            'name'      => 'Estética / Belleza',
            'primary'   => '#EC4899',   // pink-500 - femenino elegante
            'secondary' => '#DB2777',   // pink-600
            'accent'    => '#F9A8D4',   // pink-300
            'bg_card'   => '#1A0A12',   // slate oscuro rosado
            'glow_1'    => '#EC4899',   // pink-500
            'glow_2'    => '#DB2777',   // pink-600
        ),
        'barberias' => array(
            'name'      => 'Barberías',
            'primary'   => '#F97316',   // orange-500 - masculino vibrante
            'secondary' => '#EA580C',   // orange-600
            'accent'    => '#FBBF24',   // amber-400
            'bg_card'   => '#1A1008',   // slate oscuro anaranjado
            'glow_1'    => '#F97316',   // orange-500
            'glow_2'    => '#EA580C',   // orange-600
        ),
    );
}

/**
 * Registrar controles del Customizer para paletas DEOIA
 */
function deoia_palette_customizer( $wp_customize ) {
    $presets = deoia_get_palette_presets();
    $default_preset = $presets['deoia-default'];

    // ═══════════════════════════════════════════════════════════════════════
    // PANEL: DEOIA Branding
    // ═══════════════════════════════════════════════════════════════════════
    $wp_customize->add_panel( 'deoia_branding', array(
        'title'       => __( 'DEOIA Branding', 'deoia' ),
        'priority'    => 25,
        'description' => __( 'Personaliza la paleta de colores del sistema de reservas premium.', 'deoia' ),
    ) );

    // ═══════════════════════════════════════════════════════════════════════
    // SECTION: Paleta de Colores
    // ═══════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'deoia_palette', array(
        'title'       => __( 'Paleta de Colores', 'deoia' ),
        'panel'       => 'deoia_branding',
        'priority'    => 10,
        'description' => __( 'Selecciona un preset o personaliza los colores individualmente.', 'deoia' ),
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Preset Selector (Dropdown)
    // ─────────────────────────────────────────────────────────────────────────
    $preset_choices = array();
    foreach ( $presets as $key => $preset ) {
        $preset_choices[ $key ] = $preset['name'];
    }

    $wp_customize->add_setting( 'deoia_palette_preset', array(
        'default'           => 'deoia-default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_palette_preset', array(
        'label'       => __( 'Preset de Industria', 'deoia' ),
        'description' => __( 'Selecciona un preset predefinido. Al cambiar, los colores se actualizarán automáticamente.', 'deoia' ),
        'section'     => 'deoia_palette',
        'type'        => 'select',
        'choices'     => $preset_choices,
        'priority'    => 5,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Color Primario
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_primary', array(
        'default'           => $default_preset['primary'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_primary', array(
        'label'       => __( 'Color Primario', 'deoia' ),
        'description' => __( 'Color principal para botones, elementos activos y gradientes.', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 10,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Color Secundario
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_secondary', array(
        'default'           => $default_preset['secondary'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_secondary', array(
        'label'       => __( 'Color Secundario', 'deoia' ),
        'description' => __( 'Color secundario para gradientes y elementos complementarios.', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 20,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Color de Acento
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_accent', array(
        'default'           => $default_preset['accent'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_accent', array(
        'label'       => __( 'Color de Acento', 'deoia' ),
        'description' => __( 'Color para badges, íconos destacados y detalles.', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 30,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Fondo de Tarjeta
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_bg_card', array(
        'default'           => $default_preset['bg_card'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_bg_card', array(
        'label'       => __( 'Fondo de Tarjeta Premium', 'deoia' ),
        'description' => __( 'Color de fondo para el widget de reservas.', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 40,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Glow 1
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_glow_1', array(
        'default'           => $default_preset['glow_1'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_glow_1', array(
        'label'       => __( 'Color Glow Superior', 'deoia' ),
        'description' => __( 'Color del efecto de brillo decorativo superior.', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 50,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Glow 2
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_glow_2', array(
        'default'           => $default_preset['glow_2'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_glow_2', array(
        'label'       => __( 'Color Glow Inferior', 'deoia' ),
        'description' => __( 'Color del efecto de brillo decorativo inferior.', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 60,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Color de Fondo del Sitio
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_bg_site', array(
        'default'           => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_bg_site', array(
        'label'       => __( 'Color de fondo del sitio', 'deoia' ),
        'description' => __( 'Color de fondo principal del sitio (body).', 'deoia' ),
        'section'     => 'deoia_palette',
        'priority'    => 70,
    ) ) );
}
add_action( 'customize_register', 'deoia_palette_customizer' );

/**
 * ════════════════════════════════════════════════════════════════════════════
 * DEOIA Text Colors Section - Customizer Controls
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Registrar controles del Customizer para colores de texto DEOIA
 */
function deoia_text_colors_customizer( $wp_customize ) {

    // ═══════════════════════════════════════════════════════════════════════
    // SECTION: Colores de Texto
    // ═══════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'deoia_text_colors', array(
        'title'       => __( 'Colores de Texto', 'deoia' ),
        'panel'       => 'deoia_branding',
        'priority'    => 20,
        'description' => __( 'Personaliza los colores de texto del sitio para adaptarlos al branding de tu negocio.', 'deoia' ),
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Texto Principal
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_text', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_text', array(
        'label'       => __( 'Texto Principal', 'deoia' ),
        'description' => __( 'Color de texto principal para fondos oscuros (footer, widget de reservas).', 'deoia' ),
        'section'     => 'deoia_text_colors',
        'priority'    => 10,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Texto Secundario
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_text_secondary', array(
        'default'           => '#e2e8f0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_text_secondary', array(
        'label'       => __( 'Texto Secundario', 'deoia' ),
        'description' => __( 'Color para textos complementarios y descripciones en fondos oscuros.', 'deoia' ),
        'section'     => 'deoia_text_colors',
        'priority'    => 20,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Texto Atenuado
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_muted', array(
        'default'           => '#94a3b8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_muted', array(
        'label'       => __( 'Texto Atenuado', 'deoia' ),
        'description' => __( 'Color para texto de menor importancia, placeholders y ayuda (fondos oscuros).', 'deoia' ),
        'section'     => 'deoia_text_colors',
        'priority'    => 30,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Texto Atenuado en Superficies Claras
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_muted_light', array(
        'default'           => '#64748b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_muted_light', array(
        'label'       => __( 'Texto Atenuado en Superficies Claras', 'deoia' ),
        'description' => __( 'Color para texto atenuado en cards blancas (ubicación, servicios, microcopy).', 'deoia' ),
        'section'     => 'deoia_text_colors',
        'priority'    => 35,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Texto Etiquetas / Metadata
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_muted_dark', array(
        'default'           => '#64748b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_muted_dark', array(
        'label'       => __( 'Texto Etiquetas / Metadata', 'deoia' ),
        'description' => __( 'Color para etiquetas, subtítulos y texto descriptivo en fondos claros.', 'deoia' ),
        'section'     => 'deoia_text_colors',
        'priority'    => 40,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Texto Invertido (Botones)
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_color_text_inverse', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deoia_color_text_inverse', array(
        'label'       => __( 'Texto Invertido (Botones)', 'deoia' ),
        'description' => __( 'Color del texto sobre botones de acción y fondos con gradiente.', 'deoia' ),
        'section'     => 'deoia_text_colors',
        'priority'    => 50,
    ) ) );
}
add_action( 'customize_register', 'deoia_text_colors_customizer' );

/**
 * ════════════════════════════════════════════════════════════════════════════
 * DEOIA Location Section - Customizer Controls
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Registrar controles del Customizer para la sección de ubicación
 */
function deoia_location_customizer( $wp_customize ) {
    // ═══════════════════════════════════════════════════════════════════════
    // SECTION: Ubicación
    // ═══════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'deoia_location', array(
        'title'       => __( 'Ubicación', 'deoia' ),
        'panel'       => 'deoia_branding',
        'priority'    => 40,
        'description' => __( 'Configura los datos de ubicación y horarios de tu negocio.', 'deoia' ),
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Dirección
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_location_address', array(
        'default'           => 'Av. Principal 1234, Col. Centro',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_location_address', array(
        'label'       => __( 'Dirección', 'deoia' ),
        'description' => __( 'Dirección completa de tu negocio.', 'deoia' ),
        'section'     => 'deoia_location',
        'type'        => 'text',
        'priority'    => 10,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Ciudad
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_location_city', array(
        'default'           => 'Ciudad de México, CDMX',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_location_city', array(
        'label'       => __( 'Ciudad', 'deoia' ),
        'description' => __( 'Ciudad y estado.', 'deoia' ),
        'section'     => 'deoia_location',
        'type'        => 'text',
        'priority'    => 20,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Código Postal
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_location_postal', array(
        'default'           => 'CP 06000',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_location_postal', array(
        'label'       => __( 'Código Postal', 'deoia' ),
        'description' => __( 'Código postal (ej: CP 06000).', 'deoia' ),
        'section'     => 'deoia_location',
        'type'        => 'text',
        'priority'    => 30,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Referencia
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_location_reference', array(
        'default'           => 'A una cuadra del Metro Zócalo, frente al Parque Central',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_location_reference', array(
        'label'       => __( 'Referencias', 'deoia' ),
        'description' => __( 'Punto de referencia o cómo llegar.', 'deoia' ),
        'section'     => 'deoia_location',
        'type'        => 'textarea',
        'priority'    => 40,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: Horario
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_location_hours', array(
        'default'           => 'Lun - Sáb: 9:00 AM - 7:00 PM',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_location_hours', array(
        'label'       => __( 'Horario de Atención', 'deoia' ),
        'description' => __( 'Horario de tu negocio.', 'deoia' ),
        'section'     => 'deoia_location',
        'type'        => 'text',
        'priority'    => 50,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Control: URL de Google Maps
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_location_maps_url', array(
        'default'           => 'https://maps.google.com/?q=19.4326,-99.1332',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_location_maps_url', array(
        'label'       => __( 'URL de Google Maps', 'deoia' ),
        'description' => __( 'Enlace a tu ubicación en Google Maps.', 'deoia' ),
        'section'     => 'deoia_location',
        'type'        => 'url',
        'priority'    => 60,
    ) );
}
add_action( 'customize_register', 'deoia_location_customizer' );

/**
 * ════════════════════════════════════════════════════════════════════════════
 * DEOIA Background Pattern (SVG) - Customizer Controls
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Registrar controles del Customizer para patrón de fondo SVG
 */
function deoia_bg_pattern_customizer( $wp_customize ) {

    // ═══════════════════════════════════════════════════════════════════════
    // SECTION: Patrón de Fondo (SVG)
    // ═══════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'deoia_bg_pattern', array(
        'title'       => __( 'Patrón de Fondo (SVG)', 'deoia' ),
        'panel'       => 'deoia_branding',
        'priority'    => 15,
        'description' => __( 'Agrega un patrón SVG sutil como textura de fondo del sitio. Si está desactivado o sin SVG, el fondo se mantiene como color sólido.', 'deoia' ),
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Toggle: Activar patrón de fondo
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_bg_pattern_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_bg_pattern_enabled', array(
        'label'       => __( 'Activar patrón de fondo', 'deoia' ),
        'description' => __( 'Habilita un patrón SVG repetible como textura sutil sobre el color de fondo del sitio.', 'deoia' ),
        'section'     => 'deoia_bg_pattern',
        'type'        => 'checkbox',
        'priority'    => 10,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Media: Subir SVG de patrón
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_bg_pattern_svg', array(
        'default'           => '',
        'sanitize_callback' => 'deoia_sanitize_svg_attachment',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'deoia_bg_pattern_svg', array(
        'label'       => __( 'SVG del Patrón', 'deoia' ),
        'description' => __( 'Sube un archivo SVG tileable. Recomendación: patrones de heropatterns.com o svgbackgrounds.com.', 'deoia' ),
        'section'     => 'deoia_bg_pattern',
        'mime_type'   => 'image/svg+xml',
        'priority'    => 20,
    ) ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Range: Intensidad / Opacidad (0–100)
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_bg_pattern_opacity', array(
        'default'           => 5,
        'sanitize_callback' => 'deoia_sanitize_opacity_range',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_bg_pattern_opacity', array(
        'label'       => __( 'Intensidad del patrón (%)', 'deoia' ),
        'description' => __( 'Controla la opacidad del patrón. Valores bajos (3–8) dan un efecto sutil.', 'deoia' ),
        'section'     => 'deoia_bg_pattern',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
        'priority'    => 30,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Select: Modo de mezcla
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_bg_pattern_blend', array(
        'default'           => 'normal',
        'sanitize_callback' => 'deoia_sanitize_blend_mode',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_bg_pattern_blend', array(
        'label'       => __( 'Modo de mezcla', 'deoia' ),
        'description' => __( 'Cómo se mezcla el patrón con el fondo. Normal es la opción más segura.', 'deoia' ),
        'section'     => 'deoia_bg_pattern',
        'type'        => 'select',
        'choices'     => array(
            'normal'     => __( 'Normal', 'deoia' ),
            'multiply'   => __( 'Multiply', 'deoia' ),
            'overlay'    => __( 'Overlay', 'deoia' ),
            'soft-light' => __( 'Soft Light', 'deoia' ),
            'screen'     => __( 'Screen', 'deoia' ),
            'darken'     => __( 'Darken', 'deoia' ),
            'lighten'    => __( 'Lighten', 'deoia' ),
        ),
        'priority'    => 40,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Select: Color base del patrón (usar CSS vars del theme)
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_bg_pattern_color', array(
        'default'           => '',
        'sanitize_callback' => 'deoia_sanitize_pattern_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_bg_pattern_color', array(
        'label'       => __( 'Color base del patrón', 'deoia' ),
        'description' => __( 'Tiñe el patrón con un color del theme. "Original" respeta los colores propios del SVG.', 'deoia' ),
        'section'     => 'deoia_bg_pattern',
        'type'        => 'select',
        'choices'     => array(
            ''            => __( 'Original (colores del SVG)', 'deoia' ),
            'primary'     => __( 'Primario (--deoia-primary)', 'deoia' ),
            'secondary'   => __( 'Secundario (--deoia-secondary)', 'deoia' ),
            'accent'      => __( 'Acento (--deoia-accent)', 'deoia' ),
            'muted'       => __( 'Muted (--deoia-muted)', 'deoia' ),
            'muted-light' => __( 'Muted Light (--deoia-muted-light)', 'deoia' ),
            'muted-dark'  => __( 'Muted Dark (--deoia-muted-dark)', 'deoia' ),
        ),
        'priority'    => 50,
    ) );

    // ─────────────────────────────────────────────────────────────────────────
    // Number: Tamaño del tile (px)
    // ─────────────────────────────────────────────────────────────────────────
    $wp_customize->add_setting( 'deoia_bg_pattern_size', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'deoia_bg_pattern_size', array(
        'label'       => __( 'Tamaño del tile (px)', 'deoia' ),
        'description' => __( '0 = tamaño natural del SVG. Ajusta para escalar el patrón.', 'deoia' ),
        'section'     => 'deoia_bg_pattern',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 1000,
            'step' => 10,
        ),
        'priority'    => 60,
    ) );
}
add_action( 'customize_register', 'deoia_bg_pattern_customizer' );

/**
 * Generar CSS dinámico con las variables de paleta
 * Usa html:root para mayor especificidad que :root de Tailwind
 */
function deoia_output_palette_css() {
    $presets = deoia_get_palette_presets();
    $selected_preset = get_theme_mod( 'deoia_palette_preset', 'deoia-default' );
    $defaults = isset( $presets[ $selected_preset ] ) ? $presets[ $selected_preset ] : $presets['deoia-default'];

    // Obtener valores del Customizer con fallback al preset
    $primary   = get_theme_mod( 'deoia_color_primary', $defaults['primary'] );
    $secondary = get_theme_mod( 'deoia_color_secondary', $defaults['secondary'] );
    $accent    = get_theme_mod( 'deoia_color_accent', $defaults['accent'] );
    $bg_card   = get_theme_mod( 'deoia_color_bg_card', $defaults['bg_card'] );
    $glow_1    = get_theme_mod( 'deoia_color_glow_1', $defaults['glow_1'] );
    $glow_2    = get_theme_mod( 'deoia_color_glow_2', $defaults['glow_2'] );

    // Obtener colores de texto con fallback a defaults de input.css
    $text           = get_theme_mod( 'deoia_color_text', '#ffffff' );
    $text_secondary = get_theme_mod( 'deoia_color_text_secondary', '#e2e8f0' );
    $muted          = get_theme_mod( 'deoia_color_muted', '#94a3b8' );
    $muted_light    = get_theme_mod( 'deoia_color_muted_light', '#64748b' );
    $muted_dark     = get_theme_mod( 'deoia_color_muted_dark', '#64748b' );
    $text_inverse   = get_theme_mod( 'deoia_color_text_inverse', '#ffffff' );
    $bg_site        = get_theme_mod( 'deoia_color_bg_site', '#f8fafc' );

    ?>
    <style id="deoia-palette-css">
        html:root {
            --deoia-primary: <?php echo esc_attr( $primary ); ?>;
            --deoia-secondary: <?php echo esc_attr( $secondary ); ?>;
            --deoia-accent: <?php echo esc_attr( $accent ); ?>;
            --deoia-bg-card: <?php echo esc_attr( $bg_card ); ?>;
            --deoia-bg-glow-1: <?php echo esc_attr( $glow_1 ); ?>;
            --deoia-bg-glow-2: <?php echo esc_attr( $glow_2 ); ?>;
            --deoia-text: <?php echo esc_attr( $text ); ?>;
            --deoia-text-secondary: <?php echo esc_attr( $text_secondary ); ?>;
            --deoia-muted: <?php echo esc_attr( $muted ); ?>;
            --deoia-muted-light: <?php echo esc_attr( $muted_light ); ?>;
            --deoia-muted-dark: <?php echo esc_attr( $muted_dark ); ?>;
            --deoia-text-inverse: <?php echo esc_attr( $text_inverse ); ?>;
            --deoia-bg-site: <?php echo esc_attr( $bg_site ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_footer', 'deoia_output_palette_css', 1 );

/**
 * Generar CSS del patrón de fondo SVG (solo si está habilitado y hay SVG)
 * Usa body::before con position:fixed + z-index:-1 para colocar el patrón
 * entre el background-color del body y todo el contenido, sin romper layouts.
 * Requiere body { position:relative; z-index:0 } para crear stacking context.
 */
function deoia_output_bg_pattern_css() {
    // Bail early si no está habilitado
    $enabled = get_theme_mod( 'deoia_bg_pattern_enabled', false );
    if ( ! $enabled ) {
        return;
    }

    // Obtener el attachment del SVG
    $svg_id = get_theme_mod( 'deoia_bg_pattern_svg', '' );
    if ( empty( $svg_id ) ) {
        return;
    }

    // Verificar que es SVG válido
    $mime = get_post_mime_type( $svg_id );
    if ( 'image/svg+xml' !== $mime ) {
        return;
    }

    $svg_url = wp_get_attachment_url( $svg_id );
    if ( ! $svg_url ) {
        return;
    }

    // Obtener settings
    $opacity   = get_theme_mod( 'deoia_bg_pattern_opacity', 5 );
    $blend     = get_theme_mod( 'deoia_bg_pattern_blend', 'normal' );
    $color_key = get_theme_mod( 'deoia_bg_pattern_color', '' );
    $tile_size = get_theme_mod( 'deoia_bg_pattern_size', 0 );

    // Calcular valores CSS
    $opacity_css = number_format( max( 0, min( 100, absint( $opacity ) ) ) / 100, 2 );
    $svg_url_esc = esc_url( $svg_url );
    $blend_esc   = esc_attr( $blend );
    $size_css    = 'auto';
    if ( $tile_size > 0 ) {
        $size_val = absint( $tile_size );
        $size_css = $size_val . 'px ' . $size_val . 'px';
    }

    // Mapeo de claves a variables CSS del theme
    $use_tint  = false;
    $color_var = '';
    if ( ! empty( $color_key ) ) {
        $var_map = array(
            'primary'     => '--deoia-primary',
            'secondary'   => '--deoia-secondary',
            'accent'      => '--deoia-accent',
            'muted'       => '--deoia-muted',
            'muted-light' => '--deoia-muted-light',
            'muted-dark'  => '--deoia-muted-dark',
        );
        if ( isset( $var_map[ $color_key ] ) ) {
            $use_tint  = true;
            $color_var = $var_map[ $color_key ];
        }
    }

    ?>
    <style id="deoia-bg-pattern-css">
        body {
            position: relative;
            z-index: 0;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
            <?php if ( $use_tint ) : ?>
            -webkit-mask-image: url('<?php echo $svg_url_esc; ?>');
            mask-image: url('<?php echo $svg_url_esc; ?>');
            -webkit-mask-repeat: repeat;
            mask-repeat: repeat;
            -webkit-mask-size: <?php echo $size_css; ?>;
            mask-size: <?php echo $size_css; ?>;
            background-color: var(<?php echo esc_attr( $color_var ); ?>);
            <?php else : ?>
            background-image: url('<?php echo $svg_url_esc; ?>');
            background-repeat: repeat;
            background-size: <?php echo $size_css; ?>;
            <?php endif; ?>
            opacity: <?php echo $opacity_css; ?>;
            mix-blend-mode: <?php echo $blend_esc; ?>;
        }
    </style>
    <?php
}
add_action( 'wp_footer', 'deoia_output_bg_pattern_css', 2 );

/**
 * Script de Customizer para auto-rellenar colores al cambiar preset
 */
function deoia_customizer_preview_js() {
    $presets = deoia_get_palette_presets();
    ?>
    <script>
    (function($) {
        // Presets data
        var deoiaPresets = <?php echo json_encode( $presets ); ?>;
        
        // Al cambiar el selector de preset
        wp.customize('deoia_palette_preset', function(value) {
            value.bind(function(newPreset) {
                if (deoiaPresets[newPreset]) {
                    var preset = deoiaPresets[newPreset];
                    
                    // Actualizar controles de color
                    wp.customize('deoia_color_primary').set(preset.primary);
                    wp.customize('deoia_color_secondary').set(preset.secondary);
                    wp.customize('deoia_color_accent').set(preset.accent);
                    wp.customize('deoia_color_bg_card').set(preset.bg_card);
                    wp.customize('deoia_color_glow_1').set(preset.glow_1);
                    wp.customize('deoia_color_glow_2').set(preset.glow_2);
                }
            });
        });
    })(jQuery);
    </script>
    <?php
}
add_action( 'customize_controls_print_footer_scripts', 'deoia_customizer_preview_js' );

/**
 * Custom Post Type: Servicios
 */
function deoia_registrar_cpt_servicios() {
    $labels = array(
        'name'                  => 'Servicios',
        'singular_name'         => 'Servicio',
        'menu_name'             => 'Servicios',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Servicio',
        'edit_item'             => 'Editar Servicio',
        'new_item'              => 'Nuevo Servicio',
        'view_item'             => 'Ver Servicio',
        'search_items'          => 'Buscar Servicios',
        'not_found'             => 'No se encontraron servicios',
        'not_found_in_trash'    => 'No hay servicios en la papelera',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'servicios' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-heart',
        'supports'           => array( 'title', 'editor' ),
    );

    register_post_type( 'deoia_servicio', $args );
}
add_action( 'init', 'deoia_registrar_cpt_servicios' );

/**
 * Meta Boxes para Servicios
 */
function deoia_servicios_meta_boxes() {
    add_meta_box(
        'deoia_servicio_campos',
        'Configuración de la Tarjeta',
        'deoia_servicio_campos_callback',
        'deoia_servicio',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'deoia_servicios_meta_boxes' );

function deoia_servicio_campos_callback( $post ) {
    wp_nonce_field( 'deoia_servicio_nonce', 'deoia_servicio_nonce_field' );

    $icono_clases = get_post_meta( $post->ID, 'servicio_icono_clases', true );
    $icono_svg = get_post_meta( $post->ID, 'servicio_icono_svg', true );
    $caracteristicas = get_post_meta( $post->ID, 'servicio_caracteristicas', true );
    ?>
    <style>
        .deoia-meta-field { margin-bottom: 20px; }
        .deoia-meta-field label { display: block; font-weight: 600; margin-bottom: 5px; }
        .deoia-meta-field input[type="text"],
        .deoia-meta-field textarea { width: 100%; }
        .deoia-meta-field .description { color: #666; font-size: 12px; margin-top: 5px; }
    </style>

    <div class="deoia-meta-field">
        <label for="servicio_icono_clases">Clases del Gradiente del Icono</label>
        <input type="text" id="servicio_icono_clases" name="servicio_icono_clases" value="<?php echo esc_attr( $icono_clases ); ?>" placeholder="from-pink-500 to-rose-500">
        <p class="description">Ejemplo: <code>from-pink-500 to-rose-500</code>, <code>from-sky-500 to-blue-600</code>, <code>from-emerald-500 to-teal-600</code>, <code>from-amber-500 to-orange-500</code></p>
    </div>

    <div class="deoia-meta-field">
        <label for="servicio_icono_svg">Código SVG del Icono</label>
        <textarea id="servicio_icono_svg" name="servicio_icono_svg" rows="4" placeholder='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5..."/>'><?php echo esc_textarea( $icono_svg ); ?></textarea>
        <p class="description">Pega solo el contenido interno del SVG (el <code>&lt;path&gt;</code>). El wrapper SVG se genera automáticamente.</p>
    </div>

    <div class="deoia-meta-field">
        <label for="servicio_caracteristicas">Características (una por línea)</label>
        <textarea id="servicio_caracteristicas" name="servicio_caracteristicas" rows="4" placeholder="Multi-empleados&#10;Catálogo de servicios"><?php echo esc_textarea( $caracteristicas ); ?></textarea>
        <p class="description">Escribe una característica por línea. Se mostrarán como bullets con check verde.</p>
    </div>
    <?php
}

function deoia_guardar_servicio_meta( $post_id ) {
    // Verificar nonce
    if ( ! isset( $_POST['deoia_servicio_nonce_field'] ) || ! wp_verify_nonce( $_POST['deoia_servicio_nonce_field'], 'deoia_servicio_nonce' ) ) {
        return;
    }

    // Verificar autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Verificar permisos
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Guardar campos
    if ( isset( $_POST['servicio_icono_clases'] ) ) {
        update_post_meta( $post_id, 'servicio_icono_clases', sanitize_text_field( $_POST['servicio_icono_clases'] ) );
    }

    if ( isset( $_POST['servicio_icono_svg'] ) ) {
        update_post_meta( $post_id, 'servicio_icono_svg', deoia_sanitize_svg( $_POST['servicio_icono_svg'] ) );
    }

    if ( isset( $_POST['servicio_caracteristicas'] ) ) {
        update_post_meta( $post_id, 'servicio_caracteristicas', sanitize_textarea_field( $_POST['servicio_caracteristicas'] ) );
    }
}
add_action( 'save_post_deoia_servicio', 'deoia_guardar_servicio_meta' );

/**
 * Sanitización personalizada para SVG
 */
function deoia_sanitize_svg( $svg ) {
    // Permitir etiquetas y atributos SVG comunes
    $allowed_html = array(
        'path' => array(
            'd'               => true,
            'fill'            => true,
            'fill-rule'       => true,
            'clip-rule'       => true,
            'stroke'          => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
            'stroke-linejoin' => true,
        ),
        'circle' => array(
            'cx'           => true,
            'cy'           => true,
            'r'            => true,
            'fill'         => true,
            'stroke'       => true,
            'stroke-width' => true,
        ),
        'rect' => array(
            'x'            => true,
            'y'            => true,
            'width'        => true,
            'height'       => true,
            'rx'           => true,
            'ry'           => true,
            'fill'         => true,
            'stroke'       => true,
            'stroke-width' => true,
        ),
        'line' => array(
            'x1'           => true,
            'y1'           => true,
            'x2'           => true,
            'y2'           => true,
            'stroke'       => true,
            'stroke-width' => true,
        ),
        'polygon' => array(
            'points' => true,
            'fill'   => true,
            'stroke' => true,
        ),
        'polyline' => array(
            'points' => true,
            'fill'   => true,
            'stroke' => true,
        ),
        'g' => array(
            'fill'         => true,
            'stroke'       => true,
            'stroke-width' => true,
        ),
    );

    return wp_kses( $svg, $allowed_html );
}

/**
 * Desencolar CSS del plugin cuando el tema premium está activo
 * Esto permite que los estilos Tailwind del tema tomen precedencia
 */
function deoia_dequeue_plugin_default_styles() {
    // Desencolar el CSS default del plugin
    wp_dequeue_style('wpaa-calendar-default');
    wp_deregister_style('wpaa-calendar-default');
    
    // También desencolar flatpickr si no lo usamos
    wp_dequeue_style('flatpickr-css');
    wp_deregister_style('flatpickr-css');
}
// Prioridad alta (20) para que se ejecute DESPUÉS del enqueue del plugin
add_action('wp_enqueue_scripts', 'deoia_dequeue_plugin_default_styles', 20);

function deoia_cargar_scripts() {
    // 1. Carga la hoja de estilo base (style.css) para que WP no se queje
    wp_enqueue_style( 'deoia-style', get_stylesheet_uri() );

    // 2. Carga tu Tailwind compilado
    // El 'time()' al final evita que el navegador guarde caché viejo mientras programas
    if ( file_exists( get_template_directory() . '/assets/css/main.css' ) ) {
        wp_enqueue_style( 'deoia-tailwind', get_template_directory_uri() . '/assets/css/main.css', array(), time() );
    }

    // Encolar adaptador premium de calendario
    wp_enqueue_script(
        'deoia-calendar-adapter',
        get_stylesheet_directory_uri() . '/assets/js/adapters/DeoiaCalendarAdapter.js',
        ['aa-wpagenda-kernel'], // depende del plugin
        filemtime(get_stylesheet_directory() . '/assets/js/adapters/DeoiaCalendarAdapter.js'),
        true
    );

    // Encolar adaptador premium de slots
    wp_enqueue_script(
        'deoia-slots-adapter',
        get_stylesheet_directory_uri() . '/assets/js/adapters/DeoiaSlotsAdapter.js',
        ['aa-wpagenda-kernel'], // depende del plugin
        filemtime(get_stylesheet_directory() . '/assets/js/adapters/DeoiaSlotsAdapter.js'),
        true
    );

    // Encolar adaptador premium de modal
    wp_enqueue_script(
        'deoia-modal-adapter',
        get_stylesheet_directory_uri() . '/assets/js/adapters/DeoiaModalAdapter.js',
        ['aa-wpagenda-kernel'], // depende del plugin
        filemtime(get_stylesheet_directory() . '/assets/js/adapters/DeoiaModalAdapter.js'),
        true
    );

    // Encolar archivo que registra adaptadores premium
    wp_enqueue_script(
        'deoia-register-adapters',
        get_stylesheet_directory_uri() . '/assets/js/DeoiaRegisterAdapters.js',
        ['deoia-calendar-adapter', 'deoia-slots-adapter', 'deoia-modal-adapter'], 
        filemtime(get_stylesheet_directory() . '/assets/js/DeoiaRegisterAdapters.js'),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'deoia_cargar_scripts' );

/**
 * Forzar enqueue de assets del plugin cuando el calendario se muestra en el hero
 * Necesario porque el shortcode se renderiza fuera de the_content
 */
add_filter( 'wpaa_should_enqueue_frontend_assets', function( $should ) {
    // Si ya es true, mantenerlo
    if ( $should ) {
        return true;
    }
    
    // Forzar enqueue en front page si el toggle del calendario en hero está activo
    if ( is_front_page() && get_theme_mod( 'deoia_show_calendar_in_hero', true ) ) {
        return true;
    }
    
    return $should;
} );

/**
 * ════════════════════════════════════════════════════════════════════════════
 * Google Analytics 4 - Customizer & Frontend Integration
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Registrar sección Analytics en el Customizer
 */
function deoia_analytics_customizer( $wp_customize ) {
    // Sección: Analytics
    $wp_customize->add_section( 'deoia_analytics', array(
        'title'       => __( 'Analytics', 'deoia' ),
        'priority'    => 160,
        'description' => __( 'Configuración de Google Analytics 4 para el seguimiento del sitio.', 'deoia' ),
    ) );

    // Campo: GA4 Measurement ID
    $wp_customize->add_setting( 'deoia_ga4_measurement_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'deoia_ga4_measurement_id', array(
        'label'       => __( 'GA4 Measurement ID', 'deoia' ),
        'description' => __( 'Ingresa tu ID de medición de Google Analytics 4 (ej: G-XXXXXXXXXX). Déjalo vacío para desactivar el seguimiento.', 'deoia' ),
        'section'     => 'deoia_analytics',
        'type'        => 'text',
        'priority'    => 10,
    ) );
}
add_action( 'customize_register', 'deoia_analytics_customizer' );

/**
 * Imprimir snippet de Google Analytics 4 en el head
 */
function deoia_output_ga4_script() {
    $ga4_id = get_theme_mod( 'deoia_ga4_measurement_id', '' );

    // No imprimir nada si el campo está vacío
    if ( empty( $ga4_id ) ) {
        return;
    }

    // Escapar el ID para seguridad
    $ga4_id = esc_attr( $ga4_id );
    ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga4_id; ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo $ga4_id; ?>');
</script>
    <?php
}
add_action( 'wp_head', 'deoia_output_ga4_script', 1 );

// ===============================
// 🔹 THEME AUTO-UPDATES DESDE GITHUB
// ===============================
require_once get_template_directory() . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$themeUpdateChecker = PucFactory::buildUpdateChecker(
  'https://github.com/RobertoTD/deoia-theme/',
  __FILE__,
  'deoia-theme'
);

// Usa Releases (assets ZIP) si los vas a adjuntar al Release:
$themeUpdateChecker->getVcsApi()->enableReleaseAssets();


// Forzar auto-actualización del tema
add_filter('auto_update_theme', function($update, $item) {
    if (!empty($item->theme) && $item->theme === 'deoia-theme') return true;
    return $update;
  }, 10, 2);