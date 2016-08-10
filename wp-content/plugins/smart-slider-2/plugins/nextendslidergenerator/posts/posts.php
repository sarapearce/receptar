<?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorPosts extends NextendPluginBase {

    var $_group = 'posts';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        if($showall || smartsliderIsFull()){
            $group[$this->_group] = 'Posts';
    
            if (!isset($list[$this->_group])) $list[$this->_group] = array();
            $list[$this->_group][$this->_group . '_posts'] = array('By filter', $this->getPath() . 'posts' . DIRECTORY_SEPARATOR, true, true, true, 'article');
            
            $custom_posts = get_post_types();
            if(isset($custom_posts['post'])) unset($custom_posts['post']);
            if(isset($custom_posts['nav_menu_item'])) unset($custom_posts['nav_menu_item']);
            if(isset($custom_posts['revision'])) unset($custom_posts['revision']);
            if(isset($custom_posts['attachment'])) unset($custom_posts['attachment']);
            foreach($custom_posts AS $cp){
                $list[$this->_group][$this->_group . '_customposts__' . $cp] = array('Custom - '.ucfirst($cp), $this->getPath() . 'customposts' . DIRECTORY_SEPARATOR, true, true, true, 'article');
                if(smartsliderIsFull() && !class_exists('NextendGeneratorPosts_Customposts__'. $cp)){
                    require_once($this->getPath() . 'customposts' . DIRECTORY_SEPARATOR . 'generator.php');
                    eval('class NextendGeneratorPosts_Customposts__'. $cp . ' extends NextendGeneratorPosts_Customposts{}');
                }
            }
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorPosts');