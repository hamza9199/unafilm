<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Page Header', 'amy-movie-extend'),
    'icon'      => 'fas fa-headset',
    'fields'    => [
        [
            'id'		=> 'page_header_background',
            'type'		=> 'background',
            'title'		=> esc_html__('Background', 'amy-movie-extend'),
            'output'    => '#amy-page-header'
        ],
        
        [
            'id'			=> 'text_position',
            'type'			=> 'button_set',
            'title'			=> esc_html__('Text Position', 'amy-movie-extend'),
            'options'		=> [
                'center'	=> esc_html__('Center', 'amy-movie-extend'),
                'left'		=> esc_html__('Left', 'amy-movie-extend'),
                'right'		=> esc_html__('Right', 'amy-movie-extend'),
            ],
            'default'		=> 'center',
        ],

        [
            'id'		=> 'page_header_padding',
            'type'		=> 'spacing',
            'title'		=> esc_html__('Padding', 'amy-movie-extend'),
            'output'        => '#amy-page-header .amy-page-title .page-title',
            'output_mode'   => 'padding',
            'top'	        => true,
            'bottom'        => true,
            'left'          => false,
            'right'         => false
        ],

        [
            'id'		=> 'page_header_overlay',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Overlay', 'amy-movie-extend'),
        ],

        [
            'id'			=> 'page_header_overlay_color',
            'type'			=> 'color',
            'title'			=> esc_html__('Overlay Color', 'amy-movie-extend'),
            'dependency'	=> ['page_header_overlay', '==', '1'],
        ],
    ]
]);