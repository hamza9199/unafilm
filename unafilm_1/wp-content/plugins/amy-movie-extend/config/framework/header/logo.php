<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Logo', 'amy-movie-extend'),
    'icon'      => 'fa fa-heart',
    'parent'    => 'header',
    'fields'    => [
        [
            'id'	=> 'logo',
            'type'	=> 'media',
            'title'	=> esc_html__('Site Logo', 'amy-movie-extend'),
            'url'   => false
        ],

        [
            'id'	        => 'logo_padding',
            'type'	        => 'spacing',
            'title'	        => esc_html__('Logo Padding', 'amy-movie-extend'),
            'output'        => '#amy-site-logo',
            'output_mode'   => 'padding',
            'top'	        => true,
            'bottom'        => true,
            'left'          => false,
            'right'         => false
        ],
    ]
]);