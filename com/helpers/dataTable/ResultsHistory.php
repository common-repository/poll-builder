<?php
namespace yplDataTable;
use ypl\AdminHelper;

require_once dirname(__FILE__).'/Table.php';

class ResultsHistory extends YPLTable
{
	public function __construct()
	{
		global $wpdb;
		parent::__construct('');

		$this->setRowsPerPage(YPL_TABLE_LIMIT);
		$this->setTablename($wpdb->prefix.YPL_RESULTS_TABLE);
		$this->setColumns(array(
			$this->tablename.'.id',
			'cDate',
            $this->tablename.'.poll_id'
		));
		$this->setDisplayColumns(array(
			'bulk'=>'<input class="subs-bulk" type="checkbox" autocomplete="off">',
			'product_id' => 'ID',
            'title' => __('Poll Form', YPL_TEXT_DOMAIN),
			'date' => __('Date', YPL_TEXT_DOMAIN)
		));
		$this->setSortableColumns(array(
			'product_id' => array('id', false),
			'cDate' => array('date', true),
			'countdownType' => array('countdownType', true),
			$this->setInitialSort(array(
				'id' => 'DESC'
			))
		));
	}

	public function customizeRow(&$row)
	{
		$title = get_the_title($row[2]);
		if (empty($title)) {
			$title = __('(no title)', YPL_TEXT_DOMAIN);
		}
        $currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $currentLink = add_query_arg( array(
            'currentPollId' => $row[0]
        ), $currentLink);

		$row[2] = '<a href="'.esc_attr($currentLink).'">'.$title.'</a>';
		$row[3] = AdminHelper::getFormattedDate($row[1]);
		$row[1] = $row[0];
		$id = $row[0];
		$row[0] = '<input type="checkbox" name="ypl-delete-checkbox[]" value="'.esc_attr($id).'" class="ypl-delete-checkbox" data-delete-id="'.esc_attr($id).'">';
	}

	public function customizeQuery(&$query)
	{
		//$query = AdminHelper::filterHistory($query);
	}
}
