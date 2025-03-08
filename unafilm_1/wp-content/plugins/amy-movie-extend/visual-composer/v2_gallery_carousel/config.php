<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (!defined('ABSPATH')) {
	return;
}

vc_map(array(
	'name' 						=> esc_html__('V2 - Gallery Carousel', 'amy-movie-extend'),
	'base' 						=> 'amy_v2_gallery_carousel',
	'icon' 						=> 'fa fa-sliders',
	'is_container'    			=> true,
	'category' 					=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> array(
		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Title', 'amy-movie-extend'),
			'param_name'	=> 'title',
		),

		array(
			'type'			=> 'textarea',
			'heading'		=> esc_html__('Short Desciprion', 'amy-movie-extend'),
			'param_name'	=> 'short_desc',
		),

		array(
			'type'			=> 'attach_images',
			'heading'		=> esc_html__('Gallery', 'amy-movie-extend'),
			'param_name'	=> 'gallery',
		),

		array(
			'type'			=> 'param_group',
			'value'			=> '',
			'param_name'	=> 'social_lists',
			'params'		=> array(
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Link', 'amy-movie-extend'),
					'param_name'	=> 'link',
				),

				array(
					'type'			=> 'iconpicker',
					'heading'		=> esc_html__('Icon', 'amy-movie-extend'),
					'param_name'	=> 'icon',
				),
			)
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name'	=> 'class',
		),
	)
));