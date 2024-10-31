<?php
use ypl\PollResults;
$currentSettings = PollResults::findAllById($_GET['currentPollId']);
?>
<div class="ypl-bootstrap-wrapper">
	<div class="row ypl-download-details-wrapper">
		<div class="col-md-8">
			<div class="panel panel-default ui-sortable-handle">
				<div class="panel-heading"><?php _e('Details', YPL_TEXT_DOMAIN); ?></div>
				<div class="panel-body">
					<div class="row form-group">
						<div class="col-md-5">
							<?php _e('Answer: ', YPL_TEXT_DOMAIN); ?>
						</div>
						<div class="col-md-5">
							<?php echo $currentSettings['vote']; ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-5">
							<?php _e('IP address: ', YPL_TEXT_DOMAIN); ?>
						</div>
						<div class="col-md-5">
							<?php echo $currentSettings['ip']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>