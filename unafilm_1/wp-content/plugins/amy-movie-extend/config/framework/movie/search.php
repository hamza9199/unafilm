<?php
use AmyMovie\Core\Base;

$base = new Base();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Search', 'amy-movie-extend'),
    'icon'      => 'fas fa-search',
    'parent'    => 'movie',
    'fields'    => [
        array(
            'id'		=> 'movie_search_heading',
            'type'		=> 'heading',
            'content'	=> esc_html__('Movie Search Page', 'amy-movie-extend'),
        ),

        array(
            'id'				=> 'search_sidebar',
            'type'				=> 'button_set',
            'title'				=> esc_html__('Sidebar', 'amy-movie-extend'),
            'options'			=> array(
                'right'				=> esc_html__('Right Sidebar', 'amy-movie-extend'),
                'left'				=> esc_html__('Left Sidebar', 'amy-movie-extend'),
                'full'				=> esc_html__('No Sidebar', 'amy-movie-extend'),
            ),
            'default'			=> 'right',
        ),

        array(
            'id'				=> 'search_widget',
            'type'				=> 'select',
            'class'				=> 'chosen',
            'title'				=> esc_html__('Sidebar Widget', 'amy-movie-extend'),
            'options'			=> $base->get_registered_sidebars(),
            'default_option'	=> esc_html__('Select a sidebar (default primary)', 'amy-movie-extend'),
            'dependency'		=> array('search_sidebar', 'any', 'right,left'),
            'default'			=> 'right-bar',
        ),

        array(
            'id'			=> 'movie_search_orderby',
            'type'			=> 'select',
            'class'			=> 'chosen',
            'title'			=> esc_html__('Movie Order By', 'amy-movie-extend'),
            'options'		=> array(
                '_rating_average'	=> esc_html__('Rate', 'amy-movie-extend'),
                '_release'	=> esc_html__('Release Date', 'amy-movie-extend'),
                '_amy_post_views_count'	=> esc_html__('Post Views', 'amy-movie-extend'),
                'ID'					=> esc_html__('Post ID', 'amy-movie-extend'),
                'title'					=> esc_html__('Title', 'amy-movie-extend'),
                'date'					=> esc_html__('Date', 'amy-movie-extend'),
                'rand'					=> esc_html__('Random Order', 'amy-movie-extend'),
                'comment_count'			=> esc_html__('Comment Count', 'amy-movie-extend'),
            ),
            'default'		=> 'date'
        ),

        array(
            'id'		=> 'search_layout',
            'type'		=> 'select',
            'class'		=> 'chosen',
            'title'		=> esc_html__('Layout', 'amy-movie-extend'),
            'options'	=> array(
                'list'		=> esc_html__('Shortcode Movie List', 'amy-movie-extend'),
                'grid'		=> esc_html__('Shortcode Movie Grid', 'amy-movie-extend'),
                'list-2'	=> esc_html__('Shortcode Movie List V2', 'amy-movie-extend'),
                'grid-2'	=> esc_html__('Shortcode Movie Grid V2', 'amy-movie-extend')
            ),
            'default'	=> 'list',
        ),

        array(
            'type' 			=> 'image_select',
            'title' 		=> esc_html__('Grid Layout', 'amy-movie-extend'),
            'id' 			=> 'search_grid_layout',
            'options' 		=> array(
                'layout1' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout1.png',
                'layout2' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout2.png',
                'layout3' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout3.png',
                'layout4' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout4.png',
            ),
            'radio'		=> true,
            'attributes'			=> array(
                'data-depend-id'	=> 'search_grid_layout',
            ),
            'default'		=> 'layout1',
            'dependency'	=> array('search_layout', '==', 'grid'),
        ),

        array(
            'type' 			=> 'image_select',
            'title' 		=> esc_html__('Grid V2 Layout', 'amy-movie-extend'),
            'id' 			=> 'search_grid_v2_layout',
            'options' 		=> array(
                'grid-1' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout1.png',
                'grid-2' 	=> get_template_directory_uri() . '/images/shortcode/grid_layout2.png',
            ),
            'radio'		=> true,
            'attributes'			=> array(
                'data-depend-id'	=> 'search_grid_v2_layout',
            ),
            'default'		=> 'grid-1',
            'dependency'	=> array('search_layout', '==', 'grid-2'),
        ),

        array(
            'type'			=> 'select',
            'title'			=> esc_html__('Columns', 'amy-movie-extend'),
            'id'			=> 'search_column',
            'class'			=> 'chosen',
            'options'		=> array(
                '2'	=> esc_html__('2 column', 'amy-movie-extend'),
                '3'	=> esc_html__('3 column', 'amy-movie-extend'),
                '4'	=> esc_html__('4 column', 'amy-movie-extend'),
                '5' => esc_html__('5 column', 'amy-movie-extend'),
            ),
            'default'			=> '4',
            'dependency'	=> array('search_layout|search_grid_layout', '==|any', 'grid|layout1,layout3,layout4'),
        ),

        array(
            'type'		=> 'select',
            'title'		=> esc_html__('Columns', 'amy-movie-extend'),
            'id'		=> 'search_layout2_column',
            'class'		=> 'chosen',
            'options'		=> array(
                '2'	=> esc_html__('2 column', 'amy-movie-extend'),
                '3'	=> esc_html__('3 column', 'amy-movie-extend'),
            ),
            'default'			=> '2',
            'dependency'	=> array('search_layout|search_grid_layout', '==|==', 'grid|layout2'),
        ),

        array(
            'type'			=> 'select',
            'title'			=> esc_html__('Columns', 'amy-movie-extend'),
            'id'			=> 'search_grid_v2_column',
            'class'			=> 'chosen',
            'options'		=> array(
                '2'	=> esc_html__('2 column', 'amy-movie-extend'),
                '3'	=> esc_html__('3 column', 'amy-movie-extend'),
                '4'	=> esc_html__('4 column', 'amy-movie-extend'),
                '5' => esc_html__('5 column', 'amy-movie-extend'),
                '6' => esc_html__('6 column', 'amy-movie-extend'),
            ),
            'default'			=> '4',
            'dependency'	=> array('search_layout|search_grid_v2_layout', '==|==', 'grid-2|grid-1'),
        ),

        array(
            'type'		=> 'select',
            'title'		=> esc_html__('Columns', 'amy-movie-extend'),
            'id'		=> 'search_grid_v2_layout2_column',
            'class'		=> 'chosen',
            'options'		=> array(
                '2'	=> esc_html__('2 column', 'amy-movie-extend'),
                '3'	=> esc_html__('3 column', 'amy-movie-extend'),
                '4'	=> esc_html__('4 column', 'amy-movie-extend'),
            ),
            'default'			=> '2',
            'dependency'	=> array('search_layout|search_grid_v2_layout', '==|==', 'grid-2|grid-2'),
        ),

        array(
            'id' 			=> 'search_movie_number',
            'type' 			=> 'text',
            'title' 		=> esc_html__('Movies Per Page', 'amy-movie-extend'),
            'default'		=> '10'
        ),

        array(
            'type'			=> 'switcher',
            'title'			=> esc_html__('Show Pagination', 'amy-movie-extend'),
            'id'			=> 'search_pagination',
            'std'			=> true,
        ),
    ]
]);