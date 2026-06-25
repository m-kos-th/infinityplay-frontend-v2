<?php namespace Application\Block\BlockStats;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use File;
use Page;
use Permissions;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btTable = 'btBlockStats';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $pkg = false;
    
    public function getBlockTypeName()
    {
        return t("Block Stats");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->content;
        return implode(" ", $content);
    }

    public function view()
    {
        $this->set('content', LinkAbstractor::translateFrom($this->content));
        $button_URL = null;
		$button_Object = null;
		$button_Title = trim($this->button_Title);
		if (trim($this->button) != '') {
			switch ($this->button) {
				case 'page':
					if (isset($this->button_Page) && $this->button_Page > 0 && ($button_Page_c = Page::getByID($this->button_Page, 'ACTIVE')) && !$button_Page_c->error && !$button_Page_c->isInTrash()) {
						$button_Object = $button_Page_c;
						$button_URL = $button_Page_c->getCollectionLink();
						if ($button_Title == '') {
							$button_Title = $button_Page_c->getCollectionName();
						}
					}
					break;
				case 'file':
					$button_File_id = (int)$this->button_File;
					if ($button_File_id > 0 && ($button_File_object = File::getByID($button_File_id)) && is_object($button_File_object)) {
						$fp = new Permissions($button_File_object);
						if ($fp->canViewFile()) {
							$button_Object = $button_File_object;
							$button_URL = $button_File_object->getRelativePath();
							if ($button_Title == '') {
								$button_Title = $button_File_object->getTitle();
							}
						}
					}
					break;
				case 'url':
					$button_URL = $this->button_URL;
					if ($button_Title == '') {
						$button_Title = $button_URL;
					}
					break;
				case 'relative_url':
					$button_URL = $this->button_Relative_URL;
					if ($button_Title == '') {
						$button_Title = $this->button_Relative_URL;
					}
					break;
				case 'image':
					if ($this->button_Image && ($button_Image_object = File::getByID($this->button_Image)) && is_object($button_Image_object)) {
						$button_URL = $button_Image_object->getURL();
						$button_Object = $button_Image_object;
						if ($button_Title == '') {
							$button_Title = $button_Image_object->getTitle();
						}
					}
					break;
			}
		}
		$this->set("button_URL", $button_URL);
		$this->set("button_Object", $button_Object);
		$this->set("button_Title", $button_Title);
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('content', LinkAbstractor::translateFromEditMode($this->content));
    }

    protected function addEdit()
    {
        $this->set("button_Options", $this->getSmartLinkTypeOptions([
  'page',
  'file',
  'image',
  'url',
  'relative_url',
], true));
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $args['content'] = LinkAbstractor::translateTo($args['content']);
        if (isset($args["button"]) && trim($args["button"]) != '') {
			switch ($args["button"]) {
				case 'page':
					$args["button_File"] = '0';
					$args["button_URL"] = '';
					$args["button_Relative_URL"] = '';
					$args["button_Image"] = '0';
					break;
				case 'file':
					$args["button_Page"] = '0';
					$args["button_URL"] = '';
					$args["button_Relative_URL"] = '';
					$args["button_Image"] = '0';
					break;
				case 'url':
					$args["button_Page"] = '0';
					$args["button_Relative_URL"] = '';
					$args["button_File"] = '0';
					$args["button_Image"] = '0';
					break;
				case 'relative_url':
					$args["button_Page"] = '0';
					$args["button_URL"] = '';
					$args["button_File"] = '0';
					$args["button_Image"] = '0';
					break;
				case 'image':
					$args["button_Page"] = '0';
					$args["button_File"] = '0';
					$args["button_URL"] = '';
					$args["button_Relative_URL"] = '';
					break;
				default:
					$args["button_Title"] = '';
					$args["button_Page"] = '0';
					$args["button_File"] = '0';
					$args["button_URL"] = '';
					$args["button_Relative_URL"] = '';
					$args["button_Image"] = '0';
					break;	
			}
		}
		else {
			$args["button_Title"] = '';
			$args["button_Page"] = '0';
			$args["button_File"] = '0';
			$args["button_URL"] = '';
			$args["button_Relative_URL"] = '';
			$args["button_Image"] = '0';
		}
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("content", $this->btFieldsRequired) && (trim($args["content"]) == "")) {
            $e->add(t("The %s field is required.", t("Content")));
        }
        if ((in_array("button", $this->btFieldsRequired) && (!isset($args["button"]) || trim($args["button"]) == "")) || (isset($args["button"]) && trim($args["button"]) != "" && !array_key_exists($args["button"], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url'])))) {
			$e->add(t("The %s field has an invalid value.", t("Button")));
		} elseif (array_key_exists($args["button"], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url']))) {
			switch ($args["button"]) {
				case 'page':
					if (!isset($args["button_Page"]) || trim($args["button_Page"]) == "" || $args["button_Page"] == "0" || (($page = Page::getByID($args["button_Page"], 'ACTIVE')) && $page->error !== false)) {
						$e->add(t("The %s field for '%s' is required.", t("Page"), t("Button")));
					}
					break;
				case 'file':
					if (!isset($args["button_File"]) || trim($args["button_File"]) == "" || !is_object(File::getByID($args["button_File"]))) {
						$e->add(t("The %s field for '%s' is required.", t("File"), t("Button")));
					}
					break;
				case 'url':
					if (!isset($args["button_URL"]) || trim($args["button_URL"]) == "" || !filter_var($args["button_URL"], FILTER_VALIDATE_URL)) {
						$e->add(t("The %s field for '%s' does not have a valid URL.", t("URL"), t("Button")));
					}
					break;
				case 'relative_url':
					if (!isset($args["button_Relative_URL"]) || trim($args["button_Relative_URL"]) == "") {
						$e->add(t("The %s field for '%s' is required.", t("Relative URL"), t("Button")));
					}
					break;
				case 'image':
					if (!isset($args["button_Image"]) || trim($args["button_Image"]) == "" || !is_object(File::getByID($args["button_Image"]))) {
						$e->add(t("The %s field for '%s' is required.", t("Image"), t("Button")));
					}
					break;	
			}
		}
        return $e;
    }

    public function composer()
    {
        $al = AssetList::getInstance();
        $al->register('javascript', 'auto-js-' . $this->btHandle, 'blocks/' . $this->btHandle . '/auto.js', [], $this->pkg);
        $this->requireAsset('javascript', 'auto-js-' . $this->btHandle);
        $this->edit();
    }

    protected function getSmartLinkTypeOptions($include = [], $checkNone = false)
	{
		$options = [
			''             => sprintf("-- %s--", t("None")),
			'page'         => t("Page"),
			'url'          => t("External URL"),
			'relative_url' => t("Relative URL"),
			'file'         => t("File"),
			'image'        => t("Image")
		];
		if ($checkNone) {
            $include = array_merge([''], $include);
        }
		$return = [];
		foreach($include as $v){
		    if(isset($options[$v])){
		        $return[$v] = $options[$v];
		    }
		}
		return $return;
	}
}