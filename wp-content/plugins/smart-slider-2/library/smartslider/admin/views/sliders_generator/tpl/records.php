<?php
$this->loadFragment('headerstart');
?>
    <div class="smartslider-button smartslider-cancel" onclick="window.nextendsave=true;location.href='<?php echo $this->route('controller=sliders&view=sliders_slider&action='.(NextendRequest::getVar('type', '') == 'quick' ? '' : 'generator').'dashboard&sliderid=' . NextendRequest::getInt('sliderid')); ?>';"><?php echo NextendText::_('Cancel'); ?></div>
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
?>

<h2>Generator records</h2>
<div class="smartslider-button-wrap">
    <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container ">
        <a class="smartslider-button-link" href="<?php echo $this->route('controller=sliders&view=sliders_generator&action=generatorrecords&refreshcache=1&sliderid='.NextendRequest::getInt('sliderid')); ?>">
            <span class="smartslider-icon smartslider-action-icon smartslider-action-icon-refresh"></span>
            Refresh cache
        </a>
    </div>
</div>
<div style="clear:both;"></div>
<?php

nextendimportsmartslider2('nextend.smartslider.generator');

$slidersModel = $this->getModel('sliders');
$slider = $slidersModel->getSlider(NextendRequest::getInt('sliderid'));

$smartslidergenerator = (array)json_decode($slider['generator'], true);
$generatorParams = new NextendData();
$generatorParams->loadArray($smartslidergenerator);
if($generatorParams->get('enabled')){
    $source = $generatorParams->get('source', '');
    if ($source) {
        $generator = new NextendSmartsliderGenerator($generatorParams, array(), NextendRequest::getInt('sliderid'));
        $generator->initDatasource($source, true);
        
        $generatorgroup = $generatorParams->get('generatorgroup', 1);
    
        if(!empty($generator->_datasource)){
            for($i = 0, $j = 1; $i < count($generator->_datasource); $j++){
            ?>
<h2>Slide #<?php echo $j; ?></h2>
<table class="ni">
    <?php for($z = 1; $z <= $generatorgroup && $i < count($generator->_datasource); $z++){ ?>
    <?php foreach($generator->_datasource[$i] AS $k => $v){ ?>
    <tr>                                                    
        <td>                             
            <label id="slidertitle-lbl" for="slidertitle">{|<?php echo $k.'-'.$z; ?>|}</label>
        </td>                         
        <td>      
           <?php echo $v; ?>
        </td>                  
    </tr>
    <?php } $i++;} ?>          
</table>
            <?php
        }
        }else{
            ?>
            <div class="box r" style="max-width: 700px;"><h3>There are no record for your generator filter! Go to the generator setttings and check the filter options.</h3><p></p></div>
            <?php
        }
    }else{
        ?>
        <div class="box r" style="max-width: 700px;"><h3>The generator is not configured!</h3><p></p></div>
        <?php
    }
}else{
    ?>
    <div class="box r" style="max-width: 700px;"><h3>The generator is not enabled! First enable it in the Settings.</h3><p></p></div>
    <?php
}

?>

<?php
$this->loadFragment('secondcolend');
?>

<?php
$this->loadFragment('footer');
