<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */
if (!defined('ABSPATH')) {
    return;
}

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'		=> esc_html__('Page Loading', 'amy-movie-extend'),
    'icon'		=> 'fa fa-spinner',
    'parent'    => 'general',
    'fields'	=> [
        [
            'id'			=> 'page_loading_background',
            'type'			=> 'color',
            'title'			=> esc_html__('Background Color', 'amy-movie-extend'),
            'output'		=> '.amy-page-load',
            'output_mode'	=> 'background-color',
            'default'		=> '#18233E'
        ]
    ]
]);