<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

global $post;
?>

<aside id="sidebar">
	<?php
	if ((is_page()) && ! empty($post)) {
		$post_widget	= 'right-bar';
	} else if (is_tax('amy_genre')) {
		$queried_object = get_queried_object();
		$term_id 		= $queried_object->term_id;
		$term 			= get_term($term_id, 'amy_genre');
		$term_data 		= get_term_meta($term_id, '_genre_options', true);

		$post_widget 	= (isset($term_data['sidebar']) && $term_data['sidebar'] != 'global') ? $term_data['widget'] : amy_get_option('genre_widget');
	} else if (is_singular('amy_movie') || is_singular('amy_tvshow') || is_singular('amy_season')) {
		$post_widget	= amy_get_option('movie_widget');
	} else if (is_tax('amy_actor') || is_tax('amy_director')) {
		$post_widget	= amy_get_option('person_widget');
	} else {
		$post_widget	= amy_get_option('blog_widget', 'right-bar');
	}


	$custom_fields		= amy_get_option('movie_custom_fields');

	if (!empty($custom_fields)) {
		foreach ($custom_fields as $field) {
			if ($field['type'] == 'category') {
				$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
				$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

				if(is_tax($singular_name)) {
					$queried_object = get_queried_object();
					$term_id 		= $queried_object->term_id;
					$term_data 		= get_term_meta($term_id, '_custom_options', true);

					$post_widget 	= (isset($term_data['sidebar']) && $term_data['sidebar'] != 'global') ? $term_data['widget'] : amy_get_option('genre_widget');
				}
			} else if ($field['type'] == 'person') {
				$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
				$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

				if(is_tax($singular_name)) {
					$post_widget	= amy_get_option('person_widget');
				}
			}
		}
	}

	$post_widget	= (! empty($post_widget)) ? $post_widget : '';

	dynamic_sidebar($post_widget);
	?>
</aside>
