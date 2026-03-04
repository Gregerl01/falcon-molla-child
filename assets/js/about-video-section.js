/**
 * About Video Section – Parallax & Modal
 */
(function () {
  'use strict';

  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isDesktop = window.matchMedia('(min-width: 992px)').matches;

  // ========================================================================
  // PARALLAX
  // ========================================================================

  if (isDesktop && !prefersReducedMotion) {
    var sections = document.querySelectorAll('.about-video-section');
    var ticking = false;

    function updateParallax() {
      var winH = window.innerHeight;
      var scrollY = window.pageYOffset;

      sections.forEach(function (section) {
        var rect = section.getBoundingClientRect();
        var sectionTop = rect.top + scrollY;
        var sectionH = rect.height;

        // Only process if section is in viewport range
        if (scrollY + winH < sectionTop || scrollY > sectionTop + sectionH) return;

        var progress = (scrollY + winH - sectionTop) / (winH + sectionH);
        var bgOffset = (progress - 0.5) * 80;
        var contentOffset = (progress - 0.5) * 30;

        var bg = section.querySelector('[data-parallax-bg]');
        var content = section.querySelector('.about-video-section__content');

        if (bg) bg.style.transform = 'translate3d(0,' + bgOffset + 'px,0)';
        if (content) content.style.transform = 'translate3d(0,' + contentOffset + 'px,0)';
      });

      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) {
        requestAnimationFrame(updateParallax);
        ticking = true;
      }
    }, { passive: true });

    // Initial position
    updateParallax();
  }

  // ========================================================================
  // VIDEO MODAL
  // ========================================================================

  var lastFocused = null;

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.about-video-section__play-btn');
    if (!btn) return;

    var modal = document.querySelector('[data-video-modal]');
    if (!modal) return;

    var videoWrap = modal.querySelector('.about-video-modal__video-wrap');
    var src = btn.getAttribute('data-video-src');
    var type = btn.getAttribute('data-video-type');

    if (!src || !videoWrap) return;

    lastFocused = btn;

    if (type === 'youtube') {
      videoWrap.innerHTML = '<iframe src="' + src + '" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
    } else {
      videoWrap.innerHTML = '<video src="' + src + '" controls autoplay></video>';
    }

    modal.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  });

  function closeModal() {
    var modal = document.querySelector('[data-video-modal].is-active');
    if (!modal) return;

    var videoWrap = modal.querySelector('.about-video-modal__video-wrap');
    modal.classList.remove('is-active');
    document.body.style.overflow = '';

    // Destroy player to stop audio
    if (videoWrap) videoWrap.innerHTML = '';

    // Return focus
    if (lastFocused) {
      lastFocused.focus();
      lastFocused = null;
    }
  }

  // Close on backdrop or close button click
  document.addEventListener('click', function (e) {
    if (e.target.closest('.about-video-modal__close') || e.target.closest('.about-video-modal__backdrop')) {
      closeModal();
    }
  });

  // Close on Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });
})();
