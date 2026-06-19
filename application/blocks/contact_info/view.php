<?php
defined('C5_EXECUTE') or die('Access Denied.');

$hasTitle = isset($title) && trim((string) $title) !== '';
$hasIntro = isset($intro) && trim((string) $intro) !== '';
$contactItems = is_array($contactItems_items ?? null) ? $contactItems_items : [];

// Remove the editor's outer paragraph wrapper so the block matches theme markup.
$stripSingleParagraph = static function ($html) {
    $html = trim((string) $html);
    if ($html === '') {
        return '';
    }

    if (preg_match('/^<p\b[^>]*>(.*)<\/p>$/is', $html, $matches) === 1 && substr_count(strtolower($html), '<p') === 1) {
        return trim($matches[1]);
    }

    return $html;
};

$formatIntro = static function ($html) use ($stripSingleParagraph) {
    $html = trim((string) $html);
    if ($html === '') {
        return '';
    }

    if (preg_match('/^<p\b/i', $html) === 1 && substr_count(strtolower($html), '<p') === 1) {
        return preg_replace_callback(
            '/^<p\b([^>]*)>/i',
            static function ($matches) {
                $attributes = $matches[1];
                if (preg_match('/\bclass=(["\'])(.*?)\1/i', $attributes, $classMatches) === 1) {
                    $updatedAttributes = preg_replace(
                        '/\bclass=(["\'])(.*?)\1/i',
                        'class="' . trim($classMatches[2] . ' contact__intro') . '"',
                        $attributes,
                        1
                    );

                    return '<p' . $updatedAttributes . '>';
                }

                return '<p class="contact__intro"' . $attributes . '>';
            },
            $html,
            1
        );
    }

    return '<div class="contact__intro">' . $stripSingleParagraph($html) . '</div>';
};
?>

<div class="contact__info">
  <?php if ($hasTitle) { ?>
    <h1 class="contact__title" id="contact-title"><?php echo h($title); ?></h1>
  <?php } ?>

  <?php if ($hasIntro) { ?>
    <?php echo $formatIntro($intro); ?>
  <?php } ?>

  <?php if (!empty($contactItems)) { ?>
    <dl class="contact__details">
      <?php foreach ($contactItems as $contactItem) {
          $label = trim((string) ($contactItem['label'] ?? ''));
          $value = trim((string) ($contactItem['value'] ?? ''));

          if ($label === '' && $value === '') {
              continue;
          }

          $normalizedLabel = strtolower(strip_tags($label));
          $valueClasses = 'contact__value';
          if (strpos($normalizedLabel, 'address') !== false) {
              $valueClasses .= ' contact__value--address';
          }
          ?>
        <div class="contact__row">
          <dt class="contact__term"><?php echo h($label); ?></dt>
          <dd class="<?php echo h($valueClasses); ?>">
            <?php echo $stripSingleParagraph($value); ?>
          </dd>
        </div>
      <?php } ?>
    </dl>
  <?php } ?>
</div>
