<?php
use AmyMovie\Core\Base;

$base = new Base();

if (!$base->get_option('enable_streaming', false)) {
    return;
}

CSF::createSection(AMY_MOVIE_SINGE_BLOCK_STREAM, [
    'fields'    => [
        [
            'id' => 'servers',
            'type' => 'group',
            'button_title' => esc_html__('Add Server', 'amy-movie-extend'),
            'accordion_title' => esc_html__('New Server', 'amy-movie-extend'),
            'fields' => [
                [
                    'id' => 'title',
                    'type' => 'text',
                    'title' => esc_html__('Server Title', 'amy-movie-extend'),
                ],
                [
                    'id' => 'parts',
                    'type' => 'group',
                    'title' => esc_html__('Parts', 'amy-movie-extend'),
                    'button_title' => esc_html__('Add Part', 'amy-movie-extend'),
                    'accordion_title' => esc_html__('New Part', 'amy-movie-extend'),
                    'fields' => [
                        [
                            'id' => 'title',
                            'type' => 'text',
                            'title' => esc_html__('Part Title', 'amy-movie-extend'),
                        ],
                        [
                            'id' => 'link',
                            'type' => 'text',
                            'title' => esc_html__('Video Link', 'amy-movie-extend'),
                        ]
                    ]
                ]
            ]
        ]
    ]
]);