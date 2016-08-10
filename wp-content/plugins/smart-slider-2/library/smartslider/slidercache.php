<?php

class NextendSliderCache {

    var $slider = null;

    function NextendSliderCache($slider) {
        nextendimportsmartslider2('nextend.smartslider.check');
        nextendimport('nextend.css.css');
        nextendimport('nextend.javascript.javascript');
        nextendimport('nextend.fonts.google');

        $this->slider = $slider;

        $sliderid = $slider->_sliderid;

        $recache = false;
        $cached = json_decode(NextendSmartSliderStorage::get('slidercache' . $sliderid), true);
        
      	if(nextendIsWordpress()){		    		    
      		  $time = current_time( 'timestamp');
      	}else{
      		  $time = time();
      	}
        
        nextendimportsmartslider2('nextend.smartslider.admin.models.slides');
        $slidesModel = new NextendSmartsliderAdminModelSlides(null);
        $slides = $slidesModel->getSlides($sliderid, '');
        
        $slideexpire = null;
        foreach($slides AS $s){
            $publish_up = strtotime($s['publish_up']);
            if($publish_up && $publish_up > $time && ($slideexpire == null || $publish_up < $slideexpire)){
                $slideexpire = $publish_up;
            }
            
            $publish_down = strtotime($s['publish_down']);
            if($publish_down && $publish_down > $time && ($slideexpire == null || $publish_down < $slideexpire)){
                $slideexpire = $publish_down;
            }
        }

        if (is_array($cached)) {
            if (NextendSmartSliderStorage::get('sliderchanged' . $sliderid) == 1) {
                $recache = true;
            } else if (isset($cached['time']) && isset($cached['expire']) && $cached['time'] < time() - $cached['expire'] * 60 * 60) {
                $recache = true;
            } else if (isset($cached['slideexpire']) && $cached['slideexpire'] < $time) {
                $recache = true;
            }
        } else {
            $recache = true;
        }

        if (!$recache) {
            $data = $cached['data'];
            if (isset($data['css'])) {
                if (!NextendFilesystem::fileexists(NextendFilesystem::absoluteURLToPath($data['css']))) {
                    $recache = true;
                }
            } else {
                $recache = true;
            }

            if (!isset($data['libraries']) || !isset($data['libraries']['jquery']) || !isset($data['libraries']['jquery']['jsfiles']) || count($data['libraries']['jquery']['jsfiles']) == 0) {
                $recache = true;
            }
        }

        //$recache = true;
        if ($recache) {
            $data = $this->render();
            if($this->slider->_norender) return;
            $cached = array(
                'time' => time(),
                'data' => $data
            );
            
            if ($this->slider->_generatorParams->get('enabled', 0)) {
                $generatorcached = json_decode(NextendSmartSliderStorage::get('generator' . $sliderid), true);
                if (is_array($generatorcached)) {
                    $cached['time'] = $generatorcached['time'];
                    $cached['expire'] = $this->slider->_generatorParams->get('cachetime', '24');
                }
            }
            
            if($slideexpire){
                $cached['slideexpire'] = $slideexpire;
            }

            NextendSmartSliderStorage::set('slidercache' . $sliderid, json_encode($cached));
            NextendSmartSliderStorage::set('sliderchanged' . $sliderid, '0');
        }

        $this->cssurl = $data['css'];
        if (nextendIsWordPress()) {
            add_action('nextend_css', array($this, 'addCSS'));
        } elseif (nextendIsMagento()) {
            Nextend_SmartSlider2_Model_Observer::$sliders[] = array($this, 'addCSS');
        } else {
            $this->addCSS();
        }

        $js = NextendJavascript::getInstance();
        foreach ($data['js']['core'] AS $j) {
            $js->addJsFile($j);
        }
        if (isset($data['libraries']) && count($data['libraries'])) {
            foreach ($data['libraries'] AS $library => $jss) {
                $js->loadLibrary($library);
                if (!empty($jss['js']))
                    $js->addLibraryJs($library, $jss['js']);
                if (count($jss['jsfiles'])) {
                    foreach ($jss['jsfiles'] AS $j) {
                        $js->addLibraryJsFile($library, $j);
                    }
                }
            }
        }

        if (isset($data['fonts']) && count($data['fonts'])) {
            $google = NextendFontsGoogle::getInstance();
            foreach ($data['fonts'] AS $k => $v) {
                $style = explode(',', $v[0]);
                $subset = explode(',', $v[1]);
                for ($i = 0; $i < count($style); $i++) {
                    if(!isset($subset[$i])){
                        $subset[$i] = 400;
                    }
                    $google->addFont($k, $style[$i], $subset[$i]);
                }
            }
        }
        
        $slider = $data['html'];
        if(nextendIsJoomla()){
            if(version_compare(JVERSION, '1.6.0', 'ge')){
                $dispatcher = JDispatcher::getInstance();
      			    JPluginHelper::importPlugin('content');
                $article = new stdClass();
                $article->text = $slider;
                $_p = array();
                $dispatcher->trigger('onContentPrepare', array('com_smartslider2', &$article, &$_p, 0));
                if(!empty($article->text)) $slider = $article->text;
            }
        }elseif(nextendIsWordPress()){
            if(!function_exists('ss2_attr_shortcode')){
                function ss2_attr_shortcode($matches){
                    return 'data-'.$matches[1].'="'.str_replace('"', '&quot;',do_shortcode(str_replace('&quot;','"',$matches[2]))).'"';
                }
            }
            $slider = preg_replace_callback("/data-(click|enter|leave)=\"(.*?)\"/", "ss2_attr_shortcode", $slider);
            $slider = do_shortcode($slider);
        }

        echo $slider;
    }

