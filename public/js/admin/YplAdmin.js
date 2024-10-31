function YplAdmin() {

}

YplAdmin.prototype.init = function() {
	this.deleteResult();
	this.select2();
	this.crudinit();
	this.addAnswer();
	this.listeners();
	this.accordionContent();
	this.copySortCode();
	this.editor();
};

YplAdmin.prototype.crudinit = function () {
	this.toggleAnwers();
	this.deleteAnswer();
};

YplAdmin.prototype.editor = function() {
	(function($){
		$(function(){
			if( $('#ypl-edtitor-head').length ) {
				var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettings.codemirror = _.extend(
					{},
					editorSettings.codemirror,
					{
						indentUnit: 2,
						tabSize: 2
					}
				);
				var editor = wp.codeEditor.initialize( $('#ypl-edtitor-head'), editorSettings );
			}

			if( $('#ypl-editor-js').length ) {
				var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettings.codemirror = _.extend(
					{},
					editorSettings.codemirror,
					{
						mode: 'javascript',
					}
				);
				var editor = wp.codeEditor.initialize( $('#ypl-editor-js'), editorSettings );
			}

			if( $('#ypl-edtitor-css').length ) {
				var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
				editorSettings.codemirror = _.extend(
					{},
					editorSettings.codemirror,
					{
						indentUnit: 2,
						tabSize: 2,
						mode: 'css',
					}
				);
				var editor = wp.codeEditor.initialize( $('#ypl-edtitor-css'), editorSettings );
			}
		});
	})(jQuery);
};

YplAdmin.prototype.copySortCode = function() {
	jQuery('.ypl-shortcode-info').bind('click', function() {
		var currentId = jQuery(this).data('id');
		var copyText = document.getElementById('ypl-shortcode-input-'+currentId);
		copyText.select();
		document.execCommand('copy');

		var tooltip = document.getElementById('ypl-tooltip-'+currentId);
		tooltip.innerHTML = YPL_ADMIN_DATA.copied;
	});

	jQuery(document).on('focusout', '.ypl-shortcode-info',function() {
		var currentId = jQuery(this).data('id');
		var tooltip = document.getElementById('ypl-tooltip-'+currentId);
		tooltip.innerHTML = YPL_ADMIN_DATA.copyToClipboard;
	});
};

YplAdmin.prototype.deleteAnswer = function () {
	var deleteOption = jQuery('.ypl-trash');

	if (!deleteOption.length) {
		return;
	}
	var that = this;

	deleteOption.unbind('click').bind('click', function (e) {
		e.preventDefault();
		var confirmRes = confirm('Are you shure?');
		if (!confirmRes) {
			return false;
		}
		var currentIndex = jQuery(this).data('index');
		that.deleteOption(currentIndex);
	});
};

YplAdmin.prototype.listeners = function () {
	var that = this;

	jQuery(window).bind('addedNewIcon', function () {
		that.crudinit();
	});
};

YplAdmin.prototype.addAnswer = function () {
	var addNewButton = jQuery('.ypl-add-new-button');

	if (!addNewButton.length) {
		return false;
	}
	var that = this;

	addNewButton.bind('click', function (e) {
		e.preventDefault();
		var settings = that.getFieldSettings();
		var index = (parseInt(settings.length) + 1);
		//var newContent = jQuery('.ypl-default-setting').html();
		jQuery.post(ajaxurl, {action: 'ypl_add_new_answer',nonce: YPL_ADMIN_DATA.nonce}, function (newContent) {

			newContent = that.replaceAll(newContent, '{currentIndex}', index);
			jQuery('.ypl-child-options-wrapper').append(newContent);

			var options = jQuery('.current-option-wrapper-'+index).data('options');
			that.addOption(options);
			jQuery(window).trigger('addedNewIcon');
		});

	});
};

YplAdmin.prototype.addOption = function (newOption) {
	var settings = this.getFieldSettings();
	settings.push(newOption);

	this.updateOptions(settings);
};

