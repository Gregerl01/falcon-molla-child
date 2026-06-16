<?php
/**
 * About Video Section Shortcode
 *
 * Usage: [about_video_section title="..." subtitle="..." background="URL" video="YouTube or MP4 URL"]
 */

/**
 * Convert YouTube watch/short URLs to nocookie embed URL.
 */
function falcon_get_youtube_embed_url( $url ) {
    $id = '';

    if ( preg_match( '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m ) ) {
        $id = $m[1];
    }

    if ( ! $id ) {
        return '';
    }

    return 'https://www.youtube-nocookie.com/embed/' . $id . '?autoplay=1&rel=0';
}

add_shortcode( 'about_video_section', 'falcon_about_video_section_shortcode' );

function falcon_about_video_section_shortcode( $atts ) {
    $a = shortcode_atts( [
        'title'      => '',
        'subtitle'   => '',
        'background' => '',
        'video'      => '',
    ], $atts, 'about_video_section' );

    if ( empty( $a['background'] ) ) {
        return '';
    }

    // Determine video type and embed URL
    $video_src  = '';
    $video_type = 'youtube';

    if ( $a['video'] ) {
        $embed = falcon_get_youtube_embed_url( $a['video'] );
        if ( $embed ) {
            $video_src = $embed;
        } else {
            $video_src  = $a['video'];
            $video_type = 'mp4';
        }
    }

    // Conditionally enqueue JS only when shortcode renders
    wp_enqueue_script(
        'falcon-about-video-section',
        get_stylesheet_directory_uri() . '/assets/js/about-video-section.js',
        [],
        '1.0.0',
        true
    );

    ob_start();
    ?>
    <section class="about-video-section">
        <div class="about-video-section__bg" data-parallax-bg style="background-image:url(<?php echo esc_url( $a['background'] ); ?>)"></div>
        <div class="about-video-section__overlay"></div>
        <div class="about-video-section__content">
            <?php if ( $a['title'] ) : ?>
                <h2 class="about-video-section__title" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html( $a['title'] ); ?></h2>
            <?php endif; ?>
            <?php if ( $a['subtitle'] ) : ?>
                <p class="about-video-section__subtitle" data-aos="fade-up" data-aos-delay="250"><?php echo esc_html( $a['subtitle'] ); ?></p>
            <?php endif; ?>
            <?php if ( $video_src ) : ?>
                <div class="about-video-section__play-wrap" data-aos="zoom-in" data-aos-delay="400">
                    <button class="about-video-section__play-btn"
                            type="button"
                            aria-label="Play video"
                            data-video-src="<?php echo esc_attr( $video_src ); ?>"
                            data-video-type="<?php echo esc_attr( $video_type ); ?>">
                        <span class="about-video-section__ripple"></span>
                        <span class="about-video-section__ripple"></span>
                        <svg class="about-video-section__play-icon" viewBox="0 0 24 24" width="28" height="28" fill="currentColor" aria-hidden="true">
                            <polygon points="6,3 20,12 6,21"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ( $video_src ) : ?>
    <div class="about-video-modal" data-video-modal>
        <div class="about-video-modal__backdrop"></div>
        <div class="about-video-modal__container">
            <button class="about-video-modal__close" type="button" aria-label="Close video">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            <div class="about-video-modal__video-wrap"></div>
        </div>
    </div>
    <?php endif; ?>
    <?php

    return ob_get_clean();
}
