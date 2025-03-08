<?php
use AmyMovie\Core\Base;

CSF::createWidget('amy_movie_widget_module', [
    'title'         => esc_html__('+ Amy Movie Module', 'amy-movie-extend'),
    'classname'     => 'amy-widget-module',
    'description'   => esc_html__('Show Utilities Module into Widget.', 'amy-movie-extend'),
    'fields'        => [
        array(
            'id'		=> 'title',
            'type'		=> 'text',
            'title'		=> esc_html__('Title', 'amy-movie-extend'),
        ),

        array(
            'id'		=> 'type',
            'type'		=> 'select',
            'title'		=> esc_html__('Type', 'amy-movie-extend'),
            'options'			=> array(
                'advertising'	=> esc_html__('Advertising', 'amy-movie-extend'),
                'contact'		=> esc_html__('Contact', 'amy-movie-extend'),
                'social'		=> esc_html__('Social List', 'amy-movie-extend'),
                'about'			=> esc_html__('About', 'amy-movie-extend'),
            ),
        ),

        array(
            'id'		=> 'banner',
            'type'		=> 'media',
            'title'		=> esc_html__('Banner', 'amy-movie-extend'),
            'dependency'	=> array('type', '==', 'advertising'),
        ),

        array(
            'id'				=> 'link',
            'type'				=> 'text',
            'title'				=> esc_html__('Banner URL', 'amy-movie-extend'),
            'multilang'			=> true,
            'attributes'		=> array(
                'placeholder'		=> 'http://',
            ),
            'dependency'	=> array('type', '==', 'advertising'),
        ),

        array(
            'id'			=> 'address',
            'type'			=> 'text',
            'title'			=> esc_html__('Address', 'amy-movie-extend'),
            'dependency'	=> array('type', '==', 'contact'),
        ),

        array(
            'id'			=> 'email',
            'type'			=> 'text',
            'title'			=> esc_html__('Email', 'amy-movie-extend'),
            'dependency'	=> array('type', '==', 'contact'),
        ),

        array(
            'id'			=> 'phone',
            'type'			=> 'text',
            'title'			=> esc_html__('Phone', 'amy-movie-extend'),
            'dependency'	=> array('type', '==', 'contact'),
        ),

        array(
            'id'		=> 'logo',
            'type'		=> 'media',
            'title'		=> esc_html__('Logo', 'amy-movie-extend'),
            'dependency'	=> array('type', '==', 'about'),
        ),

        array(
            'id'			=> 'about_text',
            'type'			=> 'textarea',
            'title'			=> esc_html__('Summary', 'amy-movie-extend'),
            'dependency'	=> array('type', '==', 'about'),
        ),

        array(
            'id'		=> 'class',
            'type'		=> 'text',
            'title'		=> esc_html__('Extra Class', 'amy-movie-extend'),
        ),
    ]
]);

if (!function_exists('amy_movie_widget_module')) {
    function amy_movie_widget_module($args, $instance) {
        $type 		= empty($instance['type']) ? '' : $instance['type'];
        $address 	= empty($instance['address']) ? '' : $instance['address'];
        $email 		= empty($instance['email']) ? '' : $instance['email'];
        $phone 		= empty($instance['phone']) ? '' : $instance['phone'];
        $logo 		= empty($instance['logo']) ? '' : $instance['logo'];
        $about_text = empty($instance['about_text']) ? '' : $instance['about_text'];
        $banner 	= empty($instance['banner']) ? '' : $instance['banner'];
        $link 		= empty($instance['link']) ? '' : $instance['link'];
        $class 		= empty($instance['class']) ? '' : $instance['class'];

        $base = new Base();

        echo $args['before_widget'];

        $output = '<div class="amy-widget amy-widget-module ' . esc_attr($type) . ' ' . esc_attr($class) . '">';

        $output .= '<h4 class="amy-title amy-widget-title">' . $instance['title'] . '</h4>';

        switch ($type) {
            case 'advertising':
                if ($banner != '') {
                    $output .= '<a href="' . esc_url($link) . '" target="_blank">';
                    $output .= '<img src="' . $base->get_value_in_array($banner, 'url') . '" />';
                    $output .= '</a>';
                }

                break;

            case 'contact':
                if ($address != '') {
                    $output .= '<div class="address"><i class="fa fa-location-arrow" aria-hidden="true"></i>' . esc_html($address) . '</div>';
                }

                if ($email != '') {
                    $output .= '<div class="email"><i class="fa fa-envelope-o" aria-hidden="true"></i>' . esc_html($email) . '</div>';
                }

                if ($phone != '') {
                    $output .= '<div class="phone"><i class="fa fa-phone" aria-hidden="true"></i>' . esc_html($phone) . '</div>';
                }

                break;

            case 'social':
                $output .= amy_movie_social_list();

                break;

            case 'about':
                if ($logo != '') {
                    $output .= '<div class="footer-logo"><a href="' . esc_url(home_url('/')) . '">';
                    $output .= '<img src="' . $base->get_value_in_array($logo, 'url') . '" />';
                    $output .= '</a></div>';
                }

                if ($about_text != '') {
                    $output .= '<div class="summary">' . $about_text . '</div>';
                }

                break;
        }

        $output .= '</div>';

        echo $output;

        echo $args['after_widget'];
    }
}
