<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (!defined('ABSPATH')) {
	return;
}

vc_map(array(
	'name' 						=> esc_html__('V2 - Trailer List', 'amy-movie-extend'),
	'base' 						=> 'amy_v2_tralier_list',
	'icon' 						=> 'fa fa-video-camera',
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
			'heading'		=> esc_html__('Subtitle', 'amy-movie-extend'),
			'param_name'	=> 'subtitle',
		),

		array(
			'type'			=> 'vc_amy_on_off',
			'heading'		=> esc_html__('Get Movie From Library', 'amy-movie-extend'),
			'param_name'	=> 'movie_from',
			'std'			=> true
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Movies Ids', 'amy-movie-extend'),
			'param_name'	=> 'movies_ids',
			'dependency'	=> array('element' => 'movie_from', 'value' => array('1'))
		),

		array(
			'type'			=> 'param_group',
			'value'			=> '',
			'heading'		=> esc_html__('Items List', 'amy-movie-extend'),
			'param_name'	=> 'items_list',
			'params'		=> array(
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Title', 'amy-movie-extend'),
					'param_name'	=> 'title',
				),

				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Imdb Rating', 'amy-movie-extend'),
					'param_name'	=> 'imdb_rating',
				),

				array(
					'type'			=> 'attach_image',
					'heading'		=> esc_html__('Poster', 'amy-movie-extend'),
					'param_name'	=> 'poster',
				),

				array(
					'type'			=> 'attach_image',
					'heading'		=> esc_html__('Background', 'amy-movie-extend'),
					'param_name'	=> 'background',
				),

				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Link Video (youtube or vimeo)', 'amy-movie-extend'),
					'param_name'	=> 'video_link',
				),
			),
			'dependency'	=> array('element' => 'movie_from', 'value' => array(''))
		),

		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name'	=> 'class',
		),
	)
));