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
$this->loadFragment('firstcol/settings');
?>

<?php
$this->loadFragment('firstcolend');
?>

<?php
$this->loadFragment('secondcolstart');
?>

<h2>Cache</h2>
<div class="smartslider-button-wrap">
    <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container ">
        <a class="smartslider-button-link" href="<?php echo $this->route('controller=settings&view=sliders_settings&action=cache&refreshcache=1'); ?>">
            <span class="smartslider-icon smartslider-action-icon smartslider-action-icon-refresh"></span>
            Refresh slider
        </a>
    </div>
    <div class="smartslider-button smartslider-back smartslider-button-grey smartslider-button-blue-active smartslider-icon-container ">
        <a class="smartslider-button-link" href="<?php echo $this->route('controller=settings&view=sliders_settings&action=cache&refreshcache=2'); ?>">
            <span class="smartslider-icon smartslider-action-icon smartslider-action-icon-refresh"></span>
            Refresh generator
        </a>
    </div>
</div>

<?php
$this->loadFragment('secondcolend');
?>

<?php
$this->loadFragment('footer');
