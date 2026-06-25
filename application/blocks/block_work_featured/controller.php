<?php namespace Application\Block\BlockWorkFeatured;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;
use File;
use Page;
use Permissions;
use URL;

class Controller extends BlockController
{
    public $btFieldsRequired = ['workList' => []];
    protected $btExportFileColumns = ['logo', 'videoGamePreview'];
    protected $btExportTables = ['btBlockWorkFeatured', 'btBlockWorkFeaturedWorkListEntries'];
    protected $btTable = 'btBlockWorkFeatured';
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
        return t("Block Work Featured");
    }

    public function getSearchableContent()
    {
        $content = [];
        $db = Database::connection();
        $workList_items = $db->fetchAll('SELECT * FROM btBlockWorkFeaturedWorkListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($workList_items as $workList_item_k => $workList_item_v) {
            if (isset($workList_item_v["gameName"]) && trim($workList_item_v["gameName"]) != "") {
                $content[] = $workList_item_v["gameName"];
            }
            if (isset($workList_item_v["content"]) && trim($workList_item_v["content"]) != "") {
                $content[] = $workList_item_v["content"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $workList = [];
        $workList_items = $db->fetchAll('SELECT * FROM btBlockWorkFeaturedWorkListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($workList_items as $workList_item_k => &$workList_item_v) {
            if (isset($workList_item_v['logo']) && trim($workList_item_v['logo']) != "" && ($f = File::getByID($workList_item_v['logo'])) && is_object($f)) {
                $workList_item_v['logo'] = $f;
            } else {
                $workList_item_v['logo'] = false;
            }
            $workList_item_v["videoGamePreview_id"] = isset($workList_item_v["videoGamePreview"]) && trim($workList_item_v["videoGamePreview"]) != "" ? (int)$workList_item_v["videoGamePreview"] : false;
            $workList_item_v["videoGamePreview"] = false;
            if ($workList_item_v["videoGamePreview_id"] > 0 && ($workList_item_v["videoGamePreview_file"] = File::getByID($workList_item_v["videoGamePreview_id"])) && is_object($workList_item_v["videoGamePreview_file"])) {
                $fp = new Permissions($workList_item_v["videoGamePreview_file"]);
                if ($fp->canViewFile()) {
                    $urls = ['relative' => $workList_item_v["videoGamePreview_file"]->getRelativePath()];
                    $urls['download'] = URL::to('/download_file', '/force', $workList_item_v["videoGamePreview_file"]->hasFileUUID() ? $workList_item_v["videoGamePreview_file"]->getFileUUID() : $workList_item_v["videoGamePreview_file"]->getFileID());
                    $workList_item_v["videoGamePreview_file"]->urls = $urls;
                    $workList_item_v["videoGamePreview"] = $workList_item_v["videoGamePreview_file"];
                }
            }
            $workList_item_v["content"] = isset($workList_item_v["content"]) ? LinkAbstractor::translateFrom($workList_item_v["content"]) : null;
            $workList_item_v["button_Object"] = null;
			$workList_item_v["button_Title"] = trim($workList_item_v["button_Title"]);
			if (isset($workList_item_v["button"]) && trim($workList_item_v["button"]) != '') {
				switch ($workList_item_v["button"]) {
					case 'page':
						if ($workList_item_v["button_Page"] > 0 && ($workList_item_v["button_Page_c"] = Page::getByID($workList_item_v["button_Page"], 'ACTIVE')) && !$workList_item_v["button_Page_c"]->error && !$workList_item_v["button_Page_c"]->isInTrash()) {
							$workList_item_v["button_Object"] = $workList_item_v["button_Page_c"];
							$workList_item_v["button_URL"] = $workList_item_v["button_Page_c"]->getCollectionLink();
							if ($workList_item_v["button_Title"] == '') {
								$workList_item_v["button_Title"] = $workList_item_v["button_Page_c"]->getCollectionName();
							}
						}
						break;
				    case 'file':
						$workList_item_v["button_File_id"] = (int)$workList_item_v["button_File"];
						if ($workList_item_v["button_File_id"] > 0 && ($workList_item_v["button_File_object"] = File::getByID($workList_item_v["button_File_id"])) && is_object($workList_item_v["button_File_object"])) {
							$fp = new Permissions($workList_item_v["button_File_object"]);
							if ($fp->canViewFile()) {
								$workList_item_v["button_Object"] = $workList_item_v["button_File_object"];
								$workList_item_v["button_URL"] = $workList_item_v["button_File_object"]->getRelativePath();
								if ($workList_item_v["button_Title"] == '') {
									$workList_item_v["button_Title"] = $workList_item_v["button_File_object"]->getTitle();
								}
							}
						}
						break;
				    case 'url':
						if ($workList_item_v["button_Title"] == '') {
							$workList_item_v["button_Title"] = $workList_item_v["button_URL"];
						}
						break;
				    case 'relative_url':
						if ($workList_item_v["button_Title"] == '') {
							$workList_item_v["button_Title"] = $workList_item_v["button_Relative_URL"];
						}
						$workList_item_v["button_URL"] = $workList_item_v["button_Relative_URL"];
						break;
				    case 'image':
						if ($workList_item_v["button_Image"] > 0 && ($workList_item_v["button_Image_object"] = File::getByID($workList_item_v["button_Image"])) && is_object($workList_item_v["button_Image_object"])) {
							$workList_item_v["button_URL"] = $workList_item_v["button_Image_object"]->getURL();
							$workList_item_v["button_Object"] = $workList_item_v["button_Image_object"];
							if ($workList_item_v["button_Title"] == '') {
								$workList_item_v["button_Title"] = $workList_item_v["button_Image_object"]->getTitle();
							}
						}
						break;
				}
			}
        }
        $this->set('workList_items', $workList_items);
        $this->set('workList', $workList);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btBlockWorkFeaturedWorkListEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $workList_items = $db->fetchAll('SELECT * FROM btBlockWorkFeaturedWorkListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($workList_items as $workList_item) {
            unset($workList_item['id']);
            $workList_item['bID'] = $newBID;
            $db->insert('btBlockWorkFeaturedWorkListEntries', $workList_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $workList = $this->get('workList');
        $this->set('workList_items', []);
        $this->set('workList', $workList);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $workList = $this->get('workList');
        $workList_items = $db->fetchAll('SELECT * FROM btBlockWorkFeaturedWorkListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($workList_items as &$workList_item) {
            if (!File::getByID($workList_item['logo'])) {
                unset($workList_item['logo']);
            }
        }
        foreach ($workList_items as &$workList_item) {
            if (!File::getByID($workList_item['videoGamePreview'])) {
                unset($workList_item['videoGamePreview']);
            }
        }
        
        foreach ($workList_items as &$workList_item) {
            $workList_item['content'] = isset($workList_item['content']) ? LinkAbstractor::translateFromEditMode($workList_item['content']) : null;
        }
        $this->set('workList', $workList);
        $this->set('workList_items', $workList_items);
    }

    protected function addEdit()
    {
        $workList = [];
        $this->set("button_Options", $this->getSmartLinkTypeOptions([
  'page',
  'file',
  'image',
  'url',
  'relative_url',
], true));
        $this->set('workList', $workList);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/block_work_featured/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/block_work_featured/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/block_work_featured/js_form/handlebars-helpers.js', [], $this->pkg);
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
        $rows = $db->fetchAll('SELECT * FROM btBlockWorkFeaturedWorkListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $workList_items = isset($args['workList']) && is_array($args['workList']) ? $args['workList'] : [];
        $queries = [];
        if (!empty($workList_items)) {
            $i = 0;
            foreach ($workList_items as $workList_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($workList_item['gameName']) && trim($workList_item['gameName']) != '') {
                    $data['gameName'] = trim($workList_item['gameName']);
                } else {
                    $data['gameName'] = null;
                }
                if (isset($workList_item['logo']) && trim($workList_item['logo']) != '') {
                    $data['logo'] = trim($workList_item['logo']);
                } else {
                    $data['logo'] = null;
                }
                if (isset($workList_item['videoGamePreview']) && trim($workList_item['videoGamePreview']) != '') {
                    $data['videoGamePreview'] = trim($workList_item['videoGamePreview']);
                } else {
                    $data['videoGamePreview'] = null;
                }
                $data['content'] = isset($workList_item['content']) ? LinkAbstractor::translateTo($workList_item['content']) : null;
                if (isset($workList_item['button']) && trim($workList_item['button']) != '') {
					$data['button_Title'] = $workList_item['button_Title'];
					$data['button'] = $workList_item['button'];
					switch ($workList_item['button']) {
						case 'page':
							$data['button_Page'] = $workList_item['button_Page'];
							$data['button_File'] = '0';
							$data['button_URL'] = '';
							$data['button_Relative_URL'] = '';
							$data['button_Image'] = '0';
							break;
                        case 'file':
							$data['button_File'] = $workList_item['button_File'];
							$data['button_Page'] = '0';
							$data['button_URL'] = '';
							$data['button_Relative_URL'] = '';
							$data['button_Image'] = '0';
							break;
                        case 'url':
							$data['button_URL'] = $workList_item['button_URL'];
							$data['button_Page'] = '0';
							$data['button_File'] = '0';
							$data['button_Relative_URL'] = '';
							$data['button_Image'] = '0';
							break;
                        case 'relative_url':
							$data['button_Relative_URL'] = $workList_item['button_Relative_URL'];
							$data['button_Page'] = '0';
							$data['button_File'] = '0';
							$data['button_URL'] = '';
							$data['button_Image'] = '0';
							break;
                        case 'image':
							$data['button_Image'] = $workList_item['button_Image'];
							$data['button_Page'] = '0';
							$data['button_File'] = '0';
							$data['button_URL'] = '';
							$data['button_Relative_URL'] = '';
							break;
                        default:
							$data['button'] = '';
							$data['button_Page'] = '0';
							$data['button_File'] = '0';
							$data['button_URL'] = '';
							$data['button_Relative_URL'] = '';
							$data['button_Image'] = '0';
							break;	
					}
				}
				else {
					$data['button'] = '';
					$data['button_Title'] = '';
					$data['button_Page'] = '0';
					$data['button_File'] = '0';
					$data['button_URL'] = '';
					$data['button_Relative_URL'] = '';
					$data['button_Image'] = '0';
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
                                $db->update('btBlockWorkFeaturedWorkListEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btBlockWorkFeaturedWorkListEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btBlockWorkFeaturedWorkListEntries', ['id' => $value]);
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
        $workListEntriesMin = 0;
        $workListEntriesMax = 0;
        $workListEntriesErrors = 0;
        $workList = [];
        if (isset($args['workList']) && is_array($args['workList']) && !empty($args['workList'])) {
            if ($workListEntriesMin >= 1 && count($args['workList']) < $workListEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Work List"), $workListEntriesMin, count($args['workList'])));
                $workListEntriesErrors++;
            }
            if ($workListEntriesMax >= 1 && count($args['workList']) > $workListEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Work List"), $workListEntriesMax, count($args['workList'])));
                $workListEntriesErrors++;
            }
            if ($workListEntriesErrors == 0) {
                foreach ($args['workList'] as $workList_k => $workList_v) {
                    if (is_array($workList_v)) {
                        if (in_array("gameName", $this->btFieldsRequired['workList']) && (!isset($workList_v['gameName']) || trim($workList_v['gameName']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Game Name"), t("Work List"), $workList_k));
                        }
                        if (in_array("logo", $this->btFieldsRequired['workList']) && (!isset($workList_v['logo']) || trim($workList_v['logo']) == "" || !is_object(File::getByID($workList_v['logo'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Logo"), t("Work List"), $workList_k));
                        }
                        if (in_array("videoGamePreview", $this->btFieldsRequired['workList']) && (!isset($workList_v['videoGamePreview']) || trim($workList_v['videoGamePreview']) == "" || !is_object(File::getByID($workList_v['videoGamePreview'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Video Game Preview"), t("Work List"), $workList_k));
                        }
                        if (in_array("content", $this->btFieldsRequired['workList']) && (!isset($workList_v['content']) || trim($workList_v['content']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Content"), t("Work List"), $workList_k));
                        }
                        if ((in_array("button", $this->btFieldsRequired['workList']) && (!isset($workList_v['button']) || trim($workList_v['button']) == "")) || (isset($workList_v['button']) && trim($workList_v['button']) != "" && !array_key_exists($workList_v['button'], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url'])))) {
							$e->add(t("The %s field has an invalid value.", t("Button")));
						} elseif (array_key_exists($workList_v['button'], $this->getSmartLinkTypeOptions(['page', 'file', 'image', 'url', 'relative_url']))) {
							switch ($workList_v['button']) {
								case 'page':
									if (!isset($workList_v['button_Page']) || trim($workList_v['button_Page']) == "" || $workList_v['button_Page'] == "0" || (($page = Page::getByID($workList_v['button_Page'])) && $page->error !== false)) {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("Page"), t("Button"), t("Work List"), $workList_k));
									}
									break;
				                case 'file':
									if (!isset($workList_v['button_File']) || trim($workList_v['button_File']) == "" || !is_object(File::getByID($workList_v['button_File']))) {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("File"), t("Button"), t("Work List"), $workList_k));
									}
									break;
				                case 'url':
									if (!isset($workList_v['button_URL']) || trim($workList_v['button_URL']) == "" || !filter_var($workList_v['button_URL'], FILTER_VALIDATE_URL)) {
										$e->add(t("The %s field for '%s' does not have a valid URL (%s, row #%s).", t("URL"), t("Button"), t("Work List"), $workList_k));
									}
									break;
				                case 'relative_url':
									if (!isset($workList_v['button_Relative_URL']) || trim($workList_v['button_Relative_URL']) == "") {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("Relative URL"), t("Button"), t("Work List"), $workList_k));
									}
									break;
				                case 'image':
									if (!isset($workList_v['button_Image']) || trim($workList_v['button_Image']) == "" || !is_object(File::getByID($workList_v['button_Image']))) {
										$e->add(t("The %s field for '%s' is required (%s, row #%s).", t("Image"), t("Button"), t("Work List"), $workList_k));
									}
									break;	
							}
						}
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Work List'), $workList_k));
                    }
                }
            }
        } else {
            if ($workListEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Work List"), $workListEntriesMin));
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