<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Movie\MovieQuery;

CSF::createWidget('amy_movie_widget_list', [
    'title'         => esc_html__('+ Amy Movie List', 'amy-movie-extend'),
    'classname'     => 'amy-widget-list',
    'description'   => esc_html__('Show list post/movie into Widget.', 'amy-movie-extend'),
    'fields'        => [
        [
            'id'				=> 'title',
            'type'				=> 'text',
            'title'				=> esc_html__('Title', 'amy-movie-extend'),
        ],

        [
            'id'		=> 'post_type',
            'type'		=> 'select',
            'class'		=> 'horizontal',
            'title'		=> esc_html__('Post Type', 'amy-movie-extend'),
            'options'	=> [
                'post'		=> esc_html__('Post', 'amy-movie-extend'),
                'movie'		=> esc_html__('Movie', 'amy-movie-extend'),
                'tvshow'	=> esc_html__('TvShow', 'amy-movie-extend')
            ],
            'default'	=> 'amy_movie',
        ],

        [
            'id'		=> 'category',
            'type'		=> 'select',
            'title'		=> esc_html__('Categories', 'amy-movie-extend'),
            'options'	=> 'categories',
            'chosen'    => true,
            'multiple'  => true,
            'dependency'	=> ['post_type', '==', 'post'],
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
            'dependency'	=> ['post_type', '==', 'movie'],
        ],

        [
            'id'		=> 'post_number',
            'type'		=> 'text',
            'title'		=> esc_html__('Number of Posts/Movies', 'amy-movie-extend'),
            'default'	=> '4',
        ],

        [
            'id'		=> 'post_orderby',
            'type'		=> 'select',
            'title'		=> esc_html__('Order By', 'amy-movie-extend'),
            'options'	=> [
                'ID'		=> esc_html__('Post ID', 'amy-movie-extend'),
                'author'	=> esc_html__('Author', 'amy-movie-extend'),
                'title'		=> esc_html__('Title', 'amy-movie-extend'),
                'date'		=> esc_html__('Date', 'amy-movie-extend'),
                'rand'		=> esc_html__('Random Order', 'amy-movie-extend'),
                'comment_count'	=> esc_html__('Comment Count', 'amy-movie-extend'),
            ],
            'default'	=> 'date',
            'dependency'	=> ['post_type', '==', 'post'],
        ],

        [
            'id'		=> 'orderby',
            'type'		=> 'select',
            'title'		=> esc_html__('Order By', 'amy-movie-extend'),
            'options'	=> [
                '_rating_average'		=> esc_html__('Rate', 'amy-movie-extend'),
                '_release' 	            => esc_html__('Release Date', 'amy-movie-extend'),
                '_amy_post_views_count'	=> esc_html__('Post Views', 'amy-movie-extend'),
                'ID'					=> esc_html__('Post ID', 'amy-movie-extend'),
                'author'				=> esc_html__('Author', 'amy-movie-extend'),
                'title'					=> esc_html__('Title', 'amy-movie-extend'),
                'date'					=> esc_html__('Date', 'amy-movie-extend'),
                'rand'					=> esc_html__('Random Order', 'amy-movie-extend'),
                'comment_count'			=> esc_html__('Comment Count', 'amy-movie-extend'),
            ],
            'default'	=> 'date',
            'dependency'	=> ['post_type', '==', 'movie'],
        ],

        [
            'id'		=> 'post_order',
            'type'		=> 'select',
            'title'		=> esc_html__('Sort order', 'amy-movie-extend'),
            'options'	=> [
                'DESC'	=> esc_html__('Descending', 'amy-movie-extend'),
                'ASC'	=> esc_html__('Ascending', 'amy-movie-extend'),
            ],
            'defalut'	=> 'DESC',
        ],

        [
            'id'		=> 'post_date',
            'type'		=> 'select',
            'title'		=> esc_html__('Date From', 'amy-movie-extend'),
            'options'	=> [
                'day'		=> esc_html__('Last 1 day', 'amy-movie-extend'),
                'week'		=> esc_html__('Last 7 days', 'amy-movie-extend'),
                'month'		=> esc_html__('Last 30 days', 'amy-movie-extend'),
                'alltime'	=> esc_html__('All time', 'amy-movie-extend'),
            ],
            'default'	=> 'alltime',
        ],

        [
            'id'		=> 'class',
            'type'		=> 'text',
            'title'		=> esc_html__('Extra Class', 'amy-movie-extend'),
        ],
    ]
]);


