<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

vc_map(array(
	'name' 		=> esc_html__('Amy Movie Search', 'amy-movie-extend'),
	'base' 		=> 'moviesearch',
	'icon' 		=> 'fa fa-search',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> array(
		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name'	=> 'class',
			'value'			=> '',
		),
	),
));
