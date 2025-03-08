<?php
use AmyMovie\Shortcode\VisualComposer;

$vc     = new VisualComposer();
$params = $vc->default_params();

$params[] = array(
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__('Post Per Page', 'amy-movie-extend'),
	'param_name' 	=> 'posts_per_page',
	'value' 		=> 5,
	'group'       	=> esc_html__('Layout Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Title', 'amy-movie-extend'),
	'param_name'	=> 'show_title',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Release Date', 'amy-movie-extend'),
	'param_name'	=> 'show_release',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Content', 'amy-movie-extend'),
	'param_name'	=> 'show_content',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Button', 'amy-movie-extend'),
	'param_name'	=> 'show_button',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Arrows', 'amy-movie-extend'),
	'param_name'	=> 'show_arrows',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Dots', 'amy-movie-extend'),
	'param_name'	=> 'show_dots',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'value'			=> '',
	'group'			=> esc_html__('Layout Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Infinite', 'amy-movie-extend'),
	'param_name'	=> 'infinite',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Auto Play', 'amy-movie-extend'),
	'param_name'	=> 'autoplay',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
);
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Auto Play Speed', 'amy-movie-extend'),
	'param_name'	=> 'autoplayspeed',
	'value'			=> 3000,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Fade', 'amy-movie-extend'),
	'param_name'	=> 'fade',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('useCSS', 'amy-movie-extend'),
	'param_name'	=> 'usecss',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
	'description'	=> esc_html__('Enable/Disable CSS Transitions', 'amy-movie-extend'),
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('useTransform', 'amy-movie-extend'),
	'param_name'	=> 'usetransform',
	'std'			=> true,
	'group'			=> esc_html__('Slides Options', 'amy-movie-extend'),
	'description'	=> esc_html__('Enable/Disable CSS Transforms', 'amy-movie-extend'),
);

vc_map(array(
	'name' 		=> esc_html__('V1 - Movie Slide', 'amy-movie-extend'),
	'base' 		=> 'movieslide',
	'icon' 		=> 'fa fa-sliders',
	'category' 	=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 	=> $params
));
