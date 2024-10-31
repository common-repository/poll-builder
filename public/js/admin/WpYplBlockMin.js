'use strict';

function WpYplBlockMin() {}

WpYplBlockMin.prototype.init = function () {
	if (typeof wp == 'undefined' || typeof wp.element == 'undefined' || typeof wp.blocks == 'undefined' || typeof wp.editor == 'undefined' || typeof wp.components == 'undefined') {
		return false;
	}
	var localizedParams = YPL_GUTENBERG_PARAMS;

	var __ = wp.i18n;
	var createElement = wp.element.createElement;
	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.editor.InspectorControls;
	var _wp$components = wp.components,
		SelectControl = _wp$components.SelectControl,
		TextareaControl = _wp$components.TextareaControl,
		ToggleControl = _wp$components.ToggleControl,
		PanelBody = _wp$components.PanelBody,
		ServerSideRender = _wp$components.ServerSideRender,
		Placeholder = _wp$components.Placeholder;

	registerBlockType('pollbuilder/polls', {
		title: localizedParams.title,
		description: localizedParams.description,
		keywords: ['poll', 'polls', 'Poll builder'],
		category: 'widgets',
		icon: 'chart-bar',
		attributes: {
			countdownId: {
				type: 'number'
			}
		},
		edit: function edit(props) {
			var _props$attributes = props.attributes,
				_props$attributes$cou = _props$attributes.countdownId,
				countdownId = _props$attributes$cou === undefined ? '' : _props$attributes$cou,
				_props$attributes$dis = _props$attributes.displayTitle,
				displayTitle = _props$attributes$dis === undefined ? false : _props$attributes$dis,
				_props$attributes$dis2 = _props$attributes.displayDesc,
				displayDesc = _props$attributes$dis2 === undefined ? false : _props$attributes$dis2,
				setAttributes = props.setAttributes;

			const countdownOptions = [];
			let allPolls = YPL_GUTENBERG_PARAMS.allCountdowns;
			for(var id in allPolls) {
				var currentdownObj = {
					value: id,
					label: allPolls[id]
				}
				countdownOptions.push(currentdownObj);
			}
			countdownOptions.unshift({
				value: '',
				label: YPL_GUTENBERG_PARAMS.poll_select
			})
			var jsx = void 0;

			function selectCountdown(value) {
				setAttributes({
					countdownId: value
				});
			}

			function setContent(value) {
				setAttributes({
					content: value
				});
			}

			function toggleDisplayTitle(value) {
				setAttributes({
					displayTitle: value
				});
			}

			function toggleDisplayDesc(value) {
				setAttributes({
					displayDesc: value
				});
			}

			jsx = [React.createElement(
				InspectorControls,
				{ key: 'pollbuilder-gutenberg-form-selector-inspector-controls' },
				React.createElement(
					PanelBody,
					{ title: 'countdown builder title' },
					React.createElement(SelectControl, {
						label: 'Select poll',
						value: countdownId,
						options: countdownOptions,
						onChange: selectCountdown
					}),
					React.createElement(ToggleControl, {
						label: 'Select poll',
						checked: displayTitle,
						onChange: toggleDisplayTitle
					}),
					React.createElement(ToggleControl, {
						label: '',
						checked: displayDesc,
						onChange: toggleDisplayDesc
					})
				)
			)];

			if (countdownId) {
				return '[ypl_poll id="' + countdownId + '"]';
			} else {
				jsx.push(React.createElement(
					Placeholder,
					{
						key: 'ypl-gutenberg-form-selector-wrap',
						className: 'ypl-gutenberg-form-selector-wrapper' },
					React.createElement(SelectControl, {
						key: 'ypl-gutenberg-form-selector-select-control',
						value: countdownId,
						options: countdownOptions,
						onChange: selectCountdown
					}),
					React.createElement(SelectControl, {
						key: 'ypl-gutenberg-form-selector-select-control',
						onChange: selectCountdown
					})
				));
			}

			return jsx;
		},
		save: function save(props) {

			return '[ypl_poll id="' + props.attributes.countdownId + '"]';
		}
	});
};

jQuery(document).ready(function () {
	var block = new WpYplBlockMin();
	block.init();
});