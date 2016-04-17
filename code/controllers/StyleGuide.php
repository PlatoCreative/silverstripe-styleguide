e<?php

/**
* @package styleguide
*/
class StyleGuide extends Controller
{
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
        if ($config->Theme) {
            Config::inst()->update('SSViewer', 'theme_enabled', true);
            Config::inst()->update('SSViewer', 'theme', $config->Theme);
        }
        $theme = $config->Theme;

        $manifest = SS_TemplateLoader::instance()->getManifest();

        $templates = array();

        // Debug::dump($manifest->getTemplates());
        foreach($manifest->getTemplates() as $templateName => $templateInfo) {
            $themeexists = $theme && isset($templateInfo['themes'][$theme]) && isset($templateInfo['themes'][$theme]['Styles']);

            if ((isset($templateInfo['Styles']) || $themeexists) && !isset($templates[$templateName])) {
                $templates[$templateName] = array(
                    'ID' => trim($templateName),
                    'Name' => trim(str_replace('_', ' ',$templateName)),
                    'Layout' => $this->renderWith(array($templateName))
                );
            }
        }

        // ksort($templates);

        return new ArrayList($templates);
    }
}
