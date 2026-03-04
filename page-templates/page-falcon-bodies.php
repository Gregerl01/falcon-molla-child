<?php
/**
 * Template Name: Falcon Bodies Showcase
 *
 * Stacked category showcase sections using the product-line layout pattern.
 */

get_header();

$categories = array(
    array(
        'slug'        => 'service-bodies',
        'series_label' => 'SERVICE BODIES',
        'headline'    => 'Purpose-Built for Every Service Call.',
        'description' => 'Organized compartment layouts, heavy-gauge steel construction, and configurations designed for plumbing, HVAC, electrical, and general service fleets.',
        'bullets'     => array(
            array( 'title' => 'Organized Storage Systems', 'desc' => 'Compartmentalized layouts for tools, parts, and equipment access at every job site.' ),
            array( 'title' => 'Heavy-Gauge Steel Construction', 'desc' => '14ga galvanneal body panels with formed 10ga HR steel understructure for lasting durability.' ),
            array( 'title' => 'Integrated Universal Bumper', 'desc' => 'Powder-coated steel bumper with tow provisions, lighting integration, and reinforced step configuration.' ),
            array( 'title' => 'Multiple Configuration Options', 'desc' => 'Flat top, flip top, and custom configurations to match your fleet requirements.' ),
        ),
    ),
    array(
        'slug'        => 'mechanics-bodies',
        'series_label' => 'MECHANICS BODIES',
        'headline'    => 'Mobile Workshop. Built to Perform.',
        'description' => 'Full-service mechanics bodies with crane-ready platforms, deep compartments, and heavy-duty understructure for field maintenance operations.',
        'bullets'     => array(
            array( 'title' => 'Crane-Ready Platform', 'desc' => 'Reinforced mounting points and structural support for telescopic and articulating cranes.' ),
            array( 'title' => 'Deep Storage Compartments', 'desc' => 'Oversized compartments for large tools, welders, compressors, and heavy field equipment.' ),
            array( 'title' => 'Heavy-Duty Understructure', 'desc' => 'Formed 10ga HR steel crossmembers and longitudinals for maximum load capacity.' ),
            array( 'title' => 'Multiple Chassis Configurations', 'desc' => 'Available for 56CA, 60CA, 84CA, and 120CA chassis platforms.' ),
        ),
    ),
    array(
        'slug'        => 'contractor-bodies',
        'series_label' => 'CONTRACTOR BODIES',
        'headline'    => 'Built for the Jobsite. Every Day.',
        'description' => 'Versatile contractor bodies designed for general construction, roofing, and trades crews who need open bed space with organized side storage.',
        'bullets'     => array(
            array( 'title' => 'Open Bed Design', 'desc' => 'Flat bed workspace for lumber, materials, and oversized equipment hauling.' ),
            array( 'title' => 'Side-Mount Compartments', 'desc' => 'Lockable steel compartments for secure tool and material storage.' ),
            array( 'title' => 'Durable Steel Construction', 'desc' => 'Heavy-gauge galvanneal panels built to withstand daily jobsite abuse.' ),
            array( 'title' => 'Universal Chassis Fit', 'desc' => 'Engineered for popular commercial chassis platforms from Ford, RAM, and GM.' ),
        ),
    ),
    array(
        'slug'        => 'landscape-bodies',
        'series_label' => 'LANDSCAPE BODIES',
        'headline'    => 'Haul More. Work Smarter.',
        'description' => 'Purpose-built platforms with ramps, tool storage, and reinforced beds for landscaping crews and grounds maintenance fleets.',
        'bullets'     => array(
            array( 'title' => 'Integrated Ramp Systems', 'desc' => 'Built-in ramps for mower loading and equipment access.' ),
            array( 'title' => 'Reinforced Bed Platform', 'desc' => 'Heavy-duty deck built to handle daily loading of mowers, soil, and materials.' ),
            array( 'title' => 'Side Tool Storage', 'desc' => 'Lockable compartments for trimmers, blowers, and hand tools.' ),
            array( 'title' => 'Durable Finish', 'desc' => 'Powder-coated surfaces for weather and chemical resistance.' ),
        ),
    ),
    array(
        'slug'        => 'hauler-bodies',
        'series_label' => 'HAULER BODIES',
        'headline'    => 'Maximum Payload. Minimum Compromise.',
        'description' => 'Flat-bed hauler platforms engineered for heavy material transport, equipment delivery, and high-capacity commercial hauling.',
        'bullets'     => array(
            array( 'title' => 'High-Capacity Platform', 'desc' => 'Reinforced flat-bed design for maximum payload and oversized loads.' ),
            array( 'title' => 'Tie-Down Integration', 'desc' => 'Integrated stake pockets and tie-down points for secure cargo management.' ),
            array( 'title' => 'Steel Understructure', 'desc' => 'Heavy-gauge crossmembers and longitudinals for structural integrity under load.' ),
            array( 'title' => 'Commercial Chassis Ready', 'desc' => 'Designed for medium and heavy-duty commercial chassis platforms.' ),
        ),
    ),
    array(
        'slug'        => 'enclosed-bodies',
        'series_label' => 'ENCLOSED BODIES',
        'headline'    => 'Secure Storage. Professional Presence.',
        'description' => 'Fully enclosed truck bodies for trades and service operations requiring weather protection, security, and organized interior storage.',
        'bullets'     => array(
            array( 'title' => 'Fully Enclosed Design', 'desc' => 'Weather-sealed storage for tools and materials in all conditions.' ),
            array( 'title' => 'Interior Organization', 'desc' => 'Configurable shelving and storage systems for optimized workflow.' ),
            array( 'title' => 'Secure Locking System', 'desc' => 'Heavy-duty locks and reinforced doors for jobsite security.' ),
            array( 'title' => 'Professional Appearance', 'desc' => 'Clean enclosed design for a professional fleet presence.' ),
        ),
    ),
    array(
        'slug'        => 'chipper-bodies',
        'series_label' => 'CHIPPER BODIES',
        'headline'    => 'Purpose-Built for Tree Care.',
        'description' => 'Specialized chipper dump bodies for arborist and tree care operations with high-volume chip hauling capacity and integrated tool storage.',
        'bullets'     => array(
            array( 'title' => 'High-Volume Chip Box', 'desc' => 'Oversized dump body for maximum wood chip and debris capacity.' ),
            array( 'title' => 'Dump Mechanism', 'desc' => 'Hydraulic dump for fast unloading at disposal sites.' ),
            array( 'title' => 'Tool Storage Integration', 'desc' => 'Side compartments for chainsaws, ropes, and climbing gear.' ),
            array( 'title' => 'Reinforced Construction', 'desc' => 'Heavy-gauge steel built to handle daily impact from wood chips and debris.' ),
        ),
    ),
    array(
        'slug'        => 'welder-bodies',
        'series_label' => 'WELDER BODIES',
        'headline'    => 'Mobile Fabrication. Field Ready.',
        'description' => 'Specialized bodies designed for mobile welding and fabrication crews with dedicated welder platforms, gas bottle storage, and organized tool compartments.',
        'bullets'     => array(
            array( 'title' => 'Dedicated Welder Platform', 'desc' => 'Reinforced mounting area for welding machines and generators.' ),
            array( 'title' => 'Gas Bottle Storage', 'desc' => 'Secure bottle racks for acetylene, oxygen, and shielding gas.' ),
            array( 'title' => 'Lead and Cable Management', 'desc' => 'Organized routing for welding leads, power cables, and hoses.' ),
            array( 'title' => 'Heavy-Duty Compartments', 'desc' => 'Deep lockable storage for grinding, cutting, and fabrication tools.' ),
        ),
    ),
    array(
        'slug'        => 'saw-bodies',
        'series_label' => 'SAW BODIES',
        'headline'    => 'Precision Cutting. Mobile Ready.',
        'description' => 'Engineered for concrete cutting and sawing operations with dedicated saw mounts, water tank integration, and heavy-duty material handling.',
        'bullets'     => array(
            array( 'title' => 'Saw Mounting Platform', 'desc' => 'Reinforced deck with integrated mounting for concrete saws and core drills.' ),
            array( 'title' => 'Water Tank Integration', 'desc' => 'Built-in water storage for wet cutting operations and dust suppression.' ),
            array( 'title' => 'Material Storage', 'desc' => 'Compartments for blades, bits, and consumable supplies.' ),
            array( 'title' => 'Heavy-Duty Build', 'desc' => 'Steel construction rated for the weight and vibration of cutting equipment.' ),
        ),
    ),
);
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
    $term = get_term_by( 'slug', $cat['slug'], 'product_cat' );
    if ( ! $term || is_wp_error( $term ) ) continue;

    $counter++;
    $is_reversed    = ( $counter % 2 === 0 );
    $image_order    = $is_reversed ? 'order-lg-2' : '';
    $content_order  = $is_reversed ? 'order-lg-1' : '';
    $img_aos        = $is_reversed ? 'fade-left' : 'fade-right';
    $content_aos    = $is_reversed ? 'fade-right' : 'fade-left';
    $bg_class       = $is_reversed ? 'bg-dark-section' : 'bg-light';
    $cat_link     = get_term_link( $term );
    $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
