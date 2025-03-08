<?php
CSF::createSection(AMY_MOVIE_SINGE_TV_SHOW, [
    'fields'    => [
        [
            'id'				=> 'season_list',
            'type'				=> 'group',
            'title'				=> esc_html__('Season', 'amy-movie-extend'),
            'button_title'		=> esc_html__('Add New Season', 'amy-movie-extend'),
            'accordion'			=> true,
            'accordion_title'	=> esc_html__('New Season', 'amy-movie-extend'),
            'fields'			=> [
                [
                    'id' => 'select_season',
                    'type' => 'select',
                    'class'	=> 'chosen',
                    'title' => esc_html__('Season', 'amy-movie-extend'),
                    'options' 	=> 'posts',
                    'query_args'=> [
                        'post_type' => 'amy_season'
                    ]
                ],
            ],
        ]
    ]
]);