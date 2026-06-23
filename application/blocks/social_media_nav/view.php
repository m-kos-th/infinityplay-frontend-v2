<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php
$request = \Core::make('request');
$currentHost = parse_url((string) $request->getSchemeAndHttpHost(), PHP_URL_HOST);

$buildAttributes = static function (array $attributes) {
    $parts = [];

    foreach ($attributes as $name => $value) {
        if ($value === null || $value === '') {
            continue;
        }

        $parts[] = sprintf('%s="%s"', $name, h((string) $value));
    }

    return implode(' ', $parts);
};

$isExternalUrl = static function ($url) use ($currentHost) {
    $url = trim((string) $url);

    if ($url === '' || $url[0] === '#' || preg_match('/^(mailto|tel|sms):/i', $url)) {
        return false;
    }

    if (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
        return false;
    }

    $normalizedUrl = strpos($url, '//') === 0 ? 'https:' . $url : $url;
    $linkHost = parse_url($normalizedUrl, PHP_URL_HOST);

    if (!$linkHost) {
        return false;
    }

    if (!$currentHost) {
        return true;
    }

    return strcasecmp($linkHost, $currentHost) !== 0;
};
?>

<?php if (isset($title) && trim((string) $title) !== '') { ?>
    <p class="footer__col-label"><?php echo h($title); ?></p>
<?php } ?>

<?php if (!empty($socialLinks_items)) { ?>
    <ul class="footer__col-list">
        <?php foreach ($socialLinks_items as $socialLinks_item) { ?>
            <?php
            $linkTitle = trim((string) ($socialLinks_item['socialLink_Title'] ?? ''));
            $linkUrl = trim((string) ($socialLinks_item['socialLink_URL'] ?? ''));

            if ($linkTitle === '' && $linkUrl === '') {
                continue;
            }

            if ($linkTitle === '') {
                $linkTitle = $linkUrl;
            }

            $linkAttributes = [
                'class' => 'footer__col-link',
                'href' => $linkUrl !== '' ? $linkUrl : '#',
            ];

            if ($linkUrl === '') {
                $linkAttributes['aria-disabled'] = 'true';
                $linkAttributes['tabindex'] = '-1';
            } elseif ($isExternalUrl($linkUrl)) {
                $linkAttributes['class'] .= ' footer__col-link--external';
                $linkAttributes['target'] = '_blank';
                $linkAttributes['rel'] = 'noopener noreferrer';
                $linkAttributes['aria-label'] = t('%s (opens in a new tab)', $linkTitle);
            }
            ?>
            <li class="footer__col-item">
                <a <?php echo $buildAttributes($linkAttributes); ?>>
                    <?php echo h($linkTitle); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
