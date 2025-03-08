<?php
use AmyMovie\Core\Base;

$base = new Base();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Single', 'amy-movie-extend'),
    'icon'      => 'fab fa-monero',
    'parent'    => 'movie',
    'fields'    => [
        [
            'id'		=> 'movie_single_heading',
            'type'		=> 'heading',
            'content'	=> esc_html__('Single Movie', 'amy-movie-extend'),
        ],

        [
            'id'				=> 'movie_sidebar_default',
            'type'				=> 'button_set',
            'title'				=> esc_html__('Layout', 'amy-movie-extend'),
            'options'			=> [
                'right'				=> esc_html__('Right Sidebar', 'amy-movie-extend'),
                'left'				=> esc_html__('Left Sidebar', 'amy-movie-extend'),
                'full'				=> esc_html__('No Sidebar', 'amy-movie-extend'),
            ],
            'default'			=> 'right',
        ],

        [
            'id'				=> 'movie_widget',
            'type'				=> 'select',
            'title'				=> esc_html__('Sidebar Widget', 'amy-movie-extend'),
            'options'			=> $base->get_registered_sidebars(),
            'default_option'	=> esc_html__('Select a sidebar (default primary)', 'amy-movie-extend'),
            'dependency'		=> array('movie_sidebar_default', 'any', 'right,left'),
            'default'			=> 'movie-bar',
        ],

        [
            'id'				=> 'list_fields_visible',
            'type'				=> 'select',
            'title'				=> esc_html__('List Fields Visbile', 'amy-movie-extend'),
            'options'			=> [
                'movie_release' 	=> esc_html__('Release', 'amy-movie-extend'),
                'movie_imdb' 		=> esc_html__('Imdb', 'amy-movie-extend'),
                'movie_language' 	=> esc_html__('Language', 'amy-movie-extend'),
                'movie_genre' 		=> esc_html__('Genre', 'amy-movie-extend'),
                'movie_actor' 		=> esc_html__('Actor', 'amy-movie-extend'),
                'movie_director' 	=> esc_html__('Director', 'amy-movie-extend'),
                'movie_cinema' 		=> esc_html__('Cinema', 'amy-movie-extend')
            ],
            'chosen'	        => true,
            'multiple'          => true,
            'default'			=> [
                'movie_release',
                'movie_imdb',
                'movie_language',
                'movie_genre',
                'movie_actor',
                'movie_director',
                'movie_cinema'
            ],
        ],

        [
            'id'				=> 'single_movie_share_social',
            'type'				=> 'select',
            'title'				=> esc_html__('List Social Share', 'amy-movie-extend'),
            'options'			=> [
                'facebook'		=> esc_html__('Facebook', 'amy-movie-extend'),
                'twitter'		=> esc_html__('Twitter', 'amy-movie-extend'),
                'pinterest'		=> esc_html__('Pinterest', 'amy-movie-extend'),
                'digg'			=> esc_html__('Digg', 'amy-movie-extend'),
                'linkedin'		=> esc_html__('Linkedin', 'amy-movie-extend'),
                'reddit'		=> esc_html__('Reddit', 'amy-movie-extend'),
                'skype'			=> esc_html__('Skype', 'amy-movie-extend'),
                'tumblr'		=> esc_html__('Tumblr', 'amy-movie-extend'),
                'vk'			=> esc_html__('Vk', 'amy-movie-extend'),
                'weibo'			=> esc_html__('Weibo', 'amy-movie-extend'),
                'xing'			=> esc_html__('Xing', 'amy-movie-extend'),
                'yahoo'			=> esc_html__('Yahoo', 'amy-movie-extend'),
            ],
            'default'			=> ['facebook', 'twitter', 'pinterest'],
            'chosen'	        => true,
            'multiple'          => true,
        ],

        [
            'id'		=> 'enable_movie_rating',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable User Rate', 'amy-movie-extend'),
            'label'		=> esc_html__('If enable user can rate movie in page single movie', 'amy-movie-extend'),
            'default'	=> false,
        ],

        [
            'id'		=> 'movie_comment',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Show comments in movie', 'amy-movie-extend'),
            'default'	=> true,
        ],

        [
            'id'		=> 'movie_showtime',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Showtime', 'amy-movie-extend'),
            'default'	=> true,
        ],

        [
            'id'		=> 'movie_showtime_type',
            'type'		=> 'button_set',
            'title'		=> esc_html__('Showtime type', 'amy-movie-extend'),
            'options'		=> [
                'all'		=> esc_html__('All Days', 'amy-movie-extend'),
                'cm'		=> esc_html__('Coming Soon', 'amy-movie-extend'),
            ],
            'default'	=> 'full',
            'dependency'	=> ['movie_showtime', '==', '1']
        ],

        [
            'id'		=> 'show_recent_movie',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Show Recent Movie', 'amy-movie-extend'),
            'default'	=> false
        ],

        [
            'id'			=> 'recent_movie_type',
            'type'			=> 'button_set',
            'title'			=> esc_html__('Recent Movie', 'amy-movie-extend'),
            'options'		=> [
                'recent'		=> esc_html__('Recent Movie', 'amy-movie-extend'),
                'random'		=> esc_html__('Random Movie', 'amy-movie-extend'),
            ],
            'dependency'	=> ['show_recent_movie', '==', '1'],
        ],

        [
            'id'			=> 'recent_movie_title',
            'type'			=> 'text',
            'title'			=> esc_html__('Recent Movie Title', 'amy-movie-extend'),
            'dependency'	=> ['show_recent_movie', '==', '1'],
        ],

        [
            'id'			=> 'recent_movie_number',
            'type'			=> 'text',
            'title'			=> esc_html__( 'Recent Movie Number', 'amy-movie-extend' ),
            'default'		=> '5',
            'dependency'	=> [ 'show_recent_movie', '==', '1'],
        ],
    ]
]);