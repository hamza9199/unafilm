<?php
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Shortcode\ShortcodeGeneral;
use AmyMovie\Core\Base;

$sc_general = new ShortcodeGeneral();
$vc     = new VisualComposer();
$params = $vc->default_params();
$base   = new Base();

//post per page
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Movies', 'amy-movie-extend'),
	'param_name'	=> 'posts_per_page',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//General Fields Tooltip
$general_fields_tooltip_value 	= array(
	esc_html__('Title', 'amy-movie-extend') 			=> 'title',
	esc_html__('Content', 'amy-movie-extend')		=> 'content',
	esc_html__('Button Tralier', 'amy-movie-extend')	=> 'tralier',
	esc_html__('Button Detail', 'amy-movie-extend')	=> 'detail',
	esc_html__('Rating', 'amy-movie-extend')			=> 'rate',
	esc_html__('MPAA', 'amy-movie-extend')			=> 'mpaa',
	esc_html__('Imdb', 'amy-movie-extend')			=> 'imdb',
	esc_html__('Duration', 'amy-movie-extend')		=> 'duration'
);

$general_fields_tooltip_std		= array('title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration');

$params[] = array(
	'type'			=> 'vc_amy_chosen',
	'heading'		=> esc_html__('Show General Fields (Tooltip with layout 1)', 'amy-movie-extend'),
	'param_name'	=> 'general_fields_tooltip',
	'value'			=> $general_fields_tooltip_value,
	'std'			=> implode(',', $general_fields_tooltip_std),
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'vc_amy_chosen',
	'heading'		=> esc_html__('Show Custom Fields', 'amy-movie-extend'),
	'param_name'	=> 'list_fields_visible',
	'value'			=> $sc_general->list_fields_config_visiable(),
	'group'       	=> esc_html__('Layout Option', 'amy-movie-extend'),
	'std'			=> 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema'
);

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Pagination', 'amy-movie-extend'),
	'param_name'	=> 'pagination',
	'std'			=> true,
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

//extra class
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);

//showtime
if ($base->get_option('enable_m_cinema', false)) {
	$params[] = array(
		'type'			=> 'vc_amy_on_off',
		'heading'		=> esc_html__('Show Showtime', 'amy-movie-extend'),
		'param_name'	=> 'show_showtime',
		'std'			=> false,
		'group'       	=> esc_html__('Showtime Option', 'amy-movie-extend'),
	);

	$params[] = array(
		'type'			=> 'dropdown',
		'heading'		=> esc_html__('Showtime type', 'amy-movie-extend'),
		'param_name'	=> 'showtime_type',
		'value'			=> array(
			esc_html__('Only Today', 'amy-movie-extend')	=> 'today',
			esc_html__('All Days', 'amy-movie-extend')		=> 'all',
			esc_html__('Coming Soon', 'amy-movie-extend')	=> 'cm',
		),
		'std'			=> 'all',
		'group'       	=> esc_html__('Showtime Option', 'amy-movie-extend'),
		'dependency'	=> array('element' => 'show_showtime', 'value' => array('1')),
	);
}

vc_map(array(
	'name' 				=> esc_html__('V2 - Movie List', 'amy-movie-extend'),
	'base' 				=> 'movielist_v2',
	'icon'				=> 'fa fa-film',
	'is_container'   	=> true,
	'category' 			=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 			=> $params
));



