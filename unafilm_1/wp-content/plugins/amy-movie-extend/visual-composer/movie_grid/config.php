<?php
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Base;

$base           = new Base();
$movie_helper   = new MovieHelpers();
$vc             = new VisualComposer();
$params         = $vc->default_params();

$params[] = array(
	'type' 	   		=> 'textfield',
	'heading'	 	=> esc_html__('Title', 'amy-movie-extend'),
	'param_name' 	=> 'title',
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
);

$params[] = array(
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__('Post Per Page', 'amy-movie-extend'),
	'param_name' 	=> 'posts_per_page',
	'value' 		=> 10,
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
);

$params[] = array(
	'type' 			=> 'vc_amy_image_select',
	'heading' 		=> 'Layout',
	'param_name' 	=> 'layout',
	'options' 		=> array(
		'layout1' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/grid_layout1.png',
		'layout2' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/grid_layout2.png',
		'layout3' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/grid_layout3.png',
		'layout4' => AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/grid_layout4.png',
	),
	'std'			=> 'layout1',
	'admin_label'	=> true,
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Columns', 'amy-movie-extend'),
	'param_name'	=> 'column',
	'value'			=> array(
		esc_html__('2 column', 'amy-movie-extend')		=> '2',
		esc_html__('3 column', 'amy-movie-extend')	    => '3',
		esc_html__('4 column', 'amy-movie-extend')	    => '4',
		esc_html__('5 column', 'amy-movie-extend')		=> '5',
	),
	'std'			=> '4',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('layout1', 'layout3', 'layout4')),
);

$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Columns', 'amy-movie-extend'),
	'param_name'	=> 'layout2_column',
	'value'			=> array(
		esc_html__('2 column', 'amy-movie-extend')		=> '2',
		esc_html__('3 column', 'amy-movie-extend')	=> '3',
	),
	'std'			=> '2',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('layout2')),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Pagination', 'amy-movie-extend'),
	'param_name'	=> 'pagination',
	'std'			=> true,
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
);

$custom_fields		= $movie_helper->get_options_custom_fields();
$defaults_fields	= $movie_helper->get_options_default_fields();

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
	'heading'		=> esc_html__('Show Sort by', 'amy-movie-extend'),
	'param_name'	=> 'show_sortby',
	'group'			=> esc_html__('Filter Options', 'amy-movie-extend'),
	'std'			=> false,
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
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
);

vc_map(array(
	'name' 		=> esc_html__('V1 - Movie Grid', 'amy-movie-extend'),
	'base' 		=> 'moviegrid',
	'icon' 		=> 'fa fa-th-large',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> $params
));
