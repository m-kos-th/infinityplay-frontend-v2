<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');

// ─────────────────────────────────────────────────────────────────────────
// Theme asset base for the detail-page imagery.
// Drop the referenced files into assets/images/working-detail/ to populate;
// every media block has a colour fallback so the layout reads while empty.
// ─────────────────────────────────────────────────────────────────────────
$img = THEMEDIR . '/assets/images/working-detail';

// Demo content (move to block attributes / page data when refactoring to a block).
$project = [
  'title'    => 'Outlanders MMO',
  'visit'    => '#',
  'heading'  => 'Outlanders is an immersive MMORPG integrated with blockchain technology.',
  'desc'     => 'The journey begins after the Player (the Outlander) loses a duel against Ralf the Craftmaster, a legendary online player in the game Outlander. The Player is then warped from the real world into the realm known as Farworld, where they must embark on this extraordinary adventure starting from scratch. The primary objective of this journey is to seek revenge against Ralf and reclaim their lost honor.',
  'year'     => '2024',
  'client'   => 'Nakamoto.Games',
  'industry' => 'Gaming',
  'tags'     => ['MMORPG / Action', 'Multiplayer', 'Unity', 'Mobile Game'],
];
?>

<main id="main-content" class="work-detail">  

  <!-- ════════════════════════════════════════════════════════════════
       HERO — full-bleed key art with an overlaid (and sticky) title bar
  ═════════════════════════════════════════════════════════════════ -->
  <section class="work-detail__hero" aria-label="<?php echo htmlspecialchars($project['title']); ?> key art">
    <div class="work-detail__hero-media"
         style="background-image:url('<?php echo $img; ?>/hero-banner.jpg')"
         role="img" aria-label="<?php echo htmlspecialchars($project['title']); ?> key art"></div>
    <div class="work-detail__hero-scrim" aria-hidden="true"></div>
  </section>

  <!-- Title bar: overlaps the hero's lower edge, then sticks to the top on scroll -->
  <div class="work-detail__bar">
    <div class="work-detail__bar-inner">
      <a class="work-detail__back" href="working.html" aria-label="Back to all works">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <h1 class="work-detail__bar-title"><?php echo htmlspecialchars($project['title']); ?></h1>

      <a class="btn btn--dark work-detail__visit" href="<?php echo $project['visit']; ?>" aria-label="Visit site">
        <svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z"/></svg>
        <span class="btn__label">Visit Site
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 0c2.5 2.5 3.5 6 3.5 10S14.5 19.5 12 22M12 2C9.5 4.5 8.5 8 8.5 12S9.5 19.5 12 22M2.5 12h19" stroke="currentColor" stroke-width="1.6"/></svg>
        </span>
        <svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z"/></svg>
      </a>
    </div>
  </div>

  <!-- ════════════════════════════════════════════════════════════════
       BODY — sticky meta column (left) + scrolling gallery (right)
  ═════════════════════════════════════════════════════════════════ -->
  <section class="work-detail__body">
    <div class="work-detail__layout">

      <!-- ── Sticky info column ─────────────────────────────────── -->
      <aside class="work-detail__aside">
        <h2 class="work-detail__aside-heading"><?php echo htmlspecialchars($project['heading']); ?></h2>
        <p class="work-detail__aside-desc"><?php echo htmlspecialchars($project['desc']); ?></p>

        <dl class="work-detail__meta">
          <div class="work-detail__meta-item">
            <dt>Year</dt><dd><?php echo htmlspecialchars($project['year']); ?></dd>
          </div>
          <div class="work-detail__meta-item">
            <dt>Client</dt><dd><?php echo htmlspecialchars($project['client']); ?></dd>
          </div>
          <div class="work-detail__meta-item">
            <dt>Industry</dt><dd><?php echo htmlspecialchars($project['industry']); ?></dd>
          </div>
        </dl>

        <ul class="work-detail__tags">
          <?php foreach ($project['tags'] as $tag): ?>
            <li class="work-detail__tag"><?php echo htmlspecialchars($tag); ?></li>
          <?php endforeach; ?>
        </ul>
      </aside>

      <!-- ── Gallery ────────────────────────────────────────────── -->
      <div class="work-detail__gallery">
        <figure class="work-detail__shot work-detail__shot--wide" style="background-image:url('<?php echo $img; ?>/gallery-1.jpg')" role="img" aria-label="Gameplay screenshot"></figure>

        <div class="work-detail__shot-row">
          <figure class="work-detail__shot work-detail__shot--logo" style="background-image:url('<?php echo $img; ?>/gallery-logo.jpg')" role="img" aria-label="Outlanders logo"></figure>
          <figure class="work-detail__shot" style="background-image:url('<?php echo $img; ?>/gallery-2.jpg')" role="img" aria-label="Gameplay UI screenshot"></figure>
        </div>

        <figure class="work-detail__shot work-detail__shot--wide" style="background-image:url('<?php echo $img; ?>/gallery-3.jpg')" role="img" aria-label="Farworld landscape"></figure>

        <div class="work-detail__shot-row">
          <figure class="work-detail__shot" style="background-image:url('<?php echo $img; ?>/gallery-4.jpg')" role="img" aria-label="Inventory UI"></figure>
          <figure class="work-detail__shot" style="background-image:url('<?php echo $img; ?>/gallery-5.jpg')" role="img" aria-label="Lobby UI"></figure>
        </div>
      </div>

    </div>
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       STORY — light panel, copy aligned to the gallery column
  ═════════════════════════════════════════════════════════════════ -->
  <section class="work-detail__story">
    <div class="work-detail__layout">
      <div class="work-detail__story-spacer" aria-hidden="true"></div>
      <div class="work-detail__story-content">
        <h2 class="work-detail__story-heading">The story begins when the player (the Outlander) loses a duel against a legendary online player named Ralf the Craftmaster.</h2>
        <p class="work-detail__story-desc">Defeated, the player is warped from the real world into a mysterious realm known as Farworld, forced to begin an extraordinary adventure entirely from scratch. The primary objective is to track down Ralf to exact revenge and reclaim lost honor. Along the journey, players will experience survival challenges, character development, and undertake missions to protect Farworld from invading Orcs, Goblins, and the evil schemes of demon followers.</p>
      </div>
    </div>
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       PAGER — back to catalogue (left) · next project (right)
  ═════════════════════════════════════════════════════════════════ -->
  <nav class="work-detail__pager" aria-label="Project navigation">
    <a class="work-detail__pager-all" href="working.html">
      <span class="work-detail__pager-plus" aria-hidden="true">+</span>
      <span>See all games</span>
    </a>
    <a class="work-detail__pager-next" href="#"
       style="--next-art:url('<?php echo $img; ?>/pager-next.jpg')">
      <span class="work-detail__pager-name">Dawn of Damned</span>
      <span class="work-detail__pager-cue">Next
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 17L17 7M17 7H9M17 7v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </span>
      <span class="work-detail__pager-art" aria-hidden="true"></span>
    </a>
  </nav>

</main>

<!-- Styles live in assets/scss/pages/sections/_work-detail.scss
     → compiled to assets/css/pages/working_detail.css (auto-loaded by
     header_top.php when PAGETEMPLATE === 'working_detail'). -->

<script>
(function () {
  // Toggle the frosted backdrop once the title bar pins to the top.
  var bar = document.querySelector('.work-detail__bar');
  if (!bar) return;
  var onScroll = function () {
    bar.classList.toggle('is-stuck', bar.getBoundingClientRect().top <= 0);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
</script>

<?php $this->inc('elements/footer.php'); ?>
