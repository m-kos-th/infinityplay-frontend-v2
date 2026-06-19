<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Page\Page;

if (!function_exists('kos_base_url')) {
    function kos_base_url(): string
    {
        static $baseUrl;

        if ($baseUrl !== null) {
            return $baseUrl;
        }

        try {
            $request = \Concrete\Core\Http\Request::getInstance();
            if ($request && method_exists($request, 'getSchemeAndHttpHost')) {
                $baseUrl = rtrim((string) $request->getSchemeAndHttpHost(), '/');

                return $baseUrl;
            }
        } catch (\Throwable $e) {
        }

        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $scheme = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $baseUrl = $scheme . '://' . $host;

        return $baseUrl;
    }
}

if (!function_exists('kos_absolute_url')) {
    function kos_absolute_url(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }

        if (preg_match('#^[a-z][a-z0-9+.-]*://#i', $url)) {
            return $url;
        }

        if (strpos($url, '//') === 0) {
            return 'https:' . $url;
        }

        return kos_base_url() . '/' . ltrim($url, '/');
    }
}

if (!function_exists('kos_theme_path')) {
    function kos_theme_path(): string
    {
        global $view;

        if (is_object($view) && method_exists($view, 'getThemePath')) {
            $themePath = (string) $view->getThemePath();
            if ($themePath !== '') {
                return $themePath;
            }
        }

        try {
            $instance = \Concrete\Core\View\View::getInstance();
            if (is_object($instance) && method_exists($instance, 'getThemePath')) {
                $themePath = (string) $instance->getThemePath();
                if ($themePath !== '') {
                    return $themePath;
                }
            }
        } catch (\Throwable $e) {
        }

        $themeDirectory = str_replace('\\', '/', dirname(__DIR__));
        $baseDirectory = str_replace('\\', '/', rtrim(DIR_BASE, '/'));

        if (strpos($themeDirectory, $baseDirectory) === 0) {
            $relativePath = substr($themeDirectory, strlen($baseDirectory));
            if ($relativePath !== '') {
                return $relativePath;
            }
        }

        return '/application/themes/kos';
    }
}

if (!function_exists('kos_current_page')) {
    function kos_current_page(): ?Page
    {
        return Page::getCurrentPage();
    }
}

if (!function_exists('kos_current_template_handle')) {
    function kos_current_template_handle(): string
    {
        $page = kos_current_page();
        if (!$page || $page->isError()) {
            return '';
        }

        $template = $page->getPageTemplateObject();

        return $template ? (string) $template->getPageTemplateHandle() : '';
    }
}

if (!function_exists('kos_is_home_page')) {
    function kos_is_home_page(): bool
    {
        $page = kos_current_page();

        return $page ? $page->isHomePage() : false;
    }
}

if (!function_exists('kos_asset_url')) {
    function kos_asset_url(string $publicPath): string
    {
        return kos_absolute_url($publicPath);
    }
}

if (!function_exists('kos_public_path_to_filesystem')) {
    function kos_public_path_to_filesystem(string $publicPath): string
    {
        $cleanPath = '/' . ltrim($publicPath, '/');

        return rtrim(DIR_BASE, '/') . $cleanPath;
    }
}

if (!function_exists('kos_frontend_url')) {
    function kos_frontend_url(string $path = ''): string
    {
        $base = kos_theme_path() . '/assets';

        return $path !== '' ? $base . '/' . ltrim($path, '/') : $base;
    }
}

if (!function_exists('kos_home_url')) {
    function kos_home_url(string $fragment = ''): string
    {
        $homePage = Page::getByID(Page::getHomePageID());
        $url = ($homePage && !$homePage->isError()) ? $homePage->getCollectionLink() : (string) \URL::to('/');

        if ($fragment !== '') {
            $url .= '#' . ltrim($fragment, '#');
        }

        return $url;
    }
}

if (!function_exists('kos_page_url')) {
    function kos_page_url(string $path): string
    {
        $normalized = '/' . ltrim($path, '/');
        $page = Page::getByPath($normalized);

        if ($page && !$page->isError()) {
            return $page->getCollectionLink();
        }

        return (string) \URL::to($normalized);
    }
}

if (!function_exists('kos_contact_url')) {
    function kos_contact_url(): string
    {
        return kos_page_url('/contact');
    }
}

if (!function_exists('kos_privacy_url')) {
    function kos_privacy_url(): string
    {
        return kos_page_url('/privacy-policy');
    }
}

if (!function_exists('kos_home_section_url')) {
    function kos_home_section_url(string $fragment): string
    {
        $fragment = ltrim($fragment, '#');

        return kos_is_home_page() ? '#' . $fragment : kos_home_url($fragment);
    }
}

