<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php
$request = \Core::make('request');
$currentHost = parse_url((string) $request->getSchemeAndHttpHost(), PHP_URL_HOST);
$serverHosts = [
    $currentHost,
    $_SERVER['HTTP_HOST'] ?? null,
    $_SERVER['SERVER_NAME'] ?? null,
    $_SERVER['HTTP_X_FORWARDED_HOST'] ?? null,
    $_SERVER['HTTP_X_FORWARDED_SERVER'] ?? null,
];

$normalizeHost = static function ($host) {
    $host = strtolower(trim((string) $host));

    if ($host === '') {
        return '';
    }

    return preg_replace('/^www\./', '', $host);
};

$sameSiteHosts = array_values(array_filter(array_unique(array_map(
    static function ($host) use ($normalizeHost) {
        if ($host === null) {
            return null;
        }

        $host = trim((string) $host);

        if ($host === '') {
            return null;
        }

        $host = explode(',', $host)[0] ?? $host;
        $host = trim($host);
        $host = parse_url(strpos($host, '://') === false ? 'https://' . $host : $host, PHP_URL_HOST) ?: $host;
        $host = preg_replace('/:\d+$/', '', (string) $host);

        return $normalizeHost($host);
    },
    $serverHosts
))));

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

$splitCharacters = static function ($text) {
    $characters = preg_split('//u', (string) $text, -1, PREG_SPLIT_NO_EMPTY);

    return is_array($characters) ? $characters : str_split((string) $text);
};

$renderAnimatedLabel = static function ($text, array $attributes = []) use ($buildAttributes, $splitCharacters) {
    $text = preg_replace('/\s+/u', ' ', trim((string) $text));

    if ($text === '') {
        return '';
    }

    $characters = $splitCharacters($text);
    $attributes['data-btn-chars-ready'] = 'true';
    $attributes['style'] = sprintf('--btn-char-total: %d;', count($characters));

    $html = '<span ' . $buildAttributes($attributes) . '>';
    $html .= '<span class="btn__label-text" data-btn-chars aria-hidden="true">';

    foreach ($characters as $index => $character) {
        $isSpace = preg_match('/\s/u', $character) === 1;
        $className = $isSpace ? 'btn__char btn__char--space' : 'btn__char';
        $style = sprintf('--btn-char-index: %d; transition-delay: %.2fs;', $index, $index * 0.01);

        $html .= sprintf(
            '<span class="%s" style="%s">%s</span>',
            h($className),
            h($style),
            $isSpace ? '&nbsp;' : h($character)
        );
    }

    $html .= '</span>';
    $html .= '<span class="sr-only">' . h($text) . '</span>';
    $html .= '</span>';

    return $html;
};

$isExternalUrl = static function ($url) use ($sameSiteHosts, $normalizeHost) {
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

    if (empty($sameSiteHosts)) {
        return true;
    }

    return !in_array($normalizeHost($linkHost), $sameSiteHosts, true);
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
                'class' => 'footer__col-link btn',
                'href' => $linkUrl !== '' ? $linkUrl : '#',
            ];
            $labelAttributes = [
                'class' => 'btn__label',
            ];

            if ($linkUrl === '') {
                $linkAttributes['aria-disabled'] = 'true';
                $linkAttributes['tabindex'] = '-1';
                $labelAttributes['aria-disabled'] = 'true';
            } elseif ($isExternalUrl($linkUrl)) {
                $linkAttributes['class'] .= ' footer__col-link--external';
                $linkAttributes['target'] = '_blank';
                $linkAttributes['rel'] = 'noopener noreferrer';
                $linkAttributes['aria-label'] = t('%s (opens in a new tab)', $linkTitle);
            }
            ?>
            <li class="footer__col-item">
                <a <?php echo $buildAttributes($linkAttributes); ?>>
                    <?php echo $renderAnimatedLabel($linkTitle, $labelAttributes); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
