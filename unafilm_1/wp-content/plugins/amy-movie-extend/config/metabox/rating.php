<?php
use AmyMovie\Movie\Movie;

$total 	= 0;
$point 	= 0;
$ave    = 0;

if (isset($_GET['post'])) {
    $single_movie   = new Movie($_GET['post']);
    $total          = $single_movie->get_rate_total_count();
    $point          = $single_movie->get_rate_total_point();
    $ave            = $single_movie->get_rate_average();
}

$note = 'Now: ' . $total . ' turn rate, ' . $point . ' total points, average: ' . $ave . '';

CSF::createSection(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title'     => esc_html__('Rating', 'amy-movie-extend'),
    'fields'    => [
        [
            'type'    => 'notice',
            'class'   => 'success',
            'content' => $note,
        ],
        [
            'id'		=> 'custom_rating',
            'type'		=> 'switcher',
            'default'	=> false,
            'title'		=> esc_html__('Custom rating', 'amy-movie-extend'),
        ],

        [
            'id'			=> '_rating_total_count',
            'type'			=> 'number',
            'title'			=> esc_html__('Turn rating', 'amy-movie-extend'),
            'dependency'	=> ['custom_rating', '==', true],
            'default'		=> $total,
        ],

        [
            'id'			=> '_rating_total_point',
            'type'			=> 'number',
            'title'			=> esc_html__('Total Points', 'amy-movie-extend'),
            'dependency'	=> ['custom_rating', '==', true],
            'default'		=> $point,
        ]
    ]
]);