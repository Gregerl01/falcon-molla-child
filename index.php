<?php
/**
 * The blog template file.
 *
 * @package molla
 */

get_header();
?>

<section class="section section-dark">
	<?php get_template_part( 'template-parts/posts/loop/loop', 'layout' ); ?>
</section>

<?php
get_footer();