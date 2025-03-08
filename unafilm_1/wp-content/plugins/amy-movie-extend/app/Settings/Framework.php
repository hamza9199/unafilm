<?php
namespace AmyMovie\Settings;

class Framework {
    public function option_module_fields() {
        $menus 			= wp_get_nav_menus();
        $menu_fields 	= array();

        if (!empty($menus)) {
            foreach ($menus as $menu) {
                $menu_fields[ $menu->slug ] = $menu->name;
            }
        }

        return [
            [
                'id'				=> 'module',
                'type'				=> 'select',
                'title'				=> esc_html__('Module Type', 'amy-movie-extend'),
                'default_option'	=> esc_html__('Choose a Module', 'amy-movie-extend'),
                'options'			=> [
                    'text'		=> esc_html__('Text', 'amy-movie-extend'),
                    'link'		=> esc_html__('Link', 'amy-movie-extend'),
                    'social'	=> esc_html__('Social List', 'amy-movie-extend'),
                    'login'		=> esc_html__('WP Login', 'amy-movie-extend'),
                    'menu'		=> esc_html__('Menu', 'amy-movie-extend'),
                ],
            ],

            [
                'id'				=> 'icon',
                'type'				=> 'icon',
                'title'				=> esc_html__('Icon', 'amy-movie-extend'),
                'dependency'		=> ['module', 'any', 'text,link'],
            ],

            [
                'id'				=> 'text',
                'type'				=> 'text',
                'title'				=> esc_html__('Text', 'amy-movie-extend'),
                'dependency'		=> ['module', 'any', 'text,link'],
            ],

            [
                'id'				=> 'm_color',
                'type'				=> 'color',
                'title'				=> esc_html__('Color', 'amy-movie-extend'),
                'dependency'		=> ['module', 'any', 'text,link'],
            ],

            [
                'id'				=> 'm_bg_color',
                'type'				=> 'color',
                'title'				=> esc_html__('Background Color', 'amy-movie-extend'),
                'dependency'		=> ['module', 'any', 'text,link'],
            ],

            [
                'id'				=> 'link',
                'type'				=> 'link',
                'title'				=> esc_html__('Link URL', 'amy-movie-extend'),
                'dependency'		=> ['module', '==', 'link'],
            ],

            [
                'id'				=> 'menu_slug',
                'type'				=> 'select',
                'class'				=> 'chosen',
                'title'				=> esc_html__('Chosen menu', 'amy-movie-extend'),
                'options'			=> $menu_fields,
                'dependency'		=> ['module', '==', 'menu'],
            ],

            [
                'id'				=> 'class',
                'type'				=> 'text',
                'title'				=> esc_html__('CSS Class', 'amy-movie-extend'),
                'multilang'			=> true,
                'dependency'		=> ['module', '!=', ''],
            ],
            [
                'id'				=> 'visible_type',
                'type'				=> 'select',
                'class'				=> 'chosen',
                'title'				=> esc_html__('Visible to', 'amy-movie-extend'),
                'options'			=> [
                    'any'		=> esc_html__('Everyone', 'amy-movie-extend'),
                    'user'		=> esc_html__('User Only', 'amy-movie-extend'),
                    'guest'		=> esc_html__('Guest Only', 'amy-movie-extend'),
                ],
                'dependency'		=> ['module', '!=', ''],
            ],
        ];
    }
}