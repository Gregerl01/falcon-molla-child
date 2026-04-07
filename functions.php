<?php
/**
 * Molla Child Theme - Functions
 * Final optimized version for Falcon Truck Bodies
 */

require_once get_stylesheet_directory() . '/inc/sections/about-video-section.php';
require_once get_stylesheet_directory() . '/inc/customizer-hero.php';
require_once get_stylesheet_directory() . '/inc/customizer-showcase.php';

// ============================================================================
// STYLES & SCRIPTS ENQUEUING
// ============================================================================

/**
 * Enqueue parent and child theme styles
 */
add_action('wp_enqueue_scripts', 'molla_child_enqueue_styles', 10);
function molla_child_enqueue_styles() {
    // Parent theme
    wp_enqueue_style('molla-parent-style', get_template_directory_uri() . '/style.css');
    
    // Child theme main stylesheet
    wp_enqueue_style(
        'molla-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('molla-parent-style'),
        '1.0.2'
    );
    
    // Custom compiled SCSS
    wp_enqueue_style(
        'molla-custom-css',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array('molla-child-style'),
        '1.0.2'
    );
}

/**
 * Enqueue Google Fonts
 */
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');
function enqueue_google_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
}

/**
 * Enqueue Bootstrap Icons (conditionally)
 */
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_icons');
function enqueue_bootstrap_icons() {
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        array(),
        '1.11.3'
    );
}

/**
 * Enqueue AOS Animation Library (conditionally)
 */
add_action('wp_enqueue_scripts', 'enqueue_aos_library');
function enqueue_aos_library() {
    // Only on pages that use AOS
    if (is_page() || is_front_page() || is_product_category()) {
        wp_enqueue_style(
            'aos-css',
            'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css',
            array(),
            '2.3.4'
        );
        
        wp_enqueue_script(
            'aos-js',
            'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js',
            array(),
            '2.3.4',
            true
        );
    }
}

/**
 * Enqueue Swiper and custom JS
 */
add_action('wp_enqueue_scripts', 'molla_child_enqueue_assets', 20);
function molla_child_enqueue_assets() {
    // Swiper CSS
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Custom JS
    wp_enqueue_script(
        'molla-child-custom',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array('jquery', 'swiper'),
        '1.0.3',
        true
    );

    // Configurations tab JS (single product pages only)
    if (is_singular('product')) {
        wp_enqueue_script(
            'falcon-configurations',
            get_stylesheet_directory_uri() . '/assets/js/configurations.js',
            array(),
            '1.0.0',
            true
        );
    }
}

// ============================================================================
// THEME MODIFICATIONS
// ============================================================================

/**
 * Disable wpautop on specific templates
 */
add_action('template_redirect', 'disable_wpautop_conditionally');
function disable_wpautop_conditionally() {
    if (is_page_template('page-templates/custom-template.php') || is_front_page()) {
        remove_filter('the_content', 'wpautop');
        remove_filter('the_excerpt', 'wpautop');
    }
}

// ============================================================================
// WOOCOMMERCE CUSTOMIZATIONS
// ============================================================================

/**
 * Enable shortcodes in Molla custom product tabs
 * Molla tab keys: "description", "1st" (Configurations/Accessories), "2nd" (Gallery)
 */
add_filter('woocommerce_product_tabs', 'enable_shortcodes_in_custom_tabs', 98);
function enable_shortcodes_in_custom_tabs($tabs) {
    global $product;
    $product_id = $product->get_id();

    // Override Description tab if _falcon_tech_overview meta exists
    $tech_overview = get_post_meta($product_id, '_falcon_tech_overview', true);
    if ($tech_overview && isset($tabs['description'])) {
        $tabs['description']['callback'] = function() use ($tech_overview) {
            falcon_render_tech_overview($tech_overview);
        };
    }

    // Force description tab to appear when _falcon_tech_overview exists but post_content is empty
    if (!isset($tabs['description']) && $tech_overview) {
        $tabs['description'] = array(
            'title'    => __('Description', 'woocommerce'),
            'priority' => 10,
            'callback' => function() use ($tech_overview) {
                falcon_render_tech_overview($tech_overview);
            },
        );
    }

    // Override Configurations tab (Molla key: "1st") if _falcon_config_json meta exists
    $config_json = get_post_meta($product_id, '_falcon_config_json', true);
    if ($config_json && isset($tabs['1st'])) {
        $tabs['1st']['callback'] = function() use ($config_json) {
            falcon_render_configurations($config_json);
        };
    } elseif (isset($tabs['1st'])) {
        // Fallback: process tab content from Molla meta
        $tab_content = get_post_meta($product_id, 'tab_content_1st', true);
        if ($tab_content) {
            $tabs['1st']['callback'] = function() use ($tab_content) {
                echo do_shortcode($tab_content);
            };
        }
    }

    // Process Gallery tab (Molla key: "2nd")
    if (isset($tabs['2nd'])) {
        $tab_content = get_post_meta($product_id, 'tab_content_2nd', true);
        if ($tab_content) {
            $tabs['2nd']['callback'] = function() use ($tab_content) {
                echo do_shortcode($tab_content);
            };
        }
    }

    return $tabs;
}

