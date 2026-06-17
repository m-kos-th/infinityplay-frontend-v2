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

  const heroSection = document.querySelector('.hero');

  function updateNavVisualState() {
    if (!siteNav || !heroSection) return;
    const hasScrolledPastHero = window.scrollY > (heroSection.offsetHeight + 700);
    siteNav.classList.toggle('site-nav--active', hasScrolledPastHero);

    const hasScrolledPastHeroHidden = window.scrollY > (heroSection.offsetHeight);
    siteNav.classList.toggle('site-nav--hidden', !hasScrolledPastHeroHidden);
  }

  updateNavVisualState();
  window.addEventListener('scroll', updateNavVisualState, { passive: true });
  window.addEventListener('resize', updateNavVisualState);

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
   * WORK — stacked project cards
   * Each card pins when it reaches the top, then hands off to the
   * next card as that card reaches the same top edge.
   * ---------------------------------------------------------------- */
  const workCards = gsap.utils.toArray('.work__grid');
  const workCounter = document.querySelector('.work__counter');
  const workCounterCurrent = document.querySelector('.work__counter-current');
  const workCounterTotal = document.querySelector('.work__counter-total');
  const workEndSection = document.querySelector('.stats');
  const WORK_MIN_HEIGHT = 640;

  if (workCards.length) {
    const setWorkDesktopHeight = () => {
      if (window.innerWidth <= 680) {
        workCards.forEach((card) => {
          card.style.minHeight = '';
          card.querySelectorAll('.work__image, .work__content, .work__bg-pattern').forEach((el) => {
            el.style.height = '';
            el.style.minHeight = '';
          });
        });
        return;
      }

      const measuredHeight = Math.max(
        WORK_MIN_HEIGHT,
        ...workCards.map((card) => {
          const imageHeight = card.querySelector('.work__image')?.offsetHeight || 0;
          const contentHeight = card.querySelector('.work__content-inner')?.scrollHeight || 0;
          return Math.max(imageHeight, contentHeight, card.scrollHeight);
        })
      );

      workCards.forEach((card) => {
        card.style.minHeight = `${measuredHeight}px`;
        card.querySelectorAll('.work__image, .work__content, .work__bg-pattern').forEach((el) => {
          el.style.height = `${measuredHeight}px`;
          el.style.minHeight = `${measuredHeight}px`;
        });
      });
    };

    const syncWorkState = (activeIndex) => {
      const clampedIndex = gsap.utils.clamp(0, workCards.length - 1, activeIndex);

      workCards.forEach((card, index) => {
        card.classList.toggle('work__grid--active', index === clampedIndex);
      });

      if (workCounterCurrent) {
        workCounterCurrent.textContent = String(clampedIndex + 1).padStart(2, '0');
      }
    };

    if (workCounterTotal) {
      workCounterTotal.textContent = String(workCards.length).padStart(2, '0');
    }

    syncWorkState(0);

    const workMM = gsap.matchMedia();

    workMM.add('(min-width: 681px)', () => {
      setWorkDesktopHeight();

      if (workCounter) {
        gsap.set(workCounter, { autoAlpha: 1 });
      }

      syncWorkState(0);

      ScrollTrigger.addEventListener('refreshInit', setWorkDesktopHeight);

      workCards.forEach((card, index) => {
        const nextCard = workCards[index + 1];

        ScrollTrigger.create({
          trigger: card,
          start: 'top top',
          endTrigger: nextCard || workEndSection || card,
          end: nextCard || workEndSection ? 'top top' : 'bottom top',
          pin: true,
          pinSpacing: false,
          anticipatePin: 1,
          invalidateOnRefresh: true,
          onRefresh: (self) => {
            if (self.isActive) {
              syncWorkState(index);
            }
          },
          onEnter: () => syncWorkState(index),
          onEnterBack: () => syncWorkState(index),
          onLeave: () => {
            if (nextCard) {
              syncWorkState(index + 1);
            }
          },
          onLeaveBack: () => syncWorkState(index - 1),
        });
      });

      return () => {
        ScrollTrigger.removeEventListener('refreshInit', setWorkDesktopHeight);

        workCards.forEach((card) => {
          card.style.minHeight = '';
          card.querySelectorAll('.work__image, .work__content, .work__bg-pattern').forEach((el) => {
            el.style.height = '';
            el.style.minHeight = '';
          });
        });

        if (workCounter) {
          gsap.set(workCounter, { autoAlpha: 0 });
        }
      };
    });
  }

  /* ----------------------------------------------------------------
   * STATS — floating items drift + idle bounce
   * ---------------------------------------------------------------- */

  // Stats values scroll left in a continuous loop
  loopMarquee('#stats-track', 45, -1);

  /* ----------------------------------------------------------------
   * SERVICES — pinned 3-column deck.
   *   CENTER: each image is revealed over the previous with a diagonal
   *           slice/wipe (clip-path) as you scroll.
   *   RIGHT:  the title/description/checklist column slides vertically.
   *   LEFT:   nav active state follows scroll progress.
   * ---------------------------------------------------------------- */
  const sImgs     = gsap.utils.toArray('.services__img');
  const sTexts    = gsap.utils.toArray('.services__text');
  const SRV_COUNT = sImgs.length; // 7
  const navLinks  = gsap.utils.toArray('.services__nav-link');
  const navTrack  = document.querySelector('.services__nav-track');
  const navMarker = document.querySelector('.services__nav-marker');
  const navHead   = document.querySelector('.services__head');
  const navDeck   = document.querySelector('.services__deck');
  const navStage  = document.querySelector('.services__stage');
  const navBgDark = document.querySelector('.services__bg-dark');
  const markerY   = navMarker.offsetTop + navMarker.offsetHeight / 2;

  // How far the deck drops at slide 0 so the header clears it; it rises back to
  // centre as the header scrolls away. Measured from layout offsets (scroll-safe).
  const stageTop  = navStage.offsetTop - navStage.offsetHeight / 2;   // rendered top once centred
  const headBottom = navHead.offsetTop + navHead.offsetHeight;
  const deckDrop  = Math.max(0, headBottom - stageTop + 24);

  // Vertical offset that puts service `idx` exactly on the fixed marker line.
  function navYFor(idx) {
    const link = navLinks[idx];
    return markerY - (link.offsetTop + link.offsetHeight / 2);
  }

  // Diagonal slice driven by ONE shared seam line that sweeps bottom→top.
  // Incoming = region BELOW the seam; outgoing = region ABOVE the seam, so the
  // two never overlap — exactly one image is shown on each pixel.
  const CLIP_IN_HIDDEN = 'polygon(0% 118%, 100% 100%, 100% 100%, 0% 100%)'; // below frame → empty
  const CLIP_IN_FULL   = 'polygon(0% -30%, 100% -12%, 100% 100%, 0% 100%)'; // seam above → full
  const CLIP_OUT_FULL  = 'polygon(0% 0%, 100% 0%, 100% 100%, 0% 118%)';     // seam at bottom → full
  const CLIP_OUT_GONE  = 'polygon(0% 0%, 100% 0%, 100% -12%, 0% -30%)';     // seam above → empty

  // CENTER: stack images; first fully shown, the rest waiting below.
  gsap.set(sImgs, {
    zIndex:   (i) => i + 1,
    clipPath: (i) => (i === 0 ? CLIP_OUT_FULL : CLIP_IN_HIDDEN),
  });

  // RIGHT: stack text blocks; first in view, the rest below the fold.
  gsap.set(sTexts, { yPercent: (i) => (i === 0 ? 0 : 110) });

  // LEFT: start with the first service aligned to the marker.
  gsap.set(navTrack, { y: navYFor(0) });

  // Deck starts dropped (under the header), then lifts to centre on scroll.
  if (navDeck) gsap.set(navDeck, { y: deckDrop });

  function setActiveNav(idx) {
    navLinks.forEach((a, i) => {
      a.classList.toggle('services__nav-link--active', i === idx);
      a.classList.toggle('active', i === idx);
    });
  }

  // Timeline beats: [0-1] = intro reveal (header out → deck in, 3D Animation
  // lands full-screen), then [1..SRV_COUNT] = the content transitions.
  const srvTL = gsap.timeline({
    scrollTrigger: {
      trigger: '#services-pin',
      start: 'top top',
      end: `+=${SRV_COUNT * 100}%`,
      pin: true,
      scrub: 0.6,
      anticipatePin: 1,
      onUpdate(self) {
        // beat 0 = intro (idx 0); each later beat centres the next slide.
        const idx = Math.min(SRV_COUNT - 1, Math.max(0, Math.round(self.progress * SRV_COUNT) - 1));
        setActiveNav(idx);
      },
    },
  });

  for (let i = 1; i < SRV_COUNT; i++) {
    const at = i; // shifted +1: the intro owns beat 0
    // CENTER — new image fills in below the seam while the old one is cut away
    // above the same seam: no overlap, one image at a time inside the frame.
    srvTL.fromTo(sImgs[i],     { clipPath: CLIP_IN_HIDDEN }, { clipPath: CLIP_IN_FULL, ease: 'none', duration: 1 }, at);
    srvTL.fromTo(sImgs[i - 1], { clipPath: CLIP_OUT_FULL },  { clipPath: CLIP_OUT_GONE, ease: 'none', duration: 1 }, at);
    // RIGHT — outgoing text slides up & out, incoming rises in from below.
    srvTL.to(sTexts[i - 1], { yPercent: -110, ease: 'none', duration: 1 }, at);
    srvTL.to(sTexts[i],     { yPercent: 0,    ease: 'none', duration: 1 }, at);
  }

  // LEFT — scroll the nav list so the active label rides the marker (content beats only).
  srvTL.fromTo(
    navTrack,
    { y: navYFor(0) },
    { y: navYFor(SRV_COUNT - 1), ease: 'none', duration: SRV_COUNT - 1 },
    1
  );

  // INTRO · HEADER — scrolls up and off the top first (first half of beat 0).
  // Use the precomputed layout offset (NOT a runtime getBoundingClientRect): a
  // function value gets re-evaluated on ScrollTrigger refresh, and if the header
  // is already displaced at that moment it collapses to ~0 and stops moving.
  if (navHead) {
    srvTL.to(navHead, { y: -(headBottom + 24), ease: 'none', duration: 0.5 }, 0);
  }

  // INTRO · DECK — rises to centre only AFTER the header has left (second half),
  // so 3D Animation arrives full-screen without the header overlapping it.
  if (navDeck) {
    srvTL.to(navDeck, { y: 0, ease: 'none', duration: 0.5 }, 0.5);
  }

  // INTRO · BACKDROP — fade the navy over the bright intro gradient.
  if (navBgDark) {
    srvTL.to(navBgDark, { opacity: 1, ease: 'none', duration: 0.8 }, 0.1);
  }

  // Left nav click → jump to the matching scroll position.
  navLinks.forEach((a, i) => {
    a.addEventListener('click', (e) => {
      e.preventDefault();
      const st = srvTL.scrollTrigger;
      // slide i is centred at timeline beat i+1 (beat 0 is the intro).
      const y  = st.start + (st.end - st.start) * ((i + 1) / SRV_COUNT);
      window.scrollTo({ top: y, behavior: 'smooth' });
    });
  });

  /* ----------------------------------------------------------------
   * Refresh on resize
   * ---------------------------------------------------------------- */
  window.addEventListener('resize', () => ScrollTrigger.refresh());
});
