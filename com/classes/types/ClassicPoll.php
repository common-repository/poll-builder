<?php
namespace ypl;
require_once(dirname(__FILE__).'/Poll.php');

class ClassicPoll extends Poll {
    public function metaboxes() {
        add_action('yplAdditionalMetaboxes', array($this, 'additionalMetaboxes'), 100, 1);
    }

    public function additionalMetaboxes($metaboxes) {
        $metaboxes['yplOtherConditionsMetaBoxView'] = array(
            'key' => 'yplOtherConditionsMetaBoxView',
            'displayName' => 'Main Settings',
            'filePath' => YPL_VIEWS_PATH.'classic/main.php',
            'priority' => 'high'
        );

        $metaboxes['yplOptionsMetabox'] = array(
            'key' => 'yplOptionsMetabox',
            'displayName' => 'Options',
            'filePath' => YPL_VIEWS_PATH.'classic/options.php',
            'priority' => 'high'
        );

        return $metaboxes;
    }
    public function setExtraOptions() {

    }
    
    public function getAnswers() {
        $answer = array();
        $id = $this->getId();
	    $allOptions = get_post_meta($id, 'YPL_SAVED_SETTINGS', true);

	    foreach ($allOptions as $option) {
	        if (empty($option[0]['adminSide']['attrs']['value'])) {
	            continue;
            }
            $answer[] = $option[0]['adminSide']['attrs']['value'];
        }
        
        return $answer;
    }

    private function getFormContent() {
       
        $answers = $this->getAnswers();
        
        $id = $this->getId();
        $idKey = 'ypl-form-'.$id;
	    $defaultAnswer = reset($answers);
        ob_start();
        foreach ($answers as $key => $answer) {
            $checked = '';
            if ($answer == $defaultAnswer) {
                $checked = 'checked';
            }
            $uniqKey = $idKey.= '-'.$answer;
            ?>
                <div>
                    <input type="radio" id="<?php echo $uniqKey; ?>" class="ypl-answer" name="ypl-answer" value="<?php echo $answer; ?>" <?php echo $checked; ?>>
                    <label for="<?php echo $uniqKey; ?>"><?php echo $answer; ?></label>
                </div>
            <?php
        }
        $content = ob_get_contents();
        ob_end_clean();
        $content .= $this->getStyles();

        return $content;
    }

    private function getStyles() {
        $id = $this->getId();
        $align = $this->getOptionValue('ypl-poll-alignment');
        $formWidth = (int)$this->getOptionValue('ypl-form-width');
        $widthMeasure = $this->getOptionValue('ypl-form-width-measure');

        $styles = '<style>';
        $styles .= '.poll-content-wrapper-'.$id.' {';
        $styles .= 'text-align: '.$align.' !important;';
        $styles .= 'width: '.$formWidth.$widthMeasure.' !important;';
        $styles .= 'max-width: 100% !important;';
        $styles .= '}';
        $styles .= '</style>';

        return $styles;
    }

    private function enqueData() {
        wp_register_script('YplClassic', YPL_FRONT_JS_URL.'YplClassic.js', array(), YPL_VERSION);
        wp_localize_script('YplClassic', 'YPL_DATA',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ypl_ajax_nonce'))
        );
        wp_enqueue_script('YplClassic');
        $this->enequeGeneralData();
    }

    public function getPollQuestion() {
        $question = $this->getOptionValue('ypl-classic-question');
        return '<p>'.$question.'</p>';
    }

    public function getViewForm() {
        $this->enqueData();
        $formHeader = $this->getFormHeader();
        $formFooter = $this->getFormFooter();
        $form = $formHeader;
        $form .= $this->getFormContent();
        $form .= $formFooter;

        return $form;
    }
}