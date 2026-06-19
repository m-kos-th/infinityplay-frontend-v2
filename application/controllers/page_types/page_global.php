<?php

namespace Application\Controller\PageType;

use Concrete\Core\Page\Controller\PageTypeController;
use Concrete\Core\Multilingual\Page\Section\Section;

use Core;
use Loader;
use Page;
use PageList;
use Config;
use UserInfo;

class PageGlobal extends PageTypeController
{
	# Default LANG
	public $languages = ['area' => '', 'path' => '/', 'class' => ''];

	public function getLanguages() {
		# get the current page
		$current_page = Page::getCurrentPage();
		# get the current lanuage
		$site_lang = Section::getBySectionOfSite($current_page);

		# set lanuage
		if(is_object($site_lang) && $site_lang->getLocale() == 'en_US'){
			$this->languages['area'] = 'EN';
			$this->languages['path'] = $site_lang->getCollectionLink();
			$this->languages['class'] = 'lang-en';
		} else if (is_object($site_lang)) {
			$local = explode('_', $site_lang->getLocale());
			$this->languages['area'] = $local[count($local) - 1];
			$this->languages['path'] = $site_lang->getCollectionLink();
			$this->languages['class'] = 'lang-'.strtolower($this->languages['area']);
		} else {
			$this->languages['area'] = 'EN';
			$this->languages['path'] = '/';
			$this->languages['class'] = 'lang-en';
		}
		return $this->languages;
	}

	# Get Language Area
	public function getLanguageArea() {
		return $this->languages['area'];
	}

	# Get Language Path
	public function getLanguagePath() {
		return $this->languages['path'];
	}

	# Get Language Class
	public function getLanguageClass() {
		return $this->languages['class'];
	}

	# Auto Redirect Inside Page
	public function autoRedirect() {
		# get the current page
		$current = Page::getCurrentPage();
		$rid = $current->getAttribute('redirect_page');

		if(!empty($rid)) {
			$page = Page::getByID($rid);
			if (is_object($page)) {
				$url = $page->getCollectionLink();
				header('Location: '. ($url));
				exit;
			}
		}
	}
}
