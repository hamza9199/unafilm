<?php
use AmyMovie\Core\Base;

$base = new Base();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Person', 'amy-movie-extend'),
    'icon'      => 'fas fa-people-arrows',
    'parent'    => 'movie',
    'fields'    => [
        array(
            'id'		=> 'movie_person_heading',
            'type'		=> 'heading',
            'content'	=> esc_html__('Person Page', 'amy-movie-extend'),
        ),

        array(
            'id'				=> 'person_sidebar',
            'type'				=> 'button_set',
            'title'				=> esc_html__('Sidebar', 'amy-movie-extend'),
            'options'			=> array(
                'right'				=> esc_html__('Right Sidebar', 'amy-movie-extend'),
                'left'				=> esc_html__('Left Sidebar', 'amy-movie-extend'),
                'full'				=> esc_html__('No Sidebar', 'amy-movie-extend'),
            ),
            'default'			=> 'full',
        ),

        array(
            'id'				=> 'person_widget',
            'type'				=> 'select',
            'class'				=> 'chosen',
            'title'				=> esc_html__('Sidebar Widget', 'amy-movie-extend'),
            'options'			=> $base->get_registered_sidebars(),
            'default_option'	=> esc_html__('Select a sidebar (default primary)', 'amy-movie-extend'),
            'dependency'		=> array('person_sidebar', 'any', 'right,left'),
            'default'			=> 'right-bar',
        ),

        array(
            'id'			=> 'movie_person_orderby',
            'type'			=> 'select',
            'class'			=> 'chosen',
            'title'			=> esc_html__('Movie Order By', 'amy-movie-extend'),
            'options'		=> array(
                '_rating_average'	=> esc_html__('Rate', 'amy-movie-extend'),
                '_release'	=> esc_html__('Release Date', 'amy-movie-extend'),
                '_amy_post_views_count'	=> esc_html__('Post Views', 'amy-movie-extend'),
                'ID'					=> esc_html__('Post ID', 'amy-movie-extend'),
                'title'					=> esc_html__('Title', 'amy-movie-extend'),
                'date'					=> esc_html__('Date', 'amy-movie-extend'),
                'rand'					=> esc_html__('Random Order', 'amy-movie-extend'),
                'comment_count'			=> esc_html__('Comment Count', 'amy-movie-extend'),
            ),
            'default'		=> 'date'
        ),

        array(
            'id' 			=> 'movie_person_number',
            'type' 			=> 'text',
            'title' 		=> esc_html__('Movies Per Page', 'amy-movie-extend'),
            'default'		=> '5'
        ),
    ]
]);