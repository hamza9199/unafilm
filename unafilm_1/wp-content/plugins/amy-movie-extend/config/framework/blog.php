<?php
use AmyMovie\Core\Base;

$base = new Base();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Blog', 'amy-movie-extend'),
    'icon'      => 'fab fa-microblog',
    'fields'    => [
        array(
            'id'		=> 'blog_general_heading',
            'type'		=> 'heading',
            'content'	=> esc_html__('Blog', 'amy-movie-extend'),
        ),

        array(
            'id'				=> 'blog_sidebar',
            'type'				=> 'button_set',
            'title'				=> esc_html__('Blog Sidebar', 'amy-movie-extend'),
            'options'			=> array(
                'right'				=> esc_html__('Right Sidebar', 'amy-movie-extend'),
                'left'				=> esc_html__('Left Sidebar', 'amy-movie-extend'),
                'full'				=> esc_html__('No Sidebar', 'amy-movie-extend'),
            ),
            'default'			=> 'right',
        ),

        array(
            'id'				=> 'blog_widget',
            'type'				=> 'select',
            'class'				=> 'chosen',
            'title'				=> esc_html__('Blog Sidebar Widget', 'amy-movie-extend'),
            'options'			=> $base->get_registered_sidebars(),
            'default_option'	=> esc_html__('Select a sidebar (default primary)', 'amy-movie-extend'),
            'dependency'		=> array('blog_sidebar', 'any', 'right,left'),
            'default'			=> 'right-bar',
        ),

        array(
            'id'		=> 'blog_layout',
            'type'		=> 'image_select',
            'title'		=> esc_html__('BLog Layout', 'amy-movie-extend'),
            'options'	=> array(
                'list'		=> AMY_MOVIE_PLUGIN_URL . 'assets/image/shortcode/list.png',
                'grid'		=> AMY_MOVIE_PLUGIN_URL . 'assets/image/shortcode/grid.png',
                'masonry'	=> AMY_MOVIE_PLUGIN_URL . 'assets/image/shortcode/masonry.png',
            ),
            'default'	=> 'list',
            'radio'		=> true,
            'attributes'			=> array(
                'data-depend-id'	=> 'blog_layout',
            ),
            'desc'		=> esc_html__('List, Grid or Masonry. Masonry working with No Sidebar', 'amy-movie-extend'),
        ),

        array(
            'id'		=> 'blog_column',
            'type'		=> 'select',
            'class'				=> 'chosen',
            'title'		=> esc_html__('Blog Column', 'amy-movie-extend'),
            'options'	=> array(
                '2'		=> esc_html__('2 Columns', 'amy-movie-extend'),
                '3'		=> esc_html__('3 Columns', 'amy-movie-extend'),
                '4'		=> esc_html__('4 Columns', 'amy-movie-extend'),
                '6'		=> esc_html__('6 Columns', 'amy-movie-extend'),
            ),
            'dependency'	=> array('blog_layout', '==', 'grid'),
            'default'	=> 4,
        ),

        array(
            'id'		=> 'blog_meta_position',
            'type'		=> 'button_set',
            'title'		=> esc_html__('Content Position', 'amy-movie-extend'),
            'options'	=> array(
                'under'	=> esc_html__('Under Image', 'amy-movie-extend'),
                'right'	=> esc_html__('Right Image', 'amy-movie-extend'),
            ),
            'default'	=> 'under',
            'dependency'	=> array('blog_layout', '==', 'list'),
        ),

        array(
            'id'		=> 'blog_img_width',
            'type'		=> 'select',
            'class'		=> 'chosen',
            'title'		=> esc_html__('Image Width', 'amy-movie-extend'),
            'options'	=> array(
                '4'		=> esc_html__('4 columns - 1/3', 'amy-movie-extend'),
                '5'		=> esc_html__('5 columns - 5/12', 'amy-movie-extend'),
                '6'		=> esc_html__('6 columns - 1/2', 'amy-movie-extend'),
                '7'		=> esc_html__('7 columns - 7/12', 'amy-movie-extend'),
            ),
            'default'	=> '4',
            'dependency'	=> array('blog_meta_position|blog_layout', '==|==', 'right|list'),
        ),

        array(
            'id'		=> 'blog_pagination',
            'title'		=> esc_html__('Pagination', 'amy-movie-extend'),
            'type'		=> 'switcher',
            'default'	=> true,
            'dependency'	=> array('blog_layout', 'any', 'list,grid'),
        ),

        array(
            'id'		=> 'blog_post_heading',
            'type'		=> 'heading',
            'content'	=> esc_html__('Single Post', 'amy-movie-extend'),
        ),

        array(
            'id'		=> 'post_recent',
            'type'		=> 'switcher',
            'title'		=> esc_html__('Recent Post', 'amy-movie-extend'),
            'default'	=> true,
        ),

        array(
            'id'		=> 'post_recent_by',
            'type'		=> 'button_set',
            'title'		=> esc_html__('Recent Post By', 'amy-movie-extend'),
            'options'	=> array(
                'category'		=> esc_html__('Category', 'amy-movie-extend'),
                'post_tag'		=> esc_html__('Tag', 'amy-movie-extend'),

            ),
            'default'	=> 'category',
        ),

        array(
            'id'		=> 'post_recent_title',
            'type'		=> 'text',
            'title'		=> esc_html__('Recent Post title', 'amy-movie-extend'),
            'default'	=> esc_html__('Related Article', 'amy-movie-extend'),
        ),
    ]
]);