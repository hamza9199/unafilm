<?php
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\ShortcodeGeneral;

if (!function_exists('movieslide')) {
	function movieslide($atts, $content = '', $key = '') {
        $movie_helper   = new MovieHelpers();
        $base			= new Base();
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

		$shortcodes_atts['img_size']				= 'full';
		$shortcodes_atts['show_title']				= true;
		$shortcodes_atts['show_release']			= true;
		$shortcodes_atts['show_content']			= true;
		$shortcodes_atts['show_button']				= true;
		$shortcodes_atts['show_arrows']				= true;
		$shortcodes_atts['show_dots']				= true;

		$shortcodes_atts['class']					= '';

		$shortcodes_atts['infinite']				= true;
		$shortcodes_atts['autoplay']				= true;
		$shortcodes_atts['autoplayspeed']			= 3000;
		$shortcodes_atts['fade']					= true;
		$shortcodes_atts['usecss']					= true;
		$shortcodes_atts['usetransform']			= true;

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
		$params['custom_fields']	= array();

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

		$arpg 				= $movie_query->build($params);
		$movie_slide_query 	= new WP_Query($arpg);
		$data				= $movie_slide_query->posts;

        $slick = $sc_general->render_slide_options([
            'autoplay'          => $autoplay,
            'autoplayspeed'     => $autoplayspeed,
            'show_arrows'       => $show_arrows,
            'infinite'          => $infinite,
            'fade'              => $fade,
            'usecss'            => $usecss,
            'usetransform'      => $usetransform,
            'show_dots'         => $show_dots,
        ]);

		$html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('slick', $slick);
        set_query_var('data', $data);
        set_query_var('show_release', $show_release);
        set_query_var('show_content', $show_content);
        set_query_var('show_button', $show_button);
        set_query_var('show_title', $show_title);

        $template->get_template_part('/shortcode/slide');

        $html[] = ob_get_clean();

        wp_reset_query();
        wp_reset_postdata();

		return implode('', $html);
	}

	add_shortcode('movieslide', 'movieslide');
}
