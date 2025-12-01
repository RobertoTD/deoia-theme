<?php

function deoia_cargar_scripts() {
    // 1. Carga la hoja de estilo base (style.css) para que WP no se queje
    wp_enqueue_style( 'deoia-style', get_stylesheet_uri() );

    // 2. Carga tu Tailwind compilado
    // El 'time()' al final evita que el navegador guarde caché viejo mientras programas
    if ( file_exists( get_template_directory() . '/assets/css/main.css' ) ) {
        wp_enqueue_style( 'deoia-tailwind', get_template_directory_uri() . '/assets/css/main.css', array(), time() );
    }
}
add_action( 'wp_enqueue_scripts', 'deoia_cargar_scripts' );