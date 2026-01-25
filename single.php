<?php
/**
 * The default single post file.
 *
 * @package molla
 */

get_header();
?>

<section class="section section-dark">
	<?php
	if ( ! molla_is_elementor_preview() || 'footer' != get_post_type() ) {
		get_template_part( 'template-parts/posts/single/single', 'layout' );
	}
	?>
</section>

<?php
get_footer();