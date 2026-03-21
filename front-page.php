<?php

/**
 * Template Name: Front Page
 */
get_header();

// Asegurar el loop: una sola llamada a the_post() para que the_content() funcione después
if ( have_posts() ) {
    the_post();
}
?>

<?php get_template_part('template-parts/hero'); ?>


  
<div class="deoia-content-wrap">
    <div class="deoia-wysiwyg">
        <?php the_content(); ?>
    </div>
</div>
    


<?php get_template_part('template-parts/after-content'); ?>

<?php if ( get_theme_mod( 'deoia_location_visible', true ) ) : ?>
    <?php get_template_part('template-parts/location'); ?>
<?php endif; ?>

<?php get_footer(); ?>
