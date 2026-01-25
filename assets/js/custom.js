/**
 * Molla Child Theme - Custom JavaScript
 * Optimized version with consolidated initialization
 */

(function($) {
    'use strict';
    
    /**
     * Main initialization on DOM ready
     */
    $(document).ready(function() {
        console.log('Custom JS loaded');
        
        // Initialize all components
        initCustomInteractions();
        initSmoothScroll();
        initThemeToggle();
    });
    
    /**
     * Initialize on window load (for things that need full page load)
     */
    $(window).on('load', function() {
        initAOS();
        initSwiper();
        initFAQToggles();
    });
    
    // ========================================================================
    // COMPONENT INITIALIZATIONS
    // ========================================================================
    
    /**
     * Custom element interactions
     */
    function initCustomInteractions() {
        $('.custom-element').on('click', function() {
            $(this).toggleClass('active');
        });
    }
        
/**
 * Theme Toggle (Light/Dark Mode)
 */
function initThemeToggle() {
  // Inject toggle button
  const shopIcons = document.querySelector('.shop-icons');
  if (shopIcons && !document.getElementById('theme-toggle')) {
    shopIcons.insertAdjacentHTML(
      'beforeend',
      `
      <div class="header-element theme-toggle-wrapper">
        <button id="theme-toggle" class="theme-toggle-btn" aria-label="Toggle dark mode">
          <span class="light-icon" aria-hidden="true" style="font-size:20px;">🌙</span>
          <span class="dark-icon" aria-hidden="true" style="display:none;font-size:20px;">☀️</span>
        </button>
      </div>
      `
    );
  }

  const themeToggle = document.getElementById('theme-toggle');
  const themeRoot = document.documentElement;

  if (!themeToggle) return;

  // Determine initial theme
  const savedTheme = localStorage.getItem('theme');
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const currentTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');

  // Apply initial theme
  themeRoot.setAttribute('data-theme', currentTheme);
  updateToggleButton(currentTheme);

  // Toggle handler
  themeToggle.addEventListener('click', () => {
    const nextTheme =
      themeRoot.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';

    themeRoot.setAttribute('data-theme', nextTheme);
    localStorage.setItem('theme', nextTheme);
    updateToggleButton(nextTheme);
  });

  /**
   * Update toggle button icons
   */
  function updateToggleButton(theme) {
    const lightIcon = themeToggle.querySelector('.light-icon');
    const darkIcon = themeToggle.querySelector('.dark-icon');

    if (theme === 'dark') {
      lightIcon.style.display = 'none';
      darkIcon.style.display = 'inline-block';
      themeToggle.style.opacity = '0.7';
    } else {
      lightIcon.style.display = 'inline-block';
      darkIcon.style.display = 'none';
      themeToggle.style.opacity = '1';
    }
  }
}

    
    /**
     * AOS (Animate on Scroll) initialization
     */
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
        }
    }
    
    /**
     * Swiper carousel initialization
     */
    function initSwiper() {
        if (typeof Swiper === 'undefined') {
            console.error('Swiper is not available');
            return;
        }

        $('.init-swiper').each(function() {
            var $swiperEl = $(this);
            var $configScript = $swiperEl.find('.swiper-config');
            
            var config = {
                slidesPerView: 1,
                spaceBetween: 20,
            };

            if ($configScript.length) {
                try {
                    var parsed = JSON.parse($configScript.text());
                    config = $.extend(config, parsed);
                } catch (e) {
                    console.error('Invalid Swiper config JSON', e);
                }
            }

            new Swiper(this, config);
        });
    }
    
    /**
     * FAQ accordion toggle (only one open at a time)
     */
    function initFAQToggles() {
        $('.faq-item h3').on('click', function() {
            var $clickedItem = $(this).closest('.faq-item');
            
            // Close all other open items
            $('.faq-item.faq-active').not($clickedItem).removeClass('faq-active');
            
            // Toggle the clicked item
            $clickedItem.toggleClass('faq-active');
        });
    }
    
    /**
     * Smooth scroll for anchor links (fixes jump-to-top issue)
     */
    function initSmoothScroll() {
        // Unbind Molla's default scroll handler
        $(document).off('click', 'a[href^="#"]');
        
        // Add improved smooth scroll handler (event delegation)
        $(document).on('click', 'a[href*="#"]:not([href="#"]):not([data-toggle])', function(e) {
            // Skip external links
            if (this.hostname !== location.hostname) return;
            
            // Only handle same-page anchor links
            if (this.pathname !== location.pathname && this.pathname !== '/' + location.pathname) return;
            
            var $target = $(this.hash);
            if (!$target.length) return;
            
            e.preventDefault();
            e.stopImmediatePropagation();
            
            // Calculate offset based on header height
            var headerOffset = $('.header').outerHeight() || 100;
            var scrollPosition = $target.offset().top - headerOffset;
            
            // Smooth scroll animation
            $('html, body').stop(true, false).animate({
                scrollTop: scrollPosition
            }, 800, 'swing');
            
            return false;
        });
    }
    
})(jQuery);