<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Skin', 'amy-movie-extend'),
    'icon'      => 'fa fa-paint-brush',
    'parent'    => 'general',
    'fields'    => [
        [
            'id'        => 'skin_heading_general',
            'type'      => 'heading',
            'content'   => esc_html__('General', 'amy-movie-extend'),
        ],

        [
            'id'            => 'disable_skin',
            'type'          => 'switcher',
            'title'         => esc_html__('Disabled Skin', 'amy-movie-extend'),
            'label'         => esc_html__('Using themes color', 'amy-movie-extend'),
            'default'       => true,
        ],

        [
            'id'        => 'skin_color',
            'type'      => 'select',
            'class'     => 'chosen',
            'title'     => esc_html__('Skin', 'amy-movie-extend'),
            'options'   => [
                'red'       => esc_html__('Red', 'amy-movie-extend'),
                'pink'      => esc_html__('Pink', 'amy-movie-extend'),
                'blue'      => esc_html__('Blue', 'amy-movie-extend'),
                'custom'    => esc_html__('Custom', 'amy-movie-extend'),
            ],
            'default'   => 'red',
            'dependency'    => ['disable_skin', '==', '0'],
        ],

        [
            'id'        => 'skin_custom',
            'type'      => 'color',
            'title'     => esc_html__('Custom', 'amy-movie-extend'),
            'dependency'    => ['skin_color|disable_skin', '==|==', 'custom|0'],
        ],

        [
            'id'        => 'skin_heading_page_title',
            'type'      => 'heading',
            'content'   => esc_html__('Page title', 'amy-movie-extend'),
        ],

        [
            'id'        => 'pagetitle_color',
            'type'      => 'color',
            'title'     => esc_html__('Color', 'amy-movie-extend'),
            'output'    => '#amy-page-header .amy-page-title h1'
        ],

        [
            'id'        => 'skin_heading_topbar',
            'type'      => 'heading',
            'content'   => esc_html__('TopBar', 'amy-movie-extend'),
        ],

        [
            'id'        => 'topbar_bg_color',
            'type'      => 'color',
            'title'     => esc_html__('Background Color', 'amy-movie-extend'),
            'output'    => '#amy-top-bar'
        ],

        [
            'id'        => 'topbar_text_color',
            'type'      => 'color',
            'title'     => esc_html__('Text Color', 'amy-movie-extend'),
            'output'    => '#amy-top-bar'
        ],

        [
            'id'        => 'topbar_link_color',
            'type'      => 'link_color',
            'title'     => esc_html__('Link Color', 'amy-movie-extend'),
            'output'    => '#amy-top-bar a'
        ],


        [
            'id'        => 'skin_heading_header',
            'type'      => 'heading',
            'content'   => esc_html__('Header', 'amy-movie-extend'),
        ],

        [
            'id'        => 'header_bg_color',
            'type'      => 'color',
            'title'     => esc_html__('Background Color', 'amy-movie-extend'),
            'output'    => '#masthead.dark, #masthead, .header-left, #amy-masthead'
        ],

        [
            'id'        => 'skin_heading_menu',
            'type'      => 'heading',
            'content'   => esc_html__('Main Menu', 'amy-movie-extend'),
        ],

        [
            'id'        => 'menu_color',
            'type'      => 'color',
            'title'     => esc_html__('Menu Color', 'amy-movie-extend'),
            'output'    => '#masthead.dark .amy-primary-navigation ul.nav-menu > li > a, .amy-primary-navigation ul.nav-menu > li > a'
        ],

        [
            'id'        => 'menu_hover_color',
            'type'      => 'color',
            'title'     => esc_html__('Menu Hover Color', 'amy-movie-extend'),
            'output'    => '#masthead.dark .amy-primary-navigation ul.nav-menu > li:hover > a, .amy-primary-navigation ul.nav-menu > li:hover > a'
        ],

        [
            'id'        => 'submenu_background_color',
            'type'      => 'color',
            'title'     => esc_html__('Submenu Background Color', 'amy-movie-extend')
        ],

        [
            'id'        => 'submenu_color',
            'type'      => 'color',
            'title'     => esc_html__('Submenu Color', 'amy-movie-extend'),
            'output'    => '#masthead.dark .amy-primary-navigation ul.nav-menu > li ul > li > a, .amy-primary-navigation ul.nav-menu > li ul > li > a'
        ],

        [
            'id'        => 'submenu_hover_color',
            'type'      => 'color',
            'title'     => esc_html__('Submenu Hover Color', 'amy-movie-extend'),
            'output'    => '#masthead.dark .amy-primary-navigation ul.nav-menu > li:hover > a, .amy-primary-navigation ul.nav-menu > li:hover > a'
        ],

        [
            'id'        => 'submenu_border_color',
            'type'      => 'color',
            'title'     => esc_html__('Submenu Border Color', 'amy-movie-extend'),
            'output'    => '#masthead.dark .amy-primary-navigation ul.nav-menu > li ul > li > a, .amy-primary-navigation ul.nav-menu > li ul > li > a',
            'output_mode'   => 'border-color',
        ],
    ]
]);