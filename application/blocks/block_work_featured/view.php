<?php 
defined("C5_EXECUTE") or die("Access Denied."); 

if (!empty($workList_items)): 
?>
<div class="work__grid-wrapper">
    <?php 
    foreach ($workList_items as $index => $item): 
        // 1. เตรียมข้อมูลพื้นฐาน
        $gameName = isset($item['gameName']) ? trim($item['gameName']) : '';
        $content = isset($item['content']) ? trim($item['content']) : '';
        $buttonUrl = isset($item['button_URL']) ? trim($item['button_URL']) : '';
        $buttonTitle = isset($item['button_Title']) ? trim($item['button_Title']) : 'Discover';
        
        // 2. จัดการรูปภาพหลัก / โลโก้
        $logoUrl = '';
        $logoTitle = $gameName;
        if (!empty($item['logo']) && is_object($item['logo'])) {
            $logoUrl = $item['logo']->getURL();
            $logoTitle = $item['logo']->getTitle() ?: $gameName;
        }

        // 3. ตรวจสอบประเภทไฟล์ของ Media Preview (Image หรือ Video)
        $previewType = 'none';
        $previewUrl = '';
        if (!empty($item['videoGamePreview']) && is_object($item['videoGamePreview'])) {
            $previewFile = $item['videoGamePreview'];
            $previewUrl = $previewFile->getURL();
            
            $fv = $previewFile->getApprovedVersion();
            if ($fv) {
                $ext = strtolower($fv->getExtension());
                if (in_array($ext, ['mp4', 'webm', 'ogg'])) {
                    $previewType = 'video';
                } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $previewType = 'image';
                }
            }
        }

        // 4. เงื่อนไขสำหรับการสลับฝั่ง (เลขคี่จะทำการ Reverse)
        $isReverse = ($index % 2 !== 0);
        $gridClass = 'work__grid' . ($isReverse ? ' work__grid--reverse' : '');
    ?>
        <article class="<?php echo $gridClass; ?>" data-index="<?php echo $index; ?>" aria-label="Project: <?php echo h($gameName); ?>">
            
            <?php if (!$isReverse): ?>
                <div class="work__image">
                    <?php if ($previewType === 'video'): ?>
                        <video class="work__video" autoplay loop muted playsinline aria-hidden="true">
                            <source src="<?php echo $previewUrl; ?>" type="video/mp4">
                        </video>
                    <?php elseif ($previewType === 'image'): ?>
                        <img src="<?php echo $previewUrl; ?>" alt="Preview of <?php echo h($gameName); ?>" loading="lazy" />
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="work__bg-pattern"></div>
            <?php endif; ?>

            <div class="work__content">
                <div class="work__content-inner">
                    
                    <div class="work__logo">
                        <?php if ($logoUrl): ?>
                            <img src="<?php echo $logoUrl; ?>" alt="<?php echo h($logoTitle); ?>" class="work__logo-img" />
                        <?php else: ?>
                            <span class="work__logo-fallback" aria-hidden="true">
                                <?php echo nl2br(h($gameName)); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($content !== ''): ?>
                        <div class="work__slide-description">
                            <?php echo $content; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($buttonUrl !== ''): ?>
                        <a class="btn" href="<?php echo h($buttonUrl); ?>" aria-label="<?php echo h($buttonTitle) . ' ' . h($gameName); ?>">
                            <svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg>
                            <span class="btn__label"><?php echo h($buttonTitle); ?></span>
                            <svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg>
                        </a>
                    <?php endif; ?>

                </div>
            </div>

            <?php if (!$isReverse): ?>
                <div class="work__bg-pattern"></div>
            <?php else: ?>
                <div class="work__image">
                    <?php if ($previewType === 'video'): ?>
                        <video class="work__video" autoplay loop muted playsinline aria-hidden="true">
                            <source src="<?php echo $previewUrl; ?>" type="video/mp4">
                        </video>
                    <?php elseif ($previewType === 'image'): ?>
                        <img src="<?php echo $previewUrl; ?>" alt="Preview of <?php echo h($gameName); ?>" loading="lazy" />
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </article>
    <?php endforeach; ?>
</div>
<?php endif; ?>