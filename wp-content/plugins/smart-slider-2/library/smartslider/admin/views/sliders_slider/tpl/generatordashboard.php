<?php

$this->loadFragment('headerstart');
?>

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

<?php
$accessModuleCreate = $this->canDo('core.create', 'com_modules');
$accessSliderCreate = $this->canDo('slider.create');
$accessSliderEdit = $this->canDo('slider.edit');
$accessSliderDelete = $this->canDo('slider.delete');
$accessSlideCreate = $this->canDo('slide.create');
$accessSlideEdit = $this->canDo('slide.edit');
$accessSlideDelete = $this->canDo('slide.delete');
$accessCore = $this->canDo('core.admin');
$j15 = !nextendIsJoomla() || version_compare(JVERSION, '1.6.0', 'ge') ? false : true;

$sliderid = NextendRequest::getInt('sliderid', 0);
$slidersModel = $this->getModel('sliders');
$slider = $slidersModel->getSlider($sliderid);
$generatorParams = new NextendData();
$generatorParams->loadJSON($slider['generator']);
?>
    
<h2>Generator</h2>
<div class="smartslider-button-wrap">
    <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container">
        <a href="<?php echo $this->route('controller=sliders&view=sliders_generator&action=generatorstart&sliderid=' . $sliderid); ?>" class="smartslider-button-link"><span class="smartslider-icon smartslider-action-icon smartslider-action-icon-generator"></span><?php echo NextendText::_('Change_source'); ?></a>
    </div>
    <?php 
    if(!$j15 && $accessSliderEdit && $generatorParams->get('enabled', null) !== null):
    ?>
        <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container">
            <a href="<?php echo $this->route('controller=sliders&view=sliders_generator&action=generatorsettings&sliderid=' . $sliderid); ?>" class="smartslider-button-link"><span class="smartslider-icon smartslider-action-icon smartslider-action-icon-generator-settings"></span><?php echo NextendText::_('Settings'); ?></a>
        </div>
        <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container">
            <a href="<?php echo $this->route('controller=sliders&view=sliders_generator&action=generatoredit&sliderid=' . $sliderid); ?>" class="smartslider-button-link"><span class="smartslider-icon smartslider-action-icon smartslider-action-icon-generator-edit-layout"></span><?php echo NextendText::_('Edit_layout'); ?></a>
        </div>
        
        <?php if ($generatorParams->get('enabled', 0)): ?>
        <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container">
            <a href="<?php echo $this->route('controller=sliders&view=sliders_slider&action=changedynamiclayout&sliderid=' . $sliderid); ?>" class="smartslider-button-link"><span class="smartslider-icon smartslider-action-icon smartslider-action-icon-generator-layout"></span><?php echo NextendText::_('Change_layout'); ?></a>
        </div>
        <?php endif; ?>
        
        <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container">
            <a href="<?php echo $this->route('controller=sliders&view=sliders_generator&action=generatorrecords&sliderid=' . $sliderid); ?>" class="smartslider-button-link"><span class="smartslider-icon smartslider-action-icon smartslider-action-icon-generator-settings"></span><?php echo NextendText::_('Record viewer'); ?></a>
        </div>
    <?php endif; ?>
</div>
<div style="clear: both;"></div>

<h2>Documentation</h2>
<style>
.ni .doc {
    background-color: #EEF3F8;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 10px 20px 20px;
}
</style>
<div class="doc">
    <h3>Change source</h3>
    <p>You can choose/change the integration where the datas come from to generate slides.</p>
    <br />
    <h3>Settings</h3>
    <p>You can control the generator common configuration and also the source specific settings.</p>
    <br />
    <h3>Edit layout</h3>
    <p>The final generated slides look like the same. Each slide depends on a layout which can be edited in this special slide editor.</p>
    <br />
    <h3>Change layout</h3>
    <p>You can choose from several slide layouts which we created for you.</p>
</div>

<h2>Frequently Asked Questions</h2>
<div class="doc">
    <h3>How can I generate real slides?</h3>
    <p>Go to settings and enable "Create slides" and "Static slides". Then everytime when you save the layout in "Edit layout" or "Change layout", Smart Slider will (re)generate the slides.<br />
    <b>Important</b>: When you regenerate the slides, the existing generated slides will be deleted!
    </p>
</div>

<?php
$this->loadFragment('secondcolend');
?>

<?php
$this->loadFragment('footer');
?>