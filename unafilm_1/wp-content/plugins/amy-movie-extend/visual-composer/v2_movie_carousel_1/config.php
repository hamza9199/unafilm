<?php
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Shortcode\ShortcodeGeneral;

$sc_general = new ShortcodeGeneral();
$vc         = new VisualComposer();
$params     = $vc->default_params();

//post per page
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Movies', 'amy-movie-extend'),
	'param_name'	=> 'posts_per_page',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//tooltip type
$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Tooltip Type', 'amy-movie-extend'),
	'param_name'	=> 'tooltip',
	'value'			=> array(
		esc_html__('Dark', 'amy-movie-extend')	=> 'dark',
		esc_html__('Light', 'amy-movie-extend')	=> 'light',
		esc_html__('None', 'amy-movie-extend')	=> 'none',
	),
	'std'			=> 'dark',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show button all', 'amy-movie-extend'),
	'param_name'	=> 'show_button_all',
	'std'			=> false,
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Button all Text', 'amy-movie-extend'),
	'param_name'	=> 'all_custom_text',
	'dependency'	=> array('element' => 'show_button_all', 'value' => array('1')),
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Button all custom link', 'amy-movie-extend'),
	'param_name'	=> 'all_custom_link',
	'dependency'	=> array('element' => 'show_button_all', 'value' => array('1')),
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

//General Fields Front
$general_fields_front_value = array(
	esc_html__('Title', 'amy-movie-extend') => 'title',
	esc_html__('MPAA', 'amy-movie-extend')	=> 'mpaa',
	esc_html__('Imdb', 'amy-movie-extend')	=> 'imdb',
	esc_html__('Release Date', 'amy-movie-extend')	=> 'release_date'
);

$general_fields_front_std 	= array('title', 'mpaa', 'imdb', 'release_date');

$params[] = array(
	'type'			=> 'vc_amy_chosen',
	'heading'		=> esc_html__('Show Fields - Front', 'amy-movie-extend'),
	'param_name'	=> 'general_fields_front',
	'value'			=> $general_fields_front_value,
	'std'			=> implode(',', $general_fields_front_std),
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

//General Fields Tooltip
$general_fields_tooltip_value 	= array(
	esc_html__('Title', 'amy-movie-extend') 				=> 'title',
	esc_html__('Content', 'amy-movie-extend')			=> 'content',
	esc_html__('Button Tralier', 'amy-movie-extend')		=> 'tralier',
	esc_html__('Button Detail', 'amy-movie-extend')		=> 'detail',
	esc_html__('Rating', 'amy-movie-extend')				=> 'rate',
	esc_html__('MPAA', 'amy-movie-extend')				=> 'mpaa',
	esc_html__('Imdb', 'amy-movie-extend')				=> 'imdb',
	esc_html__('Duration', 'amy-movie-extend')			=> 'duration'
);

$general_fields_tooltip_std		= array('title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration');

$params[] = array(
	'type'			=> 'vc_amy_chosen',
	'heading'		=> esc_html__('Show General Fields - Back (Tooltip)', 'amy-movie-extend'),
	'param_name'	=> 'general_fields_tooltip',
	'value'			=> $general_fields_tooltip_value,
	'std'			=> implode(',', $general_fields_tooltip_std),
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'vc_amy_chosen',
	'heading'		=> esc_html__('Show Custom Fields - Back (Tooltip)', 'amy-movie-extend'),
	'param_name'	=> 'list_fields_visible',
	'value'			=> $sc_general->list_fields_config_visiable(),
	'group'       	=> esc_html__('Layout Option', 'amy-movie-extend'),
	'std'			=> 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema'
);

//extra class
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

//slide options
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Slide', 'amy-movie-extend'),
	'param_name'	=> 'number_slide',
	'group'			=> esc_html__('Slides Option', 'amy-movie-extend'),
	'std'			=> 8
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show Arrows', 'amy-movie-extend'),
	'param_name'	=> 'show_arrows',
	'group'			=> esc_html__('Slides Option', 'amy-movie-extend'),
	'std'			=> true,
);

$params[] =	array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Infinite', 'amy-movie-extend'),
	'param_name'	=> 'infinite',
	'std'			=> true,
	'group'			=> esc_html__('Slides Option', 'amy-movie-extend'),
);

$params[] =	array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Auto Play', 'amy-movie-extend'),
	'param_name'	=> 'autoplay',
	'std'			=> true,
	'group'			=> esc_html__('Slides Option', 'amy-movie-extend'),
);

$params[] =	array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Auto Play Speed', 'amy-movie-extend'),
	'param_name'	=> 'autoplayspeed',
	'value'			=> 3000,
	'group'			=> esc_html__('Slides Option', 'amy-movie-extend'),
);

vc_map(array(
	'name' 				=> esc_html__('V2 - Movie Carousel 1', 'amy-movie-extend'),
	'base' 				=> 'amy_v2_movie_carousel_1',
	'icon'				=> 'fa fa-film',
	'is_container'   	=> true,
	'category' 			=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 			=> $params
));