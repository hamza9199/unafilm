<?php
namespace AmyMovie\Core;

class Admin {
    public function __construct() {
        add_action('csf__movie_block_showtime_save_after', [$this, 'custom_save_movie_cinema'], 10, 3);
        add_action('csf__movie_block_details_save_after', [$this, 'custom_save_movie_rating_average'], 10, 3);
        add_action('csf__season_options_save_after', [$this, 'custom_save_season'], 10, 3);

        add_action('save_post_amy_movie', [$this, 'custom_term_order_save']);
    }

    public function custom_term_order_save() {

    }

    public function custom_save_movie_cinema($data, $post_id, $c) {
        if (isset($data['_cinema']) && $data['_cinema'] != null) {
            $arr = [];

            foreach ($data['_cinema'] as $cinema) {
                $arr[] = $cinema['select_cinema'];
            }

            $arr = array_unique($arr);

            $value = array_map('strval', $arr);

            if (get_post_meta($post_id, '_cinema_id')) {
                update_post_meta($post_id, '_cinema_id', $value);
            } else {
                add_post_meta($post_id, '_cinema_id', $value);
            }
        }
    }

    public function custom_save_movie_rating_average($data, $post_id, $c) {
        if (isset($data['_rating_total_count']) && isset($data['_rating_total_point']) && (int)$data['_rating_total_count'] > 0 && (int)$data['_rating_total_point'] > 0) {
            $average = (int)$data['_rating_total_point'] / (int)$data['_rating_total_count'];

            if (get_post_meta($post_id, '_rating_average')) {
                update_post_meta($post_id, '_rating_average', round($average, 1));
            } else {
                add_post_meta($post_id, '_rating_average', round($average, 1));
            }
        }
    }

    public function custom_save_season($data, $post_id, $a) {
        if (isset($data['_tv_show'])) {
            $tv_show_id     = $data['_tv_show'];
            $season_list    = get_post_meta($tv_show_id, 'season_list', true);

            if (!empty($season_list)) {
                $season_arr = [];

                foreach ($season_list as $season) {
                    $season_arr[] = $season['select_season'];
                }

                if (!in_array($post_id, $season_arr)) {
                    $season_list[]['select_season'] = $post_id;
                }

            } else {
                $season_list = [];
                $season_list[] = [
                    'select_season'	=> $post_id
                ];
            }

            update_post_meta($tv_show_id, 'season_list', $season_list);
        }
    }
}