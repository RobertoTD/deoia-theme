<?php
/**
 * Template Name: Front Page
 */
get_header();
?>

<?php get_template_part('template-parts/hero'); ?>

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

<?php get_template_part('template-parts/after-content'); ?>

<?php get_footer(); ?>
