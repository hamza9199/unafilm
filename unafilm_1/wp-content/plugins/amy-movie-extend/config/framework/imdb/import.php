<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Import', 'amy-movie-extend'),
    'class'     => 'amy-imdb-import',
    'parent'    => 'imdb_import',
    'icon'      => 'fas fa-file-import',
    'fields'    => [
        [
            'id'    => '_imdb_url',
            'type'  => 'textarea',
            'title' => esc_html__('Imdb ID', 'amy-movie-extend'),
            'subtitle'  => esc_html__('Please enter ID per line', 'amy-movie-extend'),
            'class' => 'amy-imdb-url'
        ],

        [
            'id'    => 'imdb_import',
            'type'  => 'imdb_importer',
        ]
    ]
]);