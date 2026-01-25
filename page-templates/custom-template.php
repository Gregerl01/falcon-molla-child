<?php
/**
 * Template Name: Custom Page
 */

get_header(); ?>

<div class="custom-page-wrapper">
    <?php while (have_posts()) : the_post(); ?>
        <div class="custom-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>