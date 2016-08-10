<?php
$this->loadFragment('headerstart');
?>
<div class="smartslider-button smartslider-save" onclick="setTimeout(function(){njQuery('#smartslider-form').submit();}, 300);"><?php echo NextendText::_('Save'); ?></div>
<div class="smartslider-button smartslider-cancel" onclick="window.nextendsave=true;location.href='<?php echo $this->route('controller=sliders'); ?>';"><?php echo NextendText::_('Cancel'); ?></div>
<?php
$this->loadFragment('headerend');
?>
<?php
$this->loadFragment('firstcolstart');
?>
<?php
$this->loadFragment('firstcolend');
?>
<?php
$this->loadFragment('secondcolstart');
$css = NextendCss::getInstance();
$css->addCssLibraryFile('form.css');
?>
<h2><?php echo NextendText::_('Translate urls'); ?></h2>
<div style="width: 50%" class="box y"><h3>Important notice</h3><p>Before you use this tool, make sure that you have already made a backup of your database in case of loss.</p></div>

<div style="width: 50%" class="box"><h3>Proper usage examples</h3><p>
    This tool does an usual search and replace. Searches the "From" in the sliders/slides and replace that text with the "To" value.
</p>
<style>
.translateurl td{
    padding: 5px 10px;
}
</style>
<table class="translateurl">
    <tr>
        <th>From</th>
        <th>To</th>
    </tr>
    <tr>
        <td>http://sandbox.test.com/</td>
        <td>http://test.com/</td>
    </tr>
    <tr>
        <td>http://sandbox.test.com/</td>
        <td>http://www.test.com/</td>
    </tr>
    <tr>
        <td>http://test.com/development/path/anything/</td>
        <td>http://test.com/</td>
    </tr>
    <tr>
        <td>http://test.com/development/path/anything/</td>
        <td>http://test.com/newpath/</td>
    </tr>
    <tr>
        <td>http://test.com/</td>
        <td>https://test.com/</td>
    </tr>
    <tr>
        <td>old/relative/path/</td>
        <td>new/path/</td>
    </tr>
    <tr>
        <td>http://test.com/</td>
        <td>/</td>
    </tr>
</table></div>
<?php

global $replaced, $from, $to;
    
$slidersModel = $this->getModel('sliders');
    
if(NextendRequest::getInt('save')){
    $translateurl = NextendRequest::getVar('translateurl');
    if(isset($translateurl['translateurl'])){
        $translateurl = NextendParse::parse($translateurl['translateurl']);
        if(isset($translateurl[0]) && $translateurl[0] != '') $from = $translateurl[0]; 
        if(isset($translateurl[1]) && $translateurl[1] != '') $to = $translateurl[1]; 
    }
    $replaced = 0;
    
    function nextend_translate_url($data){
        global $replaced, $from, $to;
        $str = str_replace($from, $to, $data, $count);
        $replaced+=$count;
        return $str;
    }
    
    function nextend_translate_url_in_array($array){
        foreach($array AS $k => $v){
            $array[$k] = nextend_translate_url($v);
        }
        return $array;
    }
    
    // returns as array
    function nextend_translate_url_in_json($json){
        return nextend_translate_url_in_array(json_decode($json, true));
    }
    
    function nextend_translate_items($matches){
            $itemdata = json_decode(base64_decode($matches[2]), true);
            return '['.$matches[1].' values="'.base64_encode(json_encode(nextend_translate_url_in_array($itemdata))).'"]';
    }
    $slidesModel = $this->getModel('slides');
    $sliders = $slidersModel->getSliders();
    foreach($sliders AS $sl){
        $sliderid = $sl['id'];
        unset($sl['id']);
        unset($sl['generator']);
        unset($sl['slide']);
        $sl += nextend_translate_url_in_json($sl['params']);
        unset($sl['params']);
        $slidersModel->save($sliderid, $sl);
        
        $slides = $slidesModel->getSlides($sliderid);
        foreach($slides AS $s){
            foreach($s AS $k => $prop){
                if($k == 'params'){
                    $s['params'] = nextend_translate_url_in_json($s['params']);
                }elseif($k == 'slide'){
                    $s[$k] = preg_replace_callback("/\[([a-zA-Z]+) values=\"(.*?)\"]/", 'nextend_translate_items', $s[$k]);
                }else{
                    $s[$k] = nextend_translate_url($s[$k]);
                }
            }
            $slidesModel->save($s['id'], $s, false);
        }
    }
}
?>
<?php if($replaced !== null): ?>
    <div style="width: 50%" class="box g"><h3>Url translation ready</h3><p><?php echo $replaced?> match found!</p></div>
<?php endif; ?>
<form id="smartslider-form" action="" method="post">
    <?php 
        $slidersModel->renderTranslateUrlForm();
    ?>
    <input name="save" value="1" type="hidden" />
</form>

<?php
$this->loadFragment('secondcolend');
?>
<?php
$this->loadFragment('footer');