/**
 * Render Falcon Configurations tab from _falcon_config_json meta
 */
function falcon_render_configurations($raw_json) {
    // Parse JSON — handle both string and pre-decoded array
    if (is_string($raw_json)) {
        $config = json_decode($raw_json, true);
        if (!$config) {
            echo '<!-- falcon_render_configurations: json_decode failed, error: ' . json_last_error_msg() . ' -->';
            echo '<!-- raw length: ' . strlen($raw_json) . ', first 100: ' . esc_html(substr($raw_json, 0, 100)) . ' -->';
            return;
        }
    } else {
        $config = $raw_json;
    }

    if (!isset($config['prefix'])) {
        echo '<!-- falcon_render_configurations: no prefix in config -->';
        return;
    }

    $prefix = sanitize_key($config['prefix']);
    $is_static = !empty($config['static']);

    // Re-encode to clean JSON, esc_attr() converts " to &quot; for safe HTML attribute.
    // Browser decodes &quot; back to " via getAttribute(), so JSON.parse() works.
    $json_for_attr = wp_json_encode($config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    echo '<section class="falcon-configurations" data-config="' . esc_attr($json_for_attr) . '">' . "\n";

    // Title
    echo '<h2>' . esc_html(strtoupper($prefix)) . ' Configurations</h2>' . "\n";

    // Subtitle
    if (!empty($config['subtitle'])) {
        echo '<p class="config-subtitle">' . esc_html($config['subtitle']) . '</p>' . "\n";
    }

    // Toggle buttons (multi-config products only)
    if (!$is_static && !empty($config['toggles'])) {
        echo '<div class="config-toggles">' . "\n";
        foreach ($config['toggles'] as $toggle) {
            $group_key = esc_attr($toggle['key']);
            $default_val = isset($toggle['default']) ? $toggle['default'] : '';
            echo '  <div class="toggle-group">' . "\n";
            echo '    <span class="toggle-label">' . esc_html(ucfirst($toggle['key'])) . '</span>' . "\n";
            echo '    <div class="toggle-pills" data-group="' . $group_key . '">' . "\n";
            if (!empty($toggle['options'])) {
                foreach ($toggle['options'] as $option) {
                    $val = esc_attr($option['value']);
                    $label = esc_html($option['label']);
                    $active = ($option['value'] === $default_val) ? ' active' : '';
                    echo '      <button class="toggle-pill' . $active . '" data-value="' . $val . '">' . $label . '</button>' . "\n";
                }
            }
            echo '    </div>' . "\n";
            echo '  </div>' . "\n";
        }
        echo '</div>' . "\n";
    }

    // Spec tables (populated by configurations.js)
    $table_sections = [
        'body-dims' => 'Body dimensions',
        'side-ref'  => 'Reference points &mdash; side view',
        'rear-ref'  => 'Reference points &mdash; rear view',
    ];
    foreach ($table_sections as $id_suffix => $title) {
        echo '<div class="spec-section">' . "\n";
        echo '  <div class="spec-section-title">' . $title . '</div>' . "\n";
        echo '  <table class="spec-table" id="' . esc_attr($prefix . '-' . $id_suffix) . '"></table>' . "\n";
        echo '</div>' . "\n";
    }

    // Compartment grid (static HTML from JSON)
    if (!empty($config['compartments'])) {
        echo '<div class="spec-section">' . "\n";
        echo '  <div class="spec-section-title">Compartment dimensions</div>' . "\n";
        echo '  <div class="compartment-grid">' . "\n";
        foreach ($config['compartments'] as $compartment) {
            $card_title = isset($compartment['title']) ? $compartment['title'] : (isset($compartment['side']) ? $compartment['side'] : '');
            echo '    <div class="compartment-card">' . "\n";
            echo '      <h4>' . esc_html($card_title) . '</h4>' . "\n";
            if (!empty($compartment['type'])) {
                echo '      <div class="comp-type">' . esc_html($compartment['type']) . '</div>' . "\n";
            }
            $rows = isset($compartment['rows']) ? $compartment['rows'] : [];
            foreach ($rows as $row) {
                echo '      <div class="comp-row"><span class="comp-label">' . esc_html($row[0]) . '</span><span class="comp-val">' . esc_html($row[1]) . '</span></div>' . "\n";
            }
            echo '    </div>' . "\n";
        }
        echo '  </div>' . "\n";
        echo '</div>' . "\n";
    }

    echo '</section>' . "\n";
}

/**
 * Render Falcon Tech Overview tab from _falcon_tech_overview meta
 */
function falcon_render_tech_overview($raw_json) {
    $data = is_string($raw_json) ? json_decode($raw_json, true) : $raw_json;
    if (!$data) {
        return;
    }

    $sections = [
        'construction' => 'Construction',
        'dimensions'   => 'Dimensions',
        'standard'     => 'Standard features',
    ];

    echo '<section class="falcon-configurations">' . "\n";

    foreach ($sections as $key => $title) {
        if (empty($data[$key])) {
            continue;
        }
        echo '<div class="spec-section">' . "\n";
        echo '  <div class="spec-section-title">' . esc_html($title) . '</div>' . "\n";
        echo '  <table class="spec-table">' . "\n";
        foreach ($data[$key] as $row) {
            echo '    <tr><td>' . esc_html($row[0]) . '</td><td>' . esc_html($row[1]) . '</td></tr>' . "\n";
        }
        echo '  </table>' . "\n";
        echo '</div>' . "\n";
    }

    echo '</section>' . "\n";
}

// ============================================================================
// CUSTOM SHORTCODES
// ============================================================================

/**
 * Parallax Section Shortcode
 * Usage: [gsl_parallax image="/path/img.webp" speed="1.4"]content[/gsl_parallax]
 */
add_shortcode('gsl_parallax', function ($atts, $content = null) {
    $a = shortcode_atts([
        'image'            => '',
        'speed'            => '1.5',
        'height'           => '180',
        'offset'           => '0',
        'enable_on_mobile' => 'false',
        'min_width'        => '0',
        'id'               => '',
        'class'            => '',
        'overlay'          => 'false',
        'overlay_color'    => '#000000',
        'overlay_opacity'  => '0.35',
        'container'        => 'false',
    ], $atts, 'gsl_parallax');

    if (empty($a['image'])) return '';

    // Build options
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

    // Inner content
    $inner = do_shortcode($content ?? '');
    if (filter_var($a['container'], FILTER_VALIDATE_BOOLEAN)) {
        $inner = '<div class="container"><div class="row justify-content-center"><div class="col-lg-9 py-5 my-5">'
               . $inner
               . '</div></div></div>';
    }

    // Output
    $html  = '<section' . $id_attr . ' class="' . esc_attr($classes) . '"'
          .  ' data-plugin-parallax'
          .  ' data-plugin-options="' . esc_attr($json_single) . '"'
          .  ' data-image-src="' . esc_url($a['image']) . '"'
          .  '>';
    $html .= $overlay_html . $inner . '</section>';

    return $html;
});

/**
 * Gallery image lightbox modal (Bootstrap 4)
 */
add_action('wp_footer', 'falcon_gallery_lightbox_modal');
function falcon_gallery_lightbox_modal() {
    ?>
    <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content bg-transparent border-0">
          <button type="button" class="close position-absolute" style="top:15px; right:20px; z-index:1051;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <img id="galleryModalImage" src="" class="img-fluid mx-auto d-block" alt="">
        </div>
      </div>
    </div>
    <?php
}

add_action('wp_footer', function () {
  $base_url = content_url('/uploads/diagrams/');
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('[data-diagram]').forEach(function (el) {
        const diagram = el.dataset.diagram;
        const baseUrl = <?php echo json_encode($base_url); ?>;

        fetch(baseUrl + diagram + '.svg')
          .then(response => {
            if (!response.ok) {
              throw new Error('HTTP ' + response.status);
            }
            return response.text();
          })
          .then(svg => {
            el.innerHTML = svg;
          })
          .catch(err => {
            console.warn('Falcon diagram not found:', diagram, err);
          });
      });
    });
  </script>
  <?php
});

// ============================================================================
// MAINTENANCE MODE
// ============================================================================

require_once get_stylesheet_directory() . '/inc/maintenance/maintenance-mode.php';