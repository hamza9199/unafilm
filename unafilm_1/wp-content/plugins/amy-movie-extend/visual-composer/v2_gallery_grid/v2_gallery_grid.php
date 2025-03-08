<?php
use AmyMovie\Core\Template;

if (!function_exists('amy_v2_gallery_grid')) {
	function amy_v2_gallery_grid($atts, $content = '', $key = '') {
		extract(shortcode_atts(array(
			'gallery'		=> '',
			'column'		=> '4',
			'img_size'		=> 'full',
			'class'			=> '',
		), $atts));

		$html       = [];
		$template   = new Template();
        $gallery    = explode(',', $gallery);

        ob_start();

        set_query_var('class', $class);
        set_query_var('column', $column);
        set_query_var('img_size', $img_size);
        set_query_var('gallery', $gallery);
        $template->get_template_part('/shortcode/v2-gallery-grid');

        $html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_gallery_grid', 'amy_v2_gallery_grid');
}