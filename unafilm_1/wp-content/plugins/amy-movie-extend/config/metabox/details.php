<?php
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;

$base   = new Base();
$movie  = new MovieHelpers();

$defaults_fields	= $base->get_option('movie_default_fields', $movie->default_fields());
$custom_fields		= $base->get_option('movie_custom_fields');

$movie_field		= [];

//Release
if (in_array('movie_release', $defaults_fields)) {
    $movie_field[] = [
        'id'            => '_release',
        'type'          => 'date',
        'settings'      => [
            'dateFormat'    => 'yy-mm-dd',
        ],
        'title'         => esc_html__('Release', 'amy-movie-extend'),
    ];
}

//Duration
if (in_array('movie_duration', $defaults_fields)) {
    $movie_field[] = [
        'id'	=> '_duration',
        'type'	=> 'text',
        'title'	=> esc_html__('Duration', 'amy-movie-extend'),
        'after'	=> '<em>min</em>',
    ];
}

//Imdb
if (in_array('movie_imdb', $defaults_fields)) {
    $movie_field[] = [
        'id'	=> '_imdb',
        'type'	=> 'text',
        'title'	=> esc_html__('Imdb rating', 'amy-movie-extend'),
    ];
}

//Mpaa
if (in_array('movie_mpaa', $defaults_fields)) {
    $movie_field[] = [
        'id'	=> '_mpaa',
        'type'	=> 'text',
        'title'	=> esc_html__('MPAA', 'amy-movie-extend'),
    ];
}

//Language
if (in_array('movie_language', $defaults_fields)) {
    $movie_field[] = [
        'id'	=> '_language',
        'type'	=> 'text',
        'title'	=> esc_html__('Language', 'amy-movie-extend'),
    ];
}

if (!empty($custom_fields)) {
    foreach ($custom_fields as $field) {
        if ($field['type'] == 'text') {
            $name = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';

            $movie_field[] = [
                'id'	=> sanitize_title($name),
                'type'	=> 'text',
                'title'	=> $name,
            ];
        }
    }
}


CSF::createSection(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title'     => esc_html__('Details', 'amy-movie-extend'),
    'fields'    => $movie_field
]);