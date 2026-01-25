jQuery(document).ready(function($) {
    console.log('Custom JS loaded');
    
    // Example: Custom interaction
    $('.custom-element').on('click', function() {
        $(this).toggleClass('active');
    });

    // Override MutationObserver temporarily to debug
    const originalObserve = MutationObserver.prototype.observe;
    MutationObserver.prototype.observe = function(target, config) {
        if (!target || !(target instanceof Node)) {
            console.error('MutationObserver error - Invalid target:', target);
            console.trace();
            return;
        }
        return originalObserve.call(this, target, config);
    };
});

/**
 * Animation on scroll function and init
 */
function aosInit() {
    AOS.init({
        duration: 600,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
}
window.addEventListener('load', aosInit);

/**
 * Swiper initialization
 */
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swiper === 'undefined') {
        console.error('Swiper is not available');
        return;
    }

    document.querySelectorAll('.init-swiper').forEach(function(swiperEl) {
        var configScript = swiperEl.querySelector('.swiper-config');
        var config = {
            slidesPerView: 1,
            spaceBetween: 20,
        };

        if (configScript) {
            try {
                var parsed = JSON.parse(configScript.textContent);
                config = Object.assign(config, parsed);
            } catch (e) {
                console.error('Invalid Swiper config JSON', e);
            }
        }

        new Swiper(swiperEl, config);
    });
});

/**
 * FAQ Toggle
 */
// document.addEventListener('DOMContentLoaded', function() {
//     document.querySelectorAll('.faq-item h3').forEach(function(faqHeader) {
//         faqHeader.addEventListener('click', function() {
//             this.closest('.faq-item').classList.toggle('faq-active');
//         });
//     });
// });


/**
 * FAQ Toggle - Only one open at a time
 */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-item h3').forEach(function(faqHeader) {
        faqHeader.addEventListener('click', function() {
            var clickedItem = this.closest('.faq-item');
            
            // Close all other open items
            document.querySelectorAll('.faq-item.faq-active').forEach(function(openItem) {
                if (openItem !== clickedItem) {
                    openItem.classList.remove('faq-active');
                }
            });
            
            // Toggle the clicked item
            clickedItem.classList.toggle('faq-active');
        });
    });
});


/**
 * Molla Child Theme - Custom Smooth Scroll Fix
 * Fixes the jump-to-top issue with anchor links
 */

/**
 * Molla Child Theme - Custom Smooth Scroll Fix
 * Fixes the jump-to-top issue with anchor links
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Unbind Molla's default scroll handler to prevent conflicts
        $(document).off('click', 'a[href^="#"]');
        
        // Only apply smooth scroll to clicks, not on page load
        $(document).on('click', 'a[href*="#"]', function(event) {
            // Get the href attribute
            var href = $(this).attr('href');
            
            // Skip if it's just "#" or has data-toggle (for modals/tabs)
            if (href === '#' || $(this).attr('data-toggle')) {
                return;
            }
            
            // Only handle same-page anchor links (not links to other pages with anchors)
            if (this.pathname === location.pathname || this.pathname === '/' + location.pathname) {
                var hash = this.hash;
                var $target = $(hash);
                
                if ($target.length) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    
                    // Adjust this value based on your header height
                    var headerOffset = 100;
                    var scrollPosition = $target.offset().top - headerOffset;
                    
                    // Stop any ongoing animations and scroll smoothly
                    $('html, body').stop(true, false).animate({
                        scrollTop: scrollPosition
                    }, 800, 'swing');
                    
                    return false;
                }
            }
            // If it's a link to another page with hash, let it work normally
        });
    });
    
})(jQuery);