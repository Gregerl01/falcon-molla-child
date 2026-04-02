<?php
/**
 * Homepage Hero — Customizer Settings
 *
 * Registers the "Homepage Hero" panel under Appearance → Customize
 * with all editable fields for the front-page hero section.
 */

add_action( 'customize_register', 'falcon_hero_customizer' );

function falcon_hero_customizer( $wp_customize ) {

	// ── Panel ────────────────────────────────────────────────────────────
	$wp_customize->add_panel( 'falcon_hero_panel', array(
		'title'    => __( 'Homepage Hero', 'molla-child' ),
		'priority' => 30,
	) );

	// =====================================================================
	// Section: Content
	// =====================================================================
	$wp_customize->add_section( 'falcon_hero_content', array(
		'title' => __( 'Content', 'molla-child' ),
		'panel' => 'falcon_hero_panel',
	) );

	// Eyebrow
	$wp_customize->add_setting( 'falcon_hero_eyebrow', array(
		'default'           => 'The New Standard in Work Truck Bodies',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_eyebrow', array(
		'label'   => __( 'Eyebrow Text', 'molla-child' ),
		'section' => 'falcon_hero_content',
		'type'    => 'text',
	) );

	// Headline
	$wp_customize->add_setting( 'falcon_hero_headline', array(
		'default'           => 'Built to Endure.<br>Designed for Real Work.',
		'sanitize_callback' => 'falcon_hero_sanitize_html',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_headline', array(
		'label'       => __( 'Main Headline', 'molla-child' ),
		'description' => __( 'Use &lt;br&gt; for line breaks.', 'molla-child' ),
		'section'     => 'falcon_hero_content',
		'type'        => 'textarea',
	) );

	// Supporting text
	$wp_customize->add_setting( 'falcon_hero_lead', array(
		'default'           => 'Premium truck bodies engineered for people who depend on their equipment every day.',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_lead', array(
		'label'   => __( 'Supporting Paragraph', 'molla-child' ),
		'section' => 'falcon_hero_content',
		'type'    => 'textarea',
	) );

	// =====================================================================
	// Section: Buttons
	// =====================================================================
	$wp_customize->add_section( 'falcon_hero_buttons', array(
		'title' => __( 'Buttons', 'molla-child' ),
		'panel' => 'falcon_hero_panel',
	) );

	// Primary button text
	$wp_customize->add_setting( 'falcon_hero_btn_primary_text', array(
		'default'           => 'Explore Models',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_btn_primary_text', array(
		'label'   => __( 'Primary Button Text', 'molla-child' ),
		'section' => 'falcon_hero_buttons',
		'type'    => 'text',
	) );

	// Primary button URL
	$wp_customize->add_setting( 'falcon_hero_btn_primary_url', array(
		'default'           => '#services',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_btn_primary_url', array(
		'label'   => __( 'Primary Button URL', 'molla-child' ),
		'section' => 'falcon_hero_buttons',
		'type'    => 'url',
	) );

	// Secondary button text
	$wp_customize->add_setting( 'falcon_hero_btn_secondary_text', array(
		'default'           => 'Contact Sales',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_btn_secondary_text', array(
		'label'   => __( 'Secondary Button Text', 'molla-child' ),
		'section' => 'falcon_hero_buttons',
		'type'    => 'text',
	) );

	// Secondary button URL
	$wp_customize->add_setting( 'falcon_hero_btn_secondary_url', array(
		'default'           => '#contact',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_btn_secondary_url', array(
		'label'   => __( 'Secondary Button URL', 'molla-child' ),
		'section' => 'falcon_hero_buttons',
		'type'    => 'url',
	) );

	// =====================================================================
	// Section: Contact Info
	// =====================================================================
	$wp_customize->add_section( 'falcon_hero_contact', array(
		'title' => __( 'Contact Info', 'molla-child' ),
		'panel' => 'falcon_hero_panel',
	) );

	// Show/hide contact row
	$wp_customize->add_setting( 'falcon_hero_show_contact', array(
		'default'           => true,
		'sanitize_callback' => 'falcon_hero_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_show_contact', array(
		'label'   => __( 'Show contact info row', 'molla-child' ),
		'section' => 'falcon_hero_contact',
		'type'    => 'checkbox',
	) );

	// Phone label
	$wp_customize->add_setting( 'falcon_hero_phone_label', array(
		'default'           => 'Call Us Today!',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_phone_label', array(
		'label'   => __( 'Phone Label', 'molla-child' ),
		'section' => 'falcon_hero_contact',
		'type'    => 'text',
	) );

	// Phone number (display)
	$wp_customize->add_setting( 'falcon_hero_phone_number', array(
		'default'           => '(888) 421-4150',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_phone_number', array(
		'label'   => __( 'Phone Number (display)', 'molla-child' ),
		'section' => 'falcon_hero_contact',
		'type'    => 'text',
	) );

	// Phone link (tel: href)
	$wp_customize->add_setting( 'falcon_hero_phone_link', array(
		'default'           => 'tel:+18884214150',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_phone_link', array(
		'label'       => __( 'Phone Link', 'molla-child' ),
		'description' => __( 'tel:+18884214150 format', 'molla-child' ),
		'section'     => 'falcon_hero_contact',
		'type'        => 'text',
	) );

	// Hours label
	$wp_customize->add_setting( 'falcon_hero_hours_label', array(
		'default'           => 'Working Hours',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_hours_label', array(
		'label'   => __( 'Hours Label', 'molla-child' ),
		'section' => 'falcon_hero_contact',
		'type'    => 'text',
	) );

	// Hours text
	$wp_customize->add_setting( 'falcon_hero_hours_text', array(
		'default'           => 'Mon–Fri: 8am–5pm',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_hours_text', array(
		'label'   => __( 'Hours Text', 'molla-child' ),
		'section' => 'falcon_hero_contact',
		'type'    => 'text',
	) );

	// =====================================================================
	// Section: Images & Overlay
	// =====================================================================
	$wp_customize->add_section( 'falcon_hero_images', array(
		'title' => __( 'Images & Overlay', 'molla-child' ),
		'panel' => 'falcon_hero_panel',
	) );

	// Desktop image
	$wp_customize->add_setting( 'falcon_hero_image_desktop', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'falcon_hero_image_desktop', array(
		'label'     => __( 'Hero Image — Desktop', 'molla-child' ),
		'section'   => 'falcon_hero_images',
		'mime_type' => 'image',
	) ) );

	// Mobile image
	$wp_customize->add_setting( 'falcon_hero_image_mobile', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'falcon_hero_image_mobile', array(
		'label'     => __( 'Hero Image — Mobile', 'molla-child' ),
		'section'   => 'falcon_hero_images',
		'mime_type' => 'image',
	) ) );

	// Overlay opacity
	$wp_customize->add_setting( 'falcon_hero_overlay_opacity', array(
		'default'           => 45,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'falcon_hero_overlay_opacity', array(
		'label'       => __( 'Overlay Opacity (%)', 'molla-child' ),
		'description' => __( '0 = transparent, 100 = solid black', 'molla-child' ),
		'section'     => 'falcon_hero_images',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 5,
		),
	) );
}

// ── Sanitization helpers ────────────────────────────────────────────────

function falcon_hero_sanitize_html( $input ) {
	return wp_kses( $input, array( 'br' => array() ) );
}

function falcon_hero_sanitize_checkbox( $input ) {
	return (bool) $input;
}
