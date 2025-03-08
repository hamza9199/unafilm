<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 * RIGHT SIDEBAR
 */
register_sidebar(array(
	'id'			=> 'right-bar',
	'name'			=> esc_html__('Right Bar', 'amy-movie'),
	'description'	=> esc_html__('Drag widgets for all of pages sidebar', 'amy-movie'),
	'before_widget'	=> '<div class="amy-widget %2$s">',
	'after_widget'	=> '<div class="clear"></div></div>',
	'before_title'	=> '<div class="amy-widget-title"><h4>',
	'after_title'	=> '</h4></div>',
));

/**
 * MOVIE SIDEBAR
 */
register_sidebar(array(
	'id'			=> 'movie-bar',
	'name'			=> esc_html__('Movie Bar', 'amy-movie'),
	'description'	=> esc_html__('Drag widgets for all of pages sidebar', 'amy-movie'),
	'before_widget'	=> '<div class="amy-widget %2$s">',
	'after_widget'	=> '<div class="clear"></div></div>',
	'before_title'	=> '<div class="amy-widget-title"><h4>',
	'after_title'	=> '</h4></div>',
));

/**
 * HEADER WIDGETS
 */
$header = amy_get_option('header_style', 'default');

if ($header == 'left') {
	register_sidebar(array(
		'id'			=> 'amy-logo-right',
		'name'			=> esc_html__('Amy logo right', 'amy-movie'),
		'description'	=> esc_html__('Drag widgets for all of pages sidebar', 'amy-movie'),
		'before_widget'	=> '<div class="amy-widget %2$s">',
		'after_widget'	=> '<div class="clear"></div></div>',
		'before_title'	=> '<div class="amy-widget-title"><h4>',
		'after_title'	=> '</h4></div>',
	));
}

/**
 * FOOTER WIDGETS
 */
$footer_enable  = amy_get_option('enable_footer', false);
$footer_widgets = amy_get_option('footer_widgets');

if ($footer_widgets && $footer_enable == true) {
	$length	= 0;

	switch ($footer_widgets) {
		case 5:
			$length	= 6;
			break;
		case 6:
		case 7:
		case 8:
			$length	= 3;
			break;
		case 9:
		case 10:
			$length	= 4;
			break;
		default:
			$length	= $footer_widgets;
			break;
	}

	for ($i = 0; $i < $length; $i++) {
		$num	= $i + 1;

		register_sidebar(array(
			'id'			=> 'footer-' . $num,
			'name'			=> sprintf(esc_html__('Footer Widgets %d', 'amy-movie'), $num),
			'description'	=> esc_html__('Drag widgets for all of pages sidebar', 'amy-movie'),
			'before_widget'	=> '<div class="amy-widget %2$s">',
			'after_widget'	=> '<div class="clear"></div></div>',
			'before_title'	=> '<div class="amy-widget-title"><h4>',
			'after_title'	=> '</h4></div>',
		));
	}
}