<?php
namespace AmyMovie\Shortcode;

use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Transition;

class ShortcodeHtml {
    private $movie_id;
    private $base;
    private $movie;
    private $single_movie;
    private $transition;

    public function __construct() {
        $this->base         = new Base();
        $this->movie        = new MovieHelpers();
        $this->transition   = new Transition();
    }

    public function set_movie($id) {
        $this->movie_id     = $id;
        $this->single_movie = new Movie();
        $this->single_movie->set_movie($id);
    }

    public function poster($size) {
        $html = array();

        $html[] = '<a href="' . $this->single_movie->get_url() . '">';
        $html[] = $this->single_movie->render_html_poster($size);
        $html[] = '</a>';

        return implode("\n", $html);
    }

    public function imdb() {
        $html 					= array();
        $defaults_fields		= $this->movie->get_options_default_fields();

        if (in_array('movie_imdb', $defaults_fields) && $this->single_movie->get_imdb()) {
            $html[] = '<span class="amy-movie-field-imdb">' . esc_attr($this->single_movie->get_imdb()) . '</span>';
        }

        return implode("\n", $html);
    }

    public function title() {
        return '<h3 class="amy-movie-field-title"><a href="' . $this->single_movie->get_url() . '">' . esc_attr($this->single_movie->get_title()) . '</a></h3>';
    }

    public function rating() {
        $html 		= array();
        $average  	= $this->single_movie->get_rate_average();

        if ($average > 0) {
            $html[] = '<div class="amy-movie-field-rating"><div class="amy-movie-field-rating-inner">';
            $html[] = '<span class="rating-stars"><span class="current-rating" style="width: ' . round($average / 5, 2) * 100 . '%"></span></span>';
            $html[] = '<span class="user-rating"><a href="#">' . '(' . esc_attr($this->single_movie->get_rate_total_count()) . ' ' . $this->transition->get_string_translate('Votes') . ')' . '</a></span>';
            $html[] = '</div></div>';
        }

        return implode("\n", $html);
    }

    public function mpaa() {
        $html 					= array();
        $defaults_fields		= $this->movie->get_options_default_fields();

        if (in_array('movie_mpaa', $defaults_fields) && $this->single_movie->get_mpaa()) {
            $html[] = '<span class="amy-movie-field-mpaa">' . esc_attr($this->single_movie->get_mpaa()) . '</span>';
        }

        return implode("\n", $html);
    }

    public function duration() {
        $html 					= array();
        $defaults_fields		= $this->movie->get_options_default_fields();

        if (in_array('movie_duration', $defaults_fields) && $this->single_movie->get_duration()) {
            $html[] = '<span class="amy-movie-field-duration"><i class="fa fa-clock-o"></i>' . $this->movie->convert_time(esc_attr($this->single_movie->get_duration())) . '</span>';
        }

        return implode("\n", $html);
    }

    public function content($length = 20) {
        return '<div class="amy-movie-field-desc">' . $this->single_movie->get_excerpt_by_id($length) . '</div>';
    }

    public function custom_fields($list_fields_visible) {
        $html 				= array();
        $custom_fields		= $this->movie->merge_default_taxonomy_to_custom_fields();
        $defaults_fields	= $this->movie->get_options_default_fields();
        $fields_visible		= explode(',', $list_fields_visible);

        if ($this->single_movie->get_language() && in_array('movie_language', $defaults_fields) && in_array('movie_language', $fields_visible)) {
            $html[] = '<div class="amy-movie-custom-field-group amy-movie-field-language">';
            $html[] = '<label class="amy-movie-custom-field-label">' . $this->transition->get_string_translate('Language') . ':</label>';
            $html[] = '<div class="amy-movie-custom-field-content">';
            $html[] = esc_attr($this->single_movie->get_language());
            $html[] = '</div>';
            $html[] = '</div>';
        }

        if ($this->single_movie->get_release_date() && in_array('movie_release', $defaults_fields) && in_array('movie_release', $fields_visible)) {
            $html[] = '<div class="amy-movie-custom-field-group amy-movie-field-release_date">';
            $html[] = '<label class="amy-movie-custom-field-label">' . $this->transition->get_string_translate('Release Date') . ':</label>';
            $html[] = '<div class="amy-movie-custom-field-content">';
            $html[] = $this->single_movie->get_format_release_date();
            $html[] = '</div>';
            $html[] = '</div>';
        }

        if (!empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                if (in_array($singular_name, $fields_visible) || in_array('movie_genre', $fields_visible) || in_array('movie_actor', $fields_visible) || in_array('movie_director', $fields_visible)) {
                    $html[] = '<div class="amy-movie-custom-field-group amy-movie-field-' . $singular_name . '">';

                    if ($field['type'] == 'category' || $field['type'] == 'person') {
                        if ($this->single_movie->render_taxonomy_template($singular_name)) {
                            $html[] = '<label class="amy-movie-custom-field-label">' . ucfirst($name) . ':</label>';
                            $html[] = '<div class="amy-movie-custom-field-content">';
                            $html[] = $this->single_movie->render_taxonomy_template($singular_name);
                            $html[] = '</div>';
                        }
                    } else if ($field['type'] == 'text' && get_post_meta($movie_id, $singular_name, true)) {
                        $html[] = '<div class="amy-movie-custom-field-group amy-movie-field-' . $singular_name . '">';
                        $html[] = '<label class="amy-movie-custom-field-label">' . ucfirst($name) . ':</label>';
                        $html[] = '<div class="amy-movie-custom-field-content">';
                        $html[] = esc_attr(get_post_meta($movie_id, $singular_name, true));
                        $html[] = '</div>';
                        $html[] = '</div>';
                    } else if ($field['type'] == 'date' && get_post_meta($movie_id, $singular_name, true)) {
                        $html[] = '<div class="amy-movie-custom-field-group amy-movie-field-' . $singular_name . '">';
                        $html[] = '<label class="amy-movie-custom-field-label">' . ucfirst($name) . ':</label>';
                        $html[] = '<div class="amy-movie-custom-field-content">';
                        $html[] = date_i18n(get_option('date_format'), strtotime(get_post_meta($movie_id, $singular_name, true)));
                        $html[] = '</div>';
                        $html[] = '</div>';
                    }

                    $html[] = '</div>';
                }
            }
        }

