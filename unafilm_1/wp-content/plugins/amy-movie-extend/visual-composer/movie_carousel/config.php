<?php
use AmyMovie\Shortcode\VisualComposer;

$vc     = new VisualComposer();
$params = $vc->default_params();

$params[] = [
	'type' 	   		=> 'textfield',
	'heading'	 	=> esc_html__('Title', 'amy-movie-extend'),
	'param_name' 	=> 'title',
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
];

$params[] = [
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__('Post Per Page', 'amy-movie-extend'),
	'param_name' 	=> 'posts_per_page',
	'value' 		=> 20,
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
];

$params[] = [
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Post show in slide', 'amynews'),
	'param_name'	=> 'post_slideshow',
	'value'			=> 4,
	'group'			=> esc_html__('Layout Options', 'amynews'),
];

$params[] = [
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Arrows', 'amy-movie-extend'),
	'param_name'	=> 'show_arrows',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
];

$params[] = [
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Dots', 'amy-movie-extend'),
	'param_name'	=> 'show_dots',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
];

$params[] = [
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'value'			=> '',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
];

$params[] = [
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Infinite', 'amy-movie-extend'),
	'param_name'	=> 'infinite',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
];

$params[] = [
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Auto Play', 'amy-movie-extend'),
	'param_name'	=> 'autoplay',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
];

$params[] = [
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Auto Play Speed', 'amy-movie-extend'),
	'param_name'	=> 'autoplayspeed',
	'value'			=> 3000,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
];

$params[] = [
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Center Mode', 'amy-movie-extend'),
	'param_name'	=> 'centerMode',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
];

vc_map([
	'name' 		=> esc_html__('V1 - Movie Carousel', 'amy-movie-extend'),
	'base' 		=> 'moviecarousel',
	'icon' 		=> 'fa fa-bars',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> $params
]);
