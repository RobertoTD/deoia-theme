<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="deoia-content-wrap">
        <?php if ( ! is_front_page() ) : ?>
            <header class="deoia-entry-header">
                <?php the_title( '<h1 class="deoia-entry-title">', '</h1>' ); ?>
            </header>
        <?php endif; ?>

        <div class="deoia-wysiwyg">
            <?php the_content(); ?>
        </div>
    </div>
</article>
