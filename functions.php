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
 * Personalizador: Redes Sociales
 */
function deoia_customize_register( $wp_customize ) {
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
}
add_action( 'customize_register', 'deoia_palette_customizer' );

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

    ?>
    <style id="deoia-palette-css">
        html:root {
            --deoia-primary: <?php echo esc_attr( $primary ); ?>;
            --deoia-secondary: <?php echo esc_attr( $secondary ); ?>;
            --deoia-accent: <?php echo esc_attr( $accent ); ?>;
            --deoia-bg-card: <?php echo esc_attr( $bg_card ); ?>;
            --deoia-bg-glow-1: <?php echo esc_attr( $glow_1 ); ?>;
            --deoia-bg-glow-2: <?php echo esc_attr( $glow_2 ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_footer', 'deoia_output_palette_css', 1 );

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