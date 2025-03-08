<?php
use AmyMovie\Core\Template;

if (!function_exists('amy_v2_gallery_carousel')) {
	function amy_v2_gallery_carousel($atts, $content = '', $key = '') {
		extract(shortcode_atts(array(
			'title'			=> '',
			'short_desc'	=> '',
			'gallery'		=> '',
			'social_lists'	=> '',
			'img_size'		=> 'full',
			'class'			=> '',
		), $atts));

		$html       = [];
        $template   = new Template();
        $networks   = vc_param_group_parse_atts($social_lists);
        $gallery    = explode(',', $gallery);

		ob_start();

		set_query_var('title', $title);
        set_query_var('short_desc', $short_desc);
        set_query_var('gallery', $gallery);
        set_query_var('networks', $networks);
        set_query_var('img_size', $img_size);
        set_query_var('class', $class);
		$template->get_template_part('/shortcode/v2-gallery-carousel');

		$html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('amy_v2_gallery_carousel', 'amy_v2_gallery_carousel');
}