<?php
/**
 * Falcon Maintenance Mode
 *
 * Adds an admin settings page under Appearance → Maintenance Mode
 * and intercepts front-end requests when maintenance is enabled.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================================
// ADMIN SETTINGS PAGE
// ============================================================================

/**
 * Register the settings page under Appearance
 */
add_action( 'admin_menu', 'falcon_maintenance_menu' );
function falcon_maintenance_menu() {
    add_theme_page(
        'Maintenance Mode',
        'Maintenance Mode',
        'manage_options',
        'falcon-maintenance',
        'falcon_maintenance_settings_page'
    );
}

/**
 * Register settings, sections, and fields
 */
add_action( 'admin_init', 'falcon_maintenance_settings_init' );
function falcon_maintenance_settings_init() {
    register_setting( 'falcon_maintenance', 'falcon_maintenance_options', [
        'type'              => 'array',
        'sanitize_callback' => 'falcon_maintenance_sanitize',
        'default'           => falcon_maintenance_defaults(),
    ] );

    add_settings_section(
        'falcon_maintenance_main',
        'Maintenance Mode Settings',
        '__return_false',
        'falcon-maintenance'
    );

    add_settings_field( 'enabled', 'Enable Maintenance Mode', 'falcon_maintenance_field_enabled', 'falcon-maintenance', 'falcon_maintenance_main' );
    add_settings_field( 'headline', 'Headline', 'falcon_maintenance_field_headline', 'falcon-maintenance', 'falcon_maintenance_main' );
    add_settings_field( 'message', 'Message', 'falcon_maintenance_field_message', 'falcon-maintenance', 'falcon_maintenance_main' );
    add_settings_field( 'phone', 'Phone', 'falcon_maintenance_field_phone', 'falcon-maintenance', 'falcon_maintenance_main' );
    add_settings_field( 'email', 'Email', 'falcon_maintenance_field_email', 'falcon-maintenance', 'falcon_maintenance_main' );
}

/**
 * Default option values
 */
function falcon_maintenance_defaults() {
    return [
        'enabled'  => 0,
        'headline' => 'New Site Coming Soon',
        'message'  => "We're building something better. Our new website is under construction and will be available shortly.",
        'phone'    => '(888) 421-4150',
        'email'    => 'sales@falcontruckbodies.com',
    ];
}

/**
 * Sanitize callback
 */
function falcon_maintenance_sanitize( $input ) {
    $defaults  = falcon_maintenance_defaults();
    $sanitized = [];

    $sanitized['enabled']  = ! empty( $input['enabled'] ) ? 1 : 0;
    $sanitized['headline'] = isset( $input['headline'] ) ? sanitize_text_field( $input['headline'] ) : $defaults['headline'];
    $sanitized['message']  = isset( $input['message'] ) ? sanitize_textarea_field( $input['message'] ) : $defaults['message'];
    $sanitized['phone']    = isset( $input['phone'] ) ? sanitize_text_field( $input['phone'] ) : $defaults['phone'];
    $sanitized['email']    = isset( $input['email'] ) ? sanitize_email( $input['email'] ) : $defaults['email'];

    return $sanitized;
}

// --- Field renderers ---

function falcon_maintenance_get_option( $key ) {
    $opts     = get_option( 'falcon_maintenance_options', falcon_maintenance_defaults() );
    $defaults = falcon_maintenance_defaults();
    return isset( $opts[ $key ] ) ? $opts[ $key ] : $defaults[ $key ];
}

function falcon_maintenance_field_enabled() {
    $val = falcon_maintenance_get_option( 'enabled' );
    echo '<label><input type="checkbox" name="falcon_maintenance_options[enabled]" value="1" ' . checked( 1, $val, false ) . '> Activate maintenance mode for logged-out visitors</label>';
}

function falcon_maintenance_field_headline() {
    $val = esc_attr( falcon_maintenance_get_option( 'headline' ) );
    echo '<input type="text" name="falcon_maintenance_options[headline]" value="' . $val . '" class="regular-text">';
}

