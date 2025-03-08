<?php
use AmyMovie\Core\Base;

$base = new Base();

$category_fields = [
    [
        'id'				=> 'sidebar',
        'type'				=> 'select',
        'class'				=> 'chosen',
        'title'				=> esc_html__('Sidebar', 'amy-movie-extend'),
        'options'			=> [
            'global'			=> esc_html__('Global', 'amy-movie-extend'),
            'right'				=> esc_html__('Right Sidebar', 'amy-movie-extend'),
            'left'				=> esc_html__('Left Sidebar', 'amy-movie-extend'),
            'full'				=> esc_html__('No Sidebar', 'amy-movie-extend'),
        ],
        'default'			=> 'global',
    ],

    [
        'id'				=> 'widget',
        'type'				=> 'select',
        'class'				=> 'chosen',
        'title'				=> esc_html__('Sidebar Widget', 'amy-movie-extend'),
        'options'			=> $base->get_registered_sidebars(),
        'default_option'	=> esc_html__('Select a sidebar (default primary)', 'amy-movie-extend'),
        'dependency'		=> ['sidebar', 'any', 'right,left'],
        'default'			=> 'right-bar',
    ],

    [
        'id'		=> 'layout',
        'type'		=> 'select',
        'class'		=> 'chosen',
        'title'		=> esc_html__('Layout', 'amy-movie-extend'),
        'options'	=> [
            'global'	=> esc_html__('Global', 'amy-movie-extend'),
            'list'		=> esc_html__('Shortcode Movie List', 'amy-movie-extend'),
            'grid'		=> esc_html__('Shortcode Movie Grid', 'amy-movie-extend'),
            'list-2'	=> esc_html__('Shortcode Movie List V2', 'amy-movie-extend'),
            'grid-2'	=> esc_html__('Shortcode Movie Grid V2', 'amy-movie-extend')
        ],
        'default'	=> 'global',
    ],

    [
        'type' 			=> 'image_select',
        'title' 		=> esc_html__('Grid Layout', 'amy-movie-extend'),
        'id' 			=> 'grid_layout',
        'options' 		=> [
            'layout1' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout1.png',
            'layout2' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout2.png',
            'layout3' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout3.png',
            'layout4' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout4.png',
        ],
        'radio'		=> true,
        'attributes'			=> [
            'data-depend-id'	=> 'grid_layout',
        ],
        'default'		=> 'layout1',
        'dependency'	=> ['layout', '==', 'grid'],
    ],

    [
        'type' 			=> 'image_select',
        'title' 		=> esc_html__('Grid V2 Layout', 'amy-movie-extend'),
        'id' 			=> 'grid_v2_layout',
        'options' 		=> [
            'grid-1' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout1.png',
            'grid-2' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout2.png',
        ],
        'radio'		=> true,
        'attributes'			=> [
            'data-depend-id'	=> 'grid_v2_layout',
        ],
        'default'		=> 'grid-1',
        'dependency'	=> ['layout', '==', 'grid-2'],
    ],

    [
        'type'			=> 'select',
        'title'			=> esc_html__('Columns', 'amy-movie-extend'),
        'id'			=> 'column',
        'class'			=> 'chosen',
        'options'		=> [
            '2'	=> esc_html__('2 column', 'amy-movie-extend'),
            '3'	=> esc_html__('3 column', 'amy-movie-extend'),
            '4'	=> esc_html__('4 column', 'amy-movie-extend'),
            '5' => esc_html__('5 column', 'amy-movie-extend'),
        ],
        'default'			=> '4',
        'dependency'	=> ['layout|grid_layout', '==|any', 'grid|layout1,layout3,layout4'],
    ],

    [
        'type'		=> 'select',
        'class'		=> 'chosen',
        'title'		=> esc_html__('Columns', 'amy-movie-extend'),
        'id'		=> 'layout2_column',
        'options'		=> [
            '2'	=> esc_html__('2 column', 'amy-movie-extend'),
            '3'	=> esc_html__('3 column', 'amy-movie-extend'),
        ],
        'default'			=> '2',
        'dependency'	=> ['layout|grid_layout', '==|==', 'grid|layout2'],
    ],

    [
        'type'			=> 'select',
        'title'			=> esc_html__('Columns', 'amy-movie-extend'),
        'id'			=> 'grid_v2_column',
        'class'			=> 'chosen',
        'options'		=> [
            '2'	=> esc_html__('2 column', 'amy-movie-extend'),
            '3'	=> esc_html__('3 column', 'amy-movie-extend'),
            '4'	=> esc_html__('4 column', 'amy-movie-extend'),
            '5' => esc_html__('5 column', 'amy-movie-extend'),
            '6' => esc_html__('6 column', 'amy-movie-extend'),
        ],
        'default'			=> '4',
        'dependency'	=> ['layout|grid_v2_layout', '==|==', 'grid-2|grid-1'],
    ],

    [
        'type'		=> 'select',
        'title'		=> esc_html__('Columns', 'amy-movie-extend'),
        'id'		=> 'grid_v2_layout2_column',
        'class'		=> 'chosen',
        'options'		=> [
            '2'	=> esc_html__('2 column', 'amy-movie-extend'),
            '3'	=> esc_html__('3 column', 'amy-movie-extend'),
            '4'	=> esc_html__('4 column', 'amy-movie-extend'),
        ],
        'default'			=> '2',
        'dependency'	=> ['layout|grid_v2_layout', '==|==', 'grid-2|grid-2'],
    ],
];

