<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

// font awesome
wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/vendor/font-awesome.css', array(), '5.15.4');

if (!class_exists('Amy_Movie_Helper')) {
    wp_enqueue_style('google-font-roboto-condensed', 'https://fonts.googleapis.com/css?family=Roboto+Condensed', array(), '1.0.0');
}

/**
 ******************************************
 *  SITE STYLE
 * ******************************************
 */
wp_enqueue_style('slick-style', 			get_template_directory_uri() . '/css/vendor/slick.css', array());
wp_enqueue_style('slick-theme', 			get_template_directory_uri() . '/css/vendor/slick-theme.css', array());
wp_enqueue_style('fancybox', 				get_template_directory_uri() . '/css/vendor/jquery.fancybox.css', array(), '3.5.7');

//V2 style
wp_enqueue_style('tooltipster', 	get_template_directory_uri() . '/css/vendor/tooltipster.bundle.css', array(), '1.0.0');
wp_enqueue_style('mCustomScrollbar', 	get_template_directory_uri() . '/css/vendor/jquery.mCustomScrollbar.css', array(), '1.0.0');
wp_enqueue_style('plyr', 		get_template_directory_uri() . '/css/vendor/plyr.css', array(), '1.0.0');

/**
 *********************************************
 *  PLUGIN/SHORTCODE SCRIPT
 * *********************************************
 */
// Widget UI
wp_enqueue_script( 'jquery-ui-widget', false, array('jquery') );

// Slick
wp_enqueue_script('slick', 				get_template_directory_uri() . '/js/vendor/slick.min.js', array('jquery'), '1.6.0', true);

// Metro Slider
wp_enqueue_script('isotope-pkd', 		get_template_directory_uri() . '/js/vendor/isotope.pkgd.js', array('jquery'), '3.0.1', true);
wp_enqueue_script('masonry-horizontal', get_template_directory_uri() . '/js/vendor/masonry-horizontal.js', array('isotope-pkd'), '2.0.0', true);
wp_enqueue_script('kinetic', 			get_template_directory_uri() . '/js/vendor/kinetic.js', array('jquery'), '2.0.1', true);
wp_enqueue_script('smooth-scroll', 		get_template_directory_uri() . '/js/vendor/smoothdivscroll.js', array('jquery'), '1.3', true);

// MouseWheel
wp_enqueue_script('mousewheel', 		get_template_directory_uri() . '/js/vendor/jquery.mousewheel.min.js', array(), '3.1.11', true);

// Date Picker
wp_enqueue_script('jquery-ui-datepicker');

// Fancybox
wp_enqueue_script('fancybox', 			get_template_directory_uri() . '/js/vendor/jquery.fancybox.js', array(), '3.5.7', true);

// Tab
wp_enqueue_script('bootstrap-tab', 		get_template_directory_uri() . '/js/vendor/bootstrap-tab.js', array('jquery'), '3.3.6', true);

//woocommerce
if (class_exists('WooCommerce')) {
	wp_enqueue_script('amyui-number-input', get_template_directory_uri() . '/js/vendor/amyui-number-input.js', array('jquery'), '1.0.0', true);
}

//V2 script
wp_enqueue_script('imagesloaded');
wp_enqueue_script('tooltipster', 		get_template_directory_uri() . '/js/vendor/tooltipster.bundle.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('waterwheelCarousel', 	get_template_directory_uri() . '/js/vendor/jquery.waterwheelCarousel.js', array('jquery'), '2.3.0', true);
wp_enqueue_script('TweenMax', 				get_template_directory_uri() . '/js/vendor/TweenMax.min.js', array('jquery'), '1.15.1', true);
wp_enqueue_script('mCustomScrollbar', 		get_template_directory_uri() . '/js/vendor/jquery.mCustomScrollbar.js', array('jquery'), '3.1.5', true);
wp_enqueue_script('plyr', 				get_template_directory_uri() . '/js/vendor/plyr.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('reflection', 			get_template_directory_uri() . '/js/vendor/reflection.js', array('jquery'), '1.11.0', true);

if (is_singular() && comments_open() && get_option('thread_comments')) {
	wp_enqueue_script('comment-reply');
}

wp_enqueue_style('amy-movie-style', get_template_directory_uri() . '/css/style.css', array(), '1.0.0');

if (is_rtl()) {
	wp_enqueue_style('amy-movie-style-rtl', get_template_directory_uri() . '/css/rtl.css', array(), '1.0.0');
}

$custom_css		= amy_get_option('custom_css');

if ($custom_css) {
	wp_add_inline_style('amy-movie-style', wp_specialchars_decode($custom_css));
}

wp_enqueue_script('amy-movie-script',	get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true);

$custom_js = amy_get_option('custom_js');

if ($custom_js) {
	wp_add_inline_script('amy-movie-script', $custom_js);
}

if (is_rtl()) {
	$rtl = true;
} else {
	$rtl = false;
}

wp_localize_script('amy-movie-script', 'amy_script', array(
	'ajax_url' 				=> admin_url('admin-ajax.php'),
	'viewport'				=> amy_get_option('menu_max_width'),
	'site_url'				=> esc_url(home_url('/')),
	'theme_url'				=> get_template_directory_uri(),
	'enable_fb_login'		=> amy_get_option('enable_fb_login'),
	'fb_app_id'				=> amy_get_option('fb_app_id'),
	'enable_google_login'	=> amy_get_option('enable_google_login'),
	'gg_app_id'				=> amy_get_option('gg_app_id'),
	'gg_client_id'			=> amy_get_option('gg_client_id'),
	'amy_rtl'				=> $rtl,
	'amy_rate_already'		=> esc_html__('You already rate a movie', 'amy-movie'),
	'amy_rate_done'			=> esc_html__('You vote done', 'amy-movie')
));
