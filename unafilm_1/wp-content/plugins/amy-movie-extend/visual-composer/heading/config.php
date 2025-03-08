<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (!defined('ABSPATH')) {
	return;
}

vc_map(array(
	'name' 						=> esc_html__('V2 - Heading', 'amy-movie-extend'),
	'base' 						=> 'v2_heading',
	'icon' 						=> 'fa fa-header',
	'is_container'    			=> true,
	'category' 					=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> array(
		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Title', 'amy-movie-extend'),
			'param_name'	=> 'title',
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Highlight Title', 'amy-movie-extend'),
			'param_name'	=> 'highlight_title',
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Sub Heading', 'amy-movie-extend'),
			'param_name'	=> 'subtitle',
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Alignment', 'amy-movie-extend'),
			'param_name'	=> 'alignment',
			'value'			=> array(
				esc_html__('Left', 'amy-movie-extend')		=> 'left',
				esc_html__('Center', 'amy-movie-extend')	=> 'center',
				esc_html__('Right', 'amy-movie-extend')		=> 'right',
			),
			'std'			=> 'center',
		),

		array(
			'type'			=> 'vc_amy_on_off',
			'heading'		=> esc_html__('Seprator', 'amy-movie-extend'),
			'param_name'	=> 'seprator',
			'std'			=> false
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Seprator Full', 'amy-movie-extend'),
			'param_name'	=> 'seprator_full',
			'value'			=> array(
				esc_html__('No Full', 'amy-movie-extend')		=> 'no-full',
				esc_html__('Full Left', 'amy-movie-extend')		=> 'full-left',
				esc_html__('Full Right', 'amy-movie-extend')	=> 'full-right',
				esc_html__('Full Both', 'amy-movie-extend')		=> 'full-both',
			),
			'std'			=> 'seperator-1',
			'dependency'	=> array('element' => 'seprator', 'value' => array('1'))
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Seprator Type', 'amy-movie-extend'),
			'param_name'	=> 'seprator_type',
			'value'			=> array(
				esc_html__('Seperator 1', 'amy-movie-extend')		=> 'seperator-1',
				esc_html__('Seperator 2', 'amy-movie-extend')		=> 'seperator-2',
			),
			'std'			=> 'seperator-1',
			'dependency'	=> array('element' => 'seprator', 'value' => array('1'))
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Seprator Opacity', 'amy-movie-extend'),
			'param_name'	=> 'seprator_opacity',
			'dependency'	=> array('element' => 'seprator', 'value' => array('1'))
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Title Fontsize', 'amy-movie-extend'),
			'param_name'	=> 'title_fontsize',
			'group'			=> esc_html__('Style Options', 'amy-movie-extend')
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Highlight Title Fontsize', 'amy-movie-extend'),
			'param_name'	=> 'highlight_title_fontsize',
			'group'			=> esc_html__('Style Options', 'amy-movie-extend')
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Sub Heading Fontsize', 'amy-movie-extend'),
			'param_name'	=> 'subtitle_fontsize',
			'group'			=> esc_html__('Style Options', 'amy-movie-extend')
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name'	=> 'class',
			'group'			=> esc_html__('Style Options', 'amy-movie-extend')
		),
	)
));