$person_fields = [
    [
        'id'    => 'avatar',
        'type'  => 'media',
        'title' => esc_html__('Avatar', 'amy-movie-extend'),
    ],

    [
        'id'    => 'banner',
        'type'  => 'media',
        'title' => esc_html__('Banner', 'amy-movie-extend'),
    ],

    [
        'id'	=> 'summary',
        'type'	=> 'group',
        'title'	=> esc_html__('Summary', 'amy-movie-extend'),
        'button_title'    => esc_html__('Add New', 'amy-movie-extend'),
        'accordion_title' => esc_html__('Add New Summary', 'amy-movie-extend'),
        'fields'          => [
            [
                'id'	=> 'content',
                'type'	=> 'text',
                'title'	=> esc_html__('Content', 'amy-movie-extend'),
            ],
        ],
    ],

    [
        'id'	=> 'birth_date',
        'type'	=> 'text',
        'class'	=> 'amy-date',
        'title'	=> esc_html__('Birth Day', 'amy-movie-extend'),
    ],

    [
        'id'	=> 'birth_place',
        'type'	=> 'text',
        'title'	=> esc_html__('Birth Place', 'amy-movie-extend'),
    ],

    [
        'id'	=> 'gender',
        'type'	=> 'select',
        'class'	=> 'chosen',
        'title'	=> esc_html__('Gender', 'amy-movie-extend'),
        'options'	=> [
            'Male'				=> esc_html__('Male', 'amy-movie-extend'),
            'Female'			=> esc_html__('Female', 'amy-movie-extend'),
            'Third Gender'		=> esc_html__('Third gender', 'amy-movie-extend'),
        ],
    ],

    [
        'id'	=> 'national',
        'type'	=> 'text',
        'title'	=> esc_html__('Nationality', 'amy-movie-extend'),
    ],

    [
        'id'	=> 'order_display',
        'type'	=> 'number',
        'title'	=> esc_html__('Order Display', 'amy-movie-extend')
    ],
];

$category_list      = ['amy_genre'];
$person_list        = ['amy_actor', 'amy_director'];
$custom_fields		= $base->get_option('movie_custom_fields');

if (!empty($custom_fields)) {
    foreach ($custom_fields as $field) {
        $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
        $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

        if ($field['type'] == 'category') {
            $category_list[] = $singular_name;
        } else if ($field['type'] == 'person') {
            $person_list[] = $singular_name;
        }
    }
}

/**
 * Category
 */
CSF::createTaxonomyOptions(AMY_MOVIE_CATEGORY_OPTIONS, [
    'taxonomy'  => $category_list,
    'data_type' => 'serialize',
]);

CSF::createSection(AMY_MOVIE_CATEGORY_OPTIONS, [
    'fields' => $category_fields
]);

/**
 * Person
 */
CSF::createTaxonomyOptions(AMY_MOVIE_PERSON_OPTIONS, [
    'taxonomy'  => $person_list,
    'data_type' => 'serialize',
]);

CSF::createSection(AMY_MOVIE_PERSON_OPTIONS, [
    'fields' => $person_fields
]);