<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Media', 'amy-movie-extend'),
    'icon'      => 'fa fa-image',
    'parent'    => 'general',
    'fields'    => [
        [
            'id'                => 'custom_image_sizes',
            'type'              => 'accordion',
            'title'             => esc_html__('Custom Image Size', 'amy-movie-extend'),
            'accordions'        => [
                [
                    'title'     => esc_html__('Movie List', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'movie_list_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 205,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_list_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 347,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_list_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Movie Grid Layout 1', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'movie_grid_layout_1_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 360,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_1_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 618,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_1_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Movie Grid Layout 2', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'movie_grid_layout_2_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 164,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_2_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 220,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_2_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Movie Grid Layout 3', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'movie_grid_layout_3_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 360,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_3_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 618,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_3_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Movie Grid Layout 4', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'movie_grid_layout_4_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 360,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_4_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 618,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_grid_layout_4_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Movie Carousel', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'movie_carousel_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 233,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_carousel_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 396,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'movie_carousel_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Single Movie Has Sidebar', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'single_movie_has_bar_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 204,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'single_movie_has_bar_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 350,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'single_movie_has_bar_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Single Movie Full Width', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'single_movie_full_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 360,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'single_movie_full_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 618,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'single_movie_full_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('Recent Movie', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'recent_movie_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 164,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'recent_movie_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 220,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'recent_movie_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Carousel 1', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_carousel_1_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 174,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_carousel_1_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 300,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_carousel_1_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Carousel 2', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_carousel_2_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 258,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_carousel_2_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 444,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_carousel_2_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Carousel 3', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_carousel_3_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 214,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_carousel_3_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 368,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_carousel_3_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Grid 1', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_grid_1_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 214,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_1_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 368,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_1_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Grid 2', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_grid_2_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 196,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_2_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 336,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_2_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Grid 3', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_grid_3_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 174,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_3_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 300,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_3_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Grid 4', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_grid_4_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 132,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_4_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 220,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_grid_4_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 List', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_list_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 196,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_list_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 336,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_list_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Showtime 1', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_st_1_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 264,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_1_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 396,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_1_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Showtime 2', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_st_2_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 174,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_2_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 261,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_2_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Showtime 3', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_st_3_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 214,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_3_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 321,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_3_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],

                [
                    'title'     => esc_html__('V2 Showtime 4', 'amy-movie-extend'),
                    'fields'    => [
                        [
                            'id'		=> 'v2_st_4_width',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Width', 'amy-movie-extend'),
                            'default'	=> 196,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_4_height',
                            'type'		=> 'number',
                            'title'		=> esc_html__('Height', 'amy-movie-extend'),
                            'default'	=> 294,
                            'unit'		=> 'px'
                        ],

                        [
                            'id'		=> 'v2_st_4_is_crop',
                            'type'		=> 'switcher',
                            'title'		=> esc_html__('Crop', 'amy-movie-extend'),
                            'default'	=> true,
                        ],
                    ]
                ],
            ],
        ],
    ]
]);