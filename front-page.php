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


  
<div class="page-content">
  <?php the_content(); ?>
</div>
    


<?php get_template_part('template-parts/after-content'); ?>

<?php get_template_part('template-parts/location'); ?>

<?php get_footer(); ?>
