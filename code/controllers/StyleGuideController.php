<?php

/**
 * StyleGuideController
 * @package silverstripe
 * @subpackage silverstripe-styleguide
 */
class StyleGuideController extends Page_Controller
{
    private static $title = 'Style Guide';

    private static $show_contents = true;

    /**
     * Defines methods that can be called directly
     * @var array
     */
    private static $allowed_actions = array(
        'index'
    );

    public function index()
    {
        if(Director::isLive() && !Permission::check('CMS_ACCESS_CMSMain')) {
            return Security::permissionFailure($this);
        }

        Requirements::css(STYLEGUIDE_DIR . '/css/styleguide.css');

        return $this->renderWith(array(
            __CLASS__,
            'Page'
        ));
    }

    public function getStyles()
    {
        $config = SiteConfig::current_site_config();
        $theme = $config->Theme;
        if ($theme) {
            Config::inst()->update('SSViewer', 'theme_enabled', true);
            Config::inst()->update('SSViewer', 'theme', $theme);
        }

        $manifest = SS_TemplateLoader::instance()->getManifest();

        $templates = ArrayList::create();

        foreach($manifest->getTemplates() as $templateName => $templateInfo) {
            $themeexists = $theme && isset($templateInfo['themes'][$theme]) && isset($templateInfo['themes'][$theme]['Styles']);

            if ((isset($templateInfo['Styles']) || $themeexists) && !isset($templates[$templateName])) {
                $templates->push(ArrayData::create(array(
                    'Anchor' => $this->Link . '#' . trim($templateName),
                    'AnchorAttr' => 'id="' . trim($templateName) .'"',
                    'Name' => trim(str_replace('_', ' ',$templateName)),
                    'Layout' => $this->renderWith(array($templateName))
                )));
            }
        }

        return $templates;
    }

    public function getShowContents()
    {
        return $this->config()->get('show_contents');
    }

    public function getLink()
    {
        return Controller::join_links('styleguide');
    }

    public function getTitle()
    {
        return $this->config()->get('title');
    }

    public function getMenuTitle()
    {
        return $this->Title;
    }

    public function Word()
    {
        $lorem = new joshtronic\LoremIpsum();
        return $lorem->word();
    }

    public function Words($count = 5)
    {
        $lorem = new joshtronic\LoremIpsum();
        return $lorem->words($count);
    }

    public function Sentence()
    {
        $lorem = new joshtronic\LoremIpsum();
        return $lorem->sentence();
    }

    public function Sentences($count = 5)
    {
        $lorem = new joshtronic\LoremIpsum();
        return $lorem->sentences($count);
    }

    public function Paragraph()
    {
        $lorem = new joshtronic\LoremIpsum();
        return $lorem->paragraph();
    }

    public function Paragraphs($count = 5)
    {
        $lorem = new joshtronic\LoremIpsum();
        return $lorem->paragraphs($count);
    }

    public function Field($type = 'TextField', $attributes = null)
    {
        $uniqid = uniqid();
        $optionFields = array(
            'DropdownField',
            'CheckboxSetField',
            'OptionsetField',
            'ListboxField',
            'LookupField',
            'TagField'
        );
        $name = str_ireplace('Field', '', $type);
        $name = preg_replace('/([A-Z])/', ' $1', $name);
        if (in_array($type, $optionFields)) {
            $options = array();
            for ($i=0; $i < 3; $i++) {
                $options[$i] = $this->Words($i+1);
            }
            $field = $type::create($uniqid, $name, $options);
        } else {
            $field = $type::create($uniqid, $name);
        }
        if ($attributes) {
            if (strpos($attributes, ';') !== FALSE){
                $attributes = explode(';', $attributes);
            } else {
                $attributes = array($attributes);
            }
            foreach ($attributes as $attribute) {
                if (strpos($attribute, ':') !== FALSE){
                    list($attribute, $value) = explode(':', $attribute);
                }
                switch (strtolower($attribute)) {
                    case 'required':
                    case 'require':
                        $field->addExtraClass($attribute);
                        break;
                    case 'title':
                    case 'label':
                        $field->setTitle($value);
                        break;
                    default:
                            $field->setAttribute($attribute, $value);
                        break;
                }
            }
        }
        return Form::create(
            $this,
            $uniqid,
            FieldList::create(array($field)),
            FieldList::create(array())
        );
    }
}
