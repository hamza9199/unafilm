<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

CSF::createSection(AMY_MOVIE_OPTION, [
	'title'		=> esc_html__('Custom CSS & JS', 'amy-movie-extend'),
	'icon'      => 'fa fa-code',
	'fields'	=> [
		array(
			'id'		=> 'custom_css',
			'type'		=> 'textarea',
			'title'		=> esc_html__('Custom Css', 'amy-movie-extend'),
		),

		array(
			'id'		=> 'custom_js',
			'type'		=> 'textarea',
			'title'		=> esc_html__('Custom Js', 'amy-movie-extend'),
			'after'		=> esc_html__('Do not include <script></script> tag.', 'amy-movie-extend'),
		),

        [
            'id'        => 'backup',
            'type'      => 'backup',
        ]
	]
]);