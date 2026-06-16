<?php
/**
 * Falcon Bodies Showcase — Customizer Settings
 *
 * Registers the "Falcon Bodies Showcase" panel under Appearance → Customize
 * with per-category sections for headline, description, and 4 benefit bullets.
 */

/**
 * Return the master category config array used by both the Customizer
 * registration and the page template. Single source of truth for defaults.
 */
function falcon_showcase_categories() {
	return array(
		array(
			'key'         => 'service',
			'term_slug'   => 'service-bodies',
			'label'       => 'Service Bodies',
			'headline'    => 'Purpose-Built for Every Service Call.',
			'description' => 'Organized compartment layouts, heavy-gauge steel construction, and configurations designed for plumbing, HVAC, electrical, and general service fleets.',
			'bullets'     => array(
				array( 'title' => 'Organized Storage Systems',    'desc' => 'Compartmentalized layouts for tools, parts, and equipment access at every job site.' ),
				array( 'title' => 'Heavy-Gauge Steel Construction', 'desc' => '14ga galvanneal body panels with formed 10ga HR steel understructure for lasting durability.' ),
				array( 'title' => 'Integrated Universal Bumper',  'desc' => 'Powder-coated steel bumper with tow provisions, lighting integration, and reinforced step configuration.' ),
				array( 'title' => 'Multiple Configuration Options', 'desc' => 'Flat top, flip top, and custom configurations to match your fleet requirements.' ),
			),
		),
		array(
			'key'         => 'mechanics',
			'term_slug'   => 'mechanics-bodies',
			'label'       => 'Mechanics Bodies',
			'headline'    => 'Mobile Workshop. Built to Perform.',
			'description' => 'Full-service mechanics bodies with crane-ready platforms, deep compartments, and heavy-duty understructure for field maintenance operations.',
			'bullets'     => array(
				array( 'title' => 'Crane-Ready Platform',          'desc' => 'Reinforced mounting points and structural support for telescopic and articulating cranes.' ),
				array( 'title' => 'Deep Storage Compartments',     'desc' => 'Oversized compartments for large tools, welders, compressors, and heavy field equipment.' ),
				array( 'title' => 'Heavy-Duty Understructure',     'desc' => 'Formed 10ga HR steel crossmembers and longitudinals for maximum load capacity.' ),
				array( 'title' => 'Multiple Chassis Configurations', 'desc' => 'Available for 56CA, 60CA, 84CA, and 120CA chassis platforms.' ),
			),
		),
		array(
			'key'         => 'contractor',
			'term_slug'   => 'contractor-bodies',
			'label'       => 'Contractor Bodies',
			'headline'    => 'Built for the Jobsite. Every Day.',
			'description' => 'Versatile contractor bodies designed for general construction, roofing, and trades crews who need open bed space with organized side storage.',
			'bullets'     => array(
				array( 'title' => 'Open Bed Design',          'desc' => 'Flat bed workspace for lumber, materials, and oversized equipment hauling.' ),
				array( 'title' => 'Side-Mount Compartments',  'desc' => 'Lockable steel compartments for secure tool and material storage.' ),
				array( 'title' => 'Durable Steel Construction', 'desc' => 'Heavy-gauge galvanneal panels built to withstand daily jobsite abuse.' ),
				array( 'title' => 'Universal Chassis Fit',    'desc' => 'Engineered for popular commercial chassis platforms from Ford, RAM, and GM.' ),
			),
		),
		array(
			'key'         => 'landscape',
			'term_slug'   => 'landscape-bodies',
			'label'       => 'Landscape Bodies',
			'headline'    => 'Haul More. Work Smarter.',
			'description' => 'Purpose-built platforms with ramps, tool storage, and reinforced beds for landscaping crews and grounds maintenance fleets.',
			'bullets'     => array(
				array( 'title' => 'Integrated Ramp Systems', 'desc' => 'Built-in ramps for mower loading and equipment access.' ),
				array( 'title' => 'Reinforced Bed Platform', 'desc' => 'Heavy-duty deck built to handle daily loading of mowers, soil, and materials.' ),
				array( 'title' => 'Side Tool Storage',       'desc' => 'Lockable compartments for trimmers, blowers, and hand tools.' ),
				array( 'title' => 'Durable Finish',          'desc' => 'Powder-coated surfaces for weather and chemical resistance.' ),
			),
		),
		array(
			'key'         => 'hauler',
			'term_slug'   => 'hauler-bodies',
			'label'       => 'Hauler Bodies',
			'headline'    => 'Maximum Payload. Minimum Compromise.',
			'description' => 'Flat-bed hauler platforms engineered for heavy material transport, equipment delivery, and high-capacity commercial hauling.',
			'bullets'     => array(
				array( 'title' => 'High-Capacity Platform',   'desc' => 'Reinforced flat-bed design for maximum payload and oversized loads.' ),
				array( 'title' => 'Tie-Down Integration',     'desc' => 'Integrated stake pockets and tie-down points for secure cargo management.' ),
				array( 'title' => 'Steel Understructure',     'desc' => 'Heavy-gauge crossmembers and longitudinals for structural integrity under load.' ),
				array( 'title' => 'Commercial Chassis Ready', 'desc' => 'Designed for medium and heavy-duty commercial chassis platforms.' ),
			),
		),
		array(
			'key'         => 'platform',
			'term_slug'   => 'platform-bodies',
			'label'       => 'Platform Bodies',
			'headline'    => 'Flat. Fast. Fully Loaded.',
			'description' => 'Falcon Platform Bodies deliver heavy-duty flatbed solutions engineered for maximum hauling versatility and structural integrity. From standard decks for general hauling to HD models with 8-foot runners for equipment transport, they provide the strength and configurability required for commercial, fleet, and contractor applications.',
			'bullets'     => array(
				array( 'title' => 'Standard or HD with 8′ runners',  'desc' => 'Standard flat deck or HD models with 8-foot concentrated load rails for equipment and point loads.' ),
				array( 'title' => 'Steel or aluminum construction',  'desc' => 'Steel for maximum strength or aluminum for up to 40–50% weight reduction and increased payload.' ),
				array( 'title' => '25K–30K gooseneck integration',   'desc' => 'Fully integrated gooseneck hitch prep or installed systems with receiver hitch and trailer wiring.' ),
				array( 'title' => 'Class 2–6 chassis compatibility', 'desc' => 'Designed for seamless integration across popular commercial chassis platforms.' ),
			),
		),
		array(
			'key'         => 'enclosed',
			'term_slug'   => 'enclosed-bodies',
			'label'       => 'Enclosed Bodies',
			'headline'    => 'Secure Storage. Professional Presence.',
			'description' => 'Fully enclosed truck bodies for trades and service operations requiring weather protection, security, and organized interior storage.',
			'bullets'     => array(
				array( 'title' => 'Fully Enclosed Design',    'desc' => 'Weather-sealed storage for tools and materials in all conditions.' ),
				array( 'title' => 'Interior Organization',    'desc' => 'Configurable shelving and storage systems for optimized workflow.' ),
				array( 'title' => 'Secure Locking System',    'desc' => 'Heavy-duty locks and reinforced doors for jobsite security.' ),
				array( 'title' => 'Professional Appearance',  'desc' => 'Clean enclosed design for a professional fleet presence.' ),
			),
		),
		array(
			'key'         => 'chipper',
			'term_slug'   => 'chipper-bodies',
			'label'       => 'Chipper Bodies',
			'headline'    => 'Purpose-Built for Tree Care.',
			'description' => 'Specialized chipper dump bodies for arborist and tree care operations with high-volume chip hauling capacity and integrated tool storage.',
			'bullets'     => array(
				array( 'title' => 'High-Volume Chip Box',       'desc' => 'Oversized dump body for maximum wood chip and debris capacity.' ),
				array( 'title' => 'Dump Mechanism',             'desc' => 'Hydraulic dump for fast unloading at disposal sites.' ),
				array( 'title' => 'Tool Storage Integration',   'desc' => 'Side compartments for chainsaws, ropes, and climbing gear.' ),
				array( 'title' => 'Reinforced Construction',    'desc' => 'Heavy-gauge steel built to handle daily impact from wood chips and debris.' ),
			),
		),
		array(
			'key'         => 'welder',
			'term_slug'   => 'welder-bodies',
			'label'       => 'Welder Bodies',
			'headline'    => 'Mobile Fabrication. Field Ready.',
			'description' => 'Specialized bodies designed for mobile welding and fabrication crews with dedicated welder platforms, gas bottle storage, and organized tool compartments.',
			'bullets'     => array(
				array( 'title' => 'Dedicated Welder Platform',    'desc' => 'Reinforced mounting area for welding machines and generators.' ),
				array( 'title' => 'Gas Bottle Storage',           'desc' => 'Secure bottle racks for acetylene, oxygen, and shielding gas.' ),
				array( 'title' => 'Lead and Cable Management',    'desc' => 'Organized routing for welding leads, power cables, and hoses.' ),
				array( 'title' => 'Heavy-Duty Compartments',      'desc' => 'Deep lockable storage for grinding, cutting, and fabrication tools.' ),
			),
		),
		array(
			'key'         => 'saw',
			'term_slug'   => 'saw-bodies',
			'label'       => 'Saw Bodies',
			'headline'    => 'Precision Cutting. Mobile Ready.',
			'description' => 'Engineered for concrete cutting and sawing operations with dedicated saw mounts, water tank integration, and heavy-duty material handling.',
			'bullets'     => array(
				array( 'title' => 'Saw Mounting Platform',    'desc' => 'Reinforced deck with integrated mounting for concrete saws and core drills.' ),
				array( 'title' => 'Water Tank Integration',   'desc' => 'Built-in water storage for wet cutting operations and dust suppression.' ),
				array( 'title' => 'Material Storage',         'desc' => 'Compartments for blades, bits, and consumable supplies.' ),
				array( 'title' => 'Heavy-Duty Build',         'desc' => 'Steel construction rated for the weight and vibration of cutting equipment.' ),
			),
		),
		array(
			'key'         => 'dump_trucks',
			'term_slug'   => 'dump-trucks',
			'label'       => 'Dump Trucks',
			'headline'    => 'Heavy Hauling. Hard Dumping.',
			'description' => 'Falcon Dump Trucks are built for contractors, municipalities, and heavy hauling operations that need reliable dump platforms for aggregate, soil, debris, and material transport.',
			'bullets'     => array(
				array( 'title' => 'Heavy-Duty Dump Platform', 'desc' => 'Reinforced steel dump body engineered for repeated loading and dumping cycles.' ),
				array( 'title' => 'Hydraulic Lift System',    'desc' => 'Powerful hydraulic hoist for reliable, controlled dumping of heavy loads.' ),
				array( 'title' => 'Reinforced Tailgate',      'desc' => 'Heavy-gauge tailgate with spreader and barn door configurations.' ),
				array( 'title' => 'Commercial Chassis Ready', 'desc' => 'Designed for medium and heavy-duty commercial chassis platforms.' ),
			),
		),
		array(
			'key'         => 'water_trucks',
			'term_slug'   => 'water-trucks',
			'label'       => 'Water Trucks',
			'headline'    => 'Spray. Suppress. Supply.',
			'description' => 'Falcon Water Trucks deliver reliable water transport and distribution for dust suppression, compaction, fire support, and jobsite water supply operations.',
			'bullets'     => array(
				array( 'title' => 'Durable Tank Construction',   'desc' => 'Heavy-gauge steel tank engineered for water transport and distribution applications.' ),
				array( 'title' => 'Spray System Integration',    'desc' => 'Front and rear spray heads with adjustable flow for dust control and compaction.' ),
				array( 'title' => 'Pump & Plumbing Package',     'desc' => 'Commercial-grade pump system with valved plumbing for fill and discharge operations.' ),
				array( 'title' => 'DOT Compliant Platform',      'desc' => 'Built to meet Department of Transportation requirements for on-road water transport.' ),
			),
		),
		array(
			'key'         => 'line_bodies',
			'term_slug'   => 'line-bodies',
			'label'       => 'Line Bodies',
			'headline'    => 'Linework Ready. Purpose-Built.',
			'description' => 'Falcon Line Bodies are engineered for utility and telecommunications crews who need organized aerial equipment storage, compartmentalized tool access, and heavy-duty platform performance.',
			'bullets'     => array(
				array( 'title' => 'Aerial Equipment Integration', 'desc' => 'Purpose-built platform for bucket truck and digger derrick body mounting.' ),
				array( 'title' => 'Deep Compartment Storage',     'desc' => 'Extended-depth compartments for linework tools, hot sticks, and safety equipment.' ),
				array( 'title' => 'Heavy-Gauge Construction',     'desc' => 'Galvanneal steel body panels with reinforced understructure for utility chassis.' ),
				array( 'title' => 'Organized Tool Access',        'desc' => 'Compartment layouts designed for fast access to line crew equipment and materials.' ),
			),
		),
	);
}

