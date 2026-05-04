/**
 * Homepage Hero Parallax
 *
 * Scrolls the .hero--home background-position at a fraction of the
 * page scroll, creating a slow-image / fast-content parallax effect.
 *
 * Skipped on:
 * - Viewports ≤768px (mobile — touch scroll + parallax = jank)
 * - Users with prefers-reduced-motion: reduce
 *
 * Uses requestAnimationFrame to throttle scroll handler.
 */
(function () {
  'use strict';

  const SPEED = 0.4; // image moves at 40% of scroll speed
  const MOBILE_BREAKPOINT = 768;

  const hero = document.querySelector('.hero--home');
  if (!hero) return;

  // Respect user motion preference.
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reducedMotion) return;

  let ticking = false;
  let isMobile = window.innerWidth <= MOBILE_BREAKPOINT;

  function updateParallax() {
    if (isMobile) {
      hero.style.backgroundPositionY = '';
      ticking = false;
      return;
    }
    const heroRect = hero.getBoundingClientRect();
    // Only animate while the hero is in or near the viewport.
    if (heroRect.bottom < 0 || heroRect.top > window.innerHeight) {
      ticking = false;
      return;
    }
    const offset = window.scrollY * SPEED;
    hero.style.backgroundPositionY = `calc(50% + ${offset}px)`;
    ticking = false;
  }

  function onScroll() {
    if (!ticking) {
      window.requestAnimationFrame(updateParallax);
      ticking = true;
    }
  }

  function onResize() {
    isMobile = window.innerWidth <= MOBILE_BREAKPOINT;
    updateParallax();
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onResize);

  // Initial run in case the page loads scrolled down.
  updateParallax();
})();
