<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'		=> esc_html__('API', 'amy-movie-extend'),
    'icon'      => 'fas fa-compress-alt',
    'parent'    => 'imdb_import',
    'fields'	=> [
        array(
            'id'		=> 'imdb_heading',
            'type'		=> 'heading',
            'content'	=> esc_html__('API Settings', 'amy-movie-extend')
        ),

        array(
            'id'		=> 'api_type',
            'type'		=> 'select',
            'class'		=> 'chosen',
            'title'		=> esc_html__('Api Type', 'amy-movie-extend'),
            'options'	=> array(
                'omdb'		=> esc_html__('Free - Omdbapi', 'amy-movie-extend'),
                //'myapi'		=> esc_html__('Paid - Myapifilms', 'amy-movie-extend')
            ),
        ),

        array(
            'id'			=> 'omdb_api_key',
            'type'			=> 'text',
            'title'			=> esc_html__('OMDB key', 'amy-movie-extend'),
            'desc'			=> esc_html__('You need get api from http://www.omdbapi.com/apikey.aspx', 'amy-movie-extend'),
            'dependency'	=> array('api_type', '==', 'omdb')
        ),

//        array(
//            'id'			=> 'imdb_api_key',
//            'type'			=> 'text',
//            'title'			=> esc_html__('MyApi key', 'amy-movie-extend'),
//            'desc'			=> esc_html__('You need get api from http://www.myapifilms.com/token.do', 'amy-movie-extend'),
//            'dependency'	=> array('api_type', '==', 'myapi')
//        ),

        array(
            'id'		=> 'imdb_timeout',
            'type'		=> 'number',
            'title'		=> esc_html__('Set Timeout', 'amy-movie-extend'),
            'default'	=> '300',
            'desc'		=> esc_html__('Set max_execution_time to avoid timeout to import movie.', 'amy-movie-extend')
        )
    ]
]);