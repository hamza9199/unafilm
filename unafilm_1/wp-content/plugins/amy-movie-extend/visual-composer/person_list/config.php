<?php
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;

$params				= array();
$base               = new Base();
$movie              = new MovieHelpers();

$custom_fields		= $base->get_option('movie_custom_fields');
$defaults_fields	= $base->get_option('movie_default_fields', $movie->default_fields());

$person_options 	= array();
$person_options[esc_html__('Please chosen person', 'amy-movie-extend')] 	= '';

if (!empty($defaults_fields)) {
	foreach ($defaults_fields as $field) {
		if ($field == 'movie_actor') {
			$person_options[esc_html__('Actor', 'amy-movie-extend')] = 'amy_actor';
		}

		if ($field == 'movie_director') {
			$person_options[esc_html__('Director', 'amy-movie-extend')] = 'amy_director';
		}
	}
}

if (!empty($custom_fields)) {
	foreach ($custom_fields as $field) {
		if ($field['type'] == 'person') {
			$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
			$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

			$person_options[$field['name']]	= $singular_name;
		}
	}
}

$params[] = array(
	'type'				=> 'dropdown',
	'heading'			=> esc_html__('Person', 'amy-movie-extend'),
	'param_name'		=> 'person',
	'admin_label'		=> true,
	'value'				=> $person_options,
	'group'				=> esc_html__('Query Option', 'amy-movie-extend')
);

//order by
$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Order By', 'amy-movie-extend'),
	'param_name'	=> 'orderby',
	'value'		=> array(
		esc_html__('Person ID', 'amy-movie-extend')			=> 'ID',
		esc_html__('Title', 'amy-movie-extend')			=> 'title',
		esc_html__('Date', 'amy-movie-extend')				=> 'date',
		esc_html__('Random Order', 'amy-movie-extend')		=> 'rand',
	),
	'std'	=> 'date',
	'group'	=> esc_html__('Query Option', 'amy-movie-extend')
);

//order
$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Sort order', 'amy-movie-extend'),
	'param_name'	=> 'order',
	'value'			=> array(
		esc_html__('Descending', 'amy-movie-extend')	=> 'DESC',
		esc_html__('Ascending', 'amy-movie-extend')	=> 'ASC',
	),
	'std'			=> 'DESC',
	'group'			=> esc_html__('Query Option', 'amy-movie-extend')
);

//post per page
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Person', 'amy-movie-extend'),
	'param_name'	=> 'posts_per_page',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//layout
$params[] =	array(
	'type' 			=> 'vc_amy_image_select',
	'heading' 		=> 'Layout',
	'param_name' 	=> 'layout',
	'options' 		=> array(
		'grid' 		=> AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/person-grid.png',
		'list' 		=> AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/person-list.png',
		'list-text'	=> AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/person-list-text.png',
	),
	'std'			=> 'grid',
	'admin_label'	=> true,
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//Columns
$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Columns', 'amy-movie-extend'),
	'param_name'	=> 'columns',
	'value'			=> array(
		esc_html__('2', 'amy-movie-extend')	=> '2',
		esc_html__('3', 'amy-movie-extend')	=> '3',
		esc_html__('4', 'amy-movie-extend')	=> '4',
		esc_html__('6', 'amy-movie-extend')	=> '6',
	),
	'std'			=> '4',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('grid', 'list-text')),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Pagination', 'amy-movie-extend'),
	'param_name'	=> 'pagination',
	'std'			=> true,
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('grid', 'list')),
);

//extra class
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

vc_map(array(
	'name' 				=> esc_html__('Person List', 'amy-movie-extend'),
	'base' 				=> 'amy_movie_person_list',
	'icon'				=> 'fa fa-users',
	'is_container'   	=> true,
	'category' 			=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 			=> $params
));