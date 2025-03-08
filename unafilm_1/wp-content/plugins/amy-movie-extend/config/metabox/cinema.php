<?php
use AmyMovie\Core\Base;

$base = new Base();

if (!$base->get_option('enable_m_cinema', false)) {
    return;
}

$options = [
    [
        'id' => 'date',
        'type' => 'date',
        'title' => esc_html__('Date', 'amy-movie-extend'),
    ],

    [
        'id' => 'hour',
        'type' => 'text',
        'title' => esc_html__('Time', 'amy-movie-extend'),
        'after' => esc_html__('List hour in date. Eg: 12h30, 20h24', 'amy-movie-extend'),
    ]
];

if ($base->get_option('enable_m_ticket', false) == true
    && class_exists('woocommerce')
    && defined('SMARTCMS_SRW_URL')) {

    $options[] = [
        'title'		=> esc_html__('Product ticket', 'amy-movie-extend'),
        'id'		=> 'product',
        'type'		=> 'select',
        'options' 	=> 'posts',
        'query_args'=> [
            'post_type'         => 'product',
            'posts_per_page'    => '-1'
        ]
    ];
} else {
    $options[] = [
        'id'	=> 'link',
        'type'	=> 'text',
        'title'	=> esc_html__('Link Buy Ticket', 'amy-movie-extend')
    ];
}

if ($base->get_option('is_single_cinema', false) == true) {
    CSF::createSection(AMY_MOVIE_SINGE_BLOCK_SHOWTIME, [
        'fields'    => [
            [
                'id'				=> '_showtimes',
                'type'				=> 'group',
                'button_title'		=> esc_html__('Add new Showtime', 'amy-movie-extend'),
                'accordion_title'	=> esc_html__('Showtime', 'amy-movie-extend'),
                'fields'			=> $options
            ]
        ]
    ]);
} else {
    CSF::createSection(AMY_MOVIE_SINGE_BLOCK_SHOWTIME, [
        'fields'    => [
            [
                'id' 				=> '_cinema',
                'type' 				=> 'group',
                'button_title' 		=> esc_html__('Add new Cinema', 'amy-movie-extend'),
                'accordion_title' 	=> esc_html__('Cinema', 'amy-movie-extend'),
                'fields' => array(
                    array(
                        'id' 		=> 'select_cinema',
                        'type' 		=> 'select',
                        'class'		=> 'chosen',
                        'title' 	=> esc_html__('Cinema', 'amy-movie-extend'),
                        'options' 	=> 'posts',
                        'query_args'=> [
                            'post_type'         => 'amy_cinema',
                            'posts_per_page'    => '-1'
                        ]
                    ),

                    array(
                        'id'				=> '_showtimes',
                        'type'				=> 'group',
                        'button_title'		=> esc_html__('Add new Showtime', 'amy-movie-extend'),
                        'accordion_title'	=> esc_html__('Showtime', 'amy-movie-extend'),
                        'fields'			=> $options
                    ),
                ),
            ]
        ]
    ]);
}