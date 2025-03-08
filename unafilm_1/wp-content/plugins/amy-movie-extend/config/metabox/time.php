<?php
use AmyMovie\Core\Base;

$base = new Base();

if (!$base->get_option('enable_start_end_date', false)) {
    return;
}

CSF::createSection(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title'     => esc_html__('Start & End Date', 'amy-movie-extend'),
    'fields'    => [
        [
            'id'    => '_start_date',
            'type'  => 'date',
            'title' => esc_html__('Start Date', 'amy-movie-extend'),
            'settings'      => [
                'dateFormat'    => 'yy-mm-dd',
            ],
        ],

        [
            'id'    => '_end_date',
            'type'  => 'date',
            'title' => esc_html__('End Date', 'amy-movie-extend'),
            'settings'      => [
                'dateFormat'    => 'yy-mm-dd',
            ],
        ]
    ]
]);