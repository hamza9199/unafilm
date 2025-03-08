<?php
use AmyMovie\Core\Template;

if (!function_exists('amy_movie_advance_search')) {
	function amy_movie_advance_search($atts, $content = '', $key = '') {
	    $template = new Template();

		extract(shortcode_atts(array(
			// General
			'filters'	=> '',
			'class'		=> ''
		), $atts));

		$html = [];

		ob_start();

        $data = [
            'class'         => $class,
            'filters'       => $filters
        ];

		$template->set_template_data($data)->get_template_part('/shortcode/advance-search');

        $html[] = ob_get_clean();

		return implode('', $html);

	}

	add_shortcode('amy_movie_advance_search', 'amy_movie_advance_search');
}
