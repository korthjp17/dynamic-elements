<?php

namespace Dynamic\Elements\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Dynamic\Elements\Model\FeatureObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class PageSectionBlock
 *
 * @method HasManyList $Features
 */
class ElementFeatures extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'vendor/dnadesign/silverstripe-elemental/images/base.svg';

    /**
     * @return string
     */
    private static $singular_name = 'Features Element';

    /**
     * @return string
     */
    private static $plural_name = 'Features Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementFeatures';

    /**
     * @var array
     */
    private static $db = [
        'Content' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $has_many = [
        'Features' => FeatureObject::class,
    ];

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setRows(8);

            if ($this->ID) {
                // Features
                $features = $fields->dataFieldByName('Features');
                $config = $features->getConfig();
                $config->addComponent(new GridFieldOrderableRows());
                $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                $config->removeComponentsByType(GridFieldDeleteAction::class);
                $config->addComponent(new GridFieldDeleteAction(false));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getFeaturesList()
    {
        return $this->Features()->sort('Sort');
    }

    /**
     * @return HTMLText
     */
    public function ElementSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Features');
    }
}
