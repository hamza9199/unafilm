<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('ABSPATH') or die;

if (! function_exists('amy_add_vc_row_options')) {
	function amy_add_vc_row_options() {
		vc_add_param('vc_row', array(
			'type' 			=> 'checkbox',
			'heading' 		=> esc_html__('Wrap inside div.container', 'amy-movie'),
			'param_name' 	=> 'amy_add_container',
			'value' 		=> array(
				esc_html__('Yes', 'amy-movie')	=> 'yes',
			),
		));

		vc_add_param('vc_row', array(
			'type' 			=> 'checkbox',
			'heading' 		=> esc_html__('White text', 'amy-movie'),
			'param_name' 	=> 'amy_white_text',
			'value' 		=> array(
				esc_html__('Yes', 'amy-movie')	=> 'yes',
			),
		));
	}

	amy_add_vc_row_options();
}
