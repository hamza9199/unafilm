<?php
namespace AmyMovie\Core;

class Setup {
    public function __construct() {
        add_filter('get_previous_post_join', [$this, 'get_adjacent_past_events_join']);
        add_filter('get_next_post_join', [$this, 'get_adjacent_past_events_join']);

        add_filter('get_next_post_where', [$this, 'get_next_past_events_where']);

        add_filter('get_previous_post_where', [$this, 'get_pre_past_events_where']);
    }

    public function get_adjacent_past_events_join($join) {
        if (is_singular('amy_season')) {
            global $wpdb;

            $new_join = $join . "INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id ";

            return $new_join;
        }

        return $join;
    }

    public function get_next_past_events_where($where) {
        if (is_singular('amy_season')) {
            global $wpdb, $post;

            $tvshow_id = get_post_meta($post->ID, '_tv_show', true);

            $new_where = "WHERE p.post_type = 'amy_season' AND p.post_status = 'publish' AND m.meta_key = '_tv_show' AND m.meta_value = " . $tvshow_id . " AND p.id > " . $post->ID;

            return $new_where;
        }

        return $where;
    }

    public function get_pre_past_events_where($where) {
        if (is_singular('amy_season')) {
            global $wpdb, $post;

            $tvshow_id = get_post_meta($post->ID, '_tv_show', true);

            $new_where = "WHERE p.post_type = 'amy_season' AND p.post_status = 'publish' AND m.meta_key = '_tv_show' AND m.meta_value = " . $tvshow_id . " AND p.id < " . $post->ID;

            return $new_where;
        }

        return $where;
    }
}