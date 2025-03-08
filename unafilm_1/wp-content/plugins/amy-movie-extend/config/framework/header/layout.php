<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */


CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Header', 'amy-movie-extend'),
    'icon'      => 'fa fa-angellist',
    'parent'    => 'header',
    'fields'    => [
        [
            'id'		=> 'header_style',
            'type'		=> 'image_select',
            'title'		=> esc_html__('Header Style', 'amy-movie-extend'),
            'options'	=> [
                'default'				=> AMY_MOVIE_PLUGIN_URL . 'assets/image/header/header-style-default.png',
                'left'					=> AMY_MOVIE_PLUGIN_URL . 'assets/image/header/header-style-left.png',
                'center'				=> AMY_MOVIE_PLUGIN_URL . 'assets/image/header/header-style-center.png',
                //'inline'				=> AMY_MOVIE_PLUGIN_URL . 'assets/image/header/header-inline.png',
                //'classic'				=> AMY_MOVIE_PLUGIN_URL . 'assets/image/header/header-classic.png',
                //'compact-transparent'	=> AMY_MOVIE_PLUGIN_URL . 'assets/image/header/header-compact.png',
            ],
            'attributes'			=> [
                'data-depend-id'	=> 'header_style',
            ],
            'radio'		=> true,
            'default'	=> 'default',
        ],

        [
            'id'		=> 'header_skin',
            'type'		=> 'button_set',
            'class'		=> 'chosen',
            'title'		=> esc_html__('Header Skin', 'amy-movie-extend'),
            'options'	=> [
                'light'		=> esc_html__('Light', 'amy-movie-extend'),
                'dark'		=> esc_html__('Dark', 'amy-movie-extend'),
            ],
            'default'		=> 'light',
            'dependency'	=> ['header_style', '==', 'default'],
        ],

        [
            'id'		=> 'line_through_position',
            'type'		=> 'button_set',
            'class'		=> 'chosen',
            'title'		=> esc_html__('Line Through Position', 'amy-movie-extend'),
            'options'	=> [
                'bottom'	=> esc_html__('Bottom', 'amy-movie-extend'),
                'default'	=> esc_html__('Center', 'amy-movie-extend'),
                'none'		=> esc_html__('None', 'amy-movie-extend')
            ],
            'desc'		=> esc_html__('Line through position when menu hover', 'amy-movie-extend'),
            'default'	=> 'default',
            'dependency'	=> ['header_skin', '!=', 'dark'],
        ],

        [
            'id'		=> 'dark_module_login',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Show module login', 'amy-movie-extend'),
            'default'	=> false,
            'dependency'	=> ['header_style|header_skin', '==|==', 'default|dark'],
        ],

//        [
//            'id'		=> 'show_search',
//            'type'		=> 'switcher',
//            'title'		=> esc_html__('Show search on header', 'amy-movie-extend'),
//            'dependency'	=> ['header_style', '==', 'default'],
//            'default'	=> false,
//        ],

        [
            'id'		=> 'menu_max_width',
            'type'		=> 'number',
            'title'		=> esc_html__('Disable menu in max-width', 'amy-movie-extend'),
            'default'	=> '992',
            'desc'		=> esc_html__('you can set it eg. 1200, 992, 768 or any width etc..', 'amy-movie-extend'),
        ],
    ]
]);