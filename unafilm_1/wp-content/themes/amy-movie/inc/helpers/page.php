<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 * Render Page Sidebar.
 */
if (! function_exists('amy_movie_page_sidebar')) {
	function amy_movie_page_sidebar($base = 'right', $layout = 'right') {
		if ($base == $layout) {
			echo '<div class="col-md-4 amy-sidebar-clear">';
			echo '<div class="amy-page-sidebar amy-sidebar-' . $base . '">';
			get_sidebar();
			echo '</div>';
			echo '</div>';
		}
	}
}

/*
 * Generate pagination
 */
if (! function_exists('amy_movie_pagination')) {
	function amy_movie_pagination($args = array()) {
		if (is_front_page() || is_home()) {
			$paged	= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		} else if (is_single()) {
			$paged	= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		} else {
			$paged	= intval(get_query_var('paged'));
		}

		$paged			= $paged ? $paged : 1;
		$pagenum_link	= html_entity_decode(get_pagenum_link());

		if (defined('WP_ADMIN') && WP_ADMIN) {
			$pagenum_link	= $args['current_url'];
		}

		$query_args		= array();
		$url_parts		= explode('?', $pagenum_link);

		if (isset($url_parts[1])) {
			wp_parse_str($url_parts[1], $query_args);
		}

		$pagenum_link	= remove_query_arg(array_keys($query_args), $pagenum_link);
		$pagenum_link	= trailingslashit($pagenum_link) . '%_%';

		$format	= $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';

		if (is_single()) {
			$format	.= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('%#%', 'paged') : '?paged=%#%';
		} else {
			$format	.= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';
		}

		if (is_single() && $paged > 1) {
			$page_arr	= explode('/', $pagenum_link);
			$str_p		= count($page_arr) - 2;
			unset($page_arr[ $str_p ]);

			$pagenum_link	= implode('/', $page_arr);
		}

		remove_query_arg('action');
		remove_query_arg('genreid');
		remove_query_arg('cinemaid');
		remove_query_arg('release');
		remove_query_arg('data_send');

		$links = paginate_links(array(
			'base'		=> $pagenum_link,
			'format'	=> $format,
			'total'		=> $args['max_pages'],
			'current'	=> $paged,
			'mid_size'	=> 1,
			'type'		=> 'array',
			'add_args'	=> array_map('urlencode', $query_args),
			'prev_text'	=> esc_html__('Prev', 'amy-movie'),
			'next_text'	=> esc_html__('Next', 'amy-movie'),
		));

		if ($links) {
			$output	= '<div class="clear"></div>';
			$output	.= '<nav class="amy-pagination">';
			$output	.= '<div class="amy-shadow">';

			foreach ($links as $link) {
				$output	.= $link;
			}

			$output	.= '</div>';
			$output	.= '</nav>';
		}

		return $output;
	}
}

/**
 * Breadcrumb.
 */
if (! function_exists('amy_movie_breadcrumb')) {
	function amy_movie_breadcrumb() {
		if (function_exists('bcn_display')) {
			echo '<div class="amy-breadcrumb">';
			echo bcn_display(true);
			echo '</div>';
		}
	}
}
