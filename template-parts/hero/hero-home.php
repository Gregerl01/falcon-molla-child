<?php
/**
 * Homepage Hero — template part
 *
 * Content is hardcoded. Only the background images remain wired to
 * the Customizer (Appearance → Customize → Homepage Hero → Images
 * & Overlay) so photography can be swapped without a deploy.
 *
 * Other Customizer fields registered in inc/customizer-hero.php
 * (eyebrow, headline, lead, buttons, contact) are intentionally not
 * read here. Stale settings are acceptable for now.
 */

// Background image URLs — only Customizer fields still consumed.
$desktop_id = get_theme_mod( 'falcon_hero_image_desktop', 0 );
$mobile_id  = get_theme_mod( 'falcon_hero_image_mobile', 0 );

$desktop_url = $desktop_id
	? wp_get_attachment_url( $desktop_id )
	: get_stylesheet_directory_uri() . '/assets/images/home-hero-bg.webp';

$mobile_url = $mobile_id
	? wp_get_attachment_url( $mobile_id )
	: get_stylesheet_directory_uri() . '/assets/images/home-hero-bg-mobile.webp';
?>

<section
	class="hero hero--home"
	style="--hero-bg-desktop: url('<?php echo esc_url( $desktop_url ); ?>'); --hero-bg-mobile: url('<?php echo esc_url( $mobile_url ); ?>');"
>
	<div class="container hero__container">
		<div class="hero__content">
			<span class="hero__eyebrow">Falcon Bodies Lineup</span>

			<h1 class="hero__title">
				Outlast.<br>
				Outwork.<br>
				<span class="hero__title-muted">Outperform.</span>
			</h1>

			<p class="hero__lead">
				Purpose-Built for Every Service Call. A premium service body lineup engineered for plumbing, HVAC, electrical, and general fleets.
			</p>

			<div class="hero__actions">
				<a href="<?php echo esc_url( home_url( '/falcon-bodies/' ) ); ?>" class="btn btn-primary btn-pill">
					View Falcon Bodies
				</a>
			</div>
		</div>
	</div>
</section>
