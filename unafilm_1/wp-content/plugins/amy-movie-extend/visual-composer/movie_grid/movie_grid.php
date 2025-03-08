<?php
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;

if (!function_exists('moviegrid')) {
	function moviegrid($atts, $content = '', $key = '') {
        $movie_helper   = new MovieHelpers();
        $base			= new Base();
        $movie_query    = new MovieQuery();
        $vc				= new VisualComposer();
        $template       = new Template();

        $shortcodes_atts = $vc->shortcode_atts();

		$shortcodes_atts['post_type']				= 'amy_movie';
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';

		$shortcodes_atts['title']					= '';
		$shortcodes_atts['show_sortby']				= false;

		$shortcodes_atts['show_filter']				= false;
		$shortcodes_atts['calendar_filter']			= true;
		$shortcodes_atts['genre_filter']			= true;
		$shortcodes_atts['cinema_filter']			= true;
		$shortcodes_atts['filters']					= '';

		$shortcodes_atts['class']					= '';
		$shortcodes_atts['filter_style']			= 'style1';
		$shortcodes_atts['pagination']				= true;
		$shortcodes_atts['show_showtime']			= false;
		$shortcodes_atts['showtime_type']			= 'all';

		$shortcodes_atts['layout']					= 'layout1';
		$shortcodes_atts['column']					= '4';
		$shortcodes_atts['layout2_column']			= '2';
		$shortcodes_atts['cinema_id']				= '';
        $shortcodes_atts['keyword']                 = '';

		extract(shortcode_atts($shortcodes_atts, $atts));

		/**
		 * Code now
		 */

		// Custom query
		if ($layout == 'layout2') {
			$column = $layout2_column;
		}

		switch ($layout) {
			case 'layout2':
				$image_size = $base->get_image_size('movie_grid_layout_2');
				break;
			case 'layout3':
				$image_size = $base->get_image_size('movie_grid_layout_3');
				break;
			case 'layout4':
				$image_size = $base->get_image_size('movie_grid_layout_4');
				break;
			default:
				$image_size = $base->get_image_size('movie_grid_layout_1');
				break;
		}

		$params 	= array();
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params['post_type']		= $post_type;
		$params['orderby']			= $orderby;
		$params['order']			= $order;
		$params['posts_per_page']	= $posts_per_page;
		$params['paged']			= $paged;
		$params['movie_type']		= $movie_type;
		$params['keyword']          = $keyword;
		$params['movie_cinema']     = $cinema_id;
		$params['custom_fields']	= [];

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
		$movie_grid_query 	= new WP_Query($arpg);
		$max   				= intval($movie_grid_query->max_num_pages);
		$data_content       = $movie_grid_query->posts;

		$options	 = array(
			'img_size'		=> $image_size,
			'layout'		=> $layout,
			'column'		=> $column,
			'max_pages'		=> $max,
			'pagination'	=> $pagination,
			'movie_type'	=> $movie_type,
		);

		// Begin output
		$html = [];

        ob_start();

        $data = [
            'layout'        => $layout,
            'title'         => $title,
            'show_filter'   => $show_filter,
            'filter_style'  => $filter_style,
            'filters'       => $filters,
            'show_sortby'   => $show_sortby,
            'data_content'  => $data_content,
            'options'       => $options,
            'pagination'    => $pagination,
            'max'           => $max
        ];

        $template->set_template_data($data)->get_template_part('/shortcode/grid');

        $html[] = ob_get_clean();

        wp_reset_query();
        wp_reset_postdata();

		return implode('', $html);
	}

	add_shortcode('moviegrid', 'moviegrid');
}
