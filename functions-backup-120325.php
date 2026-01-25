<?php

add_action( 'wp_enqueue_scripts', 'molla_child_css', 1001 );

// Load CSS
function molla_child_css() {
	// molla child theme styles
	wp_deregister_style( 'styles-child' );
	wp_register_style( 'styles-child', esc_url( get_stylesheet_directory_uri() ) . '/style.css' );
	wp_enqueue_style( 'styles-child' );
}



// Enqueue parent theme styles
add_action('wp_enqueue_scripts', 'molla_child_enqueue_styles');
function molla_child_enqueue_styles() {
    wp_enqueue_style('molla-parent-style', get_template_directory_uri() . '/style.css');
}

// Enqueue custom compiled CSS only (JS moved to molla_child_enqueue_assets)
add_action('wp_enqueue_scripts', 'molla_child_custom_assets');
function molla_child_custom_assets() {
    // Compiled CSS from SCSS
    wp_enqueue_style(
        'molla-custom-css',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array(),
        '1.0.1'
    );
}

// Add temporarily to functions.php to debug
add_action('init', function() {
    if (current_user_can('administrator')) {
        $post = get_post(1369);
        if ($post) {
            error_log('Post 1369 exists: ' . $post->post_title . ' (Type: ' . $post->post_type . ', Status: ' . $post->post_status . ')');
        } else {
            error_log('Post 1369 does not exist');
        }
    }
});

// Disable wpautop on specific pages/templates
add_filter('the_content', 'disable_wpautop_on_custom_pages', 9);
function disable_wpautop_on_custom_pages($content) {
    // For specific page templates
    if (is_page_template('page-templates/custom-template.php')) {
        remove_filter('the_content', 'wpautop');
        return $content;
    }
    
    // For specific page IDs
    if (is_page(array(123, 456))) { // Replace with your page IDs
        remove_filter('the_content', 'wpautop');
        return $content;
    }
    
    // For the homepage
    if (is_front_page()) {
        remove_filter('the_content', 'wpautop');
        return $content;
    }
    
    return $content;
}

function enqueue_bootstrap_icons() {
    // Bootstrap Icons CSS
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        array(),
        '1.11.3'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_icons');


function enqueue_aos_library() {
    // AOS CSS
    wp_enqueue_style(
        'aos-css',
        'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css',
        array(),
        '2.3.4'
    );
    
    // AOS JS
    wp_enqueue_script(
        'aos-js',
        'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js',
        array(),
        '2.3.4',
        true
    );
    
    // Initialize AOS
    wp_add_inline_script('aos-js', '
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: "ease-in-out"
        });
    ');
}
add_action('wp_enqueue_scripts', 'enqueue_aos_library');



