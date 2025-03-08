<?php
namespace AmyMovie\Movie;

use AmyMovie\Core\Base;

class MovieQuery {
    public function build($params) {
        $arpg			= array();

        $base = new Base();

        //basic params
        $post_type		= $base->get_value_in_array($params, 'post_type', 'amy_movie');
        $order_by	    = $base->get_value_in_array($params, 'orderby');
        $order		    = $base->get_value_in_array($params, 'order');
        $posts_per_page	= $base->get_value_in_array($params, 'posts_per_page');
        $paged			= $base->get_value_in_array($params, 'paged');

        //movie params
        $movie_type		= $base->get_value_in_array($params, 'movie_type');
        $sort_by		= $base->get_value_in_array($params, 'sortby');

        //custom fields params
        $custom_fields	= $base->get_value_in_array($params, 'custom_fields', []);

        //other params
        $movie_release  = $base->get_value_in_array($params, 'movie_release');
        $movie_cinema   = $base->get_value_in_array($params, 'movie_cinema');

        //search
        $keyword        = $base->get_value_in_array($params, 'keyword');

        if ($movie_release != '') {
            $release	= array(
                'key'		=> '_release',
                'value'		=> $movie_release,
                'compare' 	=> '=',
            );
        } else {
            $release		= '';
        }

        if ($movie_cinema != '') {
            $cinema	= array(
                'key'		=> '_cinema_id',
                'value'		=> $movie_cinema,
                'compare' 	=> 'LIKE',
            );
        } else {
            $cinema		= '';
        }

        /**
         * Begin
         */

        //basic
        if ($post_type == 'all') {
            $arpg['post_type']		= array('amy_movie', 'amy_tvshow');
        } else {
            $arpg['post_type']		= $post_type;
        }

        if ($keyword) {
            $arpg['s'] = $keyword;
        }

        $arpg['order'] 			= $order;
        $arpg['posts_per_page'] = $posts_per_page;
        $arpg['paged']			= $paged;

        //Movie type
        if ($movie_type != '' && $base->get_option('enable_start_end_date', false)) {
            $current_day = current_time('Y-m-d');

            switch ($movie_type) {
                case 'today':
                    $meta_movie_query = array('key' => '_start_date', 'value' => $current_day, 'compare' => '=');
                    break;
                case 'now':
                    $meta_movie_query = array(
                        'relation' => 'AND',
                        array('key' => '_start_date', 'value' => $current_day, 'compare' => '<='),
                        array('key' => '_end_date', 'value' => $current_day, 'compare' => '>='),
                    );
                    break;
                case 'cm':
                    $meta_movie_query = array('key' => '_start_date', 'value' => $current_day, 'compare' => '>=');
                    break;
                case 'old':
                    $meta_movie_query = array('key' => '_end_date', 'value' => $current_day, 'compare' => '<=');
                    break;
                default:
                    $meta_movie_query = '';
                    break;
            }
        } else {
            $meta_movie_query	= '';
        }

        $arpg['meta_query'][] = $meta_movie_query;
        $arpg['meta_query'][] = $release;
        $arpg['meta_query'][] = $cinema;

        //sort by
        if ($sort_by != '') {
            $order_by = $sort_by;
        }

        if ($order_by == '_rating_average' || $order_by == '_amy_post_views_count' || $order_by == '_release') {
            $arpg['meta_key'] 	= $order_by;
            $arpg['orderby']	= 'meta_value';
        } else {
            $arpg['orderby']	= $order_by;
        }

        //custom fields params
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                if (!empty($field)) {
                    if ($field['type'] == 'person' || $field['type'] == 'category') {
                        $arpg['tax_query'][] = array(
                            'taxonomy' => $field['id'],
                            'field' => 'term_id',
                            'terms' => explode(',', $field['value'])
                        );
                    }
                }
            }
        }

        return $arpg;
    }
}