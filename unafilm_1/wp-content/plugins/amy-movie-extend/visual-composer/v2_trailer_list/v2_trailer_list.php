<?php
use AmyMovie\Core\Template;

if (!function_exists('amy_v2_tralier_list')) {
	function amy_v2_tralier_list($atts, $content = '', $key = '') {
		extract(shortcode_atts(array(
			'title'				=> esc_html__('Video Play', 'amy-movie-extend'),
			'subtitle'			=> esc_html__('By Movieak', 'amy-movie-extend'),
			'movie_from'		=> true,
			'movies_ids'		=> '',
			'items_list'		=> '',
			'class'				=> '',
		), $atts));

		$html = [];
        $template = new Template();
        $list_item = vc_param_group_parse_atts($items_list);

        ob_start();

        set_query_var('title', $title);
        set_query_var('subtitle', $subtitle);
        set_query_var('movie_from', $movie_from);
        set_query_var('movies_ids', $movies_ids);
        set_query_var('class', $class);
        set_query_var('list_item', $list_item);

        $template->get_template_part('/shortcode/v2-trailer-list');

        $html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_tralier_list', 'amy_v2_tralier_list');
}