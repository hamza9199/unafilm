<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

CSF::createSection(AMY_MOVIE_OPTION, [
    'icon'      => 'fa fa-font',
    'title'     => esc_html__('Typography', 'amy-movie-extend'),
    'parent'    => 'general',
    'fields'    => [
        [
            'id'        => 'body_typography',
            'type'      => 'typography',
            'title'     => esc_html__('Body', 'amy-movie-extend'),
            'output'    => 'body',
            'default'   => [
                'color'         => '#333',
                'font-family'   => 'Roboto Condensed',
                'font-size'     => '14',
                'font-weight'   => '400',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],

        [
            'id'        => 'menu_typography',
            'type'      => 'typography',
            'title'     => esc_html__('Menu', 'amy-movie-extend'),
            'output'    => '#amy-site-nav .sub-menu .menu-item a',
            'default'   => [
                'font-family'   => 'Roboto Condensed',
                'font-weight'   => '700',
                'font-size'     => '15',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],

        [
            'id'        => 'h1_typography',
            'type'      => 'typography',
            'title'     => esc_html__('H1', 'amy-movie-extend'),
            'output'    => 'h1',
            'default'   => [
                'color'         => '#333',
                'font-family'   => 'Roboto Condensed',
                'font-weight'   => '700',
                'font-size'     => '36',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],

        [
            'id'        => 'h2_typography',
            'type'      => 'typography',
            'title'     => esc_html__('H2', 'amy-movie-extend'),
            'output'    => 'h2',
            'default'   => [
                'color'         => '#333',
                'font-family'   => 'Roboto Condensed',
                'font-weight'   => '700',
                'font-size'     => '30',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],

        [
            'id'        => 'h3_typography',
            'type'      => 'typography',
            'title'     => esc_html__('H3', 'amy-movie-extend'),
            'output'    => 'h3',
            'default'   => [
                'color'         => '#333',
                'font-family'   => 'Roboto Condensed',
                'font-weight'   => '700',
                'font-size'     => '24',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],

        [
            'id'        => 'h4_typography',
            'type'      => 'typography',
            'title'     => esc_html__('H4', 'amy-movie-extend'),
            'output'    => 'h4',
            'default'   => [
                'color'         => '#333',
                'font-family'   => 'Roboto Condensed',
                'font-weight'   => '700',
                'font-size'     => '18',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],

        [
            'id'        => 'h5_typography',
            'type'      => 'typography',
            'title'     => esc_html__('H5', 'amy-movie-extend'),
            'output'    => 'h5',
            'default'   => [
                'color'         => '#333',
                'font-family'   => 'Roboto Condensed',
                'font-weight'   => '700',
                'font-size'     => '14',
                'unit'          => 'px',
                'type'          => 'google'
            ]
        ],
    ]
]);