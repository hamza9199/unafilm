<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Social', 'amy-movie-extend'),
    'icon'      => 'fa fa-share-alt',
    'parent'    => 'general',
    'fields'    => [
        [
            'id'                => 'social_list',
            'type'              => 'group',
            'title'             => esc_html__('Social List', 'amy-movie-extend'),
            'button_title'      => esc_html__('Add New Social', 'amy-movie-extend'),
            'accordion_title'   => esc_html__('New Social', 'amy-movie-extend'),
            'fields'            => [
                [
                    'id'        => 'title',
                    'type'      => 'text',
                    'title'     => esc_html__('Title', 'amy-movie-extend')
                ],

                [
                    'id'        => 'icon',
                    'type'      => 'icon',
                    'title'     => esc_html__('Icon', 'amy-movie-extend')
                ],

                [
                    'id'        => 'link',
                    'type'      => 'text',
                    'title'     => esc_html__('Link', 'amy-movie-extend')
                ]
            ],
            'default'       => [
                [
                    'icon'  => 'fa fa-facebook',
                    'title' => esc_html__('Facebook', 'amy-movie-extend'),
                    'link'  => '#'
                ],

                [
                    'icon'  => 'fa fa-twitter',
                    'title' => esc_html__('Twitter', 'amy-movie-extend'),
                    'link'  => '#'
                ],
            ]
        ],
    ]
]);