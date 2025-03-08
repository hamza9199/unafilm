<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

$sidebars = array(
    'left'    => AMY_MOVIE_PLUGIN_URL . 'assets/image/sidebars/sidebar_left.png',
    'right'   => AMY_MOVIE_PLUGIN_URL . 'assets/image/sidebars/sidebar_right.png',
    'full'    => AMY_MOVIE_PLUGIN_URL . 'assets/image/sidebars/sidebar_full.png',
    'fluid'   => AMY_MOVIE_PLUGIN_URL . 'assets/image/sidebars/sidebar_fluid.png',
);

CSF::createSection(AMY_MOVIE_PAGE_OPTIONS, [
    'fields'    => [
        [
            'id'          => '_layout',
            'type'        => 'image_select',
            'radio'       => true,
            'options'     => $sidebars,
            'default'     => 'full',
        ],
    ]
]);