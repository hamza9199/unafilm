<?php
CSF::createSection(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title'     => esc_html__('Media', 'amy-movie-extend'),
    'fields'    => [
        [
            'id'    => '_gallery',
            'type'  => 'gallery',
            'title' => esc_html__('Gallery', 'amy-movie-extend'),
        ],

        [
            'id'              	=> '_trailer',
            'type'            	=> 'group',
            'button_title'    	=> esc_html__('Add new tralier', 'amy-movie-extend'),
            'accordion_title' 	=> esc_html__('Tralier', 'amy-movie-extend'),
            'title'				=> esc_html__('Tralier', 'amy-movie-extend'),
            'fields'			=> [
                [
                    'id'		=> '_link',
                    'type'		=> 'text',
                    'title'		=> esc_html__('Tralier link', 'amy-movie-extend'),
                    'desc'		=> esc_html__('Support youtube or vimeo', 'amy-movie-extend'),
                    'info'		=> esc_html__('Youtube link: https://www.youtube.com/watch?v=, Vimeo link: https://vimeo.com/', 'amy-movie-extend'),
                ],
            ],
        ]
    ]
]);