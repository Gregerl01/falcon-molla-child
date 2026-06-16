<?php
/**
 * Falcon Maintenance Mode Template
 *
 * Standalone HTML page (no get_header/get_footer).
 * Loaded by maintenance-mode.php when maintenance is active
 * and the visitor is not logged in.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$opts     = get_option( 'falcon_maintenance_options', [] );
$defaults = [
    'headline' => 'New Site Coming Soon',
    'message'  => "We're building something better. Our new website is under construction and will be available shortly.",
    'phone'    => '(888) 421-4150',
    'email'    => 'sales@falcontruckbodies.com',
];

$headline = ! empty( $opts['headline'] ) ? $opts['headline'] : $defaults['headline'];
$message  = ! empty( $opts['message'] )  ? $opts['message']  : $defaults['message'];
$phone    = ! empty( $opts['phone'] )    ? $opts['phone']    : $defaults['phone'];
$email    = ! empty( $opts['email'] )    ? $opts['email']    : $defaults['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo esc_html( $headline ); ?> — Falcon Truck Bodies</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;600&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Barlow', sans-serif;
            background-color: #0d1117;
            color: #e6edf3;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Thin blue accent line at top */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #2d8fdd;
            z-index: 10;
        }

        /* Subtle grid background */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(45, 143, 221, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45, 143, 221, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }

        .maintenance-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 640px;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        /* Logo */
        .logo {
            display: block;
            max-width: 220px;
            height: auto;
            margin: 0 auto 2.5rem;
        }

        /* Card */
        .maintenance-card {
            background: #161b22;
            border: 1px solid rgba(45, 143, 221, 0.15);
            border-radius: 8px;
            padding: 2.5rem 2rem;
        }

        .maintenance-card h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 600;
            font-size: 1.75rem;
            color: #e6edf3;
            margin-bottom: 1rem;
            letter-spacing: 0.02em;
        }

        .maintenance-card .message {
            font-size: 1rem;
            line-height: 1.7;
            color: #8b949e;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: rgba(45, 143, 221, 0.15);
            margin: 0 auto 1.5rem;
            max-width: 80px;
        }

        /* Contact info */
        .contact {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            align-items: center;
        }

        .contact a {
            color: #2d8fdd;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .contact a:hover {
            color: #5aa8e6;
        }

        .contact-label {
            font-size: 0.75rem;
            color: #8b949e;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: -0.3rem;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .maintenance-card { padding: 2rem 1.25rem; }
            .maintenance-card h1 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>
    <div class="maintenance-wrapper">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/falcon-logo.webp" alt="Falcon Truck Bodies" class="logo">

        <div class="maintenance-card">
            <h1><?php echo esc_html( $headline ); ?></h1>
            <p class="message"><?php echo nl2br( esc_html( $message ) ); ?></p>

            <div class="divider"></div>

            <div class="contact">
                <?php if ( $phone ) : ?>
                    <span class="contact-label">Call Us</span>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                <?php endif; ?>
                <?php if ( $email ) : ?>
                    <span class="contact-label" style="margin-top: 0.5rem;">Email</span>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
