<?php
/**
 * Get option
 */
if (! function_exists('amy_get_option')) {
    function amy_get_option($option_name = '', $default = '', $name = '_amy_options') {
        $options = get_option($name);

        if (! empty($option_name) && ! empty($options[ $option_name ])) {
            return $options[ $option_name ];
        } else {
            return (! empty($default)) ? $default : null;
        }
    }
}

/**
 * Get value in array
 */
if (! function_exists('amy_movie_get_value_in_array')) {
    function amy_movie_get_value_in_array($array, $key, $default = false) {
        return isset($array[ $key ]) ? $array[ $key ] : $default;
    }
}

/**
 * Visual Composer plugin is activated
 */
if (! function_exists('is_vc_activated')) {
    function is_vc_activated() {
        if (class_exists('Vc_Manager') && defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, '4.2.3', '>=')) {
            return true;
        } else {
            return false;
        }
    }
}