        return implode("\n", $html);
    }

    public function button() {
        $html 		= array();

        $trailer	= $this->single_movie->get_first_trailer_link();

        if ($trailer) {
            $html[] = '<a href="' . $this->movie->convert_tralier_link($trailer) . '" class="amy-btn-icon-text link-detail fancybox.iframe amy-fancybox">';
            $html[] = '<i class="fa fa-play"></i>' . $this->transition->get_string_translate('Trailer') . '</a>';
        }

        $html[] = '<a class="amy-btn-icon-text link-detail" href="' . esc_url($this->single_movie->get_url()) . '">';
        $html[] = '<i class="fa fa-info"></i>' . $this->transition->get_string_translate('Detail') . '</a>';

        return implode("\n", $html);
    }

    public function v2_showtime_1_layout_showtime($date_type, $cinema_id = false, $layout = false) {
        $html		= [];

        if ($this->base->get_option('is_single_cinema', false)) {
            $showtime_list	= $this->single_movie->get_single_cinema_showtime();

            if (!empty($showtime_list)) {
                $html[] = $this->v2_showtime_1_layout_showtime_content($showtime_list, $date_type);
            }
        } else {
            $showtimes 	= $this->single_movie->get_multi_cinema_showtime();
            if (!empty($showtimes)) {
                foreach ($showtimes as $showtime) {
                    $html[] = $this->v2_showtime_1_layout_showtime_content($showtime['_showtimes'], $date_type);
                }
            }
        }

        return implode("\n", $html);
    }

    private function v2_showtime_1_layout_showtime_content($showtimes, $date_type) {
        $today      = date('m/d/y');
        $html		= array();
        $i 			= 0;

        if (!empty($showtimes)) {
            foreach ($showtimes as $date) {
                if (($date_type == 'cm' && strtotime($date['date']) > strtotime($today)) || ($date_type == 'all')) {
                    $class = 'amy-cell';
                    $class .= ($i == 0) ? ' current-date' : '';
                    $html[] = '<div class="' . esc_attr($class) . '">';
                    $html[] = '<div class="amy-cell-inner"><div class="inner-content">';

                    $html[] = '<div class="amy-head">';
                    $html[] = '<div>' . date_i18n('D', strtotime($date['date'])) . '</div>';
                    $html[] = '<div>' . date_i18n(get_option('date_format'), strtotime($date['date'])) . '</div>';
                    $html[] = '</div>';


                    $time_list = explode(',', $date['hour']);

                    if (!empty($time_list)) {
                        $html[] = '<div class="amy-intro-times">';

                        foreach ($time_list as $time) {
                            $html[] = '<div>' . $time . '</div>';
                        }

                        if ($this->base->get_option('enable_m_ticket', false) == true && class_exists('woocommerce') && defined('SMARTCMS_SRW_URL')) {
                            if (isset($date['product']) && $date['product'] != '') {
                                $html[] = '<a class="button" href="' . esc_url(get_permalink($date['product'])) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                            }
                        } else {
                            if ($date['link'] && $date['link'] != '') {
                                $html[] = '<a class="button" href="' . esc_url($date['link']) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                            }
                        }

                        $html[] = '</div>';
                    }

                    $html[] = '</div></div>';
                    $html[] = '</div>';
                }

                $i++;
            }
        }

        return implode("\n", $html);
    }

    public function v2_showtime_2_layout_showtime($date_type, $cinema_id = false, $layout = false) {
        $html = [];

        if ($this->base->get_option('is_single_cinema', false)) {
            $showtime_list	= $this->single_movie->get_single_cinema_showtime();

            if (!empty($showtime_list)) {
                $html[] = $this->v2_showtime_2_layout_showtime_content($showtime_list, $date_type);
            }
        } else {
            $showtimes 	= $this->single_movie->get_multi_cinema_showtime();

            if (!empty($showtimes)) {
                foreach ($showtimes as $showtime) {
                    $html[] = $this->v2_showtime_2_layout_showtime_content($showtime['_showtimes'], $date_type);
                }
            }
        }

        return implode("\n", $html);
    }

    private function v2_showtime_2_layout_showtime_content($showtimes, $date_type) {
        $html		= array();
        $i 			= 0;

        if (!empty($showtimes)) {
            foreach ($showtimes as $date) {
                if (strtotime($date['date']) == $date_type) {
                    $time_list = explode(',', $date['hour']);

                    if (!empty($time_list)) {
                        foreach ($time_list as $time) {
                            $html[] = '<div class="amy-movie-intro-times">';
                            $html[] = '<span>' . $time . '</span>';
                            $html[] = '</div>';
                        }

                        if ($this->base->get_option('enable_m_ticket', false) == true && class_exists('woocommerce') && defined('SMARTCMS_SRW_URL')) {
                            if (isset($date['product']) && $date['product'] != '') {
                                $html[] = '<a class="button" href="' . esc_url(get_permalink($date['product'])) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                            }
                        } else {
                            if ($date['link'] && $date['link'] != '') {
                                $html[] = '<a class="button" href="' . esc_url($date['link']) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                            }
                        }
                    }
                }

                $i++;
            }
        }

        return implode("\n", $html);
    }

    public function v2_showtime_3_layout_showtime($date_type, $cinema_id = false, $layout = false) {
        $html		= [];

        if ($this->base->get_option('is_single_cinema', false)) {
            $single_cinema	= $this->single_movie->get_single_cinema_showtime();
            if (!empty($single_cinema)) {
                $html[] = $this->v2_showtime_3_layout_showtime_content($single_cinema, $date_type);
            }
        } else {
            $showtimes 	= $this->single_movie->get_multi_cinema_showtime();

            if (!empty($showtimes)) {
                foreach ($showtimes as $showtime) {
                    $html[] = $this->v2_showtime_3_layout_showtime_content($showtime['_showtimes'], $date_type);
                }
            }
        }

        return implode("\n", $html);
    }

    public function v2_showtime_3_layout_showtime_content($showtimes, $date_type) {
        $html		= [];

        if (!empty($showtimes)) {
            foreach ($showtimes as $date) {
                if (strtotime($date['date']) == strtotime($date_type)) {
                    $time_list = explode(',', $date['hour']);

                    if (!empty($time_list)) {
                        $html[] = '<div class="amy-movie-intro-times">';

                        foreach ($time_list as $time) {
                            $html[] = '<span>' . $time . '</span>';
                        }

                        if ($this->base->get_option('enable_m_ticket', false) == true && class_exists('woocommerce') && defined('SMARTCMS_SRW_URL')) {
                            if (isset($date['product']) && $date['product'] != '') {
                                $html[] = '<a class="button" href="' . esc_url(get_permalink($date['product'])) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                            }
                        } else {
                            if ($date['link'] && $date['link'] != '') {
                                $html[] = '<a class="button" href="' . esc_url($date['link']) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                            }
                        }

                        $html[] = '</div>';
                    }
                }
            }
        }

        return implode("\n", $html);
    }

    public function v2_showtime_4_layout_showtime($date_type, $cinema_id = false, $layout = false) {
        $today      = date('m/d/y');
        $html		= [];
        $i 			= 0;

        $showtimes 	= $this->single_movie->get_multi_cinema_showtime();

        if (!empty($showtimes)) {
            foreach ($showtimes as $showtime) {
                if (!empty($showtime['_showtimes']) && $i == 0) {
                    $html[] = '<select name="timelist" class="timelist" data-movie="' . $this->movie_id . '">';

                    foreach ($showtime['_showtimes'] as $date) {
                        if (($date_type == 'cm' && $date['date'] > $today) || ($date_type == 'all')) {
                            $html[] = '<option value="' . $date['date'] . '">' . date_i18n(get_option('date_format'), strtotime($date['date'])) . '</option>';
                        }
                    }

                    $html[] = '</select>';

                    $html[] = '<div class="amy-movie-item-time-list">';

                    foreach ($showtime['_showtimes'] as $date) {
                        if (($date_type == 'cm' && strtotime($date['date']) > strtotime($today)) || ($date_type == 'all')) {
                            $time_list = explode(',', $date['hour']);

                            if (!empty($time_list)) {
                                foreach ($time_list as $time) {
                                    $html[] = '<span class="intro-time">' . $time . '</span>';
                                }

                                if ($this->base->get_option('enable_m_ticket', false) && class_exists('woocommerce') && defined('SMARTCMS_SRW_URL')) {
                                    if (isset($date['product']) && $date['product'] != '') {
                                        $html[] = '<a class="button" href="' . esc_url(get_permalink($date['product'])) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                                    }
                                } else {
                                    if (isset($date['link']) && $date['link'] != '') {
                                        $html[] = '<a class="button" href="' . esc_url($date['link']) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                                    }
                                }
                            }
                            break;
                        }
                    }

                    $html[] = '</div>';
                }

                $i++;
            }


        }

        return implode("\n", $html);
    }
}