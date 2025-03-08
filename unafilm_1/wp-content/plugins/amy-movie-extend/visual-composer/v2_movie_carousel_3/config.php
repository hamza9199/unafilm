<?php
use AmyMovie\Shortcode\VisualComposer;

$vc     = new VisualComposer();
$params = $vc->default_params();

//post per page
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Movies', 'amy-movie-extend'),
	'param_name'	=> 'posts_per_page',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Trailer', 'amy-movie-extend'),
	'param_name'	=> 'show_trailer',
	'std'			=> true,
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//extra class
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

vc_map(array(
	'name' 				=> esc_html__('V2 - Movie Carousel 3', 'amy-movie-extend'),
	'base' 				=> 'amy_v2_movie_carousel_3',
	'icon'				=> 'fa fa-film',
	'is_container'   	=> true,
	'category' 			=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 			=> $params
));