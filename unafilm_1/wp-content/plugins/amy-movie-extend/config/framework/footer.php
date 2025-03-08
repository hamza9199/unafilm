<?php
use AmyMovie\Settings\Framework;

$framework = new Framework();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Footer', 'amy-movie-extend'),
    'icon'      => 'fas fa-robot',
    'fields'    => [
        [
            'id'		=> 'enable_footer',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Footer', 'amy-movie-extend'),
            'label'		=> esc_html__('Enable footer widgets area in all pages.', 'amy-movie-extend'),
            'default'	=> true,
        ],

        [
            'id'			=> 'footer_bg',
            'type'			=> 'background',
            'title'			=> esc_html__('Footer Background', 'amy-movie-extend'),
            'output'        => '.amy-site-footer'
        ],

        [
            'id'		=> 'footer_widgets',
            'type'		=> 'image_select',
            'url'           => false,
            'title'		=> esc_html__('Footer Widgets', 'amy-movie-extend'),
            'options'	=> [
                '1'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-1.png',
                '2'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-2.png',
                '3'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-3.png',
                '4'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-4.png',
                '5'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-5.png',
                '6'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-6.png',
                '7'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-7.png',
                '8'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-8.png',
                '9'			=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-9.png',
                '10'		=> AMY_MOVIE_PLUGIN_URL . 'assets/image/footer-widget-10.png',
            ],
            'radio'		=> true,
            'default'	=> '4',
        ],

        [
            'id'		=> 'enable_copyright',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Enable Copyright', 'amy-movie-extend'),
            'label'		=> esc_html__('Enable copyright on all pages.', 'amy-movie-extend'),
            'default'	=> true,
        ],

        [
            'id'				=> 'copyright_left',
            'type'				=> 'group',
            'title'				=> esc_html__('Copyright Left', 'amy-movie-extend'),
            'button_title'		=> esc_html__('Add New Module', 'amy-movie-extend'),
            'accordion_title'	=> esc_html__('New Module', 'amy-movie-extend'),
            'dependency'		=> ['enable_copyright', '==', 1],
            'fields'			=> $framework->option_module_fields()
        ],

        [
            'id'				=> 'copyright_right',
            'type'				=> 'group',
            'title'				=> esc_html__('Copyright Right', 'amy-movie-extend'),
            'button_title'		=> esc_html__('Add New Module', 'amy-movie-extend'),
            'accordion_title'	=> esc_html__('New Module', 'amy-movie-extend'),
            'dependency'		=> ['enable_copyright', '==', 1],
            'fields'			=> $framework->option_module_fields()
        ],
    ]
]);