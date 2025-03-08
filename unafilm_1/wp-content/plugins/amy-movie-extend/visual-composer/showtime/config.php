<?php
use AmyMovie\Core\Base;

$base = new Base();

if ($base->get_option('is_single_cinema', false) || !$base->get_option('enable_m_cinema', false)) {
	return;
}

$genre = [];

vc_map(array(
	'name' 		=> esc_html__('Amy Movie Showtime', 'amy-movie-extend'),
	'base' 		=> 'movieshowtime',
	'icon' 		=> 'fa fa-clock-o',
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
//			'admin_label'		=> true,
//			'description'	=> esc_html__('If field"s empty will get all genre', 'amy-movie-extend'),
//		),

		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Showtime type', 'amy-movie-extend'),
			'param_name'	=> 'showtime_type',
			'value'			=> array(
				esc_html__('Only Today', 'amy-movie-extend')	=> 'today',
				esc_html__('All Days', 'amy-movie-extend')		=> 'all',
				esc_html__('Coming Soon', 'amy-movie-extend')	=> 'cm',
			),
			'std'			=> 'all',
		),

		array(
			'type' 	   		=> 'textfield',
			'heading'	 	=> esc_html__('Extra Class', 'amy-movie-extend'),
			'param_name' 	=> 'class',
		),

	),
));
