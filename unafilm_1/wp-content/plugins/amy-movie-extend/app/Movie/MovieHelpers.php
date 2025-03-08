<?php
namespace AmyMovie\Movie;

use AmyMovie\Core\Transition;
use AmyMovie\Core\Base;

class MovieHelpers {
    private $base;
    private $transition;

    public function __construct() {
        $this->base = new Base();
        $this->transition = new Transition();
    }

    public function get_options_custom_fields() {
        return $this->base->get_option('movie_custom_fields');
    }

    public function get_options_default_fields() {
        return $this->base->get_option('movie_default_fields', $this->default_fields());
    }

    public function merge_default_taxonomy_to_custom_fields() {
        $custom_fields = $this->get_options_custom_fields();

        if (!empty($this->get_options_default_fields())) {
            foreach ($this->get_options_default_fields() as $field) {
                if ($field == 'movie_genre') {
                    $custom_fields[] = array(
                        'name'			=> $this->transition->get_string_translate('Genre'),
                        'type'			=> 'category',
                        'singular_name'	=> 'amy_genre'
                    );
                } else if ($field == 'movie_actor') {
                    $custom_fields[] = array(
                        'name'			=> $this->transition->get_string_translate('Actor'),
                        'type'			=> 'person',
                        'singular_name'	=> 'amy_actor'
                    );
                } else if ($field == 'movie_director') {
                    $custom_fields[] = array(
                        'name'			=> $this->transition->get_string_translate('Director'),
                        'type'			=> 'person',
                        'singular_name'	=> 'amy_director'
                    );
                }
            }
        }

        return $custom_fields;
    }

    public function default_fields() {
        return [
            'movie_release',
            'movie_duration',
            'movie_imdb',
            'movie_mpaa',
            'movie_language',
            'movie_genre',
            'movie_actor',
            'movie_director'
        ];
    }

    public function order_person($terms, $type) {
        $order_arr = array();

        foreach ($terms as $term) {
            $details    = get_term_meta($term->term_id, AMY_MOVIE_PERSON_OPTIONS, true);
            $order		= $this->base->get_value_in_array($details, 'order_display');
            $order		= (int) $order != 0 ? (int) $order : 99999;

            $order_arr[$term->term_id] = $order;
        }

        asort($order_arr);

        $new_terms = array();

        foreach ($order_arr as $term_id => $order) {
            $new_terms[] = get_term_by('id', $term_id, $type);
        }

        return $new_terms;
    }

    public function convert_time($time) {
        $time = (int) $time;
        $format = '%02d ' . $this->transition->get_string_translate('hours') . ' %02d ' . $this->transition->get_string_translate('minutes');

        if ($time < 1) {
            return;
        }

        if ($time < 60) {
            return $time . ' ' . $this->transition->get_string_translate('minutes');
        } else {
            $hours 		= floor($time / 60);
            $minutes 	= ($time % 60);

            return sprintf($format, $hours, $minutes);
        }
    }

    public function convert_tralier_link($link) {
        if (strpos($link, 'youtube') == true) {
            parse_str(parse_url($link, PHP_URL_QUERY), $youtube);

            $newlink = 'https://www.youtube.com/embed/' . $youtube['v'] . '';
        } else if (strpos($link, 'vimeo.com') == true) {
            $id		= (int) substr(parse_url($link, PHP_URL_PATH), 1);

            $newlink = 'https://player.vimeo.com/video/' . $id . '';
        } else if (strpos($link, 'dailymotion.com') == true) {
            $id = strtok(basename($link), '_');

            $newlink = 'http://www.dailymotion.com/embed/video/' . $id . '';
        } else {
            $newlink = '';
        }

        return $newlink;
    }

    public function get_stream_page() {
        return $this->base->get_option('single_movie_stream_page');
    }

    public function get_stream_page_url_with_out_movie() {
        return get_permalink($this->get_stream_page());
    }

    public function get_stream_page_full_url($movie_slug) {
        if (is_singular('amy_season')) {
            $prefix = $this->get_stream_season_prefix_name();
        } else {
            $prefix = $this->get_stream_prefix_name();
        }
        return $this->get_stream_page_url_with_out_movie() . '?' . $prefix . '=' . $movie_slug;
    }

    public function get_stream_prefix_name() {
        return $this->base->get_option('single_movie_stream_prefix_name');
    }

    public function get_stream_season_prefix_name() {
        return $this->base->get_option('single_movie_stream_prefix_name_season');
    }

    public function enable_stream() {
        return $this->base->get_option('enable_streaming', false);
    }
}