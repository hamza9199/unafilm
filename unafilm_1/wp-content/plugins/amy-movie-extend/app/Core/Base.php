<?php
namespace AmyMovie\Core;

Class Base {
    public function get_value_in_array($arr, $key, $default = '') {
        return isset($arr[ $key ]) ? $arr[ $key ] : $default;
    }

    public function check_boolean_in_array($arr, $key) {
        $data = $this->get_value_in_array($arr, $key);

        return ($data === 'yes') ? true : false;
    }

    public function get_option($option_name = '', $default = '', $name = AMY_MOVIE_OPTION) {
        $options = get_option($name);

        if (! empty($option_name) && ! empty($options[ $option_name ])) {
            return $options[ $option_name ];
        } else {
            return (! empty($default)) ? $default : null;
        }
    }

    public function get_registered_sidebars() {
        global $wp_registered_sidebars;

        $widgets	= array();

        if (! empty($wp_registered_sidebars)) {
            foreach ($wp_registered_sidebars as $key => $value) {
                $widgets[ $key ]	= $value['name'];
            }
        }

        return array_reverse($widgets);
    }

    public function get_list_images_size() {
        return $this->get_option('custom_image_sizes');
    }

    public function get_image_size($name) {
        $list_image_size = $this->get_list_images_size();

        return [
            'width'     => $list_image_size[$name . '_width'],
            'height'    => $list_image_size[$name . '_height'],
            'is_crop'   => $list_image_size[$name . '_is_crop']
        ];
    }
}