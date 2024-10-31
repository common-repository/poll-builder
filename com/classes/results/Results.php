<?php
namespace ypl;

abstract class Results {
    private $poll;
    private $id;
    private $results;
    protected $voteResults;
    private $total;

    public abstract function resultView();

    public function setPoll($poll) {
        $this->poll = $poll;
    }
    public function getPoll() {
        return $this->poll;
    }

    public function setId($id) {
        $this->id = (int)$id;
    }

    public function getId() {
        return $this->id;
    }

    public static function getResultsById($id) {
        global $wpdb;

        $st = 'SELECT * FROM '.$wpdb->prefix.YPL_RESULTS_TABLE.' WHERE poll_id = %d';
        $queryStr = $wpdb->prepare($st, $id);
        $results = $wpdb->get_results($queryStr, ARRAY_A);

        return $results;
    }

    private function prepareInitialResults() {
        $answers = $this->poll->getOptionValue('ypl-classic-answer');
        $voteResults = array();
        $options = array_keys($answers);

        foreach ($options as $option) {
            $voteResults[$option] = 0;
        }

        $this->voteResults = $voteResults;
    }

    private function setCountsOfResults() {
        $results = $this->results;
        $voteResults = $this->voteResults;

        foreach ($results as $result) {

            if(empty($result)) {
                continue;
            }
            $vote = $result['vote'];
            $voteResults[$vote] += 1;
        }

        $this->voteResults = $voteResults;
        $this->total = count($results);
    }

    public function prepare() {

        $polId = $this->poll->getId();
        $this->setId($polId);
        $results = Results::getResultsById($polId);
        $this->results = $results;
        $this->prepareInitialResults();
        $this->setCountsOfResults();
    }

    public function resultHeader() {
        $id = $this->getId();
        $header = '<div class="ypl-poll-results ypl-poll-results-'.esc_attr($id).'" data-id="'.esc_attr($id).'">';

        return $header;
    }

    public function resultFooter() {
        $footer = '</div>';

        return $footer;
    }

    public function getPercent($voteCount) {
        $total = $this->total;
        return ceil(($voteCount/$total*100));
    }

    protected function render($mainContent) {
        $content = $this->resultHeader();
        $content .= $mainContent;
        $content .= $this->resultFooter();

        return $content;
    }
    
    protected function renderStyles() {
	    
    	$id = $this->getId();
    	$pollObj = $this->poll;
    	$buttonWrapperMarginTop = $this->poll->getOptionValue('ypl-vote-button-margin-top');
    	$buttonWrapperMarginRight = $this->poll->getOptionValue('ypl-vote-button-margin-right');
    	$buttonWrapperMarginBottom = $this->poll->getOptionValue('ypl-vote-button-margin-bottom');
    	$buttonWrapperMarginLeft = $this->poll->getOptionValue('ypl-vote-button-margin-left');
    	
    	$borderRadius = $this->poll->getOptionValue('ypl-vote-button-border-radius');
    	
    	$buttonWrapperPaddingTop = $this->poll->getOptionValue('ypl-vote-button-padding-top');
    	$buttonWrapperPaddingRight = $this->poll->getOptionValue('ypl-vote-button-padding-right');
    	$buttonWrapperPaddingBottom = $this->poll->getOptionValue('ypl-vote-button-padding-bottom');
    	$buttonWrapperPaddingLeft = $this->poll->getOptionValue('ypl-vote-button-padding-left');
    	$buttonWrapperPadding = $this->poll->getOptionValue('ypl-poll-button-padding');
    	
    	$buttonDimension = $this->poll->getOptionValue('ypl-poll-button-dimension');
    	$buttonWidth = $this->poll->getOptionValue('ypl-vote-button-width');
    	$buttonHeight = $this->poll->getOptionValue('ypl-vote-button-height');

	    $optionsLabelFontSize = $pollObj->getOptionValue('ypl-options-label-font-size');
    
    	$styles = '<style>';
    	$styles .= '.poll-content-wrapper-'.$id.' .ypl-submit-wrapper input {border-radius: '.$borderRadius.' !important; }';
    	$styles .= '.poll-content-wrapper-'.$id.' .ypl-submit-wrapper {margin: '.$buttonWrapperMarginTop.' '.$buttonWrapperMarginRight.' '.$buttonWrapperMarginBottom.' '.$buttonWrapperMarginLeft.'}';
	    if (!empty($buttonWrapperPadding)) {
		    $styles .= '.poll-content-wrapper-'.$id.' .ypl-vote {padding: '.$buttonWrapperPaddingTop.' '.$buttonWrapperPaddingRight.' '.$buttonWrapperPaddingBottom.' '.$buttonWrapperPaddingLeft.'}';
	    }
	    
	    if (!empty($buttonDimension)) {
		    $styles .= '.poll-content-wrapper-'.$id.' .ypl-vote {width: '.$buttonWidth.' !important; height: '.$buttonHeight.' !important}';
	    }

	    if (!empty($optionsLabelFontSize)) {
	    	$styles .= '.poll-content-wrapper-'.$id.' label {font-size: '.$optionsLabelFontSize.' !important;}';
	    }
    	$styles .= '</style>';
    	
    	return $styles;
    }
}