<?php
use AmyMovie\Core\Base;

$base = new Base();

$list_episodes_params = [
    [
        'id'			=> 'title',
        'type'			=> 'text',
        'title'			=> esc_html__('Title', 'amy-movie-extend'),
    ],

    [
        'id'			=> 'url',
        'type'			=> 'text',
        'title'			=> esc_html__('Url', 'amy-movie-extend'),
    ]
];

if ($base->get_option('enable_streaming', false)) {
    $list_episodes_params[] = array(
        'id'				=> 'list_server',
        'type'				=> 'group',
        'title'				=> esc_html__('List Server', 'amy-movie-extend'),
        'button_title'		=> esc_html__('Add New Server', 'amy-movie-extend'),
        'accordion'			=> true,
        'accordion_title'	=> esc_html__('New Server', 'amy-movie-extend'),
        'fields'			=> array(
            array(
                'id'			=> 'title',
                'type'			=> 'text',
                'title'			=> esc_html__('Server Title', 'amy-movie-extend'),
            ),

            array(
                'id'			=> 'link',
                'type'			=> 'text',
                'title'			=> esc_html__('Server Link', 'amy-movie-extend'),
            )
        ),
    );
}

CSF::createSection(AMY_MOVIE_SINGE_SEASON, [
    'fields'    => [
        [
            'id'            => '_tv_show',
            'type'          => 'select',
            'title'         => esc_html__('Select Tv Show', 'amy-movie-extend'),
            'options'       => 'posts',
            'query_args'    => [
                'post_type' => 'amy_tvshow'
            ]
        ],

        [
            'id'				=> 'list_episodes',
            'type'				=> 'group',
            'title'				=> esc_html__('List Episodes', 'amy-movie-extend'),
            'button_title'		=> esc_html__('Add New Episode', 'amy-movie-extend'),
            'accordion'			=> true,
            'accordion_title'	=> esc_html__('New Episode', 'amy-movie-extend'),
            'fields'			=> $list_episodes_params,
        ]
    ]
]);