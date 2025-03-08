<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

if (!function_exists('movieshowtime')) {
	function movieshowtime($atts, $content = '', $key = '') {
		extract(shortcode_atts(array(
			// General
			'class'			=> '',
			'genre'			=> '',
			'showtime_type'	=> 'all',
		), $atts));

		$current_day = strtotime(current_time('Y/m/d'));

		if ($showtime_type == 'today') {
			$time_query = array(
				'key'		=> '_release',
				'value'		=> $current_day,
				'compare' 	=> '==',
			);
		} else if ($showtime_type == 'cm') {
			$time_query = array(
				'key'		=> '_release',
				'value'		=> $current_day,
				'compare' 	=> '>',
			);
		} else if ($showtime_type == 'all') {
			$time_query = array();
		}

		if ($genre != '') {
			$tax_query_genre = array(
				'taxonomy'	=> 'amy_genre',
				'field'		=> 'term_id',
				'terms'		=> explode(',', $genre),
			);
		} else {
			$tax_query_genre = '';
		}

		$movie_arpg	= array(
			'post_type'	=> 'amy_movie',
			'tax_query'	=> array(
				$tax_query_genre,
			),
			'meta_query'	=> array(
				$time_query
			),
			'posts_per_page'	=> '10',
			'orderby'			=> 'date',
			'order'				=> 'DESC',
		);

		$movie_query 	= new WP_Query($movie_arpg);
		$movie_data		= $movie_query->posts;

		$movie = '<div class="mv-content">';

		foreach ($movie_data as $i => $m) {
			$movie .= '<div><input id="cbm-' . $m->ID . '" type="radio" name="movie_id" value="' . $m->ID . '" /><label class="cbl" for="cbm-' . $m->ID . '">' . $m->post_title . '</label></div>';
		}

		$movie .= '</div>';

		$cinema_list = amy_movie_get_cinema();

		$cinema = '<div class="mv-content">';

		foreach ($cinema_list as $i => $c) {
			$cinema .= '<div><input id="cbc-' . $c->ID . '" type="radio" name="cinema_id" value="' . $c->ID . '" /><label class="cbl" for="cbc-' . $c->ID . '">' . $c->post_title . '</label></div>';
		}

		$cinema .= '</div>';

		$output  = '<div class="amy-shortcode amy-mv-showtime ' . esc_attr($class) . '">';
		$output .= '<input type="hidden" class="showtime-type" name="showtime-type" value="' . $showtime_type . '" />';
		$output .= '<div class="left"><div class="movie-list"><h3><span>1</span>' . esc_html__('Select a Movie', 'amy-movie-extend') . '</h3>' . $movie . '</div></div>';
		$output .= '<div class="right"><div class="cinema-list"><h3><span>2</span>' . esc_html__('Select a Cinema', 'amy-movie-extend') . '</h3>' . $cinema . '</div>';
		$output .= '<div class="list-time"><h3><span>3</span>' . esc_html__('Date & Time', 'amy-movie-extend') . '</h3><div class="mv-content"></div></div></div>';
		$output .= '<div class="clearfix"></div></div>';

		return $output;

	}

	add_shortcode('movieshowtime', 'movieshowtime');
}
