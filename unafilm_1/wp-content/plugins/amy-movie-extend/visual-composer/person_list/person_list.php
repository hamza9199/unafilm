<?php
use AmyMovie\Core\Template;

if (!function_exists('amy_movie_person_list')) {
	function amy_movie_person_list($atts, $content = '', $key = '') {
		$shortcodes_atts 		= array();

		//shortcode params
		$shortcodes_atts['person']			= '';
		$shortcodes_atts['orderby']			= 'date';
		$shortcodes_atts['order']			= 'DESC';
		$shortcodes_atts['posts_per_page']	= 0;
		$shortcodes_atts['layout']			= 'grid';
		$shortcodes_atts['columns']			= 4;
		$shortcodes_atts['class']			= '';
		$shortcodes_atts['pagination']		= true;

		extract(shortcode_atts($shortcodes_atts, $atts));

		if ($person == '') {
			return;
		}

		$posts_per_page = (int) $posts_per_page;
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		$offset		= (($paged - 1) * $posts_per_page);

		$arpg = array(
			'taxonomy'		=> $person,
			'order'			=> $order,
			'number'		=> $posts_per_page,
			'orderby'		=> $orderby,
			'offset'		=> $offset
		);

		$person_list_query = get_terms($arpg);

        $html       = [];
        $template   = new Template();

        ob_start();

        set_query_var('layout', $layout);
        set_query_var('class', $class);
        set_query_var('columns', $columns);
        set_query_var('person', $person);
        set_query_var('pagination', $pagination);
        set_query_var('posts_per_page', $posts_per_page);
        set_query_var('person_list_query', $person_list_query);

        $template->get_template_part('/shortcode/person-list');

        $html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('amy_movie_person_list', 'amy_movie_person_list');
}