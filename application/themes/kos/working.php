<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');
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
      <div class="work-landing__title" id="works-title">
        <?php
        $content = new Area('Work landing Page: title');
        $content->display($c);
        ?>
      </div>
      <!-- <h1 class="work-landing__title" id="works-title">Infinite Artistry<br>Expert Engineering</h1> -->

      <div class="work-landing__tabs" role="tablist" aria-label="Filter works">
        <button class="work-landing__tab work-landing__tab--active" type="button" role="tab" aria-selected="true">Games</button>
        <button class="work-landing__tab work-landing__tab--soon" type="button" role="tab" aria-disabled="true">Concept Art (Soon)</button>
        <button class="work-landing__tab work-landing__tab--soon" type="button" role="tab" aria-disabled="true">AI Cinematic (Soon)</button>
      </div>
    </div>
  </section>

  <!-- ════════════════════════════════════════════════════════════════
       FEATURED BANNER + CATALOGUE — rendered by the page_list "working"
       template: a banner that straddles the blue→white seam, then the
       white catalogue (featured meta row + grid + pagination).
  ═════════════════════════════════════════════════════════════════ -->
  <?php
  $content = new Area('Work landing Page: all list');
  $content->display($c);
  ?>

</main>

<?php $this->inc('elements/footer.php'); ?>