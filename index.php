<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tema Nuevo</title>
    
    <?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>

    <h1 class="text-4xl font-bold text-blue-600">
        ¡Hola! Soy el tema Deoia con Tailwind.
    </h1>

    <?php wp_footer(); ?>
</body>
</html>