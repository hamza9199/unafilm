<?php

CSF::createWidget('amy_movie_widget_coming_soon', [
    'title'         => esc_html__('+ Amy Movie Coming Soon', 'amy-movie-extend'),
    'classname'     => 'amy-widget-coming-soon',
    'description'   => esc_html__('Show Movie Coming Soon into Widget.', 'amy-movie-extend'),
    'fields'        => [
        [
            'id'				=> 'title',
            'type'				=> 'text',
            'title'				=> esc_html__('Title', 'amy-movie-extend'),
        ],

        [
            'id'		=> 'genre',
            'type'		=> 'select',
            'title'		=> esc_html__('Genres', 'amy-movie-extend'),
            'options'	=> 'categories',
            'query_args'=> [
                'taxonomy'  => 'amy_genre'
            ],
            'chosen'        => true,
            'multiple'      => true,
        ],

        [
            'id'		=> 'post_number',
            'type'		=> 'text',
            'title'		=> esc_html__('Number of Movies', 'amy-movie-extend'),
            'default'	=> '6',
        ],

        [
            'id'		=> 'class',
            'type'		=> 'text',
            'title'		=> esc_html__('Extra Class', 'amy-movie-extend'),
        ],
    ]
]);

if (!function_exists('amy_movie_widget_coming_soon')) {
    function amy_movie_widget_coming_soon($args, $instance) {
        $genre 			= empty($instance['genre']) ? '' : $instance['genre'];
        $post_number 	= empty($instance['post_number']) ? '' : $instance['post_number'];
        $class 			= empty($instance['class']) ? '' : $instance['class'];
        $datenow		= strtotime(current_time('y-m-d'));

        echo $args['before_widget'];

        if ($genre != '') {
            $tax_query_genre = [
                'taxonomy'	=> 'amy_genre',
                'field'		=> 'term_id',
                'terms'		=> $genre,
            ];
        } else {
            $tax_query_genre = '';
        }

        $args = [
            'post_type'	=> 'amy_movie',
            'tax_query'	=> [
                $tax_query_genre
            ],
            'meta_query'	=> [
                [
                    'key'		=> '_release',
                    'value'		=> $datenow,
                    'compare' 	=> '>',
                ],
            ],
            'posts_per_page'	=> $post_number,
            'meta_key'			=> '_release',
            'orderby'			=> 'meta_value',
            'order'				=> 'DESC',
        ];

        $output = '<div class="amy-widget amy-widget-comingsoon ' . esc_attr($class) . '">';

        $output .= '<h4 class="amy-title amy-widget-title">' . $instance['title'] . '</h4>';

        $output .= '<ul>';
        query_posts($args);

        $i = 1;

        if (have_posts()) :
            while (have_posts()) :
                the_post();

                $output .= '<li><a href="' . get_the_permalink() . '"><span>' . $i . '.</span>' . get_the_title() . '</a></li>';

                $i++;
            endwhile;
        endif;

        wp_reset_query();

        $output .= '</ul></div>';

        echo $output;

        echo $args['after_widget'];
    }
}