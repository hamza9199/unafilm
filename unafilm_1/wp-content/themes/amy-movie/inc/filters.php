<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 * Custom wp_title for seo plugins integration.
 */
if (! function_exists('amy_movie_filter_wp_title')) {
	function amy_movie_filter_wp_title($title, $sep) {
		if (is_feed()) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo('name', 'display');

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && (is_home() || is_front_page())) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if (($paged >= 2 || $page >= 2) && ! is_404()) {
			$title .= " $sep " . sprintf(esc_html__('Page %s', 'amy-movie'), max($paged, $page));
		}
		return $title;
	}

	add_filter('wp_title', 'amy_movie_filter_wp_title', 10, 2);
}

/**
 * Set body class for header options.
 */
if (! function_exists('amy_movie_filter_body_class')) {
	function amy_movie_filter_body_class($classes) {
		$boxed_layout	= amy_get_option('boxed_layout') ? 'amy-boxed-layout' : '';
		$header_style	= amy_get_option('header_style');

		$classes[]	= "amy-header-$header_style $boxed_layout";

		// Adds a class of single-author to blogs with only 1 published author
		if (! is_multi_author()) {
			$classes[] = 'single-author';
		}

		if (! is_singular()) {
			$classes[] = 'hfeed';
			$classes[] = 'h-feed';
			$classes[] = 'feed';
		}

		return $classes;
	}

	add_filter('body_class', 'amy_movie_filter_body_class');
}

/**
 * Adds custom classes to the array of post classes.
 */
if (! function_exists('amy_movie_filter_post_classes')) {
	function amy_movie_filter_post_classes($classes) {
		$classes = array_diff($classes, array('hentry'));

		if (! is_singular()) {
			return amy_movie_get_post_classes($classes);
		} else {
			return $classes;
		}
	}

	add_filter('post_class', 'amy_movie_filter_post_classes', 99);
}

/**
 * Adds custom classes to the array of comment classes.
 */
if (! function_exists('amy_movie_filter_comment_classes')) {
	function amy_movie_filter_comment_classes($classes) {
		$classes[] = 'h-as-comment';
		$classes[] = 'h-entry';
		$classes[] = 'h-cite';
		$classes[] = 'p-comment';
		$classes[] = 'comment';

		return array_unique($classes);
	}

	add_filter('comment_class', 'amy_movie_filter_comment_classes', 99);
}

/**
 * Adds microformats v2 support to the comment_author_link.
 */
if (! function_exists('amy_movie_author_link')) {
	function amy_movie_author_link($link) {
		// Adds a class for microformats v2
		return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link);
	}

	add_filter('get_comment_author_link', 'amy_movie_author_link');

}

/**
 * Add wrapper to widget content.
 */
if (! function_exists('amy_movie_filter_widget_text')) {
	function amy_movie_filter_widget_text($content) {
		$content	= '<div class="amy-widget-content">' . $content . '</div>';

		return $content;
	}

	add_filter('widget_text', 'amy_movie_filter_widget_text');
}

if (! function_exists('amy_movie_filter_widget_nav_menu_args')) {
	function amy_movie_filter_widget_nav_menu_args($nav_menu_args) {
		$nav_menu_args['container_class']	= 'amy-widget-content';

		return $nav_menu_args;
	}

	add_filter('widget_nav_menu_args', 'amy_movie_filter_widget_nav_menu_args');
}

