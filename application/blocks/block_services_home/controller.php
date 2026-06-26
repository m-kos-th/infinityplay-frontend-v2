<?php namespace Application\Block\BlockServicesHome;

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
    public $btFieldsRequired = ['servicesList' => []];
    protected $btExportFileColumns = ['imagePreview', 'videoPreview'];
    protected $btExportTables = ['btBlockServicesHome', 'btBlockServicesHomeServicesListEntries'];
    protected $btTable = 'btBlockServicesHome';
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
        return t("Block Services Home");
    }

    public function getSearchableContent()
    {
        $content = [];
        $db = Database::connection();
        $servicesList_items = $db->fetchAll('SELECT * FROM btBlockServicesHomeServicesListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($servicesList_items as $servicesList_item_k => $servicesList_item_v) {
            if (isset($servicesList_item_v["title"]) && trim($servicesList_item_v["title"]) != "") {
                $content[] = $servicesList_item_v["title"];
            }
            if (isset($servicesList_item_v["content"]) && trim($servicesList_item_v["content"]) != "") {
                $content[] = $servicesList_item_v["content"];
            }
            if (isset($servicesList_item_v["supportBy"]) && trim($servicesList_item_v["supportBy"]) != "") {
                $content[] = $servicesList_item_v["supportBy"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $servicesList = [];
        $servicesList_items = $db->fetchAll('SELECT * FROM btBlockServicesHomeServicesListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($servicesList_items as $servicesList_item_k => &$servicesList_item_v) {
            if (isset($servicesList_item_v['imagePreview']) && trim($servicesList_item_v['imagePreview']) != "" && ($f = File::getByID($servicesList_item_v['imagePreview'])) && is_object($f)) {
                $servicesList_item_v['imagePreview'] = $f;
            } else {
                $servicesList_item_v['imagePreview'] = false;
            }
            $servicesList_item_v["videoPreview_id"] = isset($servicesList_item_v["videoPreview"]) && trim($servicesList_item_v["videoPreview"]) != "" ? (int)$servicesList_item_v["videoPreview"] : false;
            $servicesList_item_v["videoPreview"] = false;
            if ($servicesList_item_v["videoPreview_id"] > 0 && ($servicesList_item_v["videoPreview_file"] = File::getByID($servicesList_item_v["videoPreview_id"])) && is_object($servicesList_item_v["videoPreview_file"])) {
                $fp = new Permissions($servicesList_item_v["videoPreview_file"]);
                if ($fp->canViewFile()) {
                    $urls = ['relative' => $servicesList_item_v["videoPreview_file"]->getRelativePath()];
                    $urls['download'] = URL::to('/download_file', '/force', $servicesList_item_v["videoPreview_file"]->hasFileUUID() ? $servicesList_item_v["videoPreview_file"]->getFileUUID() : $servicesList_item_v["videoPreview_file"]->getFileID());
                    $servicesList_item_v["videoPreview_file"]->urls = $urls;
                    $servicesList_item_v["videoPreview"] = $servicesList_item_v["videoPreview_file"];
                }
            }
            $servicesList_item_v["content"] = isset($servicesList_item_v["content"]) ? LinkAbstractor::translateFrom($servicesList_item_v["content"]) : null;
            $servicesList_item_v["supportBy"] = isset($servicesList_item_v["supportBy"]) ? LinkAbstractor::translateFrom($servicesList_item_v["supportBy"]) : null;
        }
        $this->set('servicesList_items', $servicesList_items);
        $this->set('servicesList', $servicesList);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btBlockServicesHomeServicesListEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $servicesList_items = $db->fetchAll('SELECT * FROM btBlockServicesHomeServicesListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($servicesList_items as $servicesList_item) {
            unset($servicesList_item['id']);
            $servicesList_item['bID'] = $newBID;
            $db->insert('btBlockServicesHomeServicesListEntries', $servicesList_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $servicesList = $this->get('servicesList');
        $this->set('servicesList_items', []);
        $this->set('servicesList', $servicesList);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $servicesList = $this->get('servicesList');
        $servicesList_items = $db->fetchAll('SELECT * FROM btBlockServicesHomeServicesListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($servicesList_items as &$servicesList_item) {
            if (!File::getByID($servicesList_item['imagePreview'])) {
                unset($servicesList_item['imagePreview']);
            }
        }
        foreach ($servicesList_items as &$servicesList_item) {
            if (!File::getByID($servicesList_item['videoPreview'])) {
                unset($servicesList_item['videoPreview']);
            }
        }
        
        foreach ($servicesList_items as &$servicesList_item) {
            $servicesList_item['content'] = isset($servicesList_item['content']) ? LinkAbstractor::translateFromEditMode($servicesList_item['content']) : null;
        }
        
        foreach ($servicesList_items as &$servicesList_item) {
            $servicesList_item['supportBy'] = isset($servicesList_item['supportBy']) ? LinkAbstractor::translateFromEditMode($servicesList_item['supportBy']) : null;
        }
        $this->set('servicesList', $servicesList);
        $this->set('servicesList_items', $servicesList_items);
    }

    protected function addEdit()
    {
        $servicesList = [];
        $this->set('servicesList', $servicesList);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/block_services_home/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/block_services_home/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/block_services_home/js_form/handlebars-helpers.js', [], $this->pkg);
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
        $rows = $db->fetchAll('SELECT * FROM btBlockServicesHomeServicesListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $servicesList_items = isset($args['servicesList']) && is_array($args['servicesList']) ? $args['servicesList'] : [];
        $queries = [];
        if (!empty($servicesList_items)) {
            $i = 0;
            foreach ($servicesList_items as $servicesList_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($servicesList_item['title']) && trim($servicesList_item['title']) != '') {
                    $data['title'] = trim($servicesList_item['title']);
                } else {
                    $data['title'] = null;
                }
                if (isset($servicesList_item['imagePreview']) && trim($servicesList_item['imagePreview']) != '') {
                    $data['imagePreview'] = trim($servicesList_item['imagePreview']);
                } else {
                    $data['imagePreview'] = null;
                }
                if (isset($servicesList_item['videoPreview']) && trim($servicesList_item['videoPreview']) != '') {
                    $data['videoPreview'] = trim($servicesList_item['videoPreview']);
                } else {
                    $data['videoPreview'] = null;
                }
                $data['content'] = isset($servicesList_item['content']) ? LinkAbstractor::translateTo($servicesList_item['content']) : null;
                $data['supportBy'] = isset($servicesList_item['supportBy']) ? LinkAbstractor::translateTo($servicesList_item['supportBy']) : null;
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
                                $db->update('btBlockServicesHomeServicesListEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btBlockServicesHomeServicesListEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btBlockServicesHomeServicesListEntries', ['id' => $value]);
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
        $servicesListEntriesMin = 0;
        $servicesListEntriesMax = 0;
        $servicesListEntriesErrors = 0;
        $servicesList = [];
        if (isset($args['servicesList']) && is_array($args['servicesList']) && !empty($args['servicesList'])) {
            if ($servicesListEntriesMin >= 1 && count($args['servicesList']) < $servicesListEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Services List"), $servicesListEntriesMin, count($args['servicesList'])));
                $servicesListEntriesErrors++;
            }
            if ($servicesListEntriesMax >= 1 && count($args['servicesList']) > $servicesListEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Services List"), $servicesListEntriesMax, count($args['servicesList'])));
                $servicesListEntriesErrors++;
            }
            if ($servicesListEntriesErrors == 0) {
                foreach ($args['servicesList'] as $servicesList_k => $servicesList_v) {
                    if (is_array($servicesList_v)) {
                        if (in_array("title", $this->btFieldsRequired['servicesList']) && (!isset($servicesList_v['title']) || trim($servicesList_v['title']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Title"), t("Services List"), $servicesList_k));
                        }
                        if (in_array("imagePreview", $this->btFieldsRequired['servicesList']) && (!isset($servicesList_v['imagePreview']) || trim($servicesList_v['imagePreview']) == "" || !is_object(File::getByID($servicesList_v['imagePreview'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image Preview"), t("Services List"), $servicesList_k));
                        }
                        if (in_array("videoPreview", $this->btFieldsRequired['servicesList']) && (!isset($servicesList_v['videoPreview']) || trim($servicesList_v['videoPreview']) == "" || !is_object(File::getByID($servicesList_v['videoPreview'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Video Preiview"), t("Services List"), $servicesList_k));
                        }
                        if (in_array("content", $this->btFieldsRequired['servicesList']) && (!isset($servicesList_v['content']) || trim($servicesList_v['content']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Content"), t("Services List"), $servicesList_k));
                        }
                        if (in_array("supportBy", $this->btFieldsRequired['servicesList']) && (!isset($servicesList_v['supportBy']) || trim($servicesList_v['supportBy']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Supported by (Optional)"), t("Services List"), $servicesList_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Services List'), $servicesList_k));
                    }
                }
            }
        } else {
            if ($servicesListEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Services List"), $servicesListEntriesMin));
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
}