<?php
namespace ypl;

class PollResults {

	public static function findAllById($id) {
		global $wpdb;
		$results = $wpdb->prefix.YPL_RESULTS_TABLE;
		$usersTable = $wpdb->prefix.YPL_USER_DETAILS_TABLE;
		$st = $wpdb->prepare('SELECT * from '.$results.' INNER JOIN '.$usersTable.' ON '.$results.'.user_id = '.$usersTable.'.id and user_id=%d', $id);
		$results = $wpdb->get_row($st, ARRAY_A);

		return $results;
	}
}