if (!function_exists('amy_movie_widget_list')) {
    function amy_movie_widget_list($args, $instance) {
        $post_type 		= empty($instance['post_type']) ? '' : $instance['post_type'];
        $category 		= empty($instance['category']) ? '' : $instance['category'];
        $genre 			= empty($instance['genre']) ? '' : $instance['genre'];
        $post_number 	= empty($instance['post_number']) ? '' : $instance['post_number'];
        $post_orderby 	= empty($instance['post_orderby']) ? '' : $instance['post_orderby'];
        $orderby 	    = empty($instance['orderby']) ? '' : $instance['orderby'];
        $post_order 	= empty($instance['post_order']) ? '' : $instance['post_order'];
        $post_date 		= empty($instance['post_date']) ? '' : $instance['post_date'];
        $class 			= empty($instance['class']) ? '' : $instance['class'];

        echo $args['before_widget'];

        // Custom query
        $params 	= [];

		$single_movie   = new Movie();
		$movie_query    = new MovieQuery();
		$params['movie_date']		= $post_date;
		$params['orderby']			= $orderby;
		$params['order']			= $post_order;
		$params['posts_per_page']	= $post_number;

		if (!empty($genre)) {
            $params['custom_fields'] = [
                [
                    'type'  => 'category',
                    'id'    => 'amy_genre',
                    'value' => implode(',', $genre)
                ]
            ];
        }

		$loop = '';

		if ($post_type == 'movie' || $post_type == 'tvshow') {
            $params['post_type'] = ($post_type == 'tvshow') ? 'amy_tvshow' : 'amy_movie';

            $arpg = $movie_query->build($params);

            $the_query 	= new WP_Query($arpg);
            $data		= $the_query->posts;

            if (!empty($data)) {
                foreach ($data as $i => $item) {
                    $single_movie->set_movie($item->ID);

                    $loop .= '<div class="entry-item">';

                    $loop .= '<div class="entry-thumb">';
                    $loop .= $single_movie->render_html_poster(['width' => 118, 'height' => 159]);
                    $loop .= '</div>';

                    $loop .= '<div class="entry-content">';
                    $loop .= '<h2 class="entry-title"><a href="' . get_permalink($item->ID) . '">' . $item->post_title . '</a></h2>';

                    if ($single_movie->get_duration()) {
                        $loop .= '<div><span class="duration"><i class="fa fa-clock-o"></i>' . $single_movie->get_format_duration() . '</span></div>';
                    }

                    $loop .= '<div class="genre"><span>' . $single_movie->render_taxonomy_template('amy_genre') . '</span></div>';

                    if ($single_movie->get_rate_average() > 0) {
                        $loop .= '<div class="mrate">';
                        $loop .= '<ul class="mv-rating-stars">';
                        $loop .= '<li class="mv-current-rating" data-point="' . round($single_movie->get_rate_average() / 5, 2) * 100 . '%' . '"></li>';
                        $loop .= '</ul>';
                        $loop .= '<span class="rate">' . $single_movie->get_rate_average() . '</span>';
                        $loop .= '</div>';
                    }

                    $loop .= '</div>';
                    $loop .= '<div class="clearfix"></div>';
                    $loop .= '</div>';
                }
            }
        } else if ($post_type == 'post') {
            if ($category != '') {
                $cat_query = [
                    'taxonomy'	=> 'category',
                    'field'		=> 'term_id',
                    'terms'		=> $category,
                ];
			} else {
                $cat_query = '';
            }

            $query_date = [];

			if ($post_date == 'day') {
                $query_date = [
                    [
                        'after'	=> '24 hours ago',
                    ],
                ];
			} else if ($post_date == 'week') {
                $query_date = [
                    [
                        'after'	=> '1 week ago',
                    ],
                ];
			} else if ($post_date == 'month') {
                $query_date = [
                    [
                        'after'	=> '1 month ago',
                    ],
                ];
			}

			$arpg = [
                'tax_query'	=> [
                    $cat_query
                ],
				'date_query'		=> $query_date,
				'posts_per_page'	=> $post_number,
				'orderby'			=> $post_orderby,
				'order'				=> $post_order,
            ];

			query_posts($arpg);

			if (have_posts()) :
                while (have_posts()) :
                    the_post();

                    global $post;

                    $src = get_the_post_thumbnail_url($post->ID, 'full');

                    $loop .= '<div class="entry-item">';
                    $loop .= '<div class="entry-thumb"><img src="' . mr_image_resize($src, 115, 85) . '" /></div>';
                    $loop .= '<div class="entry-content">';
                    $loop .= '<h2 class="entry-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                    $loop .= '<div class="entry-meta">';
                    $loop .= '<span class="entry-date">' . get_the_date() . '</span>';
                    $loop .= '<span> / </span>';
                    $loop .= '<span class="entry-comment">' . get_comments_number($post->ID) . esc_html__(' Comments', 'amy-movie-extend') . '</span>';
                    $loop .= '</div>';
                    $loop .= '</div>';
                    $loop .= '<div class="clearfix"></div>';
                    $loop .= '</div>';

                endwhile;
            endif;

			wp_reset_query();
		}

		$class_type = ($post_type == 'post') ? 'post' : 'movie';

		$output = '<div class="amy-widget amy-widget-list list-' . $class_type . ' ' . $class . '">';

        $output .= '<h4 class="amy-title amy-widget-title">' . $instance['title'] . '</h4>';

		$output .= $loop;

		$output .= '</div>';

		echo $output;

		echo $args['after_widget'];
    }
}