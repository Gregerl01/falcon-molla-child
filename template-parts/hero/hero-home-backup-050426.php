<?php
/**
 * Homepage Hero — template part
 *
 * All fields are editable via Appearance → Customize → Homepage Hero.
 * Falls back to hardcoded defaults when no Customizer value is saved.
 */

// Content
$eyebrow  = get_theme_mod( 'falcon_hero_eyebrow',  'The New Standard in Work Truck Bodies' );
$headline = get_theme_mod( 'falcon_hero_headline',  'Built to Endure.<br>Designed for Real Work.' );
$lead     = get_theme_mod( 'falcon_hero_lead',      'Premium truck bodies engineered for people who depend on their equipment every day.' );

// Buttons
$btn_primary_text   = get_theme_mod( 'falcon_hero_btn_primary_text',   'Explore Models' );
$btn_primary_url    = get_theme_mod( 'falcon_hero_btn_primary_url',    '#services' );
$btn_secondary_text = get_theme_mod( 'falcon_hero_btn_secondary_text', 'Contact Sales' );
$btn_secondary_url  = get_theme_mod( 'falcon_hero_btn_secondary_url',  '#contact' );

// Contact info
$show_contact = get_theme_mod( 'falcon_hero_show_contact', true );
$phone_label  = get_theme_mod( 'falcon_hero_phone_label',  'Call Us Today!' );
$phone_number = get_theme_mod( 'falcon_hero_phone_number', '(888) 421-4150' );
$phone_link   = get_theme_mod( 'falcon_hero_phone_link',   'tel:+18884214150' );
$hours_label  = get_theme_mod( 'falcon_hero_hours_label',  'Working Hours' );
$hours_text   = get_theme_mod( 'falcon_hero_hours_text',   'Mon–Fri: 8am–5pm' );

// Images
$desktop_id       = get_theme_mod( 'falcon_hero_image_desktop', 0 );
$mobile_id        = get_theme_mod( 'falcon_hero_image_mobile', 0 );
$overlay_opacity  = get_theme_mod( 'falcon_hero_overlay_opacity', 45 );

$desktop_url = $desktop_id ? wp_get_attachment_url( $desktop_id ) : get_stylesheet_directory_uri() . '/assets/images/hero-image-v3.webp';
$mobile_url  = $mobile_id  ? wp_get_attachment_url( $mobile_id )  : '';

$overlay_decimal = max( 0, min( 100, (int) $overlay_opacity ) ) / 100;
?>

<section class="hero hero--fixed-contrast">
  <div class="hero__overlay" style="background: rgba(0, 0, 0, <?php echo esc_attr( $overlay_decimal ); ?>);"></div>
  <div class="hero__glow"></div>

  <?php if ( $mobile_url ) : ?>
  <picture>
    <source media="(max-width: 768px)" srcset="<?php echo esc_url( $mobile_url ); ?>">
    <img
      src="<?php echo esc_url( $desktop_url ); ?>"
      alt="<?php echo esc_attr( $eyebrow ); ?>"
      class="hero__bg"
    >
  </picture>
  <?php else : ?>
  <img
    src="<?php echo esc_url( $desktop_url ); ?>"
    alt="<?php echo esc_attr( $eyebrow ); ?>"
    class="hero__bg"
  >
  <?php endif; ?>

  <div class="container hero__container">
    <div class="hero__content" data-aos="fade-up">
      <p class="hero__eyebrow">
        <?php echo esc_html( $eyebrow ); ?>
      </p>

      <h1 class="hero__title">
        <?php echo wp_kses( $headline, array( 'br' => array() ) ); ?>
      </h1>

      <p class="hero__lead">
        <?php echo esc_html( $lead ); ?>
      </p>

      <div class="hero__actions">
        <a href="<?php echo esc_url( $btn_primary_url ); ?>" class="btn btn-primary btn-pill">
          <?php echo esc_html( $btn_primary_text ); ?>
        </a>
        <a href="<?php echo esc_url( $btn_secondary_url ); ?>" class="btn btn-outline btn-pill">
          <?php echo esc_html( $btn_secondary_text ); ?>
        </a>
      </div>

      <?php if ( $show_contact ) : ?>
      <div class="hero__badges">
        <a href="<?php echo esc_url( $phone_link ); ?>" class="badge-item">
          <i class="bi bi-telephone-fill"></i>
          <div class="badge-content">
            <span><?php echo esc_html( $phone_label ); ?></span>
            <strong><?php echo esc_html( $phone_number ); ?></strong>
          </div>
        </a>

        <div class="badge-item">
          <i class="bi bi-clock-fill"></i>
          <div class="badge-content">
            <span><?php echo esc_html( $hours_label ); ?></span>
            <strong><?php echo esc_html( $hours_text ); ?></strong>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
