<?php
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;
use AmyMovie\Movie\MovieHelpers;

if (!function_exists('amy_moviegrid_v2')) {
	function amy_moviegrid_v2($atts, $content = '', $key = '') {
        $movie_helper   = new MovieHelpers();
        $movie_query    = new MovieQuery();
        $vc				= new VisualComposer();
        $template       = new Template();

        $shortcodes_atts = $vc->shortcode_atts();

		$general_fields_tooltip_std		= ['title', 'content', 'tralier', 'rate', 'mpaa', 'imdb', 'duration'];

		//shortcode params
		$shortcodes_atts['post_type']				= 'amy_movie';
		$shortcodes_atts['orderby']					= 'date';
		$shortcodes_atts['order']					= 'DESC';
		$shortcodes_atts['movie_type']				= 'now';
		$shortcodes_atts['posts_per_page']			= '-1';
		$shortcodes_atts['list_fields_visible']		= 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema';

		$shortcodes_atts['general_fields_tooltip']	= implode(',', $general_fields_tooltip_std);

		$shortcodes_atts['layout']					= 'grid-1';
		$shortcodes_atts['layout1_columns']			= 4;
		$shortcodes_atts['layout2_columns']			= 2;
		$shortcodes_atts['tooltip']					= 'dark';

		$shortcodes_atts['show_button_all']			= false;
		$shortcodes_atts['all_custom_text']			= '';
		$shortcodes_atts['all_custom_link']			= '';

		$shortcodes_atts['pagination']				= false;
		$shortcodes_atts['class']					= '';
        $shortcodes_atts['keyword']                 = '';

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
        $params['keyword']          = $keyword;
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

        $amy_genre      = isset($amy_genre) ? $amy_genre : '';
        $amy_actor      = isset($amy_actor) ? $amy_actor : '';
        $amy_director   = isset($amy_director) ? $amy_director : '';
        $params = $vc->shortcode_taxonomy_render_query($params, $amy_genre, $amy_actor, $amy_director);

		$html 					= array();
		$arpg 					= $movie_query->build($params);
		$movie_v2_grid_query 	= new WP_Query($arpg);

        if ($layout == 'grid-1') {
            $columns = $layout1_columns;
        } else if ($layout == 'grid-2') {
            $columns = $layout2_columns;
        } else {
            $columns = 4;
        }

        ob_start();

        set_query_var('layout', $layout);
        set_query_var('columns', $columns);
        set_query_var('class', $class);
        set_query_var('movie_v2_grid_query', $movie_v2_grid_query);
        set_query_var('show_button_all', $show_button_all);
        set_query_var('all_custom_text', $all_custom_text);
        set_query_var('all_custom_link', $all_custom_link);
        set_query_var('tooltip', $tooltip);
        set_query_var('general_fields_tooltip', $general_fields_tooltip);
        set_query_var('list_fields_visible', $list_fields_visible);
        set_query_var('pagination', $pagination);

        $template->get_template_part('/shortcode/v2-grid');

        $html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('amy_moviegrid_v2', 'amy_moviegrid_v2');
}