add_action( 'customize_register', 'falcon_showcase_customizer' );

function falcon_showcase_customizer( $wp_customize ) {

	// ── Panel ────────────────────────────────────────────────────────────
	$wp_customize->add_panel( 'falcon_showcase_panel', array(
		'title'    => __( 'Falcon Bodies Showcase', 'molla-child' ),
		'priority' => 31,
	) );

	$categories = falcon_showcase_categories();

	foreach ( $categories as $index => $cat ) {
		$key     = $cat['key'];
		$section = 'falcon_showcase_' . $key;

		// ── Section ──────────────────────────────────────────────────
		$wp_customize->add_section( $section, array(
			'title'    => $cat['label'],
			'panel'    => 'falcon_showcase_panel',
			'priority' => ( $index + 1 ) * 10,
		) );

		// Headline
		$wp_customize->add_setting( $section . '_headline', array(
			'default'           => $cat['headline'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $section . '_headline', array(
			'label'   => __( 'Headline', 'molla-child' ),
			'section' => $section,
			'type'    => 'text',
		) );

		// Description
		$wp_customize->add_setting( $section . '_description', array(
			'default'           => $cat['description'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $section . '_description', array(
			'label'   => __( 'Description', 'molla-child' ),
			'section' => $section,
			'type'    => 'textarea',
		) );

		// 4 Bullets
		for ( $b = 1; $b <= 4; $b++ ) {
			$bullet_default = $cat['bullets'][ $b - 1 ];

			// Bullet title
			$wp_customize->add_setting( $section . '_bullet_' . $b . '_title', array(
				'default'           => $bullet_default['title'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $section . '_bullet_' . $b . '_title', array(
				'label'   => sprintf( __( 'Bullet %d — Title', 'molla-child' ), $b ),
				'section' => $section,
				'type'    => 'text',
			) );

			// Bullet description
			$wp_customize->add_setting( $section . '_bullet_' . $b . '_desc', array(
				'default'           => $bullet_default['desc'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $section . '_bullet_' . $b . '_desc', array(
				'label'   => sprintf( __( 'Bullet %d — Description', 'molla-child' ), $b ),
				'section' => $section,
				'type'    => 'textarea',
			) );
		}
	}
}
