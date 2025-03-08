<?php
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;
use AmyMovie\Shortcode\ShortcodeGeneral;

if (!function_exists('amy_v2_movie_showtime_3')) {
	function amy_v2_movie_showtime_3($atts, $content = '', $key = '') {
        $movie_query    = new MovieQuery();
        $vc				= new VisualComposer();
        $template       = new Template();
        $base           = new Base();
        $sc_general     = new ShortcodeGeneral();

        $shortcodes_atts = $vc->shortcode_atts();

		$general_fields_tooltip_std		= array('title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration');

		//shortcode params
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';
		$shortcodes_atts['list_fields_visible']		= 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema';

		$shortcodes_atts['general_fields_tooltip']	= implode(',', $general_fields_tooltip_std);

		$shortcodes_atts['class']					= '';
		$shortcodes_atts['pagination']				= false;

		$shortcodes_atts['layout']					= 'daily-1';
		$shortcodes_atts['day_start_week']			= '';
		$shortcodes_atts['number_date']				= 7;

		extract(shortcode_atts($shortcodes_atts, $atts));

		//query now
		$general_fields_tooltip = explode(',', $general_fields_tooltip);

		$params 	= array();
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

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

		$html 						= [];
		$arpg 						= $movie_query->build($params);
		$movie_showtime_3_query 	= new WP_Query($arpg);

		$start_date = ($day_start_week != '') ? $day_start_week : current_time('m/d/y');

		$option = [
			'image_size'				=> $base->get_image_size('v2_st_3'),
			'general_fields_tooltip'	=> $general_fields_tooltip,
			'list_fields_visible'		=> $list_fields_visible,
			'start_date'				=> $start_date,

		];

        $list_movie_id = [];

        if ($movie_showtime_3_query->have_posts()) :
            while ($movie_showtime_3_query->have_posts()) :
                $movie_showtime_3_query->the_post();
                global $post;

                $list_movie_id[] = $post->ID;
            endwhile;
        endif;

        wp_reset_postdata();

        $list_movie_to_show = $sc_general->get_movie_follow_showtime($movie_showtime_3_query->posts, $start_date);

		ob_start();

        $data = [
            'class'                 => $class,
            'params'                => $params,
            'option'                => $option,
            'list_movie_id'         => $list_movie_id,
            'list_movie_to_show'    => $list_movie_to_show,
            'list_fields_visible'   => $list_fields_visible,
            'general_fields_tooltip'=> $general_fields_tooltip,
            'number_date'           => $number_date,
            'day_start_week'        => $day_start_week,
            'start_date'            => $start_date
        ];

        $template
            ->set_template_data($data)
            ->get_template_part('/shortcode/v2-showtime-3');

        $html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_movie_showtime_3', 'amy_v2_movie_showtime_3');
}

