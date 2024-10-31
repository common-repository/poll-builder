<?php
namespace ypl;

class AJax {
	public function __construct() {
		$this->init();
	}

	private function init() {
		add_action('wp_ajax_ypl_send_poll', array($this, 'answer'));
		add_action('wp_ajax_nopriv_ypl_send_poll', array($this, 'answer'));

		add_action('wp_ajax_ypl_delete_result', array($this, 'deleteResults'));
		add_action('wp_ajax_ypl_add_new_answer', array($this, 'addNewAnswer'));
	}
	
	public function addNewAnswer() {
		$options = YplOptionsConfig::getOptionsDefaultOptions();
		$builder = new OptionsBuilder(array());
		echo $builder->renderTemplate('{currentIndex}', $options);
		wp_die();
	}

	public function answer() {
		check_ajax_referer('ypl_ajax_nonce', 'nonce');
		$id = (int)$_POST['id'];
		$answer = $_POST['answer'];
	
		$userId = Poll::saveUserData();
		$args = array(
			'pollId' => $id,
			'answer' => $answer,
			'userId' => $userId
		);
		
		Poll::savePollResults($args);

		$poll = Poll::findById($id);
		$results = $poll->results();

		echo $results;
		wp_die();
	}

	public function deleteResults() {
		$list = $_POST['idsList'];
		$listStr = implode(',', $list);
		global $wpdb;
		$wpdb->query('DELETE from '.$wpdb->prefix.YPL_RESULTS_TABLE.' WHERE id in ('.$listStr.')');

		echo 1;
		wp_die();
	}
}

new AJax();