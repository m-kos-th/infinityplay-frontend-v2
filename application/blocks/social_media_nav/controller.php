<?php namespace Application\Block\SocialMediaNav;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Core;
use Database;
use File;
use Page;
use Permissions;

class Controller extends BlockController
{
    public $btFieldsRequired = ['socialLinks' => []];
    protected $btExportTables = ['btSocialMediaNav', 'btSocialMediaNavSocialLinksEntries'];
    protected $btTable = 'btSocialMediaNav';
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
        return t("Social Media Navigation");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $socialLinks = [];
        $socialLinks_items = $db->fetchAll('SELECT * FROM btSocialMediaNavSocialLinksEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($socialLinks_items as $socialLinks_item_k => &$socialLinks_item_v) {
            $socialLinks_item_v["socialLink_Object"] = null;
			$socialLinks_item_v["socialLink_Title"] = trim($socialLinks_item_v["socialLink_Title"]);
			if (isset($socialLinks_item_v["socialLink"]) && trim($socialLinks_item_v["socialLink"]) != '') {
				switch ($socialLinks_item_v["socialLink"]) {
					case 'page':
						if ($socialLinks_item_v["socialLink_Page"] > 0 && ($socialLinks_item_v["socialLink_Page_c"] = Page::getByID($socialLinks_item_v["socialLink_Page"], 'ACTIVE')) && !$socialLinks_item_v["socialLink_Page_c"]->error && !$socialLinks_item_v["socialLink_Page_c"]->isInTrash()) {
							$socialLinks_item_v["socialLink_Object"] = $socialLinks_item_v["socialLink_Page_c"];
							$socialLinks_item_v["socialLink_URL"] = $socialLinks_item_v["socialLink_Page_c"]->getCollectionLink();
							if ($socialLinks_item_v["socialLink_Title"] == '') {
								$socialLinks_item_v["socialLink_Title"] = $socialLinks_item_v["socialLink_Page_c"]->getCollectionName();
							}
						}
						break;
				    case 'file':
						$socialLinks_item_v["socialLink_File_id"] = (int)$socialLinks_item_v["socialLink_File"];
						if ($socialLinks_item_v["socialLink_File_id"] > 0 && ($socialLinks_item_v["socialLink_File_object"] = File::getByID($socialLinks_item_v["socialLink_File_id"])) && is_object($socialLinks_item_v["socialLink_File_object"])) {
							$fp = new Permissions($socialLinks_item_v["socialLink_File_object"]);
							if ($fp->canViewFile()) {
								$socialLinks_item_v["socialLink_Object"] = $socialLinks_item_v["socialLink_File_object"];
								$socialLinks_item_v["socialLink_URL"] = $socialLinks_item_v["socialLink_File_object"]->getRelativePath();
								if ($socialLinks_item_v["socialLink_Title"] == '') {
									$socialLinks_item_v["socialLink_Title"] = $socialLinks_item_v["socialLink_File_object"]->getTitle();
								}
							}
						}
						break;
				    case 'url':
						if ($socialLinks_item_v["socialLink_Title"] == '') {
							$socialLinks_item_v["socialLink_Title"] = $socialLinks_item_v["socialLink_URL"];
						}
						break;
				    case 'relative_url':
						if ($socialLinks_item_v["socialLink_Title"] == '') {
							$socialLinks_item_v["socialLink_Title"] = $socialLinks_item_v["socialLink_Relative_URL"];
						}
						$socialLinks_item_v["socialLink_URL"] = $socialLinks_item_v["socialLink_Relative_URL"];
						break;
				    case 'image':
						if ($socialLinks_item_v["socialLink_Image"] > 0 && ($socialLinks_item_v["socialLink_Image_object"] = File::getByID($socialLinks_item_v["socialLink_Image"])) && is_object($socialLinks_item_v["socialLink_Image_object"])) {
							$socialLinks_item_v["socialLink_URL"] = $socialLinks_item_v["socialLink_Image_object"]->getURL();
							$socialLinks_item_v["socialLink_Object"] = $socialLinks_item_v["socialLink_Image_object"];
							if ($socialLinks_item_v["socialLink_Title"] == '') {
								$socialLinks_item_v["socialLink_Title"] = $socialLinks_item_v["socialLink_Image_object"]->getTitle();
							}
						}
						break;
				}
			}
        }
        $this->set('socialLinks_items', $socialLinks_items);
        $this->set('socialLinks', $socialLinks);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btSocialMediaNavSocialLinksEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $socialLinks_items = $db->fetchAll('SELECT * FROM btSocialMediaNavSocialLinksEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($socialLinks_items as $socialLinks_item) {
            unset($socialLinks_item['id']);
            $socialLinks_item['bID'] = $newBID;
            $db->insert('btSocialMediaNavSocialLinksEntries', $socialLinks_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $socialLinks = $this->get('socialLinks');
        $this->set('socialLinks_items', []);
        $this->set('socialLinks', $socialLinks);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $socialLinks = $this->get('socialLinks');
        $socialLinks_items = $db->fetchAll('SELECT * FROM btSocialMediaNavSocialLinksEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('socialLinks', $socialLinks);
        $this->set('socialLinks_items', $socialLinks_items);
    }

    protected function addEdit()
    {
        $socialLinks = [];
        $this->set("socialLink_Options", $this->getSmartLinkTypeOptions([
  'page',
  'file',
  'image',
  'url',
  'relative_url',
], true));
        $this->set('socialLinks', $socialLinks);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/social_media_nav/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/social_media_nav/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/social_media_nav/js_form/handlebars-helpers.js', [], $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        $rows = $db->fetchAll('SELECT * FROM btSocialMediaNavSocialLinksEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $socialLinks_items = isset($args['socialLinks']) && is_array($args['socialLinks']) ? $args['socialLinks'] : [];
        $queries = [];
        if (!empty($socialLinks_items)) {
            $i = 0;
            foreach ($socialLinks_items as $socialLinks_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($socialLinks_item['socialLink']) && trim($socialLinks_item['socialLink']) != '') {
					$data['socialLink_Title'] = $socialLinks_item['socialLink_Title'];
					$data['socialLink'] = $socialLinks_item['socialLink'];
					switch ($socialLinks_item['socialLink']) {
						case 'page':
							$data['socialLink_Page'] = $socialLinks_item['socialLink_Page'];
							$data['socialLink_File'] = '0';
							$data['socialLink_URL'] = '';
							$data['socialLink_Relative_URL'] = '';
							$data['socialLink_Image'] = '0';
							break;
                        case 'file':
							$data['socialLink_File'] = $socialLinks_item['socialLink_File'];
							$data['socialLink_Page'] = '0';
							$data['socialLink_URL'] = '';
							$data['socialLink_Relative_URL'] = '';
							$data['socialLink_Image'] = '0';
							break;
                        case 'url':
							$data['socialLink_URL'] = $socialLinks_item['socialLink_URL'];
							$data['socialLink_Page'] = '0';
							$data['socialLink_File'] = '0';
							$data['socialLink_Relative_URL'] = '';
							$data['socialLink_Image'] = '0';
							break;
                        case 'relative_url':
							$data['socialLink_Relative_URL'] = $socialLinks_item['socialLink_Relative_URL'];
							$data['socialLink_Page'] = '0';
							$data['socialLink_File'] = '0';
							$data['socialLink_URL'] = '';
							$data['socialLink_Image'] = '0';
							break;
                        case 'image':
							$data['socialLink_Image'] = $socialLinks_item['socialLink_Image'];
							$data['socialLink_Page'] = '0';
							$data['socialLink_File'] = '0';
							$data['socialLink_URL'] = '';
							$data['socialLink_Relative_URL'] = '';
							break;
                        default:
							$data['socialLink'] = '';
							$data['socialLink_Page'] = '0';
							$data['socialLink_File'] = '0';
							$data['socialLink_URL'] = '';
							$data['socialLink_Relative_URL'] = '';
							$data['socialLink_Image'] = '0';
							break;	
					}
				}
				else {
					$data['socialLink'] = '';
					$data['socialLink_Title'] = '';
					$data['socialLink_Page'] = '0';
					$data['socialLink_File'] = '0';
					$data['socialLink_URL'] = '';
					$data['socialLink_Relative_URL'] = '';
					$data['socialLink_Image'] = '0';
				}
                if (isset($rows[$i])) {
                    $queries['update'][$rows[$i]['id']] = $data;
                    unset($rows[$i]);
                } else {
                    $data['bID'] = $this->bID;
                    $queries['insert'][] = $data;
                }
                $i++;
            }
        }
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $queries['delete'][] = $row['id'];
            }
        }
        if (!empty($queries)) {
            foreach ($queries as $type => $values) {
                if (!empty($values)) {
                    switch ($type) {
                        case 'update':
                            foreach ($values as $id => $data) {
                                $db->update('btSocialMediaNavSocialLinksEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btSocialMediaNavSocialLinksEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btSocialMediaNavSocialLinksEntries', ['id' => $value]);
                            }
                            break;
                    }
                }
            }
        }
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        $socialLinksEntriesMin = 0;
        $socialLinksEntriesMax = 0;
        $socialLinksEntriesErrors = 0;
        $socialLinks = [];
        if (isset($args['socialLinks']) && is_array($args['socialLinks']) && !empty($args['socialLinks'])) {
            if ($socialLinksEntriesMin >= 1 && count($args['socialLinks']) < $socialLinksEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Social Links"), $socialLinksEntriesMin, count($args['socialLinks'])));
                $socialLinksEntriesErrors++;
            }
            if ($socialLinksEntriesMax >= 1 && count($args['socialLinks']) > $socialLinksEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Social Links"), $socialLinksEntriesMax, count($args['socialLinks'])));
                $socialLinksEntriesErrors++;
            }
            if ($socialLinksEntriesErrors == 0) {
                foreach ($args['socialLinks'] as $socialLinks_k => $socialLinks_v) {
                    if (is_array($socialLinks_v)) {
                        if ((in_array("socialLink", $this->btFieldsRequired['socialLinks']) && (!isset($socialLinks_v['socialLink']) || trim($socialLinks_v['socialLink']) == "")) || (isset($socialLinks_v['socialLink']) && trim($socialLinks_v['socialLink']) != "" && !array_key_exists($socialLinks_v['socialLink'], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url'])))) {
							$e->add(t("The %s field has an invalid value.", t("Social Link")));
						} elseif (array_key_exists($socialLinks_v['socialLink'], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url']))) {
							switch ($socialLinks_v['socialLink']) {
								case 'page':
									if (!isset($socialLinks_v['socialLink_Page']) || trim($socialLinks_v['socialLink_Page']) == "" || $socialLinks_v['socialLink_Page'] == "0" || (($page = Page::getByID($socialLinks_v['socialLink_Page'])) && $page->error !== false)) {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("Page"), t("Social Link"), t("Social Links"), $socialLinks_k));
									}
									break;
				                case 'file':
									if (!isset($socialLinks_v['socialLink_File']) || trim($socialLinks_v['socialLink_File']) == "" || !is_object(File::getByID($socialLinks_v['socialLink_File']))) {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("File"), t("Social Link"), t("Social Links"), $socialLinks_k));
									}
									break;
				                case 'url':
									if (!isset($socialLinks_v['socialLink_URL']) || trim($socialLinks_v['socialLink_URL']) == "" || !filter_var($socialLinks_v['socialLink_URL'], FILTER_VALIDATE_URL)) {
										$e->add(t("The %s field for '%s' does not have a valid URL (%s, row #%s).", t("URL"), t("Social Link"), t("Social Links"), $socialLinks_k));
									}
									break;
				                case 'relative_url':
									if (!isset($socialLinks_v['socialLink_Relative_URL']) || trim($socialLinks_v['socialLink_Relative_URL']) == "") {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("Relative URL"), t("Social Link"), t("Social Links"), $socialLinks_k));
									}
									break;
				                case 'image':
									if (!isset($socialLinks_v['socialLink_Image']) || trim($socialLinks_v['socialLink_Image']) == "" || !is_object(File::getByID($socialLinks_v['socialLink_Image']))) {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("Image"), t("Social Link"), t("Social Links"), $socialLinks_k));
									}
									break;	
							}
						}
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Social Links'), $socialLinks_k));
                    }
                }
            }
        } else {
            if ($socialLinksEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Social Links"), $socialLinksEntriesMin));
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