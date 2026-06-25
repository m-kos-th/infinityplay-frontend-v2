<?php namespace Application\Block\BlockContentSection;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btTable = 'btBlockContentSection';
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
        return t("Block Content Section");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $content[] = $this->mainTitle;
        $content[] = $this->description_1;
        return implode(" ", $content);
    }

    public function view()
    {
        $this->set('mainTitle', LinkAbstractor::translateFrom($this->mainTitle));
        $this->set('description_1', LinkAbstractor::translateFrom($this->description_1));
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('mainTitle', LinkAbstractor::translateFromEditMode($this->mainTitle));
        
        $this->set('description_1', LinkAbstractor::translateFromEditMode($this->description_1));
    }

    protected function addEdit()
    {
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $args['mainTitle'] = LinkAbstractor::translateTo($args['mainTitle']);
        $args['description_1'] = LinkAbstractor::translateTo($args['description_1']);
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("mainTitle", $this->btFieldsRequired) && (trim($args["mainTitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Main Title")));
        }
        if (in_array("description_1", $this->btFieldsRequired) && (trim($args["description_1"]) == "")) {
            $e->add(t("The %s field is required.", t("Description")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}