<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('General', 'amy-movie-extend'),
    'icon'      => 'fas fa-tools',
    'parent'    => 'movie',
    'fields'    => [
        [
            'id'		=> 'movie_heading_cinema',
            'type'		=> 'heading',
            'content'	=> esc_html__('Cinema System', 'amy-movie-extend'),
        ],

        [
            'id'		=> 'enable_m_cinema',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Cinema System', 'amy-movie-extend'),
            'default'	=> false,
            'label'		=> esc_html__('If disable all featured interest cinema will disable', 'amy-movie-extend')
        ],

        [
            'id'		=> 'is_single_cinema',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Is Single Cinema', 'amy-movie-extend'),
            'default'	=> false,
            'dependency'	=> ['enable_m_cinema', '==', '1']
        ],

        [
            'id'		=> 'enable_m_ticket',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Book Ticket System', 'amy-movie-extend'),
            'default'	=> false,
            'dependency'	=> ['enable_m_cinema', '==', '1']
        ],

        [
            'id'		=> 'movie_heading_function_fields',
            'type'		=> 'heading',
            'content'	=> esc_html__('Functions', 'amy-movie-extend'),
        ],

        [
            'id'		=> 'enable_start_end_date',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Start & End Date', 'amy-movie-extend'),
            'default'	=> false,
        ],

        [
            'id'		=> 'enable_streaming',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Streaming System', 'amy-movie-extend'),
            'default'	=> false,
        ],

        [
            'id'		=> 'single_movie_stream_page',
            'type'		=> 'select',
            'title'		=> esc_html__('Single Movie Stream Page', 'amy-movie-extend'),
            'options'	=> 'pages',
            'dependency'	=> ['enable_streaming', '==', '1'],
        ],

        [
            'id'        => 'single_movie_stream_prefix_name',
            'type'      => 'text',
            'title'     => esc_html__('Movie Prefix Name', 'amy-movie-extend'),
            'default'   => 'movie'
        ],

        [
            'id'        => 'single_movie_stream_prefix_name_season',
            'type'      => 'text',
            'title'     => esc_html__('Season Prefix Name', 'amy-movie-extend'),
            'default'   => 'season'
        ],

        [
            'id'		=> 'movie_heading_default_fields',
            'type'		=> 'heading',
            'content'	=> esc_html__('Default Fields', 'amy-movie-extend'),
        ],

        [
            'id'		=> 'movie_default_fields',
            'type'		=> 'select',
            'chosen'	=> true,
            'multiple'  => true,
            'title'		=> esc_html__('Enable Default Fields', 'amy-movie-extend'),
            'options'	=> [
                'movie_release'		=> esc_html__('Release Date', 'amy-movie-extend'),
                'movie_duration'	=> esc_html__('Duration', 'amy-movie-extend'),
                'movie_imdb'		=> esc_html__('IMDB', 'amy-movie-extend'),
                'movie_mpaa'		=> esc_html__('MPAA', 'amy-movie-extend'),
                'movie_language'	=> esc_html__('Language', 'amy-movie-extend'),
                'movie_genre'		=> esc_html__('Genre', 'amy-movie-extend'),
                'movie_actor'		=> esc_html__('Actor', 'amy-movie-extend'),
                'movie_director'	=> esc_html__('Director', 'amy-movie-extend'),
            ],
            'default'	=> [
                'movie_release',
                'movie_duration',
                'movie_imdb',
                'movie_mpaa',
                'movie_language',
                'movie_genre',
                'movie_actor',
                'movie_director'
            ]
        ],

        [
            'id'		=> 'movie_heading_custom_fields',
            'type'		=> 'heading',
            'content'	=> esc_html__('Custom Fields', 'amy-movie-extend')
        ],

        [
            'id'				=> 'movie_custom_fields',
            'type'				=> 'group',
            'button_title'		=> esc_html__('Add New Field', 'amy-movie-extend'),
            'accordion_title'	=> esc_html__('New Field', 'amy-movie-extend'),
            'fields'			=> [
                [
                    'id'			=> 'name',
                    'type'			=> 'text',
                    'title'			=> esc_html__('Field Name', 'amy-movie-extend'),
                ],
                [
                    'id'			=> 'type',
                    'type'			=> 'select',
                    'class'			=> 'chosen',
                    'title'			=> esc_html__('Type', 'amy-movie-extend'),
                    'options'		=> [
                        'text'			=> esc_html__('Text', 'amy-movie-extend'),
                        'date'			=> esc_html__('Date', 'amy-movie-extend'),
                        'category'		=> esc_html__('Category', 'amy-movie-extend'),
                        'person'		=> esc_html__('Person', 'amy-movie-extend'),
                    ]
                ],
                [
                    'id'			=> 'singular_name',
                    'type'			=> 'text',
                    'title'			=> esc_html__('Singular Name', 'amy-movie-extend'),
                    'dependency'	=> ['type', 'any', 'category,person']
                ]
            ],
        ]
    ]
]);