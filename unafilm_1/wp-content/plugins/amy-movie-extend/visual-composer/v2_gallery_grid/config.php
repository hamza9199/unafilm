<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (!defined('ABSPATH')) {
	return;
}

vc_map(array(
	'name' 						=> esc_html__('V2 - Gallery Grid', 'amy-movie-extend'),
	'base' 						=> 'amy_v2_gallery_grid',
	'icon' 						=> 'fa fa-th',
	'is_container'    			=> true,
	'category' 					=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> array(
		array(
			'type'			=> 'attach_images',
			'heading'		=> esc_html__('Gallery', 'amy-movie-extend'),
			'param_name'	=> 'gallery',
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Columns', 'amy-movie-extend'),
			'param_name'	=> 'column',
			'value'			=> array(
				esc_html__('2 columns', 'amy-movie-extend')		=> '2',
				esc_html__('3 columns', 'amy-movie-extend')		=> '3',
				esc_html__('4 columns', 'amy-movie-extend')		=> '4',
				esc_html__('6 columns', 'amy-movie-extend')		=> '6',
			),
			'std'			=> '4',
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name'	=> 'class',
		),
	)
));