<?php
CSF::createSection(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title'     => esc_html__('Poster & Banner', 'amy-movie-extend'),
    'fields'    => [
        [
            'id'    => '_poster',
            'type'  => 'media',
            'title' => esc_html__('Poster', 'amy-movie-extend'),
        ],

        [
            'id'    => '_banner',
            'type'  => 'media',
            'title' => esc_html__('Banner', 'amy-movie-extend'),
        ],
    ]
]);