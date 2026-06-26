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
    <section aria-labelledby="working-detail-hero" class="work-detail__hero">
        <?php
        $content = new Area('Work detail Page: hero banner');
        $content->display($c);
        ?>
    </section>
    <!-- ════════════════════════════════════════════════════════════════
       BODY — sticky meta column (left) + scrolling gallery (right)
  ═════════════════════════════════════════════════════════════════ -->
    <section class="work-detail__body">
        <div class="work-detail__layout">

            <!-- ── Sticky info column ─────────────────────────────────── -->
            <aside class="work-detail__aside">
                <div class="work-detail__aside-heading">
                    <?php
                    $content = new Area('Work detail Page: heading');
                    $content->display($c);
                    ?>
                </div>

                <div class="work-detail__aside-desc">
                    <?php
                    $content = new Area('Work detail Page: description');
                    $content->display($c);
                    ?>
                </div>


                <?php
                // Pull meta from the page's "Working Detail" attributes.
                $year     = (string) $c->getAttribute('year');
                $client   = (string) $c->getAttribute('client');
                $industry = (string) $c->getAttribute('industry');

                // "Game tags" is a Topics attribute → array of tree node objects.
                $gameTags = $c->getAttribute('game_tags');
                $tags = [];
                if ($gameTags) {
                    foreach ($gameTags as $tag) {
                        if (is_object($tag) && method_exists($tag, 'getTreeNodeDisplayName')) {
                            $tags[] = $tag->getTreeNodeDisplayName();
                        } else {
                            $tags[] = (string) $tag;
                        }
                    }
                }
                ?>

                <dl class="work-detail__meta">
                    <?php if ($year !== ''): ?>
                        <div class="work-detail__meta-item">
                            <p class="dt">Year</p>
                            <p class="dd"><?php echo htmlspecialchars($year); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($client !== ''): ?>
                        <div class="work-detail__meta-item">
                            <p class="dt">Client</p>
                            <p class="dd"><?php echo htmlspecialchars($client); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($industry !== ''): ?>
                        <div class="work-detail__meta-item">
                            <p class="dt">Industry</p>
                            <p class="dd"><?php echo htmlspecialchars($industry); ?></p>
                        </div>
                    <?php endif; ?>
                </dl>

                <?php if (!empty($tags)): ?>
                    <ul class="work-detail__tags">
                        <?php foreach ($tags as $tag): ?>
                            <li class="work-detail__tag"><?php echo htmlspecialchars($tag); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </aside>

            <!-- ── Gallery ────────────────────────────────────────────── -->
            <div class="work-detail__gallery">

                <?php
                $content = new Area('Work detail Page: gallery');
                $content->display($c);
                ?>
            </div>

            <!-- <figure class="work-detail__shot work-detail__shot--wide" style="background-image:url('<?php echo $img; ?>/gallery-1.jpg')" role="img" aria-label="Gameplay screenshot"></figure> -->

            <!-- <div class="work-detail__shot-row">
                    <figure class="work-detail__shot work-detail__shot--logo" style="background-image:url('<?php echo $img; ?>/gallery-logo.jpg')" role="img" aria-label="Outlanders logo"></figure>
                    <figure class="work-detail__shot" style="background-image:url('<?php echo $img; ?>/gallery-2.jpg')" role="img" aria-label="Gameplay UI screenshot"></figure>
                </div>

                <figure class="work-detail__shot work-detail__shot--wide" style="background-image:url('<?php echo $img; ?>/gallery-3.jpg')" role="img" aria-label="Farworld landscape"></figure>

                <div class="work-detail__shot-row">
                    <figure class="work-detail__shot" style="background-image:url('<?php echo $img; ?>/gallery-4.jpg')" role="img" aria-label="Inventory UI"></figure>
                    <figure class="work-detail__shot" style="background-image:url('<?php echo $img; ?>/gallery-5.jpg')" role="img" aria-label="Lobby UI"></figure>
                </div> -->



        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════════════
       STORY — full-width light panel, offset to start at the aside divider
  ═════════════════════════════════════════════════════════════════ -->
    <section class="work-detail__story">
        <div class="work-detail__story-heading">
            <?php
            $content = new Area('Work detail Page: story title');
            $content->display($c);
            ?>
        </div>
        <div class="work-detail__story-desc">
            <?php
            $content = new Area('Work detail Page: story detail');
            $content->display($c);
            ?>
        </div>
    </section>

    <!-- ════════════════════════════════════════════════════════════════
       STORY (old) — light panel, copy aligned to the gallery column
  ═════════════════════════════════════════════════════════════════ -->
    <!-- <section class="work-detail__story">

        <div class="work-detail__story-content">
            <?php
            $content = new Area('Work detail Page: story');
            $content->display($c);
            ?>
        </div> -->

    <!-- <div class="work-detail__layout">
            <div class="work-detail__story-spacer" aria-hidden="true"></div>
            <div class="work-detail__story-content">
                <h2 class="work-detail__story-heading">The story begins when the player (the Outlander) loses a duel against a legendary online player named Ralf the Craftmaster.</h2>
                <p class="work-detail__story-desc">Defeated, the player is warped from the real world into a mysterious realm known as Farworld, forced to begin an extraordinary adventure entirely from scratch. The primary objective is to track down Ralf to exact revenge and reclaim lost honor. Along the journey, players will experience survival challenges, character development, and undertake missions to protect Farworld from invading Orcs, Goblins, and the evil schemes of demon followers.</p>
            </div>
        </div> -->
    <!-- </section> -->

    <!-- ════════════════════════════════════════════════════════════════
       PAGER — back to catalogue (left) · next project (right)
  ═════════════════════════════════════════════════════════════════ -->
    <nav class="work-detail__pager" aria-label="Project navigation">


        <div class="work-detail__pager-all">
            <?php
            $content = new Area('Work detail Page: pager all');
            $content->display($c);
            ?>
        </div>

        <!-- <a class="work-detail__pager-all" href="working.html">
            <span class="work-detail__pager-plus" aria-hidden="true">+</span>
            <span>See all games</span>
        </a> -->



        <?php
        // ── Resolve the "next" game page to drive the pager below ────────────
        // Reuse the editor's "Next & Previous Nav" block so its settings
        // (order, Loop Navigation, exclude_nav, permissions) are honoured, then
        // pull the key-art straight from that page's "thumbnail" attribute.
        $nextPage = null;
        $nextLabel = 'Next';
        try {
            $area = \Concrete\Core\Area\Area::get($c, 'Work detail Page: pager name');
            if (is_object($area)) {
                foreach ($area->getAreaBlocksArray($c) as $b) {
                    if ($b->getBlockTypeHandle() !== 'next_previous') {
                        continue;
                    }
                    $bc = $b->getController();
                    if (!empty($bc->nextLabel)) {
                        $nextLabel = (string) $bc->nextLabel;
                    }
                    if (method_exists($bc, 'getNextCollection')) {
                        $np = $bc->getNextCollection();
                        if (is_object($np) && !$np->isError()) {
                            $nextPage = $np;
                        }
                    }
                    break;
                }
            }
        } catch (\Throwable $e) {
            $nextPage = null;
        }

        $nextName = $nextLink = $nextArt = '';
        if (is_object($nextPage)) {
            $nextName  = (string) $nextPage->getCollectionName();
            $nextLink  = (string) $nextPage->getCollectionLink();
            // The "thumbnail" File entity proxies getURL() to its approved
            // version via __call, so method_exists() is unreliable here — call
            // it directly (same pattern as elements/function.php).
            $nextThumb = $nextPage->getAttribute('thumbnail');
            if (is_object($nextThumb)) {
                $nextArt = (string) $nextThumb->getURL();
            }
        }
        ?>

        <?php if (is_object($nextPage) && !$c->isEditMode()): ?>
            <a class="work-detail__pager-next" href="<?php echo htmlspecialchars($nextLink); ?>"
                <?php if ($nextArt !== ''): ?>style="--next-art:url('<?php echo htmlspecialchars($nextArt); ?>')" <?php endif; ?>>
                <span class="work-detail__pager-name"><?php echo htmlspecialchars($nextName); ?></span>
                <span class="work-detail__pager-cue">
                    <?php echo htmlspecialchars($nextLabel); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 17L17 7M17 7H9M17 7v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="work-detail__pager-art" aria-hidden="true"></span>
            </a>
        <?php else: ?>
            <div class="work-detail__pager-next">
                <div class="work-detail__pager-name">
                    <?php
                    $content = new Area('Work detail Page: pager name');
                    $content->display($c);
                    ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 17L17 7M17 7H9M17 7v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="work-detail__pager-art" aria-hidden="true"></div>
            </div>
        <?php endif; ?>
    </nav>

