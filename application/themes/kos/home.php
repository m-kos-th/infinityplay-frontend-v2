<?php
defined('C5_EXECUTE') or die('Access Denied.');
$this->inc('elements/header.php');
?>

<main id="main-content">

  <!-- ════════════════════════════════════════════════════════════════
       §1 · HERO
  ═════════════════════════════════════════════════════════════════ -->
  <section class="hero" id="home" aria-labelledby="hero-title">
    <div class="hero__media" aria-hidden="true">
      <video class="hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="/application/themes/kos/assets/video/background.mp4" type="video/mp4">
      </video>
      <video class="hero__video hero__video--shadow" autoplay muted loop playsinline preload="metadata">
        <source src="/application/themes/kos/assets/video/shadow.mp4" type="video/mp4">
      </video>
    </div>
    <div class="hero__nav-echo" aria-hidden="true">
      <div class="hero__nav-row">
        <div class="site-nav__toggle hero__nav-toggle">
          <span class="site-nav__toggle-line"></span>
          <span class="site-nav__toggle-line"></span>
        </div>
        <div class="site-nav__brand hero__nav-brand">
          <svg class="site-nav__brand-mark" width="116" height="12" viewBox="0 0 116 12" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
            <path d="M-0.00042963 11.2002V0.00019455H2.39957V11.2002H-0.00042963ZM5.60082 11.2002V0.00019455H7.76082L13.2008 6.9602V0.00019455H15.6008V11.2002H13.4408L8.00082 4.24019V11.2002H5.60082ZM18.7958 11.2002V0.00019455H27.0358V2.2402H21.1958V4.8802H25.7558V7.12019H21.1958V11.2002H18.7958ZM29.3502 11.2002V0.00019455H31.7502V11.2002H29.3502ZM34.9514 11.2002V0.00019455H37.1114L42.5514 6.9602V0.00019455H44.9514V11.2002H42.7914L37.3514 4.24019V11.2002H34.9514ZM48.1464 11.2002V0.00019455H50.5464V11.2002H48.1464ZM55.8277 11.2002V2.2402H52.6277V0.00019455H61.4277V2.2402H58.2277V11.2002H55.8277ZM66.2252 11.2002V7.2002L61.9852 0.00019455H64.7852L67.3932 4.8002H67.4572L70.0652 0.00019455H72.8652L68.6252 7.2002V11.2002H66.2252ZM74.5439 11.2002V0.00019455H79.2639C81.6479 0.00019455 83.2639 1.5842 83.2639 3.76019C83.2639 5.93619 81.6479 7.5202 79.2639 7.5202H76.9439V11.2002H74.5439ZM76.9439 5.2802H79.1839C80.1439 5.2802 80.7839 4.6562 80.7839 3.76019C80.7839 2.86419 80.1439 2.2402 79.1839 2.2402H76.9439V5.2802ZM85.7389 11.2002V0.00019455H88.1389V8.9602H93.3389V11.2002H85.7389ZM98.3783 6.4802H101.098L99.7703 2.80019H99.7063L98.3783 6.4802ZM94.0583 11.2002L98.3783 0.00019455H101.098L105.418 11.2002H102.858L101.898 8.6402H97.5783L96.6183 11.2002H94.0583ZM108.693 11.2002V7.2002L104.453 0.00019455H107.253L109.861 4.8002H109.925L112.533 0.00019455H115.333L111.093 7.2002V11.2002H108.693Z" fill="currentColor"/>
          </svg>
        </div>
      </div>
      <div class="site-nav__emblem hero__nav-emblem">
        <svg class="site-nav__emblem-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="36" viewBox="0 0 28 36" fill="none" focusable="false">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M16.705 0.00120353C16.8376 -0.0154871 16.9226 0.145182 16.839 0.249844C15.3869 2.06653 13.7545 6.37865 15.7941 8.7826C17.98 11.359 21.0673 10.0701 21.2519 7.96767C21.2605 7.86964 21.3555 7.79962 21.4459 7.83739C23.1418 8.54566 25.2625 11.6117 24.783 15.453C24.7758 15.5103 24.7349 15.5578 24.6802 15.5752C23.8207 15.8482 22.9938 16.4903 22.425 17.4197C21.3457 19.1832 21.6039 21.3132 23.0017 22.1773C24.2056 22.9215 25.8621 22.4839 26.9881 21.2215C27.0322 21.172 27.1037 21.1569 27.1631 21.1862L27.9192 21.5597C27.9811 21.5903 28.0129 21.6607 27.9951 21.7277L25.9901 29.2476C25.9788 29.2901 25.9489 29.3252 25.9088 29.3429L20.1088 31.9147C20.0851 31.9252 20.0646 31.942 20.0495 31.9632L17.2238 35.9391C17.1966 35.9773 17.1528 36 17.1061 36H11.4634C11.4209 36 11.3805 35.9812 11.353 35.9485L8.23792 32.2486C8.2229 32.2307 8.20381 32.2168 8.18229 32.208L1.90879 29.6286C1.87278 29.6138 1.84422 29.5851 1.82957 29.5488L0.0106392 25.049C-0.012196 24.9925 0.00248545 24.9277 0.047403 24.8867L0.705805 24.2859C0.762627 24.234 0.84971 24.2361 0.906354 24.2882C2.06126 25.3494 3.70621 25.4841 4.6933 24.5566C5.74024 23.5729 5.65068 21.7668 4.49326 20.5226C3.81289 19.7912 2.91497 19.4168 2.07771 19.4322C2.00528 19.4335 1.94047 19.3843 1.92776 19.3127C1.46411 16.6982 2.79948 13.6903 4.42397 12.8949C4.50156 12.8569 4.59161 12.9024 4.61851 12.9848C5.2225 14.8353 7.42836 16.133 9.32314 15.414C11.7451 14.4948 11.0628 9.89619 7.01237 9.37428C6.93607 9.36445 6.87683 9.29989 6.8829 9.22282C7.10649 6.38578 9.95658 0.851004 16.705 0.00120353ZM12.6697 23.3707C12.6563 23.4207 12.6174 23.4598 12.5676 23.4732L8.17748 24.6606C8.11433 24.6777 8.07045 24.7352 8.07045 24.8009V25.1089C8.07045 25.1746 8.11433 25.2322 8.17748 25.2493L12.5676 26.4365C12.6174 26.4499 12.6563 26.489 12.6697 26.539L13.851 30.9512C13.868 31.0147 13.9252 31.0588 13.9906 31.0588H14.297C14.3624 31.0588 14.4197 31.0147 14.4367 30.9512L15.6181 26.539C15.6315 26.489 15.6704 26.4499 15.7202 26.4365L20.1102 25.2493C20.1733 25.2322 20.2172 25.1746 20.2172 25.1089V24.8009C20.2172 24.7352 20.1733 24.6777 20.1102 24.6606L15.7201 23.4732C15.6704 23.4598 15.6315 23.4207 15.6181 23.3707L14.4367 18.9587C14.4197 18.8952 14.3624 18.8511 14.297 18.8511H13.9906C13.9252 18.8511 13.868 18.8952 13.851 18.9587L12.6697 23.3707Z" fill="currentColor"/>
        </svg>
      </div>
    </div>
    <div class="hero__inner">
      <div class="hero__copy">
        <h1 class="hero__title" id="hero-title">
          Crafting Legendary<br>Gaming Experiences
        </h1>
        <hr class="hero__rule" aria-hidden="true">
        <p class="hero__description">
          We bring your wildest gaming visions to life. From concept to launch,
          Infinity Play delivers immersive worlds and unforgettable adventures.
        </p>
      </div>
    </div>
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       §2 · ABOUT
  ═════════════════════════════════════════════════════════════════ -->
  <section class="about" id="about" aria-labelledby="about-title">
    <!-- Marquee watermark -->
    <div class="about__marquee" aria-hidden="true">
      <div class="about__marquee-band" aria-hidden="true">
        <div class="about__marquee-surface">
          <div class="marquee marquee--about" id="marquee-about">
            INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;
          </div>
        </div>
      </div>
    </div>

    <div class="about__content-wrapper">
      <div class="about__characters" aria-hidden="true">
        <figure class="about__character about__character--left">
          <div class="about__character-image"></div>
          <div class="about__cloud about__cloud--1" aria-hidden="true"></div>
        </figure>
        <figure class="about__character about__character--right">
          <div class="about__character-image"></div>
          <div class="about__cloud about__cloud--2" aria-hidden="true"></div>
        </figure>
      </div>

      <div class="about__content">
        <div class="btn__badge-wrap">
          <span class="btn__badge">
            <span class="btn__badge-text">About Us</span>
          </span>
          <span class="btn__sparkles" aria-hidden="true"></span>
        </div>
        <h2 class="about__title" id="about-title">
          Infinite Artistry<br>Expert Engineering
        </h2>
        <p class="about__description">
          We are a full-cycle game development studio and production house dedicated to
          pushing the boundaries of digital storytelling.
        </p>
      </div>
    </div>
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       §3 · FEATURED WORK — pinned scroll, 4 projects
  ═════════════════════════════════════════════════════════════════ -->
  <section class="work" id="work" aria-labelledby="work-heading">
    <h2 class="sr-only" id="work-heading">Featured Work</h2>

    <div class="work__pin">

      <!-- Marquee watermark -->
      <div class="marquee marquee--work" id="marquee-work" aria-hidden="true">
        FEATURED WORK&nbsp;&nbsp;&nbsp;FEATURED WORK&nbsp;&nbsp;&nbsp;FEATURED WORK&nbsp;&nbsp;&nbsp;FEATURED WORK&nbsp;&nbsp;&nbsp;FEATURED WORK&nbsp;&nbsp;&nbsp;FEATURED WORK&nbsp;&nbsp;&nbsp;
      </div>

      <!-- Scroll progress counter -->
      <div class="work__counter" aria-hidden="true">
        <span class="work__counter-current">01</span>
        <span class="work__counter-sep">/</span>
        <span class="work__counter-total">04</span>
      </div>

      <div class="work__grid-wrapper">
        <!-- Project 1: Dawn of the Damned -->
        <article class="work__grid" data-index="0" aria-label="Project: Dawn of the Damned">
          <div class="work__image work__image--dawn"></div>
          <div class="work__content">
            <div class="work__content-inner">
              <div class="work__logo work__logo--dawn">
                <span class="work__logo-fallback work__logo-fallback--dawn" aria-hidden="true">
                  Dawn<br>of the<br>Damned
                </span>
              </div>
              <p class="work__slide-description">Post-apocalyptic zombie survival shooter on Unreal Engine 5.</p>
              <a class="btn" href="#" aria-label="Discover Dawn of the Damned"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">Discover</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
            </div>
          </div>
          <div class="work__bg-pattern"></div>
        </article>

        <!-- Project 2: Trick or Seek -->
        <article class="work__grid work__grid--reverse" data-index="1" aria-label="Project: Trick or Seek">
          <div class="work__bg-pattern"></div>
          <div class="work__content">
            <div class="work__content-inner">
              <div class="work__logo work__logo--trick">
                <span class="work__logo-fallback work__logo-fallback--trick" aria-hidden="true">
                  Trick<br>or Seek
                </span>
              </div>
              <p class="work__slide-description">Charming multiplayer hide-and-seek party game.</p>
              <a class="btn" href="#" aria-label="Discover Trick or Seek"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">Discover</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
            </div>
          </div>
          <div class="work__image work__image--trick"></div>
        </article>

        <!-- Project 3: Outlanders -->
        <article class="work__grid" data-index="2" aria-label="Project: Outlanders">
          <div class="work__image work__image--outlanders">
            <video class="work__video" src="/application/themes/kos/assets/video/work-outlanders.mp4" autoplay loop muted playsinline></video>
          </div>
          <div class="work__content">
            <div class="work__content-inner">
              <div class="work__logo work__logo--outlanders">
                <span class="work__logo-fallback work__logo-fallback--outlanders" aria-hidden="true">
                  Outlanders
                </span>
              </div>
              <p class="work__slide-description">Blockchain-integrated MMORPG set in an open fantasy world.</p>
              <a class="btn" href="#" aria-label="Discover Outlanders"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">Discover</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
            </div>
          </div>
          <div class="work__bg-pattern"></div>
        </article>

        <!-- Project 4: UMT -->
        <article class="work__grid" data-index="3" aria-label="Project: Ultimate Muay Thai">
          <div class="work__bg-pattern"></div>
          <div class="work__content">
            <div class="work__content-inner">
              <div class="work__logo work__logo--umt">
                <span class="work__logo-fallback work__logo-fallback--umt" aria-hidden="true">UMT</span>
              </div>
              <p class="work__slide-description">Ultimate Muay Thai — competitive fighting experience.</p>
              <a class="btn" href="#" aria-label="Discover Ultimate Muay Thai"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">Discover</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
            </div>
          </div>
          <div class="work__image work__image--umt">
            <video class="work__video" src="/application/themes/kos/assets/video/work-umt.mp4" autoplay loop muted playsinline></video>
          </div>
        </article>
      </div>

    </div><!-- /.work__pin -->
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       §4 · STATS
  ═════════════════════════════════════════════════════════════════ -->
  <section class="stats" id="stats" aria-labelledby="stats-headline">

    <div class="stats__hero">
      <div class="stats__circuit" aria-hidden="true">
        <svg class="stats__circuit-art" viewBox="0 0 1201 551" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
          <g filter="url(#stats-circuit-filter)">
            <path d="M568.473 200.5C566.234 201.317 564.177 202.616 562.46 204.333L534.333 232.46C531.426 235.367 527.484 237 523.373 237H395.127C390.751 237 386.554 238.739 383.46 241.833L315.333 309.96C312.239 313.054 310.5 317.252 310.5 321.628V363.373C310.5 367.484 308.867 371.426 305.96 374.333L129.293 551H0V490.5H35.873C40.249 490.5 44.4458 488.761 47.54 485.667L117.167 416.04C120.261 412.946 122 408.749 122 404.373V340.934C122 336.648 123.774 332.554 126.901 329.624L260.227 204.689C263.009 202.082 266.652 200.595 270.456 200.505L270.825 200.5H568.473ZM893.333 25.46C890.239 28.5543 888.5 32.7519 888.5 37.1279V78.873C888.5 82.9837 886.867 86.9263 883.96 89.833L815.833 157.96C812.926 160.867 808.984 162.5 804.873 162.5H676.564C672.227 162.5 668.063 164.208 664.976 167.255L636.822 195.033C633.922 197.895 630.01 199.5 625.936 199.5H625.873C626.082 199.5 626.292 199.505 626.5 199.513V200.489C626.312 200.496 626.124 200.5 625.936 200.5H625.873C629.984 200.5 633.926 202.133 636.833 205.04L664.96 233.167C668.054 236.261 672.252 238 676.628 238H804.873C808.984 238 812.926 239.633 815.833 242.54L883.96 310.667C886.867 313.574 888.5 317.517 888.5 321.628V363.373C888.5 367.749 890.239 371.946 893.333 375.04L1069.29 551H837.707L741.54 454.833C738.446 451.739 734.249 450 729.873 450H470.128C465.752 450 461.554 451.739 458.46 454.833L362.293 551H130.707L306.667 375.04C309.761 371.946 311.5 367.749 311.5 363.373V321.628C311.5 317.517 313.133 313.574 316.04 310.667L384.167 242.54C387.074 239.633 391.016 238 395.127 238H523.373C527.749 238 531.946 236.261 535.04 233.167L563.167 205.04C566.074 202.133 570.016 200.5 574.127 200.5H574.064C573.876 200.5 573.688 200.496 573.5 200.489V199.513C573.708 199.505 573.918 199.5 574.127 199.5H574.064C569.99 199.5 566.079 197.895 563.179 195.033L535.024 167.255C531.937 164.208 527.773 162.5 523.436 162.5H395.127C391.016 162.5 387.074 160.867 384.167 157.96L316.04 89.833C313.133 86.9263 311.5 82.9837 311.5 78.873V37.1279C311.5 32.7519 309.761 28.5543 306.667 25.46L281.207 0H918.793L893.333 25.46ZM729.873 451C733.984 451 737.926 452.633 740.833 455.54L836.293 551H363.707L459.167 455.54C462.074 452.633 466.017 451 470.128 451H729.873ZM929.175 200.5C933.111 200.5 936.901 201.998 939.773 204.689L1073.1 329.624C1076.23 332.554 1078 336.648 1078 340.934V404.373C1078 408.749 1079.74 412.946 1082.83 416.04L1152.46 485.667C1155.55 488.761 1159.75 490.5 1164.13 490.5H1201V551H1070.71L894.04 374.333C891.133 371.426 889.5 367.484 889.5 363.373V321.628C889.5 317.252 887.761 313.054 884.667 309.96L816.54 241.833C813.446 238.739 809.249 237 804.873 237H676.628C672.517 237 668.574 235.367 665.667 232.46L637.54 204.333C635.823 202.616 633.766 201.317 631.527 200.5H929.175ZM1201 489.5H1164.13C1160.02 489.5 1156.07 487.867 1153.17 484.96L1083.54 415.333C1080.63 412.426 1079 408.484 1079 404.373V340.934C1079 336.372 1077.11 332.013 1073.78 328.894L940.457 203.96C938.819 202.425 936.902 201.256 934.83 200.5H1045.87C1050.25 200.5 1054.45 198.761 1057.54 195.667L1120.17 133.04C1123.07 130.133 1127.02 128.5 1131.13 128.5H1201V489.5ZM68.873 128.5C72.9837 128.5 76.9263 130.133 79.833 133.04L142.46 195.667C145.554 198.761 149.751 200.5 154.127 200.5H265.17C263.098 201.256 261.181 202.425 259.543 203.96L126.218 328.894C122.889 332.013 121 336.372 121 340.934V404.373C121 408.484 119.367 412.426 116.46 415.333L46.833 484.96C43.9263 487.867 39.9837 489.5 35.873 489.5H0V128.5H68.873ZM603.55 171.002C594.44 172.155 590.593 179.666 590.291 183.517C590.283 183.621 590.363 183.709 590.466 183.723C595.933 184.431 596.854 190.672 593.585 191.919C591.027 192.895 588.05 191.133 587.234 188.622C587.198 188.51 587.076 188.448 586.972 188.5C584.779 189.58 582.977 193.662 583.603 197.21C583.62 197.307 583.707 197.374 583.805 197.372C584.935 197.351 586.147 197.86 587.065 198.853C588.628 200.541 588.748 202.992 587.335 204.327C586.003 205.585 583.782 205.403 582.224 203.963C582.147 203.892 582.03 203.889 581.953 203.959L581.064 204.774C581.004 204.83 580.984 204.918 581.015 204.995L583.47 211.102C583.489 211.151 583.528 211.19 583.576 211.21L592.045 214.711C592.074 214.723 592.1 214.742 592.12 214.766L596.325 219.787C596.362 219.831 596.417 219.857 596.475 219.857H604.091C604.154 219.857 604.213 219.826 604.25 219.774L608.064 214.379C608.085 214.35 608.112 214.327 608.145 214.312L615.974 210.822C616.028 210.798 616.068 210.751 616.083 210.693L618.79 200.487C618.814 200.396 618.771 200.301 618.688 200.26L617.667 199.753C617.587 199.713 617.49 199.734 617.431 199.801C615.911 201.514 613.675 202.107 612.05 201.098C610.163 199.925 609.814 197.034 611.271 194.641C612.038 193.379 613.155 192.508 614.315 192.138C614.389 192.114 614.444 192.049 614.454 191.972C615.101 186.759 612.238 182.598 609.949 181.637C609.827 181.585 609.699 181.68 609.688 181.813C609.438 184.667 605.271 186.415 602.32 182.919C599.567 179.656 601.77 173.804 603.73 171.339C603.843 171.197 603.729 170.979 603.55 171.002ZM600.299 196.584C600.387 196.584 600.464 196.643 600.487 196.729L602.082 202.718C602.1 202.786 602.154 202.838 602.221 202.856L608.146 204.468C608.232 204.491 608.291 204.569 608.291 204.658V205.076C608.291 205.165 608.232 205.243 608.146 205.267L602.221 206.878C602.154 206.896 602.1 206.95 602.082 207.018L600.487 213.005C600.464 213.091 600.387 213.151 600.299 213.151H599.886C599.797 213.151 599.72 213.091 599.697 213.005L598.103 207.018C598.084 206.95 598.032 206.896 597.965 206.878L592.039 205.267C591.954 205.243 591.895 205.165 591.895 205.076V204.658C591.895 204.569 591.953 204.491 592.038 204.468L597.965 202.856C598.032 202.838 598.084 202.785 598.103 202.718L599.697 196.729C599.72 196.643 599.798 196.584 599.886 196.584H600.299ZM107.96 56.167C111.054 59.2612 115.251 60.9999 119.627 61H182.373C186.484 61.0001 190.426 62.6333 193.333 65.54L323.46 195.667C325.177 197.384 327.234 198.683 329.473 199.5H154.127C150.016 199.5 146.074 197.867 143.167 194.96L80.54 132.333C77.4458 129.239 73.249 127.5 68.873 127.5H0V0H51.793L107.96 56.167ZM305.96 26.167C308.867 29.0738 310.5 33.0171 310.5 37.1279V78.873C310.5 83.249 312.239 87.4458 315.333 90.54L383.46 158.667C386.554 161.761 390.751 163.5 395.127 163.5H523.436C527.51 163.5 531.422 165.105 534.322 167.967L562.476 195.745C564.177 197.424 566.207 198.696 568.411 199.5H335.127C331.016 199.5 327.074 197.867 324.167 194.96L194.04 64.833C190.946 61.7388 186.749 60.0001 182.373 60H119.627C115.516 59.9999 111.574 58.3667 108.667 55.46L53.207 0H279.793L305.96 26.167ZM1091.33 55.46C1088.43 58.3667 1084.48 59.9999 1080.37 60H1017.63C1013.25 60.0001 1009.05 61.7388 1005.96 64.833L875.833 194.96C872.926 197.867 868.984 199.5 864.873 199.5H631.589C633.793 198.696 635.823 197.424 637.524 195.745L665.679 167.967C668.579 165.105 672.49 163.5 676.564 163.5H804.873C809.249 163.5 813.446 161.761 816.54 158.667L884.667 90.54C887.761 87.4458 889.5 83.249 889.5 78.873V37.1279C889.5 33.0171 891.133 29.0738 894.04 26.167L920.207 0H1146.79L1091.33 55.46ZM1201 127.5H1131.13C1126.75 127.5 1122.55 129.239 1119.46 132.333L1056.83 194.96C1053.93 197.867 1049.98 199.5 1045.87 199.5H870.527C872.766 198.683 874.823 197.384 876.54 195.667L1006.67 65.54C1009.57 62.6333 1013.52 61.0001 1017.63 61H1080.37C1084.75 60.9999 1088.95 59.2612 1092.04 56.167L1148.21 0H1201V127.5Z" fill="#FFFFFF"/>
          </g>
          <defs>
            <filter id="stats-circuit-filter" x="0" y="0" width="1201" height="553" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
              <feFlood flood-opacity="0" result="BackgroundImageFix"/>
              <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
              <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
              <feOffset dy="2"/>
              <feGaussianBlur stdDeviation="1"/>
              <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"/>
              <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
              <feBlend mode="normal" in2="shape" result="effect1_innerShadow_4083_3188"/>
            </filter>
          </defs>
        </svg>
      </div>

      <!-- Floating decorative items -->
      <div class="stats__float stats__float--1" aria-hidden="true"></div>
      <div class="stats__float stats__float--2" aria-hidden="true"></div>
      <div class="stats__float stats__float--3" aria-hidden="true"></div>
      <div class="stats__float stats__float--4" aria-hidden="true"></div>
      <div class="stats__float stats__float--5" aria-hidden="true"></div>
      <div class="stats__float stats__float--6" aria-hidden="true"></div>

      <h2 class="stats__headline" id="stats-headline">
        Fueling Infinite Possibilities<br>With Our Passion For Gaming
      </h2>
      <a class="btn" href="#work"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">See All Works</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
    </div>

    <div class="stats__marquee">
      <div class="stats__track" id="stats-track">

        <!-- One group: 6 columns in a zig-zag. Odd columns carry their
             value in the TOP cell (bottom empty); even columns carry it in
             the BOTTOM cell (top empty). -->
        <div class="stats__group">
          <div class="stats__col stats__col--top">
            <div class="stats__cell stats__cell--top">
              <p class="stats__label">Downloads</p>
              <p class="stats__value">3B+</p>
            </div>
            <div class="stats__cell stats__cell--bottom"></div>
          </div>
          <div class="stats__col stats__col--bottom">
            <div class="stats__cell stats__cell--top"></div>
            <div class="stats__cell stats__cell--bottom">
              <p class="stats__value">100+</p>
              <p class="stats__sub">Games Launched</p>
            </div>
          </div>
          <div class="stats__col stats__col--top">
            <div class="stats__cell stats__cell--top">
              <p class="stats__label">Staff</p>
              <p class="stats__value">60+</p>
            </div>
            <div class="stats__cell stats__cell--bottom"></div>
          </div>
          <div class="stats__col stats__col--bottom">
            <div class="stats__cell stats__cell--top"></div>
            <div class="stats__cell stats__cell--bottom">
              <p class="stats__value">15B+</p>
              <p class="stats__sub">Special parameters used to train AI model</p>
            </div>
          </div>
          <div class="stats__col stats__col--top">
            <div class="stats__cell stats__cell--top">
              <p class="stats__label">Game Titles</p>
              <p class="stats__value">10+</p>
            </div>
            <div class="stats__cell stats__cell--bottom"></div>
          </div>
          <div class="stats__col stats__col--bottom">
            <div class="stats__cell stats__cell--top"></div>
            <div class="stats__cell stats__cell--bottom">
              <p class="stats__value stats__value--word">PROFESSIONAL</p>
              <p class="stats__sub">Data process and AI-ready</p>
            </div>
          </div>
        </div>

        <!-- Duplicate group for a seamless infinite loop -->
        <div class="stats__group" aria-hidden="true">
          <div class="stats__col stats__col--top">
            <div class="stats__cell stats__cell--top">
              <p class="stats__label">Downloads</p>
              <p class="stats__value">3B+</p>
            </div>
            <div class="stats__cell stats__cell--bottom"></div>
          </div>
          <div class="stats__col stats__col--bottom">
            <div class="stats__cell stats__cell--top"></div>
            <div class="stats__cell stats__cell--bottom">
              <p class="stats__value">100+</p>
              <p class="stats__sub">Games Launched</p>
            </div>
          </div>
          <div class="stats__col stats__col--top">
            <div class="stats__cell stats__cell--top">
              <p class="stats__label">Staff</p>
              <p class="stats__value">60+</p>
            </div>
            <div class="stats__cell stats__cell--bottom"></div>
          </div>
          <div class="stats__col stats__col--bottom">
            <div class="stats__cell stats__cell--top"></div>
            <div class="stats__cell stats__cell--bottom">
              <p class="stats__value">15B+</p>
              <p class="stats__sub">Special parameters used to train AI model</p>
            </div>
          </div>
          <div class="stats__col stats__col--top">
            <div class="stats__cell stats__cell--top">
              <p class="stats__label">Game Titles</p>
              <p class="stats__value">10+</p>
            </div>
            <div class="stats__cell stats__cell--bottom"></div>
          </div>
          <div class="stats__col stats__col--bottom">
            <div class="stats__cell stats__cell--top"></div>
            <div class="stats__cell stats__cell--bottom">
              <p class="stats__value stats__value--word">PROFESSIONAL</p>
              <p class="stats__sub">Data process and AI-ready</p>
            </div>
          </div>
        </div>

    </div><!-- /.stats__rows -->
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       §5 · SERVICES — pinned deck, 7 slides
  ═════════════════════════════════════════════════════════════════ -->
  <section class="services" id="services" aria-labelledby="services-heading">
    <h2 class="sr-only" id="services-heading">Our Services</h2>

    <div class="services__pin" id="services-pin">

      <!-- Dark backdrop — fades in past the intro so the deck reads on navy -->
      <div class="services__bg-dark" aria-hidden="true"></div>

      <!-- Section header — pinned at the top, stays put through the deck -->
      <header class="services__head">
        <span class="pill">Services</span>
        <h3 class="services__head-title">Infinite Artistry<br>Expert Engineering</h3>
      </header>

      <!-- Deck of 3 columns — sits low under the header, rises to centre as it leaves -->
      <div class="services__deck">

      <!-- Sidebar nav — fixed rail + marker; the list scrolls past it -->
      <nav class="services__nav" aria-label="Services navigation">
        <span class="services__nav-marker" aria-hidden="true"></span>
        <div class="services__nav-track">
          <a href="#" class="services__nav-link services__nav-link--active active" data-slide="0">3D Animation</a>
          <a href="#" class="services__nav-link" data-slide="1">3D Art</a>
          <a href="#" class="services__nav-link" data-slide="2">VFX &amp; Shaders</a>
          <a href="#" class="services__nav-link" data-slide="3">2D Art</a>
          <a href="#" class="services__nav-link" data-slide="4">Roblox</a>
          <a href="#" class="services__nav-link" data-slide="5">Development</a>
          <a href="#" class="services__nav-link" data-slide="6">AI Cinematic</a>
        </div>
      </nav>

      <!-- CENTER — image stage; images slice/wipe between each other on scroll -->
      <figure class="services__stage" aria-hidden="true">
        <div class="services__frame">
          <div class="services__img" data-img="0" style="background-image:url('/application/themes/kos/assets/images/Services/3D_ANIMATION.gif')"></div>
          <div class="services__img" data-img="1" style="background-image:url('/application/themes/kos/assets/images/Services/3D_ART.png')"></div>
          <div class="services__img" data-img="2" style="background-image:url('/application/themes/kos/assets/images/Services/VFX%26SHADERS.png')"></div>
          <div class="services__img" data-img="3" style="background-image:url('/application/themes/kos/assets/images/Services/2D_ART.png')"></div>
          <div class="services__img" data-img="4" style="background-image:url('/application/themes/kos/assets/images/Services/Roblox.png')"></div>
          <div class="services__img" data-img="5" style="background-image:url('/application/themes/kos/assets/images/Services/Development.png')"></div>
          <video class="services__img services__img--video" data-img="6" autoplay loop muted playsinline>
            <source src="/application/themes/kos/assets/images/Services/AI_Cinematic.mp4" type="video/mp4">
          </video>
        </div>
      </figure>

      <!-- RIGHT — title + description + checklist; scrolls per service -->
      <div class="services__texts">

        <article class="services__text" data-text="0">
          <h3 class="services__title">3D Animation</h3>
          <p class="services__desc">Breathing life into characters with fluid mechanics and emotional depth.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Advanced Rigging
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Gameplay Animation
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Cinematic &amp; Acting
            </li>
          </ul>
        </article>

        <article class="services__text" data-text="1">
          <h3 class="services__title">3D Art</h3>
          <p class="services__desc">High-fidelity assets optimised for real-time rendering engines.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Characters &amp; Creatures
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Props &amp; Accessories
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Vehicles &amp; Environments
            </li>
          </ul>
        </article>

        <article class="services__text" data-text="2">
          <h3 class="services__title">VFX &amp; Shaders</h3>
          <p class="services__desc">Visual magic that enhances immersion without sacrificing performance.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              2D &amp; 3D VFX Animation
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Shader Graph &amp; HLSL
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Particle Systems
            </li>
          </ul>
          <div class="services__supported">
            <p class="services__supported-label">Supported by</p>
            <div class="services__supported-logos"><img src="/application/themes/kos/assets/images/Services/service-supported.png" alt="Supported by Unreal Engine and Unity" class="services__supported-img"></div>
          </div>
        </article>

        <article class="services__text" data-text="3">
          <h3 class="services__title">2D Art</h3>
          <p class="services__desc">Laying the visual foundation and storytelling elements.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Spine / Frame Animation
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Storyboarding
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Concept Art
            </li>
          </ul>
        </article>

        <article class="services__text" data-text="4">
          <h3 class="services__title">Roblox</h3>
          <p class="services__desc">Immersive Roblox experiences built for engagement and retention.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Lua Scripting
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              World Building
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              UGC Item Design
            </li>
          </ul>
        </article>

        <article class="services__text" data-text="5">
          <h3 class="services__title">Development</h3>
          <p class="services__desc">Clean, scalable architecture for seamless gameplay experiences.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Unity &amp; Unreal Engine
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Engineering Support
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Systems Architecture
            </li>
          </ul>
          <div class="services__supported">
            <p class="services__supported-label">Supported by</p>
            <div class="services__supported-logos"><img src="/application/themes/kos/assets/images/Services/service-supported.png" alt="Supported by Unreal Engine and Unity" class="services__supported-img"></div>
          </div>
        </article>

        <article class="services__text" data-text="6">
          <h3 class="services__title">AI Cinematic</h3>
          <p class="services__desc">AI-driven cinematic pipelines that accelerate storytelling at scale.</p>
          <ul class="services__checklist">
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Storyboard Generation
            </li>
            <li class="services__check">
              <span class="services__check-icon" aria-hidden="true"><svg viewBox="0 0 16 16"><rect x="1.5" y="1.5" width="13" height="13" rx="2.5"/><path d="M5 5l6 6M11 5l-6 6"/></svg></span>
              Video Output
            </li>
          </ul>
        </article>

      </div><!-- /.services__texts -->

      </div><!-- /.services__deck -->

    </div><!-- /.services__pin -->
  </section>

</main>
<?php $this->inc('elements/footer.php'); ?>
