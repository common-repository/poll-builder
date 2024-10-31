<?php
namespace ypl;

class OptionsBuilder {
    private $options;
    private $optionKey;
    private $settingKey;

    public function __construct($options) {
        $this->options = $options;
    }

    public function __toString() {
        return $this->render();
    }

    public function render() {
        $options= $this->options;

        if(empty($options)) {
            return '';
        }
        $optionsHtml = '<div class="ypl-child-options-wrapper">';
        foreach ($options as $optionKey => $option) {
            if(empty($option)) {
                continue;
            }
            $this->optionKey = ++$optionKey;
            $optionsHtml .= $this->renderCurrentOption($option);
        }
        $optionsHtml .= '</div>';
        $optionsHtml .= $this->renderAdminOptions();

        return $optionsHtml;
    }
    
    private function renderAdminOptions() {
	    $options= $this->options;
	    $options = json_encode($options);
	    return '<input type="hidden" id="ypl-options-settings" name="ypl-options-settings" value="'.esc_attr($options).'">';
    }

    private function renderCurrentOption($option) {
        $index = $this->optionKey;
        $optionHtml = $this->renderSetting($index, $option);

        return $optionHtml;
    }
    
    private function renderSetting($index, $option = array()) {
        $optionString = json_encode($option);
	    ob_start();
	    ?>
	    <div class="current-option-wrapper current-option-wrapper-<?php echo $index; ?>" data-options='<?php echo $optionString; ?>'>
            <div class="current-option-header">
                <p class="current-option-info-p">Option <?php echo $index; ?></p> <button type="button" class="handlediv ypl-handlediv ypl-rotate-180" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Options</span><span class="toggle-indicator ypl-toggle-indicator" aria-hidden="true"></span></button>
        <button class=" btn btn-success btn-xs"><span class="dashicons ypl-cursor ypl-edit dashicons-edit"></span></button>
        <button class="btn btn-danger btn-xs ypl-trash-wrapper"><span class="dashicons ypl-cursor ypl-trash dashicons-trash" data-index="<?php echo $index; ?>"></span></button>
        </div>
        <div class="current-option-settings ypl-hide">
		    <?php foreach ($option as $settingKey => $setting):?>
			    <?php if(empty($setting) || !is_array($setting)) {continue;}?>
			    <?php $this->settingKey = $settingKey; echo $this->renderSubSetting($setting); ?>
		    <?php endforeach; ?>
        </div>
        </div>
	    <?php
        $optionHtml = ob_get_contents();
        ob_end_clean();

        return $optionHtml;
    }

    private function renderSubSetting($setting) {
        $adminSideSetting = $setting['adminSide'];
        $frontElement = $adminSideSetting['frontElement'];
    //    $frontSide = $setting['frontData'];
        
        $optionKey = $this->optionKey;
        $settingKey = $this->settingKey;
        $name = 'ypl-optionsBuilder['.esc_attr($optionKey).']['.esc_attr($settingKey).']['.esc_attr($adminSideSetting['frontElement']).']';
	 
        $adminSideSetting['attrs']['name'] = $name;
//
//	    if (!empty($frontSide[$frontElement])) {
//		    $adminSideSetting['attrs']['value'] =  $frontSide[$frontElement];
//        }
        ob_start();
        ?>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo $adminSideSetting['label']; ?></label>
                </div>
                <div class="col-md-6">
                    <?php echo AdminHelper::createInput('', '', $adminSideSetting['attrs']); ?>
                </div>
            </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
    public function renderTemplate($index, $allOptions) {
        $newSettings = $allOptions[0];
	    $newSettings[0]['adminSide']['attrs']['value'] = 'option '.$index;
	    $newSettings['currentIndex'] = $index;
	    $this->optionKey = $index;
	 
        return $this->renderSetting($index, $newSettings);
    }
}