<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\ShortcodeGeneral;

if (!function_exists('moviecarousel')) {
	function moviecarousel($atts, $content = '', $key = '') {
		$movie_helper   = new MovieHelpers();
		$movie_query    = new MovieQuery();
		$vc				= new VisualComposer();
		$template       = new Template();
		$sc_general     = new ShortcodeGeneral();

		$shortcodes_atts = $vc->shortcode_atts();

		//shortcode params
		$shortcodes_atts['post_type']				= 'amy_movie';
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';

		$shortcodes_atts['title']					= '';
		$shortcodes_atts['class']					= '';

		$shortcodes_atts['post_slideshow']			= 4;

		$shortcodes_atts['infinite']				= true;
		$shortcodes_atts['autoplay']				= true;
		$shortcodes_atts['autoplayspeed']			= 3000;
		$shortcodes_atts['centerMode']				= true;
		$shortcodes_atts['show_arrows']				= false;
		$shortcodes_atts['show_dots']				= false;

		extract(shortcode_atts($shortcodes_atts, $atts));

		/*
		 * Code now
		 */
		$params 	= array();

		$params['post_type']		= $post_type;
		$params['orderby']			= $orderby;
		$params['order']			= $order;
		$params['posts_per_page']	= $posts_per_page;
		$params['movie_type']		= $movie_type;
		$params['custom_fields']	= [];

		if (!empty($movie_helper->get_options_custom_fields())) {
			foreach ($movie_helper->get_options_custom_fields() as $field) {
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

		$arpg 					= $movie_query->build($params);
		$movie_carousel_query 	= new WP_Query($arpg);
		$data_content			= $movie_carousel_query->posts;

        $slick = $sc_general->carousel_render_slide_option([
            'autoplay'          => $autoplay,
            'autoplayspeed'     => $autoplayspeed,
            'show_arrows'       => $show_arrows,
            'infinite'          => $infinite,
            'centerMode'        => $centerMode,
            'post_slideshow'    => $post_slideshow,
            'show_dots'         => $show_dots,
        ]);

		$html = [];

		$data = ['slick' => $slick, 'data_content' => $data_content, 'title' => $title, 'class' => $class];

		ob_start();

        $template->set_template_data($data)->get_template_part('/shortcode/carousel');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_query();

        return implode('', $html);
	}

	add_shortcode('moviecarousel', 'moviecarousel');
}
