/**
 * main.js — InfinityPlay site interactions
 * Marquee loops require GSAP 3. Homepage scroll scenes also require ScrollTrigger.
 */

(function (window, document) {
  'use strict';

  function onWindowLoad(callback) {
    if (document.readyState === 'complete') {
      callback();
      return;
    }

    window.addEventListener('load', callback, { once: true });
  }

  function getErrorMessage(error, fallbackMessage) {
    if (error instanceof Error && error.message) {
      return error.message;
    }

    return fallbackMessage;
  }

  function initSiteInteractions() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const siteNav = document.querySelector('.site-nav');
    const navToggles = Array.from(document.querySelectorAll('.site-nav__toggle'));
    const navMenu = document.querySelector('.site-nav__menu');
    const heroSection = document.querySelector('.hero');
    const heroNavToggle = document.querySelector('.hero__nav-toggle');
    const contactForm = document.querySelector('.contact__form');
    const contactStatus = document.querySelector('.contact__status');
    const contactSubmit = contactForm?.querySelector('.contact__submit');
    const contactSubmitLabel = contactSubmit?.querySelector('.contact__submit-label');
    const defaultSubmitLabel =
      contactSubmit?.dataset.defaultLabel || contactSubmitLabel?.textContent || contactSubmit?.textContent || 'Send';

    const enhanceButtonLabel = (label) => {
      if (!label) return;

      const text = String(label.textContent || '').replace(/\s+/g, ' ').trim();

      if (!text) return;

      const animatedText = document.createElement('span');
      animatedText.className = 'btn__label-text';
      animatedText.setAttribute('data-btn-chars', '');
      animatedText.setAttribute('aria-hidden', 'true');

      Array.from(text).forEach((character, index) => {
        const span = document.createElement('span');
        span.className = character === ' ' ? 'btn__char btn__char--space' : 'btn__char';
        span.style.setProperty('--btn-char-index', String(index));
        span.style.transitionDelay = `${index * 0.01}s`;
        if (character === ' ') {
          span.style.whiteSpace = 'pre';
        }
        span.textContent = character === ' ' ? '\u00A0' : character;
        animatedText.appendChild(span);
      });

      const accessibleText = document.createElement('span');
      accessibleText.className = 'sr-only';
      accessibleText.textContent = text;

      label.textContent = '';
      label.style.setProperty('--btn-char-total', String(text.length));
      label.append(animatedText, accessibleText);
      label.dataset.btnCharsReady = 'true';
    };

    const enhanceButtonLabels = (root = document) => {
      const labels = root instanceof Element && root.matches('.btn__label')
        ? [root]
        : Array.from(root.querySelectorAll?.('.btn__label') || []);

      labels.forEach((label) => {
        if (!(label instanceof HTMLElement)) return;
        if (label.dataset.btnCharsReady === 'true') return;
        if (label.querySelector('.btn__label-text, .btn__char, .sr-only')) {
          label.dataset.btnCharsReady = 'true';
          return;
        }
        if (label.childElementCount > 0) return;

        enhanceButtonLabel(label);
      });
    };

    enhanceButtonLabels();

    if ('MutationObserver' in window && document.body) {
      const observer = new MutationObserver((records) => {
        records.forEach((record) => {
          record.addedNodes.forEach((node) => {
            if (!(node instanceof Element)) return;
            enhanceButtonLabels(node);
          });
        });
      });

      observer.observe(document.body, { childList: true, subtree: true });
    }

    if (siteNav && navToggles.length && navMenu) {
      const setNavState = (isOpen) => {
        siteNav.classList.toggle('site-nav--open', isOpen);
        navToggles.forEach((toggle) => {
          toggle.setAttribute('aria-expanded', String(isOpen));
          toggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
        });
        updateNavVisualState();
      };

      navToggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
          setNavState(!siteNav.classList.contains('site-nav--open'));
        });
      });

      if (heroNavToggle) {
        heroNavToggle.style.pointerEvents = 'auto';
        heroNavToggle.style.cursor = 'pointer';

        heroNavToggle.addEventListener('click', (event) => {
          event.preventDefault();
          event.stopPropagation();
          setNavState(!siteNav.classList.contains('site-nav--open'));
        });
      }

      navMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setNavState(false));
      });

      document.addEventListener('click', (event) => {
        if (!siteNav.contains(event.target)) {
          setNavState(false);
        }
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
          setNavState(false);
        }
      });
    }

    function updateNavVisualState() {
      if (!siteNav) return;

      const isNavOpen = siteNav.classList.contains('site-nav--open');

      if (!heroSection) {
        siteNav.classList.add('site-nav--active');
        // siteNav.classList.remove('site-nav--hidden');
        return;
      }

      const heroBottom = heroSection.offsetTop + (heroSection.offsetHeight - 100);
      const hasScrolledPastHero = window.scrollY >= heroBottom;

      siteNav.classList.toggle('site-nav--active', hasScrolledPastHero || isNavOpen);
      // siteNav.classList.toggle('site-nav--hidden', !hasScrolledPastHero && !isNavOpen);
    }

    updateNavVisualState();

    if (heroSection) {
      window.addEventListener('scroll', updateNavVisualState, { passive: true });
      window.addEventListener('resize', updateNavVisualState);
    }

    if (reduced) {
      document.querySelectorAll('.hero__video, .contact__video').forEach((video) => {
        video.pause();
        video.removeAttribute('autoplay');
      });
    }
  }

  onWindowLoad(initSiteInteractions);

  // Lenis
  const lenis = new Lenis({
    autoRaf: true,
  });

})(window, document);
