<?php
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;

if (!function_exists('amy_v2_movie_carousel_3')) {
	function amy_v2_movie_carousel_3($atts, $content = '', $key = '') {
        $movie_query    = new MovieQuery();
        $vc				= new VisualComposer();
        $template       = new Template();

        $shortcodes_atts = $vc->shortcode_atts();

		//shortcode params
		$shortcodes_atts['post_type']				= 'amy_movie';
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';
		$shortcodes_atts['class']					= '';
		$shortcodes_atts['show_trailer']			= true;

		extract(shortcode_atts($shortcodes_atts, $atts));

		$image_size = array('214', '368');

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

		$html 					= array();
		$arpg 					= $movie_query->build($params);
		$movie_carousel3_query 	= new WP_Query($arpg);
		
		$slick  = '{';
		$slick .= '"slidesToShow":1,"slidesToScroll":1,';
		$slick .= '"autoplay":false,';
		$slick .= '"prevArrow": "<a class=\"amy-arrow fa amy-pre fa-chevron-right\"></a>",';
		$slick .= '"nextArrow": "<a class=\"amy-arrow fa amy-next fa-chevron-left\"></a>",';
		$slick .= '"arrows":true,';
		$slick .= '"infinite":false,';
		$slick .= '"dots":true';
		$slick .= '}';

        ob_start();

        set_query_var('slick', $slick);
        set_query_var('movie_carousel3_query', $movie_carousel3_query);
        set_query_var('show_trailer', $show_trailer);
        $template->get_template_part('/shortcode/v2-carousel-3');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_postdata();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_movie_carousel_3', 'amy_v2_movie_carousel_3');
}