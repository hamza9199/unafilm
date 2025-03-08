<?php
use AmyMovie\Core\Template;

if (!function_exists('v2_heading')) {
	function v2_heading($atts, $content = '', $key = '') {
	    $template = new Template();

		extract(shortcode_atts(array(
			'title'						=> '',
			'highlight_title'			=> '',
			'subtitle'					=> '',
			'alignment'					=> 'center',
			'seprator'					=> false,
			'seprator_full'				=> 'no-full',
			'seprator_opacity'			=> '',
			'seprator_type'				=> 'seperator-1',
			'title_fontsize'			=> '',
			'highlight_title_fontsize'	=> '',
			'subtitle_fontsize'			=> '',
			'class'						=> '',
		), $atts));

		$sclass	= array();

		$sclass[] = 'amy-heading';
		$sclass[] = 'text-' . $alignment;
		$sclass[] = ($seprator) ? 'has-seperator' : '';

		if ($seprator) {
			if ($seprator_full == 'full-left') {
				$sclass[] = 'seperator-left-full';
			} else if ($seprator_full == 'full-right') {
				$sclass[] = 'seperator-right-full';
			} else if($seprator_full == 'full-both') {
				$sclass[] = 'seperator-left-full seperator-right-full';
			}
		}

		$sclass[] = ($seprator && $seprator_type) ? $seprator_type : '';
		$sclass[] = esc_attr($class);

		if ($seprator_opacity != '') {
			$style = 'style="opacity:' . $seprator_opacity . '"';
		} else {
			$style = '';
		}

		$title_style = '';

		if ($title_fontsize) {
			$title_style .= 'font-size: ' . $title_fontsize . 'px;';
		}

		$highlight_title_style = '';

		if ($highlight_title_fontsize) {
			$highlight_title_style .= 'font-size: ' . $highlight_title_fontsize . 'px;';
		}

		$subtitle_style = '';

		if ($subtitle_fontsize) {
			$subtitle_style .= 'font-size: ' . $subtitle_fontsize . 'px;';
		}

        $html = [];

		ob_start();

		$data = [
		    'sclass'                    => $sclass,
            'style'                     => $style,
            'title_style'               => $title_style,
            'highlight_title_style'     => $highlight_title_style,
            'subtitle_style'            => $subtitle_style,
            'seprator'                  => $seprator,
            'title'                     => $title,
            'highlight_title'           => $highlight_title,
            'subtitle'                  => $subtitle,
        ];

		$template->set_template_data($data)->get_template_part('/shortcode/heading');

		$html[] = ob_get_clean();

		return implode("\n", $html);
	}

	add_shortcode('v2_heading', 'v2_heading');
}