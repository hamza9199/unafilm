<?php
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\ShortcodeGeneral;

if (!function_exists('amy_v2_movie_carousel_1')) {
	function amy_v2_movie_carousel_1($atts, $content = '', $key = '') {
        $movie_query    = new MovieQuery();
        $vc				= new VisualComposer();
        $template       = new Template();
        $sc_general     = new ShortcodeGeneral();

        $shortcodes_atts = $vc->shortcode_atts();

		$general_fields_front_std 		= ['title', 'mpaa', 'imdb', 'release_date'];
		$general_fields_tooltip_std		= ['title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration'];

		//shortcode params
		$shortcodes_atts['post_type']				= 'amy_movie';
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';
		$shortcodes_atts['list_fields_visible']		= 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema';

		$shortcodes_atts['general_fields_front']	= implode(',', $general_fields_front_std);
		$shortcodes_atts['general_fields_tooltip']	= implode(',', $general_fields_tooltip_std);

		$shortcodes_atts['class']					= '';
		$shortcodes_atts['pagination']				= true;
		$shortcodes_atts['show_showtime']			= false;
		$shortcodes_atts['showtime_type']			= 'all';
		$shortcodes_atts['img_size']				= 'amy-movie-v2-174-300-crop-shortcode-movie-carousel-1';

		$shortcodes_atts['number_slide']			= 8;
		$shortcodes_atts['infinite']				= true;
		$shortcodes_atts['autoplay']				= true;
		$shortcodes_atts['autoplayspeed']			= 3000;
		$shortcodes_atts['show_arrows']				= true;
		$shortcodes_atts['is_sidebar']				= false;

		$shortcodes_atts['tooltip']					= 'dark';
		$shortcodes_atts['show_button_all']			= false;
		$shortcodes_atts['all_custom_text']			= '';
		$shortcodes_atts['all_custom_link']			= '';

		extract(shortcode_atts($shortcodes_atts, $atts));

		$general_fields_front 	= explode(',', $general_fields_front);
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

		$html 					= [];
		$arpg 					= $movie_query->build($params);
		$v2_movie_carousel_1 	= new WP_Query($arpg);

        $slick = $sc_general->render_v2_carousel_1_slide_options([
            'number_slide'  => $number_slide,
            'autoplay'      => $autoplay,
            'autoplayspeed' => $autoplayspeed,
            'infinite'      => $infinite,
            'show_arrows'   => $show_arrows
        ]);

        ob_start();

        set_query_var('class', $class);
        set_query_var('show_button_all', $show_button_all);
        set_query_var('all_custom_text', $all_custom_text);
        set_query_var('all_custom_link', $all_custom_link);
        set_query_var('tooltip', $tooltip);
        set_query_var('slick', $slick);
        set_query_var('v2_movie_carousel_1', $v2_movie_carousel_1);
        set_query_var('general_fields_front', $general_fields_front);
        set_query_var('list_fields_visible', $list_fields_visible);
        set_query_var('general_fields_tooltip', $general_fields_tooltip);

        $template->get_template_part('/shortcode/v2-carousel-1');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_query();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_movie_carousel_1', 'amy_v2_movie_carousel_1');
}