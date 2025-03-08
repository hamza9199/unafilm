<?php
use AmyMovie\Settings\Framework;
$framework = new Framework();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Topbar', 'amy-movie-extend'),
    'icon'      => 'fa fa-globe',
    'parent'    => 'header',
    'fields'    => [
        [
            'id'			=> 'top_bar',
            'type'			=> 'switcher',
            'title'			=> esc_html__('Enable Top Bar', 'amy-movie-extend'),
            'default'		=> 1,
        ],
        [
            'id'				=> 'top_bar_left',
            'type'				=> 'group',
            'title'				=> esc_html__('Top Bar Left', 'amy-movie-extend'),
            'button_title'		=> esc_html__('Add New Module', 'amy-movie-extend'),
            'accordion_title'	=> esc_html__('New Module', 'amy-movie-extend'),
            'dependency'		=> ['top_bar', '==', 1],
            'fields'			=> $framework->option_module_fields()
        ],
        [
            'id'				=> 'top_bar_right',
            'type'				=> 'group',
            'title'				=> esc_html__('Top Bar Right', 'amy-movie-extend'),
            'button_title'		=> esc_html__('Add New Module', 'amy-movie-extend'),
            'accordion_title'	=> esc_html__('New Module', 'amy-movie-extend'),
            'dependency'		=> ['top_bar', '==', 1],
            'fields'			=> $framework->option_module_fields()
        ],
    ]
]);