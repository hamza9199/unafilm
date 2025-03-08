<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 * Get sidebar name.
 */
if (! function_exists('amy_movie_get_sidebar_name')) {
	function amy_movie_get_sidebar_name($name) {
		if (empty($GLOBALS['wp_registered_sidebars'])) {
			return $name;
		}

		$sidebars	= get_option('stag_custom_sidebars');
		$taken		= array();

		foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
			$taken[]	= $sidebar['name'];
		}

		if (empty($sidebars)) {
			$sidebars	= array();
		}

		$taken	= array_merge($taken, $sidebars);

		if (in_array($name, $taken)) {
			$counter 	= substr($name, -1);

			if (! is_numeric($counter)) {
				$new_name	= $name . ' 1';
			} else {
				$new_name	= substr($name, 0, -1) . ((int) $counter + 1);
			}

			$name = amy_movie_get_sidebar_name($new_name);
		}

		return $name;
	}
}

/**
 * Get registered sidebars
 */
if (! function_exists('amy_movie_wp_registered_sidebars')) {
	function amy_movie_wp_registered_sidebars() {
		global $wp_registered_sidebars;

		$widgets	= array();

		if (! empty($wp_registered_sidebars)) {
			foreach ($wp_registered_sidebars as $key => $value) {
				$widgets[ $key ]	= $value['name'];
			}
		}

		return array_reverse($widgets);
	}
}

/**
 * encapsulates post-classes to use them on different tags
 */
if (! function_exists('amy_movie_get_post_classes')) {
	function amy_movie_get_post_classes($classes = array()) {
		// Adds a class for microformats v2
		$classes[] = 'h-entry';

		// add hentry to the same tag as h-entry
		$classes[] = 'hentry';

		// adds microformats 2 activity-stream support
		// for pages and articles
		if (get_post_type() === 'page') {
			$classes[] = 'h-as-page';
		}
		if (! get_post_format() && 'post' === get_post_type()) {
			$classes[] = 'h-as-article';
		}

		// adds some more microformats 2 classes based on the
		// posts "format"
		switch (get_post_format()) {
			case 'aside':
			case 'status':
				$classes[] = 'h-as-note';
				break;
			case 'audio':
				$classes[] = 'h-as-audio';
				break;
			case 'video':
				$classes[] = 'h-as-video';
				break;
			case 'gallery':
			case 'image':
				$classes[] = 'h-as-image';
				break;
			case 'link':
				$classes[] = 'h-as-bookmark';
				break;
		}

		return array_unique($classes);
	}
}

/**
 * add semantics
 *
 * @param string $id the class identifier
 * @return array
 */
if (! function_exists('amy_movie_get_semantics')) {
	function amy_movie_get_semantics($id = null) {
		$classes = array();

		// add default values
		switch ($id) {
			case 'body':
				if (! is_singular()) {
					$classes['itemscope'] 	= array('');
					$classes['itemtype'] 	= array('http://schema.org/Blog');
				} elseif (is_single()) {
					$classes['itemscope'] 	= array('');
					$classes['itemtype'] 	= array('http://schema.org/BlogPosting');
				} elseif (is_page()) {
					$classes['itemscope'] 	= array('');
					$classes['itemtype'] 	= array('http://schema.org/WebPage');
				}

				break;
			case 'site-title':
				if (! is_singular()) {
					$classes['itemprop'] 	= array('name');
					$classes['class'] 		= array('p-name');
				}

				break;
			case 'site-description':
				if (! is_singular()) {
					$classes['itemprop'] 	= array('description');
					$classes['class'] 		= array('p-summary', 'e-content');
				}

				break;
			case 'site-url':
				if (! is_singular()) {
					$classes['itemprop'] 	= array('url');
					$classes['class'] 		= array('u-url', 'url');
				}

				break;
			case 'post':
				if (! is_singular()) {
					$classes['itemprop'] 	= array('blogPost');
					$classes['itemscope'] 	= array('');
					$classes['itemtype'] 	= array('http://schema.org/BlogPosting');
				}

				break;
		}

		$classes = apply_filters('amy_movie_semantics', $classes, $id);
		$classes = apply_filters("amy_movie_semantics_{$id}", $classes, $id);

		return $classes;
	}
}

/**
 * echos the semantic classes added via
 *
 * @param string $id the class identifier
 */
if (! function_exists('amy_movie_semantics')) {
	function amy_movie_semantics($id) {
		$classes = amy_movie_get_semantics($id);

		if (! $classes) {
			return;
		}

		foreach ($classes as $key => $value) {
			echo ' ' . esc_attr($key) . '="' . esc_attr(join(' ', $value)) . '"';
		}
	}
}

/*
 * Social List
 */
if (! function_exists('amy_movie_social_list')) {
	function amy_movie_social_list() {
		$social_list = amy_get_option('social_list');

		$html = '<ul class="amy-social-list">';

		if (!empty($social_list)) {
			foreach ($social_list as $social) {
				$html .= '<li><a href="' . esc_url(amy_movie_get_value_in_array($social, 'link')) . '" class="' . esc_attr(amy_movie_get_value_in_array($social, 'icon')) . '"></a></li>';
			}
		}

		$html .= '</ul>';

		return $html;
	}
}

/*
 * Login / Register
 */
if (! function_exists('amy_movie_user')) {
	function amy_movie_user() {
		$html  = '<div class="box-user">';

		if (is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$html .= '<span>' . esc_html__('Hello ', 'amy-movie') . $current_user->display_name . ',</span>';
			$html .= '<a href="' . wp_logout_url() . '">' . esc_html__('Log Out', 'amy-movie') . '</a>';
		} else {
			if (function_exists('amy_user_popup')) {
				$html .= amy_user_popup();
			} else {
				$html .= '<a href="' . esc_url(home_url('/wp-login.php')) . '"><i aria-hidden="true" class="fa fa-user"></i>' . esc_html__('Login', 'amy-movie') . '</a>';

				if (get_option('users_can_register')) {
					$html	.= '<a href="' . esc_url(home_url('/wp-login.php?action=register')) . '">' . esc_html__('Register', 'amy-movie') . '</a>';
				}
			}
		}

		$html .= '</div>';

		return $html;
	}
}

/*
 * Show Menu by ID
 */
if (! function_exists('amy_movie_menu_item')) {
	function amy_movie_menu_item($slug) {
		$menu = wp_get_nav_menu_items($slug);

		$html  = '<div class="amy-menu">';
		$html .= '<ul class="menu">';

		if (!empty($menu)) {
			foreach ($menu as $item) {
				$html .= '<li class="menu-item">';
				$html .= '<a href="' . esc_url($item->url) . '">' . esc_attr($item->title) . '</a>';
				$html .= '</li>';
			}
		}

		$html .= '</ul></div>';

		return $html;
	}
}