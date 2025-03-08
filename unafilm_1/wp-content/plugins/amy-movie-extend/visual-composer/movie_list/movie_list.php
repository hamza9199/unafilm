<?php
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;

if (!function_exists('movielist')) {
	function movielist($atts, $content = '', $key = '') {
        $movie_helper   = new MovieHelpers();
        $base			= new Base();
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

		$shortcodes_atts['list_fields_visible']		= 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema';
		$shortcodes_atts['title']					= '';
		$shortcodes_atts['show_sortby']				= false;

		$shortcodes_atts['show_filter']				= false;
		$shortcodes_atts['calendar_filter']			= true;
		$shortcodes_atts['genre_filter']			= true;
		$shortcodes_atts['cinema_filter']			= false;
		$shortcodes_atts['filters']					= '';

		$shortcodes_atts['class']					= '';
		$shortcodes_atts['filter_style']			= 'style1';
		$shortcodes_atts['pagination']				= true;
		$shortcodes_atts['show_showtime']			= false;
		$shortcodes_atts['showtime_type']			= 'all';
        $shortcodes_atts['keyword']                 = '';

		extract(shortcode_atts($shortcodes_atts, $atts));

		/**
		 * Code Now
		 */

		// Custom query
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		$params 	= array();

		$params['post_type']		= $post_type;
		$params['orderby']			= $orderby;
		$params['order']			= $order;
		$params['posts_per_page']	= $posts_per_page;
		$params['paged']			= $paged;
		$params['movie_type']		= $movie_type;
        $params['keyword']          = $keyword;
		$params['custom_fields']	= array();

		if (isset($_GET['orderby']) && $_GET['orderby'] != 'default') {
			$params['orderby'] = $_GET['orderby'];
		}

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

                    $params['custom_fields'][] = $vc->check_url_param_exists_for_filter_movie($singular_name, $field['type']);
                }
            }
        }

        $amy_genre      = isset($amy_genre) ? $amy_genre : '';
        $amy_actor      = isset($amy_actor) ? $amy_actor : '';
        $amy_director   = isset($amy_director) ? $amy_director : '';
        $params = $vc->shortcode_taxonomy_render_query($params, $amy_genre, $amy_actor, $amy_director);

		$arpg 				= $movie_query->build($params);
		$movie_list_query 	= new WP_Query($arpg);
		$max   				= intval($movie_list_query->max_num_pages);
		$data				= $movie_list_query->posts;

		$options	 = array(
			'img_size'				=> $base->get_image_size('movie_list'),
			'max_pages'				=> $max,
			'pagination'			=> $pagination,
			'show_showtime'			=> $show_showtime,
			'showtime_type'			=> $showtime_type,
			'list_fields_visible'	=> $list_fields_visible,
		);

		// Begin output
		$html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('title', $title);
        set_query_var('data', $data);
        set_query_var('show_filter', $show_filter);
        set_query_var('filter_style', $filter_style);
        set_query_var('filters', $filters);
        set_query_var('show_sortby', $show_sortby);
        set_query_var('options', $options);
        set_query_var('pagination', $pagination);
        set_query_var('max', $max);
        $template->get_template_part('/shortcode/list');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_query();

		return implode('', $html);
	}

	add_shortcode('movielist', 'movielist');
}
