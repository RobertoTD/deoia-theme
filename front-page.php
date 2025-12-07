<?php

/**
 * Template Name: Front Page
 */
get_header();
?>

<?php get_template_part('template-parts/hero'); ?>

<?php 
// Si tienes contenido adicional en la página (además del shortcode), mantenlo
// Si solo usabas esta sección para el shortcode, puedes eliminarla
$content = get_the_content();
if (!empty($content) && strpos($content, '[agenda_automatizada]') === false) : 
?>
<section class="wp-content-section py-12 px-6">
    <div class="container mx-auto">
        <?php 
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</section>
<?php endif; ?>

<?php get_template_part('template-parts/after-content'); ?>

<?php get_footer(); ?>
