<?php
use ypl\OptionsData;
use ypl\OptionsBuilder;
use ypl\YplOptionsConfig;

$options = ypl\YplOptionsConfig::getOptionsDefaultOptions();

$optionsObj = new OptionsData();
$optionsObj->addAllOptions($options);
$allOptions = $optionsObj->getAllOptions();

if (!empty($_GET['post'])) {
	$allOptions = get_post_meta($_GET['post'], 'YPL_SAVED_SETTINGS', true);
}
?>
<div class="ypl-bootstrap-wrapper">
    <div class="ypl-settings-wrapper">
	    <?php
	        $builder = new OptionsBuilder($allOptions);
            echo $builder;
	    ?>
    </div>
	<div>
        <button class="ypl-add-new-button btn btn-primary">
	        <span class="ypl-button-content ypl-button-content-text"><?php _e('Add new'); ?></span><span class="dashicons dashicons-plus ypl-button-content"></span>
        </button>
	</div>
</div>
	