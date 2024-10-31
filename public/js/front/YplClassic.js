function YplClassic() {
	this.init();
}

YplClassic.prototype.init = function() {
	var that = this;
	jQuery('.ypl-poll').each(function() {
		that.submitListener(jQuery(this));
	});
};

YplClassic.prototype.submitListener = function(form) {
	form.submit(function(e) {
		e.preventDefault();
		var id = jQuery(this).data('id');
		var answer = jQuery('.ypl-answer:checked', this).val();

		var data = {
			action: 'ypl_send_poll',
			nonce: YPL_DATA.nonce,
			beforeSend: function () {
				var currentButton = jQuery('.ypl-vote', form);
				currentButton.val(currentButton.data('progress-title'));
			},
			id: id,
			answer: answer
		};

		jQuery.post(YPL_DATA.ajaxUrl, data, function(answer) {
			jQuery('.poll-content-wrapper-'+id).html(answer);
		})
	});
};

jQuery(document).ready(function() {
	new YplClassic();
});