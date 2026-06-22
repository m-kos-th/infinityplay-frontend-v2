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
    const gsap = window.gsap;
    const ScrollTrigger = window.ScrollTrigger;
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const siteNav = document.querySelector('.site-nav');
    const navToggle = document.querySelector('.site-nav__toggle');
    const navMenu = document.querySelector('.site-nav__menu');
    const heroSection = document.querySelector('.hero');
    const heroNavToggle = document.querySelector('.hero__nav-toggle');
    const contactForm = document.querySelector('.contact__form');
    const contactStatus = document.querySelector('.contact__status');
    const contactSubmit = contactForm?.querySelector('.contact__submit');
    const contactSubmitLabel = contactSubmit?.querySelector('.contact__submit-label');
    const defaultSubmitLabel =
      contactSubmit?.dataset.defaultLabel || contactSubmitLabel?.textContent || contactSubmit?.textContent || 'Send';

    // const setContactSubmitText = (message) => {
    //   if (!contactSubmit) return;

    //   if (contactSubmitLabel) {
    //     contactSubmitLabel.textContent = message;
    //     return;
    //   }

    //   contactSubmit.textContent = message;
    // };

    // const setContactStatus = (state, message) => {
    //   if (!contactStatus) return;

    //   if (state) {
    //     contactStatus.dataset.state = state;
    //   } else {
    //     delete contactStatus.dataset.state;
    //   }

    //   contactStatus.textContent = message || '';
    // };

    // if (contactForm) {
    //   contactForm.addEventListener('submit', async (event) => {
    //     event.preventDefault();

    //     const formData = new FormData(contactForm);
    //     const payload = {
    //       full_name: String(formData.get('full_name') || '').trim(),
    //       company_name: String(formData.get('company_name') || '').trim(),
    //       email: String(formData.get('email') || '').trim(),
    //       telephone: String(formData.get('telephone') || '').trim(),
    //       services: formData
    //         .getAll('services')
    //         .map((service) => String(service).trim())
    //         .filter(Boolean),
    //       budget: String(formData.get('budget') || '').trim(),
    //       description: String(formData.get('description') || '').trim(),
    //       agree: formData.get('agree') === 'on',
    //       website: String(formData.get('website') || '').trim(),
    //     };

    //     if (!payload.full_name || !payload.email) {
    //       setContactStatus('error', 'Please add your name and email address.');
    //       return;
    //     }

    //     if (!payload.agree) {
    //       setContactStatus('error', 'Please agree to the terms before sending.');
    //       return;
    //     }

    //     try {
    //       setContactStatus('sending', 'Sending your message...');

    //       if (contactSubmit) {
    //         contactSubmit.disabled = true;
    //         setContactSubmitText('Sending...');
    //       }

    //       contactForm.setAttribute('aria-busy', 'true');

    //       const response = await fetch('/api/contact', {
    //         method: 'POST',
    //         headers: {
    //           'Content-Type': 'application/json',
    //         },
    //         body: JSON.stringify(payload),
    //       });

    //       const result = await response.json().catch(() => ({}));

    //       if (!response.ok) {
    //         throw new Error(result.error || 'Unable to send your message right now.');
    //       }

    //       contactForm.reset();

    //       const defaultService = contactForm.querySelector('input[name="services"][value="Games"]');
    //       if (defaultService) {
    //         defaultService.checked = true;
    //       }

    //       setContactStatus('success', 'Thanks. Your message has been sent successfully.');
    //     } catch (error) {
    //       setContactStatus('error', getErrorMessage(error, 'Unable to send your message right now.'));
    //     } finally {
    //       contactForm.removeAttribute('aria-busy');

    //       if (contactSubmit) {
    //         contactSubmit.disabled = false;
    //         setContactSubmitText(defaultSubmitLabel);
    //       }
    //     }
    //   });
    // }

    if (siteNav && navToggle && navMenu) {
      const setNavState = (isOpen) => {
        siteNav.classList.toggle('site-nav--open', isOpen);
        navToggle.setAttribute('aria-expanded', String(isOpen));
        navToggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
        updateNavVisualState();
      };

      navToggle.addEventListener('click', () => {
        setNavState(!siteNav.classList.contains('site-nav--open'));
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
        siteNav.classList.remove('site-nav--hidden');
        return;
      }

      const heroBottom = heroSection.offsetTop + (heroSection.offsetHeight / 2);
      const hasScrolledPastHero = window.scrollY >= heroBottom;

      siteNav.classList.toggle('site-nav--active', hasScrolledPastHero || isNavOpen);
      siteNav.classList.toggle('site-nav--hidden', !hasScrolledPastHero && !isNavOpen);
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

    if (!gsap) {
      return;
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
    loopMarquee('#marquee-work', 34, -1);
    loopMarquee('#stats-track', 45, -1);
    loopMarquee('#marquee-contact', 40, -1);

    if (!ScrollTrigger || !heroSection) {
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
     * ABOUT — characters + content reveal
     * ---------------------------------------------------------------- */
    if (document.querySelector('.about')) {
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
          opacity: 0,
          stagger: 0.12,
          duration: 0.9,
          ease: 'power3.out',
          scrollTrigger: { trigger: '.about', start: 'top 55%' },
        });
      }
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
          }),
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
     * SERVICES — pinned 3-column deck.
     * ---------------------------------------------------------------- */
    const sImgs = gsap.utils.toArray('.services__img');
    const sTexts = gsap.utils.toArray('.services__text');
    const navLinks = gsap.utils.toArray('.services__nav-link');
    const navTrack = document.querySelector('.services__nav-track');
    const navMarker = document.querySelector('.services__nav-marker');
    const navHead = document.querySelector('.services__head');
    const navDeck = document.querySelector('.services__deck');
    const navStage = document.querySelector('.services__stage');
    const navBgDark = document.querySelector('.services__bg-dark');

    if (sImgs.length && sTexts.length && navLinks.length && navTrack && navMarker && navHead && navDeck && navStage) {
      const SRV_COUNT = sImgs.length;
      const markerY = navMarker.offsetTop + navMarker.offsetHeight / 2;
      const stageTop = navStage.offsetTop - navStage.offsetHeight / 2;
      const headBottom = navHead.offsetTop + navHead.offsetHeight;
      const deckDrop = Math.max(0, headBottom - stageTop + 24);

      function navYFor(idx) {
        const link = navLinks[idx];
        return markerY - (link.offsetTop + link.offsetHeight / 2);
      }

      const CLIP_IN_HIDDEN = 'polygon(0% 118%, 100% 100%, 100% 100%, 0% 100%)';
      const CLIP_IN_FULL = 'polygon(0% -30%, 100% -12%, 100% 100%, 0% 100%)';
      const CLIP_OUT_FULL = 'polygon(0% 0%, 100% 0%, 100% 100%, 0% 118%)';
      const CLIP_OUT_GONE = 'polygon(0% 0%, 100% 0%, 100% -12%, 0% -30%)';

      gsap.set(sImgs, {
        zIndex: (i) => i + 1,
        clipPath: (i) => (i === 0 ? CLIP_OUT_FULL : CLIP_IN_HIDDEN),
      });

      gsap.set(sTexts, { yPercent: (i) => (i === 0 ? 0 : 110) });
      gsap.set(navTrack, { y: navYFor(0) });
      gsap.set(navDeck, { y: deckDrop });

      function setActiveNav(idx) {
        navLinks.forEach((link, index) => {
          link.classList.toggle('services__nav-link--active', index === idx);
          link.classList.toggle('active', index === idx);
        });
      }

      const srvTL = gsap.timeline({
        scrollTrigger: {
          trigger: '#services-pin',
          start: 'top top',
          end: `+=${SRV_COUNT * 100}%`,
          pin: true,
          scrub: 0.6,
          anticipatePin: 1,
          onUpdate(self) {
            const idx = Math.min(SRV_COUNT - 1, Math.max(0, Math.round(self.progress * SRV_COUNT) - 1));
            setActiveNav(idx);
          },
        },
      });

      for (let i = 1; i < SRV_COUNT; i += 1) {
        const at = i;
        srvTL.fromTo(sImgs[i], { clipPath: CLIP_IN_HIDDEN }, { clipPath: CLIP_IN_FULL, ease: 'none', duration: 1 }, at);
        srvTL.fromTo(sImgs[i - 1], { clipPath: CLIP_OUT_FULL }, { clipPath: CLIP_OUT_GONE, ease: 'none', duration: 1 }, at);
        srvTL.to(sTexts[i - 1], { yPercent: -110, ease: 'none', duration: 1 }, at);
        srvTL.to(sTexts[i], { yPercent: 0, ease: 'none', duration: 1 }, at);
      }

      srvTL.fromTo(
        navTrack,
        { y: navYFor(0) },
        { y: navYFor(SRV_COUNT - 1), ease: 'none', duration: SRV_COUNT - 1 },
        1,
      );

      srvTL.to(navHead, { y: -(headBottom + 24), ease: 'none', duration: 0.5 }, 0);
      srvTL.to(navDeck, { y: 0, ease: 'none', duration: 0.5 }, 0.5);

      if (navBgDark) {
        srvTL.to(navBgDark, { opacity: 1, ease: 'none', duration: 0.8 }, 0.1);
      }

      navLinks.forEach((link, index) => {
        link.addEventListener('click', (event) => {
          event.preventDefault();
          const st = srvTL.scrollTrigger;
          const y = st.start + ((st.end - st.start) * ((index + 1) / SRV_COUNT));
          window.scrollTo({ top: y, behavior: 'smooth' });
        });
      });
    }

    window.addEventListener('resize', () => ScrollTrigger.refresh());
  }

  onWindowLoad(initSiteInteractions);
})(window, document);
