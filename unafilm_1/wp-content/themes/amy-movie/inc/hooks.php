<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 * After setup theme
 */
if (! function_exists('amy_movie_action_after_theme_setup')) {
	function amy_movie_action_after_theme_setup() {
		global $content_width;

		if (! isset($content_width)) {
			$content_width	= 1170;
		}

		// Make theme available for translation.
		load_theme_textdomain('amy-movie', get_template_directory() . '/languages');

		add_theme_support('automatic-feed-links');
		add_theme_support('post-formats', array('image', 'video'));
		add_theme_support('post-thumbnails');
		add_theme_support('title-tag');
		add_theme_support('custom-background');
		add_theme_support('custom-header');
		add_theme_support('editor_style');

		add_theme_support('widgets');

		add_editor_style();

		remove_theme_support('custom-header');

		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		add_theme_support('microformats2');
		add_theme_support('microformats');
		add_theme_support('microdata');
	}

	add_action('after_setup_theme', 'amy_movie_action_after_theme_setup');
}

/**
 * Add admin script.
 */
if (! function_exists('amy_movie_action_admin_enqueue_scripts')) {
	function amy_movie_action_admin_enqueue_scripts() {
		wp_enqueue_style('jquery-ui-datepicker', 	get_template_directory_uri() . '/css/admin-style.css');
		wp_enqueue_style('fancybox', 				get_template_directory_uri() . '/css/vendor/jquery.fancybox.css', array());

		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('tagsinput', 			get_template_directory_uri() . '/js/jquery.tagsinput.js', array('jquery'), '1.3.3', true);
		wp_enqueue_script('amy-admin-script', 	get_template_directory_uri() . '/js/admin-script.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('fancybox', 			get_template_directory_uri() . '/js/vendor/jquery.fancybox.js', array('jquery'), '2.1.5', true);

		wp_localize_script('amy-admin-script', 'amy_script', array(
			'ajax_url'		=> admin_url('admin-ajax.php')
		));
	}

	add_action('admin_print_scripts-post.php', 'amy_movie_action_admin_enqueue_scripts', 99);
	add_action('admin_print_scripts-post-new.php', 'amy_movie_action_admin_enqueue_scripts', 99);
	add_action('admin_enqueue_scripts', 'amy_movie_action_admin_enqueue_scripts', 99);
}

/**
 *	Check Post View
 */
if (! function_exists('amy_movie_set_post_views')) {
	function amy_movie_set_post_views($postID) {
		$count_key 	= '_amy_post_views_count';
		$count 		= get_post_meta($postID, $count_key, true);

		if ($count == '') {
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		} else {
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}

	// To keep the count accurate, lets get rid of prefetching
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

/*
 * Track Post View
 */
if (! function_exists('amy_movie_track_post_views')) {
	function amy_movie_track_post_views($post_id) {
		if (! is_single()) {
			return;
		}

		if (empty($post_id)) {
			global $post;
			$post_id = $post->ID;
		}

		amy_movie_set_post_views($post_id);
	}

	add_action('wp_head', 'amy_movie_track_post_views');

}

if (! function_exists('amy_movie_insert_fb_tag_in_head')) {
	function amy_movie_insert_fb_tag_in_head() {
		global $post;

		if (! is_singular()) {
			return;
		}

		echo '<meta property="og:title" content="' . get_the_title() . '"/>';
		echo '<meta property="og:type" content="article"/>';
		echo '<meta property="og:description" content="' . wp_strip_all_tags(amy_movie_get_excerpt_by_id($post->ID, 30)) . '"/>';
		echo '<meta property="og:url" content="' . get_permalink() . '"/>';

		echo '<meta name="twitter:card" content="summary" />';
		echo '<meta name="twitter:description" content="' . wp_strip_all_tags(amy_movie_get_excerpt_by_id($post->ID, 30)) . '" />';
		echo '<meta name="twitter:title" content="' . get_the_title() . '" />';

		if (has_post_thumbnail($post->ID)) {
			$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
			echo '<meta name="twitter:image" content="' . esc_attr($thumbnail_src[0]) . '" />';
		}

		if (is_singular('amy_movie')) {
			$arr 	= get_post_meta($post->ID, '_movie_poster', true);
			$thumbnail_src = wp_get_attachment_image_src($arr['movie_poster'], 'full');

			echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
			echo '<meta name="twitter:image" content="' . esc_attr($thumbnail_src[0]) . '" />';
		}

		echo '';
	}

	//add_action('wp_head', 'amy_movie_insert_fb_tag_in_head', 5);
}


if (!function_exists('amy_movie_pre_get_posts')) {
	function amy_movie_pre_get_posts($query) {
		$custom_fields = amy_get_option('movie_custom_fields');

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				if ($field['type'] == 'category') {
					$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
					$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

					if (!is_admin() && $query->is_main_query() && is_tax($singular_name)) {
						$query->set('posts_per_page', amy_get_option('movie_number'));
					}
				}

				if ($field['type'] == 'person') {
					$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
					$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

					if (!is_admin() && $query->is_main_query() && is_tax($singular_name)) {
						$query->set('posts_per_page', amy_get_option('movie_person_number', 5));
					}
				}
			}
		}

		if (!is_admin() && $query->is_main_query() && is_tax('amy_genre')) {
			$query->set('posts_per_page', amy_get_option('movie_number'));
		}

		if (!is_admin() && $query->is_main_query() && (is_tax('amy_actor') || is_tax('amy_director'))) {
			$query->set('posts_per_page', amy_get_option('movie_person_number', 5));
		}
	}

	add_action('pre_get_posts', 'amy_movie_pre_get_posts');
}