if (!function_exists('kos_template_body_class')) {
    function kos_template_body_class(): string
    {
        $map = [
            'contact' => 'contact-page',
            'privacy_policy' => 'privacy-page',
        ];

        $template = kos_current_template_handle();

        return $map[$template] ?? '';
    }
}

if (!function_exists('kos_default_body_classes')) {
    function kos_default_body_classes(): string
    {
        $classes = [];
        $templateClass = kos_template_body_class();
        $page = kos_current_page();
        $user = new \Concrete\Core\User\User();

        if ($templateClass !== '') {
            $classes[] = $templateClass;
        }

        if ($page && $page->isEditMode()) {
            $classes[] = 'mode-edit';
        } else {
            $classes[] = 'mode-view';
        }

        if ($user->isRegistered()) {
            $classes[] = 'mode-login';
        }

        return implode(' ', $classes);
    }
}

if (!function_exists('kos_is_edit_mode_context')) {
    function kos_is_edit_mode_context(): bool
    {
        $page = Page::getCurrentPage();
        if ($page && !$page->isError()) {
            if (method_exists($page, 'isAdminArea') && $page->isAdminArea()) {
                return true;
            }

            if (method_exists($page, 'isEditMode') && $page->isEditMode()) {
                return true;
            }
        }

        try {
            $request = \Concrete\Core\Http\Request::getInstance();
            $path = $request ? (string) $request->getPath() : '';

            return strpos($path, '/dashboard') === 0 || strpos($path, '/ccm') === 0;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

$pg = Core::make('Application\Controller\PageType\PageGlobal');
if (!kos_is_edit_mode_context()) {
    $pg->autoRedirect();
}

$th = Core::make('helper/text');
$ux = new User();
$page = Page::getCurrentPage();
$pt = $c->getPageTemplateObject();
$template = null;
if (is_object($pt)) {
    $template = $pt->getPageTemplateHandle();
}

$site = Config::get('concrete.site');
$thumb = $page->getAttribute('thumbnail');
$fallbackThumb = '/application/themes/kos/assets/images/website-template-OG.webp';
$thumb = is_object($thumb) ? $thumb->getURL() : $fallbackThumb;

$metaTitle = $page->getAttribute('meta_title');
$metaTitle = $metaTitle !== '' ? $metaTitle : $page->getCollectionName() . ' - ' . $site;

$metaDesc = $page->getAttribute('meta_description');
$metaDesc = $metaDesc !== '' ? $metaDesc : $page->getCollectionDescription();
$metaDesc = trim((string) strip_tags((string) $metaDesc));
if ($metaDesc === '') {
    $metaDesc = trim((string) strip_tags((string) $page->getAttribute('meta_title')));
}

$lang = $pg->getLanguages();
$langArea = $lang['area'];
$langPath = $lang['path'];
$langTag = str_replace('_', '-', (string) Localization::activeLanguage());
$pageUrl = kos_absolute_url($page->getCollectionLink());
$metaImage = kos_absolute_url($thumb);
$bodyClass = kos_default_body_classes();

defined('SITE') || define('SITE', $site);
defined('THEMEDIR') || define('THEMEDIR', kos_theme_path());
defined('PAGETYPE') || define('PAGETYPE', $page->getCollectionTypeHandle());
defined('PAGETEMPLATE') || define('PAGETEMPLATE', $template);
defined('CHECKLOGIN') || define('CHECKLOGIN', $ux->checkLogin());
defined('PAGENAME') || define('PAGENAME', $page->getCollectionName());
defined('PAGEDESC') || define('PAGEDESC', (string) $page->getCollectionDescription());
defined('PAGETHUMB') || define('PAGETHUMB', $thumb);
defined('PAGEID') || define('PAGEID', $page->getCollectionID());
defined('PAGEPATH') || define('PAGEPATH', $page->getCollectionLink());
defined('PAGEURLABS') || define('PAGEURLABS', $pageUrl);
defined('EDITMODE') || define('EDITMODE', $c->isEditMode());
defined('METATITLE') || define('METATITLE', $metaTitle);
defined('METADESC') || define('METADESC', $metaDesc);
defined('METAIMAGE') || define('METAIMAGE', $metaImage);
defined('LANGAREA') || define('LANGAREA', $langArea);
defined('LANGPATH') || define('LANGPATH', $langPath);
defined('LANGTAG') || define('LANGTAG', $langTag);
defined('BODYCLASS') || define('BODYCLASS', $bodyClass);