function falcon_maintenance_field_message() {
    $val = esc_textarea( falcon_maintenance_get_option( 'message' ) );
    echo '<textarea name="falcon_maintenance_options[message]" rows="4" class="large-text">' . $val . '</textarea>';
}

function falcon_maintenance_field_phone() {
    $val = esc_attr( falcon_maintenance_get_option( 'phone' ) );
    echo '<input type="text" name="falcon_maintenance_options[phone]" value="' . $val . '" class="regular-text">';
}

function falcon_maintenance_field_email() {
    $val = esc_attr( falcon_maintenance_get_option( 'email' ) );
    echo '<input type="email" name="falcon_maintenance_options[email]" value="' . $val . '" class="regular-text">';
}

/**
 * Render the settings page
 */
function falcon_maintenance_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $is_active = falcon_maintenance_get_option( 'enabled' );
    ?>
    <div class="wrap">
        <h1>Maintenance Mode</h1>

        <?php if ( $is_active ) : ?>
            <div class="notice notice-warning inline" style="margin-top:12px;">
                <p><strong>Maintenance mode is currently ACTIVE.</strong> Logged-out visitors see the maintenance page.</p>
            </div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php
            settings_fields( 'falcon_maintenance' );
            do_settings_sections( 'falcon-maintenance' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// ============================================================================
// ADMIN NOTICES & ADMIN BAR INDICATOR
// ============================================================================

/**
 * Dashboard notice when maintenance mode is on
 */
add_action( 'admin_notices', 'falcon_maintenance_admin_notice' );
function falcon_maintenance_admin_notice() {
    if ( ! falcon_maintenance_get_option( 'enabled' ) ) {
        return;
    }

    $screen = get_current_screen();
    if ( $screen && 'dashboard' === $screen->id ) {
        echo '<div class="notice notice-warning"><p><strong>Maintenance Mode is active.</strong> Logged-out visitors cannot access the site. <a href="' . esc_url( admin_url( 'themes.php?page=falcon-maintenance' ) ) . '">Manage settings</a></p></div>';
    }
}

/**
 * Admin bar indicator
 */
add_action( 'admin_bar_menu', 'falcon_maintenance_admin_bar', 100 );
function falcon_maintenance_admin_bar( $wp_admin_bar ) {
    if ( ! falcon_maintenance_get_option( 'enabled' ) ) {
        return;
    }

    $wp_admin_bar->add_node( [
        'id'    => 'falcon-maintenance-indicator',
        'title' => '<span style="display:inline-block;width:8px;height:8px;background:#e74c3c;border-radius:50%;margin-right:6px;vertical-align:middle;"></span>Maintenance ON',
        'href'  => admin_url( 'themes.php?page=falcon-maintenance' ),
        'meta'  => [
            'title' => 'Maintenance mode is active — click to manage',
        ],
    ] );
}

// ============================================================================
// FRONT-END INTERCEPT
// ============================================================================

/**
 * Intercept front-end requests when maintenance mode is enabled.
 * Bypasses: logged-in users, wp-login, wp-admin, admin-ajax, REST API, WP Cron.
 */
add_action( 'template_redirect', 'falcon_maintenance_maybe_show', 10 );
function falcon_maintenance_maybe_show() {
    if ( ! falcon_maintenance_get_option( 'enabled' ) ) {
        return;
    }

    // Allow logged-in users through
    if ( is_user_logged_in() ) {
        return;
    }

    // Bypass wp-login.php
    if ( false !== strpos( $_SERVER['REQUEST_URI'], 'wp-login.php' ) ) {
        return;
    }

    // Bypass wp-admin
    if ( is_admin() ) {
        return;
    }

    // Bypass admin-ajax.php
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    // Bypass REST API
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }

    // Bypass WP Cron
    if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
        return;
    }

    // Serve the maintenance template
    $template = get_stylesheet_directory() . '/inc/maintenance/maintenance-template.php';
    if ( file_exists( $template ) ) {
        http_response_code( 503 );
        header( 'Retry-After: 3600' );
        header( 'Content-Type: text/html; charset=utf-8' );
        include $template;
        exit;
    }
}