?>

    <div class="product-list-item section <?php echo esc_attr( $bg_class ); ?>">
        <div class="row g-0 align-items-stretch overflow-hidden max-w-1500 mx-auto">

            <!-- Category Image -->
            <div class="col-lg-6 p-0 d-flex <?php echo esc_attr( $image_order ); ?>" data-aos="<?php echo esc_attr( $img_aos ); ?>" data-aos-delay="200">
                <div class="image-frame w-100">
                    <a href="<?php echo esc_url( $cat_link ); ?>">
                        <?php if ( $thumbnail_id ) : ?>
                            <?php echo wp_get_attachment_image( $thumbnail_id, 'full', false, array( 'class' => 'img-fluid w-100' ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( wc_placeholder_img_src( 'full' ) ); ?>" alt="<?php echo esc_attr( $cat['series_label'] ); ?>" class="img-fluid w-100">
                        <?php endif; ?>
                    </a>
                </div>
            </div>

            <!-- Category Content -->
            <div class="col-lg-6 d-flex align-items-center <?php echo esc_attr( $content_order ); ?>" data-aos="<?php echo esc_attr( $content_aos ); ?>" data-aos-delay="200">
                <div class="feature-content-wrap">
                    <h5 class="text-uppercase"><?php echo esc_html( $cat['series_label'] ); ?></h5>
                    <h2 class="mb-3"><?php echo esc_html( $cat['headline'] ); ?></h2>
                    <p class="product-description mb-4"><?php echo esc_html( $cat['description'] ); ?></p>

                    <ul class="product-features list-unstyled mb-4">
                        <?php foreach ( $cat['bullets'] as $bullet ) : ?>
                            <li class="product-feature d-flex align-items-start mb-3">
                                <svg class="flex-shrink-0 me-2 mt-1" width="18" height="18" viewBox="0 0 16 16" fill="currentColor" style="color:var(--accent-color)">
                                    <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5z"/>
                                </svg>
                                <div>
                                    <strong><?php echo esc_html( $bullet['title'] ); ?></strong>
                                    <span class="d-block"><?php echo esc_html( $bullet['desc'] ); ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if ( $term->count > 0 ) : ?>
                        <a href="<?php echo esc_url( $cat_link ); ?>" class="btn btn-primary">View <?php echo esc_html( $term->name ); ?></a>
                    <?php else : ?>
                        <span class="text-uppercase fw-semibold" style="opacity:0.45;letter-spacing:0.08em">Coming Soon</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php endforeach; ?>
</div>

<!-- CTA Section -->
<section class="sb-cta section">
    <div class="container">
        <div class="sb-cta-wrapper surface--subtle">
            <h3>Ready to Upfit Your Fleet?</h3>
            <p class="mb-4">Contact us for pricing, lead times, and custom configurations.</p>
            <a href="<?php echo esc_url( home_url( '/quote-request/' ) ); ?>" class="btn btn-primary btn-pill">Request a Quote</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
