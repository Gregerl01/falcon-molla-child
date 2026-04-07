<?php
/**
 * Template Name: Falcon Bodies Showcase
 *
 * Stacked category showcase sections using the product-line layout pattern.
 * All text content is editable via Appearance → Customize → Falcon Bodies Showcase.
 */

get_header();

$categories = falcon_showcase_categories();
?>

<!-- Hero Section -->
<section class="falcon-showcase-hero section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h1>Falcon Truck Bodies</h1>
                <p class="lead mt-3">Purpose-built work truck bodies engineered for durability, organization, and everyday performance across every trade.</p>
            </div>
        </div>
    </div>
</section>

<!-- Category Showcase Sections -->
<div class="falcon-bodies-showcase">
<?php
$counter = 0;
foreach ( $categories as $cat ) :
    $term = get_term_by( 'slug', $cat['term_slug'], 'product_cat' );
    if ( ! $term || is_wp_error( $term ) ) continue;

    $section_key = 'falcon_showcase_' . $cat['key'];

    // Pull Customizer values with hardcoded fallbacks
    $headline    = get_theme_mod( $section_key . '_headline',    $cat['headline'] );
    $description = get_theme_mod( $section_key . '_description', $cat['description'] );

    $bullets = array();
    for ( $b = 1; $b <= 4; $b++ ) {
        $bullets[] = array(
            'title' => get_theme_mod( $section_key . '_bullet_' . $b . '_title', $cat['bullets'][ $b - 1 ]['title'] ),
            'desc'  => get_theme_mod( $section_key . '_bullet_' . $b . '_desc',  $cat['bullets'][ $b - 1 ]['desc'] ),
        );
    }

    $is_reversed    = ( $counter % 2 !== 0 );
    $reversed_class = $is_reversed ? 'is-reversed' : '';
    $img_aos        = $is_reversed ? 'fade-left' : 'fade-right';
    $content_aos    = $is_reversed ? 'fade-right' : 'fade-left';
    $bg_class       = $is_reversed ? 'bg-dark-section' : 'bg-light';
    $cat_link       = get_term_link( $term );
    $thumbnail_id   = get_term_meta( $term->term_id, 'thumbnail_id', true );
?>

    <div class="product-list-item section <?php echo esc_attr( $bg_class ); ?> <?php echo esc_attr( $reversed_class ); ?>">
        <div class="row g-0 align-items-stretch overflow-hidden max-w-1500 mx-auto">

            <!-- Category Image -->
            <div class="col-lg-6 p-0 d-flex" data-aos="<?php echo esc_attr( $img_aos ); ?>" data-aos-delay="200">
                <div class="image-frame w-100">
                    <a href="<?php echo esc_url( $cat_link ); ?>">
                        <?php if ( $thumbnail_id ) : ?>
                            <?php echo wp_get_attachment_image( $thumbnail_id, 'full', false, array( 'class' => 'img-fluid w-100' ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( wc_placeholder_img_src( 'full' ) ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy" class="img-fluid w-100">
                        <?php endif; ?>
                    </a>
                </div>
            </div>

            <!-- Category Content -->
            <div class="col-lg-6 d-flex align-items-center" data-aos="<?php echo esc_attr( $content_aos ); ?>" data-aos-delay="200">
                <div class="feature-content-wrap">
                    <h5 class="text-uppercase"><?php echo esc_html( $term->name ); ?></h5>

                    <div class="falcon-feature-block">
                        <h2 class="falcon-headline"><?php echo esc_html( $headline ); ?></h2>
                        <p class="falcon-intro"><?php echo esc_html( $description ); ?></p>

                        <div class="falcon-benefits">
                            <?php
                            $delays = array( 250, 300, 350, 400 );
                            foreach ( $bullets as $i => $bullet ) :
                                $delay = isset( $delays[ $i ] ) ? $delays[ $i ] : 400;
                            ?>
                                <div class="benefit-item" data-aos="<?php echo esc_attr( $content_aos ); ?>" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
                                    <div class="benefit-icon">
                                        <i class="bi bi-lightning-fill"></i>
                                    </div>
                                    <div class="benefit-content">
                                        <h3><?php echo esc_html( $bullet['title'] ); ?></h3>
                                        <p><?php echo esc_html( $bullet['desc'] ); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if ( $term->count > 0 ) : ?>
                        <a href="<?php echo esc_url( $cat_link ); ?>" class="btn btn-primary">View <?php echo esc_html( $term->name ); ?></a>
                    <?php else : ?>
                        <span class="text-uppercase fw-semibold" style="opacity:0.45;letter-spacing:0.08em">Coming Soon</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php
    $counter++;
endforeach;
?>
</div>

<!-- CTA Section -->
<section class="sb-cta section">
    <div class="container">
        <div class="sb-cta-wrapper surface--subtle">
            <h2>Ready to Upfit Your Fleet?</h2>
            <p class="mb-4">Contact us for pricing, lead times, and custom configurations.</p>
            <a href="<?php echo esc_url( home_url( '/quote-request/' ) ); ?>" class="btn btn-primary btn-pill">Request a Quote</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
