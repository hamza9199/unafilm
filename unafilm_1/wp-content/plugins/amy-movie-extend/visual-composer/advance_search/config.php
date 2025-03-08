<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Base;

$base   = new Base();
$movie  = new MovieHelpers();

$custom_fields		= $base->get_option('movie_custom_fields');
$defaults_fields	= $base->get_option('movie_default_fields', $movie->default_fields());

$params				= [];
$person_options 	= [];

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
	'type'				=> 'vc_amy_chosen',
	'heading'			=> esc_html__('Chosen Filters Show', 'amy-movie-extend'),
	'param_name'		=> 'filters',
	'admin_label'		=> true,
	'value'				=> $person_options,
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'value'			=> '',
);

vc_map(array(
	'name' 		=> esc_html__('Advance Search', 'amy-movie-extend'),
	'base' 		=> 'amy_movie_advance_search',
	'icon' 		=> 'fa fa-search',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> $params,
));
