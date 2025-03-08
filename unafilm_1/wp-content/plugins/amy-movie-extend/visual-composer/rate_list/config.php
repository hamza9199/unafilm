<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

$genre = [];

vc_map(array(
	'name' 		=> esc_html__('Amy Movie Rate List', 'amy-movie-extend'),
	'base' 		=> 'movieratelist',
	'icon' 		=> 'fa fa-star',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> array(
//		array(
//			'type' 				=> 'vc_amy_chosen',
//			'heading' 			=> esc_html__('Genre', 'amy-movie-extend'),
//			'param_name' 		=> 'genre',
//			'placeholder' 		=> 'Select genre',
//			'value' 			=> amy_element_values('callback', array(
//				'function'	=> array($genre, 'get_genre_args'),
//				'args'		=> array(
//					'taxonomy' => 'amy_genre',
//				),
//			)),
//			'description'	=> esc_html__('If field"s empty will get all genre', 'amy-movie-extend'),
//			'admin_label'		=> true,
//		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Order By', 'amy-movie-extend'),
			'param_name'	=> 'orderby',
			'value'		=> array(
				esc_html__('Point Rate', 'amy-movie-extend')		=> '_rating_average',
				esc_html__('Release Date', 'amy-movie-extend')		=> '_release',
				esc_html__('Post ID', 'amy-movie-extend')			=> 'ID',
				esc_html__('Author', 'amy-movie-extend')			=> 'author',
				esc_html__('Title', 'amy-movie-extend')			=> 'title',
				esc_html__('Date', 'amy-movie-extend')				=> 'date',
				esc_html__('Random Order', 'amy-movie-extend')		=> 'rand',
				esc_html__('Comment Count', 'amy-movie-extend')	=> 'comment_count',
			),
			'std'	=> 'date',
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Sort order', 'amy-movie-extend'),
			'param_name'	=> 'movie_order',
			'value'			=> array(
				esc_html__('Descending', 'amy-movie-extend')	=> 'DESC',
				esc_html__('Ascending', 'amy-movie-extend')	=> 'ASC',
			),
			'std'			=> 'DESC',
		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Date From', 'amy-movie-extend'),
			'param_name'	=> 'movie_date',
			'value'			=> array(
				esc_html__('Last 1 day', 'amy-movie-extend')		=> 'day',
				esc_html__('Last 7 days', 'amy-movie-extend')	=> 'week',
				esc_html__('Last 30 days', 'amy-movie-extend')	=> 'month',
				esc_html__('All time', 'amy-movie-extend')		=> 'alltime',
			),
			'std'			=> 'alltime',
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> esc_html__('Post Per Page', 'amy-movie-extend'),
			'param_name' 	=> 'movie_number',
			'value' 		=> 7,
			'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
		),

		array(
			'type'			=> 'vc_amy_on_off',
			'heading'		=> esc_html__('Show Pagination', 'amy-movie-extend'),
			'param_name'	=> 'pagination',
			'std'			=> true,
			'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name' 	=> 'class',
			'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
		),
	),
));
