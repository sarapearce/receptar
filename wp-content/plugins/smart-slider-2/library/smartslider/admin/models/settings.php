<?php

nextendimportsmartslider2('nextend.smartslider.admin.models.base');

class NextendSmartsliderAdminModelSettings extends NextendSmartsliderAdminModelBase {

    function form($xml) {
    
        $data = array();
        switch ($xml) {
            case 'layout':
                $data = NextendSmartSliderLayoutSettings::getAll();
                break;
            case 'font':
                $data = NextendSmartSliderFontSettings::getAll(NextendRequest::getInt('sliderid'));
                break;
            case 'joomla':
                $data = NextendSmartSliderJoomlaSettings::getAll();
                break;
            default:
                $data = NextendSmartSliderSettings::getAll();
                break;
        }
        
        $this->render(dirname(__FILE__) . '/forms/settings/' . $xml . '.xml', $data);
    }
    
    function render($xmlpath, $data){

        $css = NextendCss::getInstance();
        $js = NextendJavascript::getInstance();

        $css->addCssLibraryFile('common.css');
        $css->addCssLibraryFile('window.css');
        $css->addCssLibraryFile('configurator.css');

        $js->loadLibrary('dojo');

        nextendimport('nextend.form.form');
        $form = new NextendForm();

        $form->loadArray($data);

        $form->loadXMLFile($xmlpath);
        echo $form->render('settings');
    
        $js->addLibraryJsAssetsFile('dojo', 'form.js');
        $js->addLibraryJs('dojo', '
            new NextendForm({
              container: "smartslider-form",
              data: ' . json_encode($form->_data) . ',
              xml: "' . NextendFilesystem::toLinux(NextendFilesystem::pathToRelativePath($xmlpath)) . '",
              control_name: "settings",
              url: "'.NextendUri::ajaxUri('nextend', 'smartslider').'",
              loadedJSS: ' . json_encode($js->generateArrayJs()) . ',
              loadedCSS: ' . json_encode($css->generateArrayCSS()) . '
            });
        ', true);
    }

    function save() {
        $namespace = NextendRequest::getCmd('namespace', 'default');
        if (isset($_REQUEST['namespace']) && isset($_REQUEST['settings'])) {
            if ($namespace == 'default')
                $namespace = 'settings';
            if($namespace == 'font' && NextendRequest::getInt('sliderid')){
                $namespace.= NextendRequest::getInt('sliderid');
                self::markChanged(NextendRequest::getInt('sliderid'));
            }
            if ($namespace == 'joomla'){
                $license = empty($_REQUEST['settings']['license']) ? '': $_REQUEST['settings']['license'];
            		$db = NextendDatabase::getInstance();
                $db->setQuery("SELECT b.update_site_id FROM #__extensions AS a LEFT JOIN #__update_sites_extensions AS b ON a.extension_id = b.extension_id WHERE a.element = 'com_smartslider2' ");
                $updates = $db->loadAssocList();
                if(count($updates)){
                    $id = $updates[0]['update_site_id'];
                    unset($updates[0]);
                    if(count($updates)){
                        foreach($updates AS $u){
                            $db->setQuery('DELETE FROM #__update_sites WHERE update_site_id = '.$u['update_site_id']);
                            $db->query();
                            $db->setQuery('DELETE FROM #__update_sites_extensions WHERE update_site_id = '.$u['update_site_id']);
                            $db->query();
                        }
                    }
                    $db->setQuery('UPDATE #__update_sites SET location = '.$db->quote('http://www.nextendweb.com/update2/joomla/update.php?license='.urlencode($license).'&fake=extension.xml').' WHERE update_site_id = '.$id);
                    $db->query();
                }
            }
            NextendSmartSliderStorage::set($namespace, json_encode($_REQUEST['settings']));
        }
    }

    function loadglobalfonts($sliderid) {
        $this->clearfonts($sliderid);
        if($sliderid) NextendSmartSliderStorage::set('font'.$sliderid, NextendSmartSliderStorage::get('font'));
        return true;
    }

    function clearfonts($sliderid) {
        if($sliderid) NextendSmartSliderStorage::delete('font'.$sliderid);
        return true;
    }

}