<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

vc_map(array(
	'name' 		=> esc_html__('Amy Movie Blog', 'amy-movie-extend'),
	'base' 		=> 'movieblog',
	'icon' 		=> 'fa fa-th-large',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> array(
		array(
			'type' 	   		=> 'textfield',
			'heading'	 	=> esc_html__('Title', 'amy-movie-extend'),
			'param_name' 	=> 'title',
		),

		array(
			'type' 			=> 'vc_amy_image_select',
			'heading' 		=> esc_html__('Layout', 'amy-movie-extend'),
			'param_name' 	=> 'layout',
			'options' 		=> array(
				'layout1' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/blog_layout1.png',
				'layout2' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/blog_layout2.png',
			),
			'std'			=> 'layout1',
			'admin_label'	=> true,
		),

//		array(
//			'type' 				=> 'vc_amy_chosen',
//			'heading' 			=> esc_html__('Category', 'amy-movie-extend'),
//			'param_name' 		=> 'category',
//			'placeholder' 		=> 'Select category',
//			'value' 			=> amy_element_values('categories', array(
//				'sort_order' 	=> 'ASC',
//				'taxonomy' 		=> 'category',
//				'hide_empty' 	=> 0,
//			)),
//			'admin_label'		=> true,
//		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Order By', 'amy-movie-extend'),
			'param_name'	=> 'post_orderby',
			'value'		=> array(
				esc_html__('Post ID', 'amy-movie-extend')		=> 'ID',
				esc_html__('Author', 'amy-movie-extend')			=> 'author',
				esc_html__('Title', 'amy-movie-extend')			=> 'title',
				esc_html__('Date', 'amy-movie-extend')			=> 'date',
				esc_html__('Random Order', 'amy-movie-extend')	=> 'rand',
				esc_html__('Comment Count', 'amy-movie-extend')	=> 'comment_count',
			),
			'std'	=> 'date',
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Sort order', 'amy-movie-extend'),
			'param_name'	=> 'post_order',
			'value'			=> array(
				esc_html__('Descending', 'amy-movie-extend')	=> 'DESC',
				esc_html__('Ascending', 'amy-movie-extend')	=> 'ASC',
			),
			'std'			=> 'DESC',
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Date From', 'amy-movie-extend'),
			'param_name'	=> 'post_date',
			'value'			=> array(
				esc_html__('Last 1 day', 'amy-movie-extend')		=> 'day',
				esc_html__('Last 7 days', 'amy-movie-extend')	=> 'week',
				esc_html__('Last 30 days', 'amy-movie-extend')	=> 'month',
				esc_html__('All time', 'amy-movie-extend')		=> 'alltime',
			),
			'std'			=> 'alltime',
		),

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name'  => 'class',
		),
	),
));
