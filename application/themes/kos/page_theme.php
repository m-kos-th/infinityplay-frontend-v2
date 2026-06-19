<?php
namespace Application\Theme\Kos;

use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use Concrete\Core\Feature\Features;
use Concrete\Core\Http\Request;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme implements ThemeProviderInterface
{
    protected function isEditorContext()
    {
        $page = Page::getCurrentPage();
        if (is_object($page) && !$page->isError()) {
            if (method_exists($page, 'isAdminArea') && $page->isAdminArea()) {
                return true;
            }

            if (method_exists($page, 'isEditMode') && $page->isEditMode()) {
                return true;
            }
        }

        $request = Request::getInstance();
        $path = $request ? (string) $request->getPath() : '';

        return strpos($path, '/dashboard') === 0 || strpos($path, '/ccm') === 0;
    }

    public function getThemeSupportedFeatures()
    {
        return [
            Features::BASICS,
            Features::TYPOGRAPHY,
            Features::FAQ,
            Features::NAVIGATION,
            Features::FORMS,
            Features::SEARCH,
            Features::TESTIMONIALS,
            Features::TAXONOMY,
        ];
    }

    public function registerAssets()
    {
        $this->requireAsset('jquery');
        $this->requireAsset('bootstrap');

        if ($this->isEditorContext()) {
            $this->requireAsset('font-awesome');
            $this->requireAsset('vue');
            $this->requireAsset('moment');
        }
    }

    protected $pThemeGridFrameworkHandle = 'bootstrap3';

    public function getThemeName()
    {
        return t('Infinity Play');
    }

    public function getThemeDescription()
    {
        return t('ConcreteCMS theme conversion for the Infinity Play frontend.');
    }

    /**
     * @return array
     */
    public function getThemeBlockClasses()
    {
        return [
            'feature' => ['feature-home-page'],
            'page_list' => [
                'recent-blog-entry',
                'blog-entry-list',
                'page-list-with-buttons',
                'block-sidebar-wrapped',
            ],
            'next_previous' => ['block-sidebar-wrapped'],
            'share_this_page' => ['block-sidebar-wrapped'],
            'content' => [
                'block-sidebar-wrapped',
                'block-sidebar-padded',
            ],
            'date_navigation' => ['block-sidebar-padded'],
            'topic_list' => ['block-sidebar-wrapped'],
            'testimonial' => ['testimonial-bio'],
            'image' => [
                'image-right-tilt',
                'image-circle',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getThemeAreaClasses()
    {
        return [
            'Page Footer' => ['area-content-accent'],
        ];
    }

    /**
     * @return array
     */
    public function getThemeDefaultBlockTemplates()
    {
        return [
            'calendar' => 'bootstrap_calendar.php',
        ];
    }

    /**
     * @return array
     */
    public function getThemeResponsiveImageMap()
    {
        return [
            'large' => '900px',
            'medium' => '768px',
            'small' => '0',
        ];
    }

    /**
     * @return array
     */
    public function getThemeEditorClasses()
    {
        return [
            ['title' => t('Title Thin'), 'menuClass' => 'title-thin', 'spanClass' => 'title-thin', 'forceBlock' => 1],
            ['title' => t('Title Caps Bold'), 'menuClass' => 'title-caps-bold', 'spanClass' => 'title-caps-bold', 'forceBlock' => 1],
            ['title' => t('Title Caps'), 'menuClass' => 'title-caps', 'spanClass' => 'title-caps', 'forceBlock' => 1],
            ['title' => t('Image Caption'), 'menuClass' => 'image-caption', 'spanClass' => 'image-caption', 'forceBlock' => '-1'],
            ['title' => t('Standard Button'), 'menuClass' => '', 'spanClass' => 'btn btn-default', 'forceBlock' => '-1'],
            ['title' => t('Success Button'), 'menuClass' => '', 'spanClass' => 'btn btn-success', 'forceBlock' => '-1'],
            ['title' => t('Primary Button'), 'menuClass' => '', 'spanClass' => 'btn btn-primary', 'forceBlock' => '-1'],
        ];
    }

    /**
     * @return array
     */
    public function getThemeAreaLayoutPresets()
    {
        $presets = [
            [
                'handle' => 'left_sidebar',
                'name' => 'Left Sidebar',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-sm-4"></div>',
                    '<div class="col-sm-8"></div>',
                ],
            ],
            [
                'handle' => 'right_sidebar',
                'name' => 'Right Sidebar',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-sm-8"></div>',
                    '<div class="col-sm-4"></div>',
                ],
            ],
            [
                'handle' => 'two_column_equal',
                'name' => 'Two Column Equal',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-sm-6"></div>',
                    '<div class="col-sm-6"></div>',
                ],
            ],
            [
                'handle' => 'three_column_equal',
                'name' => 'Three Column Equal',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-sm-4"></div>',
                    '<div class="col-sm-4"></div>',
                    '<div class="col-sm-4"></div>',
                ],
            ],
        ];

        return $presets;
    }
}
