<?php
use AmyMovie\Core\Template;

if (!function_exists('movieblog')) {
	function movieblog($atts, $content = '', $key = '') {
	    $template = new Template();
		extract(shortcode_atts(array(
			'title'					=> '',
			'category'				=> '',
			'layout'				=> 'layout1',
			'post_orderby'			=> 'date',
			'post_order'			=> 'DESC',
			'post_date'				=> 'alltime',
			'class'					=> '',

		), $atts));

		/*
		 * Code now
		 */
		if ($category != '') {
			$cat_query = array(
				'taxonomy'	=> 'category',
				'field'		=> 'term_id',
				'terms'		=> $category,
			);
		} else {
			$cat_query = '';
		}

		if ($layout == 'layout1') {
			$per_page = '5';
		} else if ($layout == 'layout2') {
			$per_page = '3';
		}

		$query_date = array();

		if ($post_date == 'day') {
			$query_date = array(
				array(
					'after'	=> '24 hours ago',
				),
			);
		} else if ($post_date == 'week') {
			$query_date = array(
				array(
					'after'	=> '1 week ago',
				),
			);
		} else if ($post_date == 'month') {
			$query_date = array(
				array(
					'after'	=> '1 month ago',
				),
			);
		}

		$arpg = array(
			'date_query'		=> $query_date,
			'posts_per_page'	=> $per_page,
			'orderby'			=> $post_orderby,
			'order'				=> $post_order,
			'ignore_sticky_posts' => 1,
		);

		$blog_query = new WP_Query($arpg);

		$html = [];

		ob_start();

		$data = [
            'blog_query'    => $blog_query,
            'title'         => $title,
            'class'         => $class,
            'layout'        => $layout
        ];

		$template->set_template_data($data)->get_template_part('/shortcode/blog');

		$html[] = ob_get_clean();

		return implode('', $html);
	}

	add_shortcode('movieblog', 'movieblog');
}