    function render() {
        $data = array(
            'css' => '',
            'js' => array(),
            'fonts' => array(),
            'html' => ''
        );

        $this->css = $css = NextendCss::getInstance();
        $tmpCSScacheTime = $css->_cache->_cacheTime;
        $css->_cache->_cacheTime = 'static';
        $cssFiles = $css->_cssFiles;
        $css->_cssFiles = array();

        $js = NextendJavascript::getInstance();
        $jsFiles = array();
        $jsFiles['core'] = $js->_jsFiles;
        $js->_jsFiles = array();
        $jsFiles['libraries'] = array();
        foreach ($js->_loadedLibraries AS $k => $v) {
            $jsFiles['libraries'][$k] = array();
            $jsFiles['libraries'][$k]['jsfiles'] = $v->_jsFiles;
            $jsFiles['libraries'][$k]['js'] = $v->_js;

            $js->_loadedLibraries[$k]->_jsFiles = array();
            $js->_loadedLibraries[$k]->_js = '';
        }

        $google = NextendFontsGoogle::getInstance();
        $fonts = $google->_fonts;
        $google->_fonts = array();

        ob_start();
        $this->slider->render(true);
        $this->id = $this->slider->getId();
        $data['html'] = preg_replace_callback('/<style.*?>(.*?)<\/style>/s', array($this, 'inlineCSS'), ob_get_clean());
        
        if($this->slider->_norender){
            $google->_fonts = $fonts;
            $css->_cssFiles = $cssFiles;
            $js->_jsFiles = $jsFiles['core'];
            
            foreach ($jsFiles['libraries'] AS $k => $v) {
                $js->_loadedLibraries[$k]->_jsFiles = $v['jsfiles'];
                $js->_loadedLibraries[$k]->_js = $v['js'];
            }
            return false;
        }

        $data['fonts'] = $google->_fonts;
        $google->_fonts = $fonts;


        $extracssfiles = $css->_cssFiles;
        $css->_cssFiles = $cssFiles;

        foreach ($extracssfiles AS $f) {
            $css->addCssFile($f, $this->id);
        }

        $css->_cacheGroup[$this->id]->_cacheTime = 'static';

        $data['css'] = $css->generateCSS($this->id, false);

        $css->_cache->_cacheTime = $tmpCSScacheTime;

        $data['js']['core'] = $js->_jsFiles;
        $js->_jsFiles = $jsFiles['core'];

        foreach ($js->_loadedLibraries AS $k => $v) {

            $data['libraries'][$k]['jsfiles'] = $v->_jsFiles;
            $data['libraries'][$k]['js'] = $v->_js;

            if (isset($jsFiles['libraries'][$k])) {
                $js->_loadedLibraries[$k]->_jsFiles = $jsFiles['libraries'][$k]['jsfiles'];
                $js->_loadedLibraries[$k]->_js = $jsFiles['libraries'][$k]['js'];
            }
        }

        return $data;
    }

    function addCSS() {
        $css = NextendCss::getInstance();
        $css->serveCSSFile($this->cssurl);
    }

    function inlineCSS($matches) {
        $this->css->addCssFile($matches[1], $this->id);
        return '';
    }

}
