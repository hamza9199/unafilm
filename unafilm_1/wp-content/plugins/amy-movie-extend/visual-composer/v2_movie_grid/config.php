<?php
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Shortcode\ShortcodeGeneral;

$sc_general = new ShortcodeGeneral();
$vc     = new VisualComposer();
$params = $vc->default_params();

//post per page
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Movies', 'amy-movie-extend'),
	'param_name'	=> 'posts_per_page',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//layout
$params[] =	array(
	'type' 			=> 'vc_amy_image_select',
	'heading' 		=> 'Layout',
	'param_name' 	=> 'layout',
	'options' 		=> array(
		'grid-1' 	=> AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/grid_layout1.png',
		'grid-2' 	=> AMY_MOVIE_PLUGIN_URL . '/assets/image/shortcode/grid_layout2.png',
	),
	'std'			=> 'grid-1',
	'admin_label'	=> true,
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
);

//Columns
$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Columns', 'amy-movie-extend'),
	'param_name'	=> 'layout1_columns',
	'value'			=> array(
		esc_html__('2', 'amy-movie-extend')	=> '2',
		esc_html__('3', 'amy-movie-extend')	=> '3',
		esc_html__('4', 'amy-movie-extend')	=> '4',
		esc_html__('5', 'amy-movie-extend')	=> '5',
		esc_html__('6', 'amy-movie-extend')	=> '6',
	),
	'std'			=> '4',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('grid-1')),
);

$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Columns', 'amy-movie-extend'),
	'param_name'	=> 'layout2_columns',
	'value'			=> array(
		esc_html__('2', 'amy-movie-extend')	=> '2',
		esc_html__('3', 'amy-movie-extend')	=> '3',
		esc_html__('4', 'amy-movie-extend')	=> '4',
	),
	'std'			=> '2',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('grid-2')),
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
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend'),
	'dependency'	=> array('element' => 'layout', 'value' => array('grid-1')),
);

//General Fields Tooltip
$general_fields_tooltip_value 	= array(
	esc_html__('Title', 'amy-movie-extend') 			=> 'title',
	esc_html__('Content', 'amy-movie-extend')			=> 'content',
	esc_html__('Button', 'amy-movie-extend')			=> 'tralier',
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
	'heading'		=> esc_html__('Show Custom Fields - (Tooltip with layout 1)', 'amy-movie-extend'),
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

$params[] = array(
	'type'			=> 'vc_amy_on_off',
	'heading'		=> esc_html__('Show button all', 'amy-movie-extend'),
	'param_name'	=> 'show_button_all',
	'std'			=> false,
	'group'			=> esc_html__('Button Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Button all Text', 'amy-movie-extend'),
	'param_name'	=> 'all_custom_text',
	'dependency'	=> array('element' => 'show_button_all', 'value' => array('1')),
	'group'			=> esc_html__('Button Option', 'amy-movie-extend')
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Button all custom link', 'amy-movie-extend'),
	'param_name'	=> 'all_custom_link',
	'dependency'	=> array('element' => 'show_button_all', 'value' => array('1')),
	'group'			=> esc_html__('Button Option', 'amy-movie-extend')
);

//extra class
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'amy-movie-extend'),
	'param_name'	=> 'class',
	'group'			=> esc_html__('Layout Option', 'amy-movie-extend')
);


vc_map(array(
	'name' 				=> esc_html__('V2 - Movie Grid', 'amy-movie-extend'),
	'base' 				=> 'amy_moviegrid_v2',
	'icon'				=> 'fa fa-film',
	'is_container'   	=> true,
	'category' 			=> esc_html__('Amy Movie', 'amy-movie-extend'),
	'params' 			=> $params
));