<?php 
defined("C5_EXECUTE") or die("Access Denied."); 

$content = isset($content) ? trim($content) : '';
$buttonUrl = isset($button_URL) ? trim($button_URL) : '';
$buttonTitle = isset($button_Title) ? trim($button_Title) : 'See All Works';
?>

<?php if ($content !== ''): ?>
    <h2 class="stats__headline" id="stats-headline">
        <?php echo nl2br($content); ?>
    </h2>
<?php endif; ?>

<?php if ($buttonUrl !== ''): ?>
    <a class="btn" href="<?php echo h($buttonUrl); ?>" aria-describedby="stats-headline">
        <svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/>
        </svg>
        
        <span class="btn__label"><?php echo h($buttonTitle); ?></span>
        
        <svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true">
            <path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/>
        </svg>
    </a>
<?php endif; ?>