YplAdmin.prototype.deleteOption = function (index) {
	var settings = this.getFieldSettings();

	if(!settings.length) {
		return false;
	}

	for(var i in settings) {
		var currentSetting = settings[i];

		if (!currentSetting) {
			continue;
		}

		if (parseInt(currentSetting.currentIndex) == index) {
			delete settings[i];
			jQuery('.current-option-wrapper-'+index).remove();
			break;
		}
	}

	this.updateOptions(settings);
};

YplAdmin.prototype.getFieldSettings = function () {
	var settings = jQuery('#ypl-options-settings').val();
	settings = jQuery.parseJSON(settings);

	return settings;
};

YplAdmin.prototype.updateOptions = function (settings) {
	jQuery('#ypl-options-settings').attr('value', JSON.stringify(settings));
};

YplAdmin.prototype.toggleAnwers = function() {
	var currentEdit =  jQuery('.ypl-edit, .current-option-info-p, .ypl-toggle-indicator');

	if (!currentEdit.length) {
		return false;
	}

	currentEdit.unbind('click').bind('click', function (e) {
		e.preventDefault();
		var current = jQuery(this);

		if (!current.length) {
			return false;
		}
		var currentParent = current.parents('.current-option-header').first();
		jQuery('.ypl-handlediv', currentParent).toggleClass('ypl-rotate-180');
		currentParent.next().toggleClass('ypl-hide');
	});
};


YplAdmin.prototype.select2 = function() {
    var select2 = jQuery('.js-ypl-select');

    if(!select2.length) {
        return false;
    }

    select2.select2();
};

YplAdmin.prototype.deleteResult = function() {
	jQuery('.subs-bulk').bind('change', function() {
		var isChecked = jQuery(this).is(':checked');
		jQuery('.ypl-delete-checkbox, .subs-bulk').prop('checked', isChecked);
	});
	var that = this;

	jQuery('.ypl-delete-history').bind('click', function(e) {
		e.preventDefault();
		var action = jQuery(this).prev('.ypl-bulk-action');

		if(action.val() == 'delete') {
			// delete
			that.deleteSelected();
		}
	});
};

YplAdmin.prototype.deleteSelected = function() {
	var checkboxes = jQuery('.ypl-delete-checkbox');
 
	if (!checkboxes.length) {
		return false;
	}
	var idsList = [];

	checkboxes.each(function() {
		if (jQuery(this).is(':checked')) {
			idsList.push(jQuery(this).data('delete-id'));
		}
	});

	var data = {
		action: 'ypl_delete_result',
		idsList: idsList
	};

	jQuery.post(ajaxurl, data, function(result) {
		window.location.reload();
	})
};

YplAdmin.prototype.replaceAll = function(str, find, replace) {
	return str.replace(new RegExp(find, 'g'), replace);
};

YplAdmin.prototype.accordionContent = function() {

	var that = this;
	var accordionCheckbox = jQuery('.ypl-accordion-checkbox');

	if (!accordionCheckbox.length) {
		return false;
	}
	accordionCheckbox.each(function () {
		that.doAccordion(jQuery(this), jQuery(this).is(':checked'));
	});
	accordionCheckbox.each(function () {
		jQuery(this).bind('change', function () {
			var attrChecked = jQuery(this).is(':checked');
			var currentCheckbox = jQuery(this);
			that.doAccordion(currentCheckbox, attrChecked);
		});
	});
};

YplAdmin.prototype.doAccordion = function(checkbox, isChecked) {
	var accordionContent = checkbox.parents('.row').nextAll('.ypl-accordion-content').first();

	if(isChecked) {
		accordionContent.removeClass('ypl-hide-content');
	}
	else {
		accordionContent.addClass('ypl-hide-content');
	}
};

jQuery(document).ready(function() {
	var obj = new YplAdmin();
	obj.init();
});