<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

if (!function_exists('moviesearch')) {
	function moviesearch($atts, $content = '', $key = '') {
		extract(shortcode_atts(array(
			// General
			'show_filter'	=> false,
			'class'			=> ''
		), $atts));

		$output  = '<div class="amy-shortcode amy-mv-search ' . esc_attr($class) . '">';

		$output .= '<form role="search" action="' . site_url('/') . '" method="get" id="searchform">';

		$output .= '<input type="text" name="s" placeholder="' . esc_html__('Movie search...', 'amy-movie-extend') . '" class="input-txt" />';
		$output .= ' <input type="hidden" name="post_type" value="amy_movie" />';
		$output .= '<input type="submit" alt="Search" value="' . esc_html__('Go', 'amy-movie-extend') . '" />';
		$output .= '<input type="hidden" name="amy_type" value="movie" class="amy_type"/>';
		$output .= '</form>';

		$output .= '<div class="search-ajax-content"></div>';
		$output .= '</div>';

		return $output;

	}

	add_shortcode('moviesearch', 'moviesearch');
}
