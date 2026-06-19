<?php namespace Application\Block\ContactInfo;

defined("C5_EXECUTE") or die("Access Denied.");

use AssetList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use Database;

class Controller extends BlockController
{
    public $btFieldsRequired = ['contactItems' => []];
    protected $btExportTables = ['btContactInfo', 'btContactInfoContactItemsEntries'];
    protected $btTable = 'btContactInfo';
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
        return t("Contact Info");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $content[] = $this->intro;
        $db = Database::connection();
        $contactItems_items = $db->fetchAll('SELECT * FROM btContactInfoContactItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($contactItems_items as $contactItems_item_k => $contactItems_item_v) {
            if (isset($contactItems_item_v["label"]) && trim($contactItems_item_v["label"]) != "") {
                $content[] = $contactItems_item_v["label"];
            }
            if (isset($contactItems_item_v["value"]) && trim($contactItems_item_v["value"]) != "") {
                $content[] = $contactItems_item_v["value"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $this->set('intro', LinkAbstractor::translateFrom($this->intro));
        $contactItems = [];
        $contactItems_items = $db->fetchAll('SELECT * FROM btContactInfoContactItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($contactItems_items as $contactItems_item_k => &$contactItems_item_v) {
            $contactItems_item_v["value"] = isset($contactItems_item_v["value"]) ? LinkAbstractor::translateFrom($contactItems_item_v["value"]) : null;
        }
        $this->set('contactItems_items', $contactItems_items);
        $this->set('contactItems', $contactItems);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btContactInfoContactItemsEntries', ['bID' => $this->bID]);
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $contactItems_items = $db->fetchAll('SELECT * FROM btContactInfoContactItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($contactItems_items as $contactItems_item) {
            unset($contactItems_item['id']);
            $contactItems_item['bID'] = $newBID;
            $db->insert('btContactInfoContactItemsEntries', $contactItems_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $contactItems = $this->get('contactItems');
        $this->set('contactItems_items', []);
        $this->set('contactItems', $contactItems);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        
        $this->set('intro', LinkAbstractor::translateFromEditMode($this->intro));
        $contactItems = $this->get('contactItems');
        $contactItems_items = $db->fetchAll('SELECT * FROM btContactInfoContactItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        
        foreach ($contactItems_items as &$contactItems_item) {
            $contactItems_item['value'] = isset($contactItems_item['value']) ? LinkAbstractor::translateFromEditMode($contactItems_item['value']) : null;
        }
        $this->set('contactItems', $contactItems);
        $this->set('contactItems_items', $contactItems_items);
    }

    protected function addEdit()
    {
        $contactItems = [];
        $this->set('contactItems', $contactItems);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/contact_info/css_form/repeatable-ft.form.css', [], $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/contact_info/js_form/handlebars-v4.0.4.js', [], $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/contact_info/js_form/handlebars-helpers.js', [], $this->pkg);
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
        $args['intro'] = LinkAbstractor::translateTo($args['intro']);
        $rows = $db->fetchAll('SELECT * FROM btContactInfoContactItemsEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $contactItems_items = isset($args['contactItems']) && is_array($args['contactItems']) ? $args['contactItems'] : [];
        $queries = [];
        if (!empty($contactItems_items)) {
            $i = 0;
            foreach ($contactItems_items as $contactItems_item) {
                $data = [
                    'sortOrder' => $i + 1,
                ];
                if (isset($contactItems_item['label']) && trim($contactItems_item['label']) != '') {
                    $data['label'] = trim($contactItems_item['label']);
                } else {
                    $data['label'] = null;
                }
                $data['value'] = isset($contactItems_item['value']) ? LinkAbstractor::translateTo($contactItems_item['value']) : null;
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
                                $db->update('btContactInfoContactItemsEntries', $data, ['id' => $id]);
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btContactInfoContactItemsEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btContactInfoContactItemsEntries', ['id' => $value]);
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
        if (in_array("intro", $this->btFieldsRequired) && (trim($args["intro"]) == "")) {
            $e->add(t("The %s field is required.", t("Intro Text")));
        }
        $contactItemsEntriesMin = 0;
        $contactItemsEntriesMax = 0;
        $contactItemsEntriesErrors = 0;
        $contactItems = [];
        if (isset($args['contactItems']) && is_array($args['contactItems']) && !empty($args['contactItems'])) {
            if ($contactItemsEntriesMin >= 1 && count($args['contactItems']) < $contactItemsEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Contact Items"), $contactItemsEntriesMin, count($args['contactItems'])));
                $contactItemsEntriesErrors++;
            }
            if ($contactItemsEntriesMax >= 1 && count($args['contactItems']) > $contactItemsEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Contact Items"), $contactItemsEntriesMax, count($args['contactItems'])));
                $contactItemsEntriesErrors++;
            }
            if ($contactItemsEntriesErrors == 0) {
                foreach ($args['contactItems'] as $contactItems_k => $contactItems_v) {
                    if (is_array($contactItems_v)) {
                        if (in_array("label", $this->btFieldsRequired['contactItems']) && (!isset($contactItems_v['label']) || trim($contactItems_v['label']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Label"), t("Contact Items"), $contactItems_k));
                        }
                        if (in_array("value", $this->btFieldsRequired['contactItems']) && (!isset($contactItems_v['value']) || trim($contactItems_v['value']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Value"), t("Contact Items"), $contactItems_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Contact Items'), $contactItems_k));
                    }
                }
            }
        } else {
            if ($contactItemsEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Contact Items"), $contactItemsEntriesMin));
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