/**
 * main.js — InfinityPlay site animations
 * Requires: GSAP 3 + ScrollTrigger (loaded via CDN before this script)
 */

window.addEventListener('load', () => {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const siteNav = document.querySelector('.site-nav');
  const navToggle = document.querySelector('.site-nav__toggle');
  const navMenu = document.querySelector('.site-nav__menu');

  if (siteNav && navToggle && navMenu) {
    const setNavState = (isOpen) => {
      siteNav.classList.toggle('site-nav--open', isOpen);
      navToggle.setAttribute('aria-expanded', String(isOpen));
      navToggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
    };

    navToggle.addEventListener('click', () => {
      setNavState(!siteNav.classList.contains('site-nav--open'));
    });

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

  // updateNavVisualState();
  // window.addEventListener('scroll', updateNavVisualState, { passive: true });
  // window.addEventListener('resize', updateNavVisualState);

  if (reduced) {
    document.querySelectorAll('.hero__video').forEach((video) => {
      video.pause();
      video.removeAttribute('autoplay');
    });
  }

  if (!window.gsap || !window.ScrollTrigger) {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  /* ----------------------------------------------------------------
   * HERO — entrance animation
   * ---------------------------------------------------------------- */
  if (!reduced) {
    gsap.from('.hero__title', {
      y: 40, opacity: 0, duration: 1.1, ease: 'power3.out', delay: 0.2,
    });
    gsap.from('.hero__rule', {
      scaleX: 0, transformOrigin: 'left', duration: 1, ease: 'power3.out', delay: 0.6,
    });
    gsap.from('.hero__description', {
      y: 24, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.8,
    });
  }

  /* ----------------------------------------------------------------
   * MARQUEE — continuous loops
   * dir: -1 = RTL scroll (element moves left), 1 = LTR
   * ---------------------------------------------------------------- */
  function loopMarquee(sel, seconds, dir = 1) {
    const el = document.querySelector(sel);
    if (!el || reduced) return;
    gsap.set(el, { xPercent: dir === 1 ? -50 : 0 });
    gsap.to(el, { xPercent: dir === 1 ? 0 : -50, duration: seconds, ease: 'none', repeat: -1 });
  }

  loopMarquee('#marquee-about', 38, -1);
  loopMarquee('#marquee-work',  34, -1);

  /* ----------------------------------------------------------------
   * ABOUT — characters + content reveal
   * ---------------------------------------------------------------- */
  gsap.set('.about__character--left', { left: '-100%' });
  gsap.set('.about__character--right', { right: '-100%' });
  gsap.set('.about__character-image', { autoAlpha: 0 });
  gsap.set('.about__cloud--1', { left: '-100%', autoAlpha: 0 });
  gsap.set('.about__cloud--2', { right: '-100%', autoAlpha: 0 });

  const aboutCharactersTl = gsap.timeline({
    paused: true,
    defaults: {
      duration: 1,
      ease: 'power3.out',
    },
  });

  aboutCharactersTl
    .to('.about__cloud--1', { left: '-170px', autoAlpha: 1, duration: 0.8 }, 0)
    .to('.about__cloud--2', { right: '-170px', autoAlpha: 1, duration: 0.8 }, 0.05)
    .to('.about__character--left', { left: 0 }, 0.2)
    .to('.about__character--right', { right: 0 }, 0.2)
    .to('.about__character--left .about__character-image', { autoAlpha: 1, duration: 0.6 }, 0.3)
    .to('.about__character--right .about__character-image', { autoAlpha: 1, duration: 0.6 }, 0.35);

  ScrollTrigger.create({
    trigger: '.about__content-wrapper',
    start: 'top 30%',
    onEnter: () => aboutCharactersTl.play(),
    onLeaveBack: () => aboutCharactersTl.reverse(),
  });

  if (!reduced) {
    gsap.from('.about__content > *', {
      opacity: 0, stagger: 0.12, duration: 0.9, ease: 'power3.out',
      scrollTrigger: { trigger: '.about', start: 'top 55%' },
    });
  }

  /* ----------------------------------------------------------------
   * WORK — pinned scroll, 4 projects
   * Each project is a full-viewport grid (.work__grid).
   * Grids slide horizontally: incoming from right, outgoing to left.
   * .work__content is flex-centered so it always sits mid-viewport.
   * ---------------------------------------------------------------- */
  const workGrids   = gsap.utils.toArray('.work__grid');
  const WORK_SLIDES = workGrids.length;
  const counterEl   = document.querySelector('.work__counter-current');

  // All grids except the first start off-screen below
  gsap.set(workGrids.slice(1), { yPercent: 100 });

  const workTL = gsap.timeline({
    scrollTrigger: {
      trigger: '.work__pin',
      start:  'top top',
      end:    `+=${(WORK_SLIDES - 1) * 100}%`,
      pin:    true,
      scrub:  0.5,
      anticipatePin: 1,
      onUpdate(self) {
        // Keep the counter in sync
        if (!counterEl) return;
        const idx = Math.min(WORK_SLIDES - 1, Math.round(self.progress * (WORK_SLIDES - 1)));
        counterEl.textContent = String(idx + 1).padStart(2, '0');
      },
    },
  });

  // Build one transition per project pair
  for (let i = 1; i < WORK_SLIDES; i++) {
    const position = i - 1;
    workTL
      // Previous grid drifts up slightly (parallax pull-back)
      .to(workGrids[i - 1], {
        yPercent: 0,
        ease: 'none',
        duration: 1,
      }, position)
      // Incoming grid sweeps up from bottom
      .to(workGrids[i], {
        yPercent: 0,
        ease: 'none',
        duration: 1,
      }, position);
  }

  /* ----------------------------------------------------------------
   * STATS — floating items drift + idle bounce
   * ---------------------------------------------------------------- */
  gsap.utils.toArray('.stats__float').forEach((el, i) => {
    gsap.to(el, {
      rotation: i % 2 ? -8 : 8,
      ease: 'none',
      scrollTrigger: {
        trigger: '.stats__hero', start: 'top bottom', end: 'bottom top', scrub: 1.2,
      },
    });

    if (!reduced) {
      gsap.to(el, {
        y: '+=12',
        duration: 2.4 + i * 0.3,
        yoyo: true,
        repeat: -1,
        ease: 'sine.inOut',
      });
    }
  });

  if (!reduced) {
    gsap.from('#stats-row-1 .stats__item', {
      opacity: 0, stagger: 0.15, duration: 0.9, ease: 'power3.out',
      scrollTrigger: { trigger: '#stats-row-1', start: 'top 80%' },
    });

    gsap.from('#stats-row-2 .stats__item', {
      opacity: 0, stagger: 0.15, duration: 0.9, ease: 'power3.out',
      scrollTrigger: { trigger: '#stats-row-2', start: 'top 85%' },
    });
  }

  /* ----------------------------------------------------------------
   * SERVICES — pinned deck, 7 slides stack from bottom → top
   * ---------------------------------------------------------------- */
  const sSlides   = gsap.utils.toArray('.services__slide');
  const SRV_COUNT = sSlides.length; // 7

  gsap.set(sSlides, {
    yPercent: (i) => (i === 0 ? 0 : 100),
    zIndex:   (i) => i + 1,
  });

  const navLinks = gsap.utils.toArray('.services__nav-link');

  function setActiveNav(idx) {
    navLinks.forEach((a, i) => {
      a.classList.toggle('services__nav-link--active', i === idx);
      a.classList.toggle('active', i === idx);
    });
  }

  const srvTL = gsap.timeline({
    scrollTrigger: {
      trigger: '#services-pin',
      start: 'top top',
      end: `+=${(SRV_COUNT - 1) * 90}%`,
      pin: true,
      scrub: 0.6,
      anticipatePin: 1,
      onUpdate(self) {
        const idx = Math.min(SRV_COUNT - 1, Math.round(self.progress * (SRV_COUNT - 1)));
        setActiveNav(idx);
      },
    },
  });

  for (let i = 1; i < SRV_COUNT; i++) {
    srvTL.to(sSlides[i],     { yPercent: 0,  ease: 'none', duration: 1 }, i - 1);
    srvTL.to(sSlides[i - 1], { yPercent: -8, ease: 'none', duration: 1 }, i - 1);
  }

  // Sidebar nav click → jump to corresponding scroll position
  navLinks.forEach((a, i) => {
    a.addEventListener('click', (e) => {
      e.preventDefault();
      const st = srvTL.scrollTrigger;
      const y  = st.start + (st.end - st.start) * (i / (SRV_COUNT - 1));
      window.scrollTo({ top: y, behavior: 'smooth' });
    });
  });

  /* ----------------------------------------------------------------
   * FOOTER — character + giant text parallax
   * ---------------------------------------------------------------- */
  gsap.from('.footer__character', {
    yPercent: 18, ease: 'none',
    scrollTrigger: {
      trigger: '.footer', start: 'top bottom', end: 'center center', scrub: 1,
    },
  });

  gsap.from('.footer__giant-text', {
    yPercent: 40, ease: 'none',
    scrollTrigger: {
      trigger: '.footer', start: 'top bottom', end: 'center center', scrub: 1,
    },
  });

  if (!reduced) {
    gsap.from('.footer__headline', {
      opacity: 0, duration: 1, ease: 'power3.out',
      scrollTrigger: { trigger: '.footer', start: 'top 70%' },
    });
  }

  /* ----------------------------------------------------------------
   * Refresh on resize
   * ---------------------------------------------------------------- */
  window.addEventListener('resize', () => ScrollTrigger.refresh());
});