// add products to homepage
add_action('wp_footer', function () {
  if ( ! is_page() ) return;
  $post = get_queried_object();
  if ( empty($post->post_content) ) return;
  if ( ! ( has_shortcode($post->post_content, 'products') || has_shortcode($post->post_content, 'featured_products') ) ) return;
  ?>
  <script>
  (function($){
    if (!window.jQuery) return;

    function hydrateProducts(){
      $('.product-wrap script[type="text/template"]').each(function(){
        try{
          var raw = $(this).text().trim();
          if (raw[0] === '"' && raw[raw.length-1] === '"') raw = raw.slice(1, -1);
          raw = raw
            .replace(/\\r\\n/g, '\n')
            .replace(/\\n/g, '\n')
            .replace(/\\"/g, '"')
            .replace(/\\\//g, '/')
            .replace(/\\t/g, '\t');
          var $html = $(raw);

          // De-lazy images: move data-* to real attrs and remove placeholder padding
          $html.find('img.molla-lazyload').each(function(){
            var $img = $(this);
            var src = $img.attr('data-src');
            var srcset = $img.attr('data-srcset');
            if (src)    $img.attr('src', src);
            if (srcset) $img.attr('srcset', srcset);

            // Kill the lazy placeholders
            $img.removeAttr('data-src data-srcset');
            $img.removeClass('molla-lazyload');

            // Remove only the padding-top from inline style (keep any other styles)
            var style = $img.attr('style') || '';
            if (style) {
              style = style.replace(/padding-top\s*:\s*[^;]+;?/i, '');
              style = style.trim();
              if (style) $img.attr('style', style); else $img.removeAttr('style');
            }
            // Ensure it renders normally
            $img.css({ width: '100%', height: 'auto', display: 'block' });
          });

          // Replace the skeleton placeholder
          var $skel = $(this).next('.skel-pro');
          if ($skel.length) $skel.replaceWith($html);

          // Optional: remove the template <script> node
          $(this).remove();
        } catch(e) { console.error('Hydrate fallback failed:', e); }
      });
    }

    $(hydrateProducts);
  })(jQuery);
  </script>
  <?php
}, 99);



// [gsl_parallax image="/path/img.webp" speed="1.4" container="true"]...inner HTML...[/gsl_parallax]
add_shortcode('gsl_parallax', function ($atts, $content = null) {
    $a = shortcode_atts([
        'image'            => '',      // required
        'speed'            => '1.5',   // float
        'height'           => '180',   // percent (number only)
        'offset'           => '0',     // px
        'enable_on_mobile' => 'false', // "true"|"false"
        'min_width'        => '0',     // px (scrollableParallaxMinWidth)
        'id'               => '',
        'class'            => '',
        'overlay'          => 'false',     // optional dark overlay
        'overlay_color'    => '#000000',
        'overlay_opacity'  => '0.35',
        'container'        => 'false',     // auto-wrap inner content in .container > .row > .col
    ], $atts, 'gsl_parallax');

    if (empty($a['image'])) return ''; // require an image

    // Build Porto-style options string (single quotes) that our JS parses
    $opts = [
        'speed' => (float) $a['speed'],
        'height' => (float) $a['height'],
        'offset' => (float) $a['offset'],
        'enableOnMobile' => filter_var($a['enable_on_mobile'], FILTER_VALIDATE_BOOLEAN),
        'scrollableParallaxMinWidth' => (int) $a['min_width'],
    ];
    $json_single = str_replace('"', "'", json_encode($opts, JSON_UNESCAPED_SLASHES));

    $classes = trim('parallax section section-parallax ' . $a['class']);
    $id_attr = $a['id'] ? ' id="' . esc_attr($a['id']) . '"' : '';

    // Optional overlay
    $overlay_html = '';
    if (filter_var($a['overlay'], FILTER_VALIDATE_BOOLEAN)) {
        $color   = esc_attr($a['overlay_color']);
        $opacity = max(0, min(1, (float) $a['overlay_opacity']));
        $overlay_html = '<span class="gsl-parallax-overlay" style="position:absolute;inset:0;pointer-events:none;background:' . $color . ';opacity:' . $opacity . '"></span>';
    }

    // Inner content (allow nested shortcodes)
    $inner = do_shortcode($content ?? '');
    if (filter_var($a['container'], FILTER_VALIDATE_BOOLEAN)) {
        $inner = '<div class="container"><div class="row justify-content-center"><div class="col-lg-9 py-5 my-5">'
               . $inner
               . '</div></div></div>';
    }

    // Output (script injects .parallax-background; we don't hardcode it)
    $html  = '<section' . $id_attr . ' class="' . esc_attr($classes) . '"'
          .  ' data-plugin-parallax'
          .  ' data-plugin-options="' . esc_attr($json_single) . '"'
          .  ' data-image-src="' . esc_url($a['image']) . '"'
          .  '>';
    $html .= $overlay_html . $inner . '</section>';

    return $html;
});

// Disable Molla / WooCommerce product image lightbox
add_action( 'after_setup_theme', function() {
    // Make sure WooCommerce has already added support
    remove_theme_support( 'wc-product-gallery-lightbox' );
}, 100 );





function molla_child_enqueue_assets() {

    // Swiper CSS (CDN)
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Swiper JS (global Swiper available on window)
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Custom JS - depends on jquery and swiper, version bumped to bust cache
    wp_enqueue_script(
        'molla-child-custom',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array( 'jquery', 'swiper' ),
        '1.0.2',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'molla_child_enqueue_assets', 20 );



// Process shortcodes in Molla custom product tabs
add_filter('the_content', 'process_molla_tab_shortcodes');
function process_molla_tab_shortcodes($content) {
    // Check if we're on a single product page
    if (is_product()) {
        return do_shortcode($content);
    }
    return $content;
}

// Alternative: Hook directly into tab content output
add_filter('woocommerce_product_tabs', 'enable_shortcodes_in_custom_tabs', 98);
function enable_shortcodes_in_custom_tabs($tabs) {
    global $product;
    
    // Process tab_content_2nd (your Gallery tab)
    if (isset($tabs['tab-custom-2'])) {
        $tab_content = get_post_meta($product->get_id(), 'tab_content_2nd', true);
        if ($tab_content) {
            $tabs['tab-custom-2']['content'] = do_shortcode($tab_content);
        }
    }
    
    return $tabs;
}