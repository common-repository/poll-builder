<?php
use yplDataTable\ResultsHistory;
require_once YPL_HELPERS_DATATABLE_PATH.'ResultsHistory.php';
?>

<div class="ypl-hidden-table-wrapper">
    <h2><?php _e('Downloads', YPL_TEXT_DOMAIN); ?></h2>
<?php
    $table = new ResultsHistory();
    echo $table;
?>
</div>