<?php
get_header();
?>

<?php get_template_part( 'template-parts/hero/hero-home' ); ?>

<main id="primary" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <?php the_content(); // if you still want editable content from the Home page ?>

    <?php endwhile; ?>
</main>



<?php
get_footer();
