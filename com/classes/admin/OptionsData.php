<?php
namespace ypl;

class OptionsData {
    private $options = array();
    private $currentIndex = 1;

    public function increaseCurrentIndex() {
        $this->currentIndex += 1;
    }

    public function getCurrentIndex() {
        return (int)$this->currentIndex;
    }

    public function addOption($option) {
        $options = $this->getAllOptions();
        $option['currentIndex'] = $this->getCurrentIndex();
        array_push($options, $option);
        $this->increaseCurrentIndex();
        $this->setOptions($options);
    }
    
    public function addAllOptions($options) {
    	if (empty($options)) {
    		return false;
	    }
	    
	    foreach ($options as $option) {
    		$this->addOption($option);
	    }
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function getAllOptions() {
        return $this->options;
    }
}