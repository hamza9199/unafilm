<?php
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Template;

if (!function_exists('movieratelist')) {
	function movieratelist($atts, $content = '', $key = '') {
        $movie_query    = new MovieQuery();
        $template       = new Template();

		extract(shortcode_atts(array(
			/*
			 * General
			 */
			'title'						=> '',
			'genre'						=> '',
			'movie_number'				=> '7',
			'orderby'				=> 'date',
			'movie_order'				=> 'DESC',
			'movie_date'				=> 'alltime',

			'class'						=> '',
			'filter_style'				=> 'style1',
			'pagination'				=> true,
		), $atts));

		/*
		 * Code now
		 */

		// Custom query
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params = array();

		$params['movie_date']		= $movie_date;
		$params['movie_genre']		= $genre;
		$params['orderby']	= $orderby;
		$params['movie_order']		= $movie_order;
		$params['movie_per_page']	= $movie_number;
		$params['paged']			= $paged;

		$arpg 		= $movie_query->build($params);
		$the_query 	= new WP_Query($arpg);
		$max   		= intval($the_query->max_num_pages);
		$data		= $the_query->posts;

        $html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('data', $data);
        set_query_var('pagination', $pagination);
        set_query_var('max', $max);
        set_query_var('movie_number', $movie_number);
        $template->get_template_part('/shortcode/rate-list');

        $html[] = ob_get_clean();

		return implode('', $html);
	}

	add_shortcode('movieratelist', 'movieratelist');
}

