<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');

// Theme asset base for background images used inline below.
$img = THEMEDIR . '/assets/images/working';
?>

<main id="main-content" class="work-landing">

  <!-- ════════════════════════════════════════════════════════════════
       HERO — eyebrow · title · filter tabs · character · featured banner
  ═════════════════════════════════════════════════════════════════ -->
  <section class="work-landing__hero" aria-labelledby="works-title">
    <div class="work-landing__hero-bg" aria-hidden="true"></div>
    <div class="work-landing__hero-cut" aria-hidden="true"></div>
    <div class="work-landing__hero-character" aria-hidden="true"></div>

    <div class="work-landing__hero-inner">
      <span class="pill work-landing__eyebrow">Works</span>
      <h1 class="work-landing__title" id="works-title">Infinite Artistry<br>Expert Engineering</h1>

      <div class="work-landing__tabs" role="tablist" aria-label="Filter works">
        <button class="work-landing__tab work-landing__tab--active" type="button" role="tab" aria-selected="true">Games</button>
        <button class="work-landing__tab work-landing__tab--soon" type="button" role="tab" aria-disabled="true">Concept Art (Soon)</button>
        <button class="work-landing__tab work-landing__tab--soon" type="button" role="tab" aria-disabled="true">AI Cinematic (Soon)</button>
      </div>
    </div>

    <!-- Featured project banner — straddles the blue → white seam -->
    <div class="work-landing__feature">
      <div class="work-landing__feature-media" style="background-image:url('<?php echo $img; ?>/working-hero-out-mmobanner.png')" role="img" aria-label="Outlanders MMO key art"></div>
    </div>
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       CATALOGUE — featured meta row + grid + pagination
  ═════════════════════════════════════════════════════════════════ -->
  <div class="work-landing__catalog">
    <div class="work-landing__catalog-inner">

      <!-- Featured meta -->
      <div class="work-landing__feature-meta">
        <h2 class="work-landing__feature-title">Outlanders MMO</h2>
        <p class="work-landing__feature-desc">Blockchain-integrated MMORPG set in an open fantasy world.</p>
        <a class="btn work-landing__feature-cta" href="#" aria-label="Discover Outlanders MMO"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">Discover</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
      </div>

      <!-- Grid -->
      <div class="work-landing__grid">

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-nakaboom.png')" role="img" aria-label="Naka Boom"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Naka Boom</h3>
            <p class="work-landing__card-desc">Fast-paced 3D arena battler with hazards and power-ups.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-dawn.png')" role="img" aria-label="Dawn of the Damned"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Dawn of the Damned</h3>
            <p class="work-landing__card-desc">Post-apocalyptic zombie survival shooter on Unreal Engine 5.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-metal-rampage.png')" role="img" aria-label="Metal Rampage"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Metal Rampage</h3>
            <p class="work-landing__card-desc">Action-packed multiplayer vehicular combat arena.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-wizard-shooter.png')" role="img" aria-label="Wizard Shooter"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Wizard Shooter</h3>
            <p class="work-landing__card-desc">Magic-fueled multiplayer shooter with spell-based combat.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-marjong.png')" role="img" aria-label="Mahjong"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Mahjong</h3>
            <p class="work-landing__card-desc">Classic tile-matching puzzle with a modern twist.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-sushi-match.png')" role="img" aria-label="Sushi Match"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Sushi Match</h3>
            <p class="work-landing__card-desc">Relaxing, adorable Match-3 puzzle serving sushi from a 7-slot tray.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-8ballpool.png')" role="img" aria-label="8 Ball Pool"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">8 Ball Pool</h3>
            <p class="work-landing__card-desc">High-fidelity 3D multiplayer pool with realistic physics and 1v1 rankings.</p>
          </div>
        </article>

        <article class="work-landing__card">
          <div class="work-landing__card-media" style="background-image:url('<?php echo $img; ?>/working-hexacosmic.png')" role="img" aria-label="Hexa Cosmic"></div>
          <div class="work-landing__card-info">
            <h3 class="work-landing__card-title">Hexa Cosmic</h3>
            <p class="work-landing__card-desc">Futuristic space-themed puzzle challenging your spatial logic with hexagonal blocks.</p>
          </div>
        </article>

      </div><!-- /.work-landing__grid -->

    </div><!-- /.work-landing__catalog-inner -->
  </div><!-- /.work-landing__catalog -->

</main>

<?php $this->inc('elements/footer.php'); ?>
