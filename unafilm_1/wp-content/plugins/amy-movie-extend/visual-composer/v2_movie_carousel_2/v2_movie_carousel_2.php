<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;

if (!function_exists('amy_v2_movie_carousel_2')) {
	function amy_v2_movie_carousel_2($atts, $content = '', $key = '') {
        $movie_helper   = new MovieHelpers();
        $movie_query    = new MovieQuery();
        $vc				= new VisualComposer();
        $template       = new Template();

        $shortcodes_atts = $vc->shortcode_atts();

		$general_fields_tooltip_std		= array('title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration');

		//shortcode params
		$shortcodes_atts['post_type']				= 'amy_movie';
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';
		$shortcodes_atts['list_fields_visible']		= 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema';

		$shortcodes_atts['general_fields_tooltip']	= implode(',', $general_fields_tooltip_std);

		$shortcodes_atts['class']					= '';
		$shortcodes_atts['pagination']				= true;
		$shortcodes_atts['show_showtime']			= false;
		$shortcodes_atts['showtime_type']			= 'all';

		extract(shortcode_atts($shortcodes_atts, $atts));

		$general_fields_tooltip = explode(',', $general_fields_tooltip);

		//query now
		$params 	= array();
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params['post_type']		= $post_type;
		$params['orderby']			= $orderby;
		$params['order']			= $order;
		$params['posts_per_page']	= $posts_per_page;
		$params['paged']			= $paged;
		$params['movie_type']		= $movie_type;
		$params['custom_fields']	= array();

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				if ($field['type'] == 'category' || $field['type'] == 'person') {
					$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
					$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

					if ($$singular_name != '') {
						$params['custom_fields'][] = array(
							'type'	=> $field['type'],
							'id'	=> $singular_name,
							'value'	=> $$singular_name
						);
					}


				}
			}
		}

        $params = $vc->shortcode_taxonomy_render_query($params, $amy_genre, $amy_actor, $amy_director);

		$html 		= array();
		$arpg 		= $movie_query->build($params);
		$movie_carousel2_query 	= new WP_Query($arpg);

		ob_start();

		set_query_var('movie_carousel2_query', $movie_carousel2_query);
		set_query_var('list_fields_visible', $list_fields_visible);
		set_query_var('general_fields_tooltip', $general_fields_tooltip);

		$template->get_template_part('/shortcode/v2-carousel-2');

		$html[] = ob_get_clean();

		wp_reset_query();
		wp_reset_postdata();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_movie_carousel_2', 'amy_v2_movie_carousel_2');
}