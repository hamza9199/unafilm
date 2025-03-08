// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
;(function ($) {
	$.fn.addBack = $.fn.addBack || $.fn.andSelf;

	$.fn.extend({

		actual: function (method, options) {
			// check if the jQuery method exist
			if (!this[method]) {
				throw '$.actual => The jQuery method "' + method + '" you called does not exist';
			}

			var defaults = {
				absolute: false,
				clone: false,
				includeMargin: false
			};

			var configs = $.extend(defaults, options);

			var $target = this.eq(0);
			var fix, restore;

			if (configs.clone === true) {
				fix = function () {
					var style = 'position: absolute !important; top: -1000 !important; ';

					// this is useful with css3pie
					$target = $target.clone().attr('style', style).appendTo('body');
				};

				restore = function () {
					// remove DOM element after getting the width
					$target.remove();
				};
			} else {
				var tmp = [];
				var style = '';
				var $hidden;

				fix = function () {
					// get all hidden parents
					$hidden = $target.parents().addBack().filter(':hidden');
					style += 'visibility: hidden !important; display: block !important; ';

					if (configs.absolute === true) style += 'position: absolute !important; ';

					// save the origin style props
					// set the hidden el css to be got the actual value later
					$hidden.each(function () {
						// Save original style. If no style was set, attr() returns undefined
						var $this = $(this);
						var thisStyle = $this.attr('style');

						tmp.push(thisStyle);
						// Retain as much of the original style as possible, if there is one
						$this.attr('style', thisStyle ? thisStyle + ';' + style : style);
					});
				};

				restore = function () {
					// restore origin style values
					$hidden.each(function (i) {
						var $this = $(this);
						var _tmp = tmp[i];

						if (_tmp === undefined) {
							$this.removeAttr('style');
						} else {
							$this.attr('style', _tmp);
						}
					});
				};
			}

			fix();
			// get the actual value with user specific methed
			// it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
			// configs.includeMargin only works for 'outerWidth' and 'outerHeight'
			var actual = /(outer)/.test(method) ?
				$target[method](configs.includeMargin) :
				$target[method]();

			restore();
			// IMPORTANT, this plugin only return the value of the first element
			return actual;
		}
	});
})(jQuery);

;(function ($, window, document, undefined) {
	'use strict';

	var Shortcodes  = vc.shortcodes;

	if (window.VcColumnView) {

		//
		// Amy module
		// -------------------------------------------------------------------------
		window.AmyModuleView  = window.VcColumnView.extend({
			events: {
				'click > .controls .column_add': 'addDirectlyElement',
				'click > .wpb_element_wrapper > .vc_empty-container': 'addDirectlyElement',
				'click > .controls .column_delete': 'deleteShortcode',
				'click > .controls .column_edit': 'editElement',
				'click > .controls .column_clone': 'clone',
			},

			addDirectlyElement: function(e) {
				e.preventDefault();

				var module  = Shortcodes.create({shortcode: 'amy_module_item', parent_id: this.model.id});

				return module;
			},

			setDropable: function () {

			},

			dropButton: function(event, ui) {

			},
		});
	}

	//
	// ATTS
	// -------------------------------------------------------------------------
	_.extend(vc.atts, {
		vc_amy_exploded_textarea: {
			parse: function (param) {
				var $field  = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');

				return $field.val().replace(/\n/g, '~');
			}
		},
		vc_amy_style_textarea: {
			parse: function(param) {
				var $field  = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');

				return $field.val().replace(/\n/g, '');
			}
		},
		vc_amy_chosen: {
			parse: function(param) {
				var value = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']').val();

				return ( value ) ? value.join(',') : '';
			}
		},
	});

	// ======================================================
	// VISUAL COMPOSER SWITCH
	// ------------------------------------------------------
	$.fn.JSCOMPOSER_SWITCH = function() {
		return this.each(function() {

			var _this   = $(this),
			_input  = _this.find('input');

			_this.click(function() {
				_this.toggleClass('switch-active');
				_input.val(( _input.val() == 1 ) ? '' : 1).trigger('keyup');
			});
		});
	};

	// ======================================================
	// VISUAL COMPOSER IMAGE SELECT
	// ------------------------------------------------------
	$.fn.JSCOMPOSER_IMAGE_SELECT = function() {
		return this.each(function() {

			var _el       = $(this),
				_elems    = _el.find('li');

			_elems.each( function (){
				var _this = $(this),
					_data   = _this.data('value');

				_this.click(function() {
					if (_this.is('.selected')) {
						_this.removeClass('selected');
						_el.next().val('').trigger('keyup');
					} else {
						_this.addClass('selected').siblings().removeClass('selected');
						_el.next().val( _data ).trigger('keyup');
					}
				});
			});
		});
	};

	$.fn.AMYFRAMEWORK_CHOSEN = function () {
		return this.each(function() {
			var $this	= $(this);
			console.log($this);
			if (!$this.closest('#widget-list').length) {
				$this.chosen({
					allow_single_deselect:		true,
					disable_search_threshold:	15,
					width:						parseFloat($(this).actual('width') + 25) + 'px'
				});
			}
		});
	};

	// ======================================================
	// RELOAD FRAMEWORK PLUGINS
	// ------------------------------------------------------
	$.AMYFRAMEWORK_VC_RELOAD_PLUGINS = function () {
		$('.vc_switch').JSCOMPOSER_SWITCH();
		$('.vc_image_select').JSCOMPOSER_IMAGE_SELECT();
		$('.chosen').AMYFRAMEWORK_CHOSEN();
	};

})(jQuery, window, document);