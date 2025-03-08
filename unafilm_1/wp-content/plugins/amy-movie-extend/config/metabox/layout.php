<?php
use AmyMovie\Core\Base;

$base = new Base();

CSF::createSection(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title'     => esc_html__('Layout', 'amy-movie-extend'),
    'fields'    => [
        [
            'id'          => '_layout',
            'type'        => 'button_set',
            'radio'       => true,
            'options'     => array(
                ''          => esc_html__('Global', 'amy-movie-extend'),
                'left'      => esc_html__('Left Sidebar', 'amy-movie-extend'),
                'right'     => esc_html__('Right Sidebar', 'amy-movie-extend'),
                'full'      => esc_html__('No Sidebar', 'amy-movie-extend'),
            ),
            'title'         => esc_html__('Movie Sidebar', 'amy-movie-extend'),
            'default'       => ''
        ],
    ]
]);
