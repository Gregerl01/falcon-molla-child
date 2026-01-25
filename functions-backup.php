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

// Enqueue custom JS and compiled CSS
add_action('wp_enqueue_scripts', 'molla_child_custom_assets');
function molla_child_custom_assets() {
    // Custom JS
    wp_enqueue_script(
        'molla-custom-js',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Compiled CSS from SCSS
    wp_enqueue_style(
        'molla-custom-css',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array(),
        '1.0.0'
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




function rf_fix_parallax_zindex() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait a bit for Rellax to initialize
        setTimeout(function() {
            // Find the parallax background
            var parallaxBg = document.querySelector('.newsletter-section .parallax-bg.rellax');
            var newsletterSection = document.querySelector('.newsletter-section');
            
            if (parallaxBg && newsletterSection) {
                // Force correct positioning
                parallaxBg.style.position = 'absolute';
                parallaxBg.style.zIndex = '-1';
                parallaxBg.style.top = '-20%';
                parallaxBg.style.height = '120%';
                
                // Ensure section has proper stacking context
                newsletterSection.style.position = 'relative';
                newsletterSection.style.zIndex = '1';
                newsletterSection.style.isolation = 'isolate';
                
                console.log('✅ Parallax z-index fixed');
            }
            
            // Remove any test elements
            document.querySelectorAll('.rellax[style*="background: red"]').forEach(function(el) {
                el.remove();
            });
            
            // Optional: Refresh Rellax after positioning fix
            if (window.rellax) {
                window.rellax.refresh();
            }
        }, 100);
    });
    
    // Additional fix for WordPress themes that might interfere
    window.addEventListener('load', function() {
        var footer = document.querySelector('footer, .site-footer, #footer');
        if (footer) {
            footer.style.position = 'relative';
            footer.style.zIndex = '2';
            footer.style.background = footer.style.background || '#1a1a1a';
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'rf_fix_parallax_zindex', 100);

// COMPLETE UPDATED FUNCTIONS.PHP CODE
function rf_enqueue_rellax_fixed() {
    if ( is_front_page() ) {
        // Enqueue Rellax
        wp_enqueue_script( 
            'rellax-js', 
            'https://cdn.jsdelivr.net/gh/dixonandmoe/rellax@master/rellax.min.js', 
            array(), 
            '1.12.1', 
            true 
        );
        
        // Initialize with proper z-index handling
        wp_add_inline_script( 'rellax-js', '
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof Rellax !== "undefined") {
                    // Initialize Rellax
                    window.rellax = new Rellax(".rellax", {
                        speed: -2,
                        center: false,
                        wrapper: null,
                        round: true,
                        vertical: true,
                        horizontal: false
                    });
                    
                    // Fix z-index issues immediately after initialization
                    setTimeout(function() {
                        // Get all parallax elements
                        var parallaxElements = document.querySelectorAll(".newsletter-section .rellax");
                        parallaxElements.forEach(function(el) {
                            // Force absolute positioning within section
                            el.style.position = "absolute";
                            el.style.zIndex = "-1";
                            
                            // Get parent section
                            var section = el.closest(".newsletter-section");
                            if (section) {
                                section.style.position = "relative";
                                section.style.overflow = "hidden";
                                section.style.zIndex = "1";
                            }
                        });
                        
                        // Refresh Rellax positions
                        if (window.rellax) {
                            window.rellax.refresh();
                        }
                        
                        console.log("Rellax initialized with z-index fixes");
                    }, 50);
                }
            });
        ');
        
        // Add inline CSS fixes
        wp_add_inline_style( 'wp-block-library', '
            .newsletter-section {
                position: relative !important;
                z-index: 1 !important;
                overflow: hidden !important;
                isolation: isolate !important;
            }
            .newsletter-section .parallax-bg.rellax {
                position: absolute !important;
                z-index: -1 !important;
                pointer-events: none !important;
            }
            .newsletter-section .container {
                position: relative !important;
                z-index: 2 !important;
            }
        ');
    }
}
add_action( 'wp_enqueue_scripts', 'rf_enqueue_rellax_fixed' );