<?php
/**
 * Registro y assets del bloque Gutenberg Etiqueta Deoia.
 */

function deoia_register_badge_block() {
    $script_path = get_theme_file_path( 'assets/js/blocks/deoia-badge-block.js' );
    $editor_css_path = get_theme_file_path( 'assets/css/blocks/deoia-badge-editor.css' );
    $frontend_css_path = get_theme_file_path( 'assets/css/blocks/deoia-badge-frontend.css' );

    wp_register_script(
        'deoia-badge-block',
        get_theme_file_uri( 'assets/js/blocks/deoia-badge-block.js' ),
        array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n' ),
        file_exists( $script_path ) ? filemtime( $script_path ) : null,
        true
    );

    wp_register_style(
        'deoia-badge-block-editor',
        get_theme_file_uri( 'assets/css/blocks/deoia-badge-editor.css' ),
        array(),
        file_exists( $editor_css_path ) ? filemtime( $editor_css_path ) : null
    );

    wp_register_style(
        'deoia-badge-block-frontend',
        get_theme_file_uri( 'assets/css/blocks/deoia-badge-frontend.css' ),
        array(),
        file_exists( $frontend_css_path ) ? filemtime( $frontend_css_path ) : null
    );

    register_block_type(
        'deoia/badge',
        array(
            'editor_script' => 'deoia-badge-block',
            'editor_style'  => 'deoia-badge-block-editor',
            'style'         => 'deoia-badge-block-frontend',
        )
    );
}
add_action( 'init', 'deoia_register_badge_block' );
