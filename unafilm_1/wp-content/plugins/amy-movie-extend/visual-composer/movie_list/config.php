<?php
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Base;

$base   = new Base();
$movie  = new MovieHelpers();
$vc     = new VisualComposer();
$params = $vc->default_params();

$params[] = array(
	'type' 	   		=> 'textfield',
	'heading'	 	=> esc_html__('Title', 'amy-movie-extend'),
	'param_name' 	=> 'title',
	'group'       	=> esc_html__('Layout Option', 'amy-movie-extend'),
);

$params[] = array(
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__('Post Per Page', 'amy-movie-extend'),
	'param_name' 	=> 'posts_per_page',
	'value' 		=> 7,
	'group'       	=> esc_html__('Layout Option', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Pagination', 'amy-movie-extend'),
	'param_name'	=> 'pagination',
	'std'			=> true,
	'group'       	=> esc_html__('Layout Option', 'amy-movie-extend'),
);

if ($base->get_option('enable_m_cinema', false)) {
	$params[] = array(
		'type' => 'vc_amy_on_off',
		'heading' => esc_html__('Show Showtime', 'amy-movie-extend'),
		'param_name' => 'show_showtime',
		'std' => false,
		'group' => esc_html__('Layout Option', 'amy-movie-extend'),
	);

	$params[] = array(
		'type' => 'dropdown',
		'heading' => esc_html__('Showtime type', 'amy-movie-extend'),
		'param_name' => 'showtime_type',
		'value' => array(
			esc_html__('Only Today', 'amy-movie-extend') => 'today',
			esc_html__('All Days', 'amy-movie-extend') => 'all',
			esc_html__('Coming Soon', 'amy-movie-extend') => 'cm',
		),
		'std' => 'all',
		'group' => esc_html__('Layout Option', 'amy-movie-extend'),
		'dependency' => array('element' => 'show_showtime', 'value' => array('1')),
	);
}

$custom_fields		= $base->get_option('movie_custom_fields');
$defaults_fields	= $base->get_option('movie_default_fields', $movie->default_fields());

$person_options 	= array();

if (!empty($defaults_fields)) {
	foreach ($defaults_fields as $field) {
		if ($field == 'movie_actor') {
			$person_options[esc_html__('Actor', 'amy-movie-extend')] = 'amy_actor';
		}

		if ($field == 'movie_director') {
			$person_options[esc_html__('Director', 'amy-movie-extend')] = 'amy_director';
		}

		if ($field == 'movie_genre') {
			$person_options[esc_html__('Genre', 'amy-movie-extend')] = 'amy_genre';
		}
	}
}

if (!empty($custom_fields)) {
	foreach ($custom_fields as $field) {
		if ($field['type'] == 'person' || $field['type'] == 'category') {
			$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
			$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

			$person_options[$field['name']]	= $singular_name;
		}
	}
}

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Filter', 'amy-movie-extend'),
	'param_name'	=> 'show_filter',
	'std'			=> false,
	'group'       	=> esc_html__('Filter Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'				=> 'vc_amy_chosen',
	'heading'			=> esc_html__('Chosen Filters Show', 'amy-movie-extend'),
	'param_name'		=> 'filters',
	'admin_label'		=> true,
	'value'				=> $person_options,
	'group'       		=> esc_html__('Filter Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Sort By', 'amy-movie-extend'),
	'param_name'	=> 'show_sortby',
	'std'			=> false,
	'group'       	=> esc_html__('Filter Options', 'amy-movie-extend'),
);

$params[] = array(
	'type' 			=> 'vc_amy_image_select',
	'heading' 		=> esc_html__('Filter Style'),
	'param_name' 	=> 'filter_style',
	'options' 		=> array(
		'style1' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/filter_layout1.png',
		'style2' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/filter_layout2.png',
	),
	'std'			=> 'style1',
	'group'			=> esc_html__('Filter Options', 'amy-movie-extend'),
);

$params[] = array(
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name' 	=> 'class',
	'group'       	=> esc_html__('Layout Option', 'amy-movie-extend'),
);

vc_map(array(
	'name' 		=> esc_html__('V1 - Movie List', 'amy-movie-extend'),
	'base' 		=> 'movielist',
	'icon' 		=> 'fa fa-list',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> $params
));
