<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

if (class_exists('WooCommerce')) {
    CSF::createSection(AMY_MOVIE_OPTION, [
        'title' => esc_html__('WooCommerce', 'amy-movie-extend'),
        'icon'  => 'fa fa-shopping-basket',
        'fields' => [
            array(
                'id'        => 'woo_loop_columns',
                'type'      => 'select',
                'title'     => esc_html__('Shop Columns', 'amy-movie-extend'),
                'options'   => array(
                    '2'     => esc_html__('2 Columns', 'amy-movie-extend'),
                    '3'     => esc_html__('3 Columns', 'amy-movie-extend'),
                    '4'     => esc_html__('4 Columns', 'amy-movie-extend'),
                    '6'     => esc_html__('6 Columns', 'amy-movie-extend')
                ),
                'default'   => 4,
                'class'     => 'chosen'
            ),

            array(
                'id'               => 'woo_related_columns',
                'type'             => 'select',
                'title'            => esc_html__('Related Columns', 'amy-movie-extend'),
                'options'   => array(
                    '2'     => esc_html__('2 Columns', 'amy-movie-extend'),
                    '3'     => esc_html__('3 Columns', 'amy-movie-extend'),
                    '4'     => esc_html__('4 Columns', 'amy-movie-extend'),
                    '6'     => esc_html__('6 Columns', 'amy-movie-extend')
                ),
                'default'   => 4,
                'class'     => 'chosen'
            ),

            array(
                'id'               => 'woo_upsells_columns',
                'type'             => 'select',
                'title'            => esc_html__('Up-Sells Columns', 'amy-movie-extend'),
                'options'   => array(
                    '2'     => esc_html__('2 Columns', 'amy-movie-extend'),
                    '3'     => esc_html__('3 Columns', 'amy-movie-extend'),
                    '4'     => esc_html__('4 Columns', 'amy-movie-extend'),
                    '6'     => esc_html__('6 Columns', 'amy-movie-extend')
                ),
                'default'   => 4,
                'class'     => 'chosen'
            ),
        ]
    ]);
}