</main>

<!-- Styles live in assets/scss/pages/sections/_work-detail.scss
     → compiled to assets/css/pages/working_detail.css (auto-loaded by
     header_top.php when PAGETEMPLATE === 'working_detail'). -->

<script>
    (function() {
        // Toggle the frosted backdrop once the title bar pins to the top.
        var bar = document.querySelector('.work-detail__bar');
        if (!bar) return;
        var onScroll = function() {
            bar.classList.toggle('is-stuck', bar.getBoundingClientRect().top <= 0);
        };
        window.addEventListener('scroll', onScroll, {
            passive: true
        });
        onScroll();
    })();
</script>

<!-- ════════════════════════════════════════════════════════════════
     GALLERY LIGHTBOX — click a gallery image to view it zoomed
═════════════════════════════════════════════════════════════════ -->
<div class="work-detail__lightbox" id="wdLightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Image viewer">
    <button class="work-detail__lightbox-nav work-detail__lightbox-nav--prev" type="button" aria-label="Previous image" hidden>&#8249;</button>
    <figure class="work-detail__lightbox-figure">
        <img class="work-detail__lightbox-img" src="" alt="">
        <button class="work-detail__lightbox-close" type="button" aria-label="Close viewer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </figure>
    <button class="work-detail__lightbox-nav work-detail__lightbox-nav--next" type="button" aria-label="Next image" hidden>&#8250;</button>
</div>

<script>
    (function() {
        var gallery = document.querySelector('.work-detail__gallery');
        var box = document.getElementById('wdLightbox');
        if (!gallery || !box) return;

        var imgEl = box.querySelector('.work-detail__lightbox-img');
        var btnClose = box.querySelector('.work-detail__lightbox-close');
        var btnPrev = box.querySelector('.work-detail__lightbox-nav--prev');
        var btnNext = box.querySelector('.work-detail__lightbox-nav--next');
        var fileRe = /\.(jpe?g|png|webp|gif|avif)(\?.*)?$/i;
        var images = [];
        var current = -1;

        function collect() {
            images = Array.prototype.slice.call(gallery.querySelectorAll('img'));
        }

        // Prefer a linked full-size file when the image is wrapped in <a>.
        function srcOf(img) {
            var a = img.closest('a');
            if (a && a.href && fileRe.test(a.href)) return a.href;
            return img.currentSrc || img.src;
        }

        function open(i) {
            if (i < 0 || i >= images.length) return;
            current = i;
            imgEl.src = srcOf(images[i]);
            imgEl.alt = images[i].alt || '';
            box.classList.add('is-open');
            box.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            var multi = images.length > 1;
            btnPrev.hidden = !multi;
            btnNext.hidden = !multi;
        }

        function close() {
            box.classList.remove('is-open');
            box.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            imgEl.removeAttribute('src');
            current = -1;
        }

        function step(dir) {
            if (!images.length) return;
            open((current + dir + images.length) % images.length);
        }

        gallery.addEventListener('click', function(e) {
            var img = e.target.closest('img');
            if (!img || !gallery.contains(img)) return;
            // Leave non-file links (e.g. external pages) to behave normally.
            var a = img.closest('a');
            if (a && a.href && !fileRe.test(a.href)) return;
            e.preventDefault();
            collect();
            open(images.indexOf(img));
        });

        btnClose.addEventListener('click', close);
        btnPrev.addEventListener('click', function(e) {
            e.stopPropagation();
            step(-1);
        });
        btnNext.addEventListener('click', function(e) {
            e.stopPropagation();
            step(1);
        });
        box.addEventListener('click', function(e) {
            if (e.target === box) close(); // click on the backdrop
        });
        document.addEventListener('keydown', function(e) {
            if (!box.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            else if (e.key === 'ArrowLeft') step(-1);
            else if (e.key === 'ArrowRight') step(1);
        });
    })();
</script>

<?php $this->inc('elements/footer.php'); ?>