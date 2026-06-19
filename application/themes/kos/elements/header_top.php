<?php
defined('C5_EXECUTE') or die('Access Denied.');
require_once __DIR__ . '/function.php';

$currentPage = kos_current_page();
$request = \Core::make('request');
$pageTitle = $pageTitle ?? METATITLE;
$pageDescription = $pageDescription ?? METADESC;
$pageMetaKeywords = $pageMetaKeywords ?? '';
$canonicalUrl = $canonicalUrl ?? PAGEURLABS;
$metaRobots = $metaRobots ?? 'index, follow';
$shareTitle = $shareTitle ?? $pageTitle;
$shareDescription = $shareDescription ?? $pageDescription;
$metaImage = $metaImage ?? METAIMAGE;
$structuredData = $structuredData ?? null;
$bodyClass = trim(implode(' ', array_filter([$bodyClass ?? '', BODYCLASS])));
?>
<!DOCTYPE html>
<html lang="<?= h(LANGTAG) ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="<?= h($metaRobots) ?>">
  <link rel="canonical" href="<?= h($canonicalUrl) ?>">
  <link rel="icon" type="image/svg+xml" href="/application/themes/kos/assets/favicon.svg">
  <link rel="alternate icon" href="/application/themes/kos/assets/favicon.ico">

  <meta property="og:locale" content="<?= h(str_replace('-', '_', LANGTAG)) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= h($canonicalUrl) ?>">
  <meta property="og:title" content="<?= h($shareTitle) ?>">
  <meta property="og:description" content="<?= h($shareDescription) ?>">
  <meta property="og:site_name" content="<?= h(SITE) ?>">
  <meta property="og:image" content="<?= h($metaImage) ?>">
  <meta property="og:image:alt" content="<?= h($shareTitle) ?>">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= h($shareTitle) ?>">
  <meta name="twitter:description" content="<?= h($shareDescription) ?>">
  <meta name="twitter:image" content="<?= h($metaImage) ?>">

  <?php
  $bootstrapCssPublicPath = THEMEDIR . '/assets/libs/bootstrap/bootstrap.min.css';
  $bootstrapCss = kos_public_path_to_filesystem($bootstrapCssPublicPath);
  if (file_exists($bootstrapCss)) {
      ?>
      <link rel="stylesheet" href="<?= h(kos_asset_url($bootstrapCssPublicPath)) ?>">
      <?php
  }
  ?>
  <link rel="dns-prefetch" href="https://fonts.googleapis.com">
  <link rel="dns-prefetch" href="https://fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Doto:wght@300;700;900&display=swap" rel="stylesheet">
  <?php
  $globalCssPublicPath = THEMEDIR . '/assets/css/global.css';
  $globalCss = kos_public_path_to_filesystem($globalCssPublicPath);
  if (file_exists($globalCss)) {
      ?>
      <link rel="stylesheet" href="<?= h(kos_asset_url($globalCssPublicPath)) ?>">
      <?php
  }

  if (PAGETEMPLATE) {
      $pageCssPublicPath = THEMEDIR . '/assets/css/pages/' . PAGETEMPLATE . '.css';
      $pageCss = kos_public_path_to_filesystem($pageCssPublicPath);
      if (file_exists($pageCss)) {
          ?>
          <link rel="stylesheet" href="<?= h(kos_asset_url($pageCssPublicPath)) ?>">
          <?php
      }
  }
  ?>

  <?php
  \View::element('header_required', [
      'pageTitle' => $pageTitle,
      'pageDescription' => $pageDescription,
      'pageMetaKeywords' => $pageMetaKeywords,
  ]);

  if ($structuredData) {
      echo '<script type="application/ld+json">' . json_encode(
          $structuredData,
          JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
      ) . '</script>';
  }
  ?>
</head>
<body<?= $bodyClass !== '' ? ' class="' . h($bodyClass) . '"' : '' ?>>
<div class="<?= h($c->getPageWrapperClass()) ?>">
<a class="sr-only" href="#main-content">Skip to main content</a>
