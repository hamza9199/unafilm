<?php
CSF::createSection(AMY_MOVIE_SINGE_CINEMA, [
    'fields'    => [
        [
            'id'    => '_banner',
            'type'  => 'media',
            'title' => esc_html__('Banner', 'amy-movie-extend'),
        ],

        [
            'id'    => '_gallery',
            'type'  => 'gallery',
            'title' => esc_html__('Gallery', 'amy-movie-extend'),
        ],

        [
            'id'    => '_address',
            'type'  => 'text',
            'title' => esc_html__('Address', 'amy-movie-extend'),
        ],

        [
            'id'    => '_phone',
            'type'  => 'text',
            'title' => esc_html__('Phone', 'amy-movie-extend'),
        ],

        [
            'id'    => '_website',
            'type'  => 'text',
            'title' => esc_html__('Website', 'amy-movie-extend'),
        ],

        [
            'id'    => '_email',
            'type'  => 'text',
            'title' => esc_html__('Email', 'amy-movie-extend'),
        ],

        [
            'id'    	=> '_map',
            'type'  	=> 'textarea',
            'title' 	=> esc_html__('Google Map Iframe', 'amy-movie-extend'),
            'sanitize' 	=> true,
            'after'		=> esc_html__('Visit Google maps to create your map (Step by step: 1) Find location 2) Click the cog symbol in the lower right corner and select "Share or embed map" 3) On modal window select "Embed map" 4) Copy iframe code and paste it).', 'amy-movie-extend'),
        ],
    ]
]);