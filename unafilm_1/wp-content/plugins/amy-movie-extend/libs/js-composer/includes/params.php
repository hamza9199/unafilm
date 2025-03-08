<?php
defined('ABSPATH') or die;

/**
 * Switcher
 */
if (! function_exists('vc_amy_on_off')) {
	function vc_amy_on_off($settings, $value) {
		$checked    = $value == 1 ? ' switch-active' : '';
		$label      = isset($settings['label']) ? '<span class="amy-text-desc">' . $settings['label'] . '</span>' : '';

		$output = '<div class="amy_field amy_field_on_off">';
		$output .= '<div class="vc_switch switch' . $checked . '"><span class="switch-label" data-on="ON" data-off="OFF"></span><span class="switch-handle"></span>';
		$output .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value vc_amy_on_off ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="' . $value . '"/>';
		$output .= '</div>';
		$output .= $label;
		$output .= '</div>';

		return $output;
	}

	vc_add_shortcode_param('vc_amy_on_off', 'vc_amy_on_off');
}

/**
 * Chosen
 */
if (! function_exists('vc_amy_chosen')) {
	function vc_amy_chosen($settings, $value) {
		$css_option = vc_get_dropdown_option($settings, $value);
		$value      = explode(',', $value);
		$chosen_rtl = is_rtl() ? ' chosen-rtl' : '';

		// begin output
		$output     = '<select name="' . $settings['param_name'] . '" data-placeholder="' . $settings['heading'] . '" multiple="multiple" class="wpb_vc_param_value wpb_chosen chosen ' . $chosen_rtl . ' wpb-input wpb-amy-select ' . $settings['param_name'] . ' ' . $settings['type'] . ' ' . $css_option . '" data-option="' . $css_option . '">';

		foreach ($settings['value'] as $text_val => $val) {
			$selected   = (in_array($val, $value)) ? ' selected="selected"' : '';
			$output     .= '<option value="' . $val . '"' . $selected . '>' . htmlspecialchars($text_val) . '</option>';
		}

		$output .= '<select>';
		// end output
		return $output;
	}

	vc_add_shortcode_param('vc_amy_chosen', 'vc_amy_chosen');
}

/**
 * Image Select
 */
if ( ! function_exists( 'vc_amy_image_select' ) ) {
    function vc_amy_image_select( $settings, $value ) {
        $output = '<ul class="vc_image_select">';

        if ( isset( $settings['options'] ) ) {
            $options    = $settings['options'];

            foreach ( $options as $key => $img ) {
                $selected   = ($value == $key) ? ' class="selected"' : '';
                $output     .= '<li data-value="' . $key . '"' . $selected . '><img src="' . $img . '" alt="' . $key . '" /></li>';
            }
        }

        $output .= '</ul>';
        $output .= '<input type="hidden" class="wpb_vc_param_value vc_amy_image_select ' . $settings['param_name'] . ' ' . $settings['type'] . '" name="' . $settings['param_name'] . '" value="' . $value . '" />';

        return $output;
    }

    vc_add_shortcode_param( 'vc_amy_image_select', 'vc_amy_image_select' );
}