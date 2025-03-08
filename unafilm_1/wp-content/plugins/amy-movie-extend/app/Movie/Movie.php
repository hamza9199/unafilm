<?php
namespace AmyMovie\Movie;

use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

class Movie extends Base {
    private $movie_id;
    private $base;
    private $movie_helper;
    private $transition;

    public function __construct() {
        $this->base             = new Base();
        $this->movie_helper     = new MovieHelpers();
        $this->transition       = new Transition();
    }

    public function set_movie($id) {
        $this->movie_id = $id;

        //global $post;

        //$this->movie_id = isset($post->ID) ? $post->ID : $this->movie_id;
    }

    public function get_layout() {
        $layout_global  = $this->base->get_option('movie_sidebar_default', 'right');
        $layout	        = get_post_meta($this->movie_id, '_layout', true);
        $layout         = ($layout == '') ? $layout_global : $layout;

        return $layout;
    }

    public function get_poster() {
        $poster = get_post_meta($this->movie_id, '_poster', true);

        return $this->get_value_in_array($poster, 'url');
    }

    public function render_html_poster($size, $class = '') {
        return '<img class="' . $class . '" src="' . mr_image_resize($this->get_poster(), $size['width'], $size['height']) . '" alt="' . $this->get_title() . '"/>';
    }

    public function get_banner() {
        $poster = get_post_meta($this->movie_id, '_banner', true);

        return $this->get_value_in_array($poster, 'url');
    }

    public function render_html_banner() {
        return '<img src="' . $this->get_banner() . '" alt="' . $this->get_title() . '"/>';
    }

    public function get_gallery() {
        return get_post_meta($this->movie_id, '_gallery', true);
    }

    public function get_trailer_list() {
        $list   = get_post_meta($this->movie_id, '_trailer', true);
        $result = [];

        if (!empty($list) && is_array($list)) {
            foreach ($list as $link) {
                $result[] = $this->get_value_in_array($link, '_link');
            }
        }
        return $result;
    }

    public function get_first_trailer_link() {
        $list   = $this->get_trailer_list();
        $first  = !empty($list) ? $list[0] : false;

        return $first;
    }

    public function get_url() {
        return get_permalink($this->movie_id);
    }

    public function get_title() {
        return get_the_title($this->movie_id);
    }

    public function get_release_date() {
        return get_post_meta($this->movie_id, '_release', true);
    }

    public function get_duration() {
        return get_post_meta($this->movie_id, '_duration', true);
    }

    public function get_format_duration() {
        return $this->movie_helper->convert_time($this->get_duration());
    }

    public function get_mpaa() {
        return get_post_meta($this->movie_id, '_mpaa', true);
    }

    public function get_imdb() {
        return get_post_meta($this->movie_id, '_imdb', true);
    }

    public function get_language() {
        return get_post_meta($this->movie_id, '_language', true);
    }

    public function get_format_release_date($format = false) {
        $format = !$format ? get_option('date_format') : $format;
        return date_i18n($format, strtotime($this->get_release_date()));
    }

    public function get_rate_total_count() {
        return get_post_meta($this->movie_id, '_rating_total_count', true);
    }

    public function get_rate_total_point() {
        return get_post_meta($this->movie_id, '_rating_total_point', true);
    }

    public function get_rate_average() {
        $count      = (int) $this->get_rate_total_count();
        $point      = (int) $this->get_rate_total_point();
        $average    = ($point != 0 && $count != 0) ? round($point / $count, 1) : 0;

        return $average;
    }

    public function get_excerpt_by_id($length = 20) {
        $post		= get_post($this->movie_id);
        $excerpt	= $post->post_content;

        $excerpt 	= strip_tags(strip_shortcodes($excerpt));
        $words 		= explode(' ', $excerpt, $length + 1);

        if (count($words) > $length) {
            array_pop($words);
            array_push($words, '...');
            $excerpt = implode(' ', $words);
        }

        $excerpt = '<p>' . $excerpt . '</p>';

        return $excerpt;
    }

    public function get_single_cinema_showtime() {
        return get_post_meta($this->movie_id, '_showtimes', true);
    }

    public function get_multi_cinema_showtime() {
        return get_post_meta($this->movie_id, '_cinema', true);;
    }

    public function get_cinema() {
        $items 		= get_post_meta($this->movie_id, '_cinema_id', true);
        $array	    = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $array[] = $item;
            }
        }

        return $array;
    }

    public function render_star() {
        $star = '<ul class="movie-rating-stars">';
        $star .= '<li><a class="movie-rating-star movie-rating-star-1" data-value="1" data-post="' . $this->movie_id . '"></a></li>';
        $star .= '<li><a class="movie-rating-star movie-rating-star-2" data-value="2" data-post="' . $this->movie_id . '"></a></li>';
        $star .= '<li><a class="movie-rating-star movie-rating-star-3" data-value="3" data-post="' . $this->movie_id . '"></a></li>';
        $star .= '<li><a class="movie-rating-star movie-rating-star-4" data-value="4" data-post="' . $this->movie_id . '"></a></li>';
        $star .= '<li><a class="movie-rating-star movie-rating-star-5" data-value="5" data-post="' . $this->movie_id . '"></a></li>';
        $star .= '</ul>';

        return $star;
    }

    public function render_social_link() {
        global $post;

        $link						= $this->get_url();
        $single_movie_share_social 	= $this->base->get_option('single_movie_share_social', ['facebook', 'twitter', 'pinterest']);

        echo '<ul class="amy-social-links clearfix">';

        if (in_array('facebook', $single_movie_share_social)) {
            echo '<li><a href="https://www.facebook.com/sharer.php?u=' . esc_url($link) . '" class="fab fa-facebook" target="_blank"></a></li>';
        }

        if (in_array('twitter', $single_movie_share_social)) {
            echo '<li><a href="http://www.twitter.com/share?url=' . esc_url($link) . '" class="fab fa-twitter" target="_blank"></a></li>';
        }

        if (in_array('pinterest', $single_movie_share_social)) {
            echo '<li><a href="http://pinterest.com/pin/create/button/?url=' . esc_url($link) . '" class="fab fa-pinterest" target="_blank"></a></li>';
        }

        if (in_array('digg', $single_movie_share_social)) {
            echo '<li><a href="http://digg.com/submit?url=' . esc_url($link) . '" class="fab fa-digg" target="_blank"></a></li>';
        }

        if (in_array('linkedin', $single_movie_share_social)) {
            echo '<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url($link) . '" class="fab fa-linkedin" target="_blank"></a></li>';
        }

        if (in_array('reddit', $single_movie_share_social)) {
            echo '<li><a href="https://reddit.com/submit?url=' . esc_url($link) . '" class="fab fa-reddit" target="_blank"></a></li>';
        }

        if (in_array('skype', $single_movie_share_social)) {
            echo '<li><a href="https://web.skype.com/share?url=' . esc_url($link) . '" class="fab fa-skype" target="_blank"></a></li>';
        }

        if (in_array('tumblr', $single_movie_share_social)) {
            echo '<li><a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . esc_url($link) . '" class="fab fa-tumblr" target="_blank"></a></li>';
        }

        if (in_array('vk', $single_movie_share_social)) {
            echo '<li><a href="http://vk.com/share.php?url=' . esc_url($link) . '" class="fab fa-vk" target="_blank"></a></li>';
        }

        if (in_array('weibo', $single_movie_share_social)) {
            echo '<li><a href="http://service.weibo.com/share/share.php?url=' . esc_url($link) . '" class="fab fa-weibo" target="_blank"></a></li>';
        }

        if (in_array('xing', $single_movie_share_social)) {
            echo '<li><a href="https://www.xing.com/spi/shares/new?url=' . esc_url($link) . '" class="fab fa-xing" target="_blank"></a></li>';
        }

        if (in_array('yahoo', $single_movie_share_social)) {
            echo '<li><a href="http://compose.mail.yahoo.com/?to=' . esc_url($link) . '" class="fab fa-yahoo" target="_blank"></a></li>';
        }

        echo '</ul>';
    }

    public function render_taxonomy_template($type) {
        $terms	= wp_get_post_terms($this->movie_id, $type, ['orderby' => 'term_order']);
        $custom_fields		= $this->movie_helper->get_options_custom_fields();

        if (!empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                $name = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                $singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                if ($field['type'] == 'person' && $type == $singular_name) {
                    $terms = $this->movie_helper->order_person($terms, $type);
                }
            }
        }

        if ($type == 'amy_actor' || $type == 'amy_director') {
            $terms = $this->movie_helper->order_person($terms, $type);
        }

        $html 		= '';
        $numItems 	= count($terms);
        $i 			= 0;

        if (!empty($terms)) {
            foreach ($terms as $term) {

                if (++$i === $numItems) {
                    $space = '';
                } else {
                    $space = ', ';
                }

                $html .= '<a href="' . get_term_link($term->slug, $type) . '">';
                $html .= $term->name;
                $html .= '</a>';
                $html .= $space;
            }
        }

        return $html;
    }

    public function render_showtime_tmp($m_id, $c_id, $date, $layout) {
        $items 		= get_post_meta($m_id, '_movie_block_cinema', true);
        $content 	= '';

        if (isset($items['amy_movie_cinema'])) {
            $items = $items['amy_movie_cinema'];

            if (!empty($items)) {
                foreach ($items as $i => $item) {
                    if (isset($c_id) && $c_id != '') {
                        if ($item['select_cinema'] == $c_id) {
                            for ($j = 1; $j < 8; $j++) {
                                $content .= $this->check_number($item, $j, $date);
                            }
                        }
                    } else {
                        if ($layout == 'tsl') {
                            $content .= '<div class="showtime-item"><h3>' . get_the_title($item['select_cinema']) . '</h3><div class="st-item">';
                        }

                        for ($j = 1; $j < 8; $j++) {
                            $content .= $this->check_number($item, $j, $date);
                        }

                        if ($layout == 'tsl') {
                            $content .= '</div></div>';
                        }
                    }
                }
            }
        }

        return $content;
    }

    private function check_number($item, $number, $date) {
        $content	= '';

        if ($item[ 'cinema_date_' . $number ] != '') {
            $time_list 	= explode(',', $item['cinema_hour_' . $number]);
            $day 		= strtotime($item['cinema_date_' . $number]);
            $today 		= strtotime(date('Y-m-d'));

            if (($date == 'today' && $today == $day) || ($date == 'cm' && $day > $today) || ($date == 'all')) {
                $content .= '<div class="st-title">';
                $content .= '<label>' . date_i18n(get_option('date_format'), $day) . '</label>';

                if ($item['link_buyticket_' . $number] != '') {
                    $content .= '<a href="' . esc_url($item['link_buyticket_' . $number]) . '" class="amy-buy-ticket" target="_blank">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                }

                $content .= '</div>';

                $content .= '<ul>';

                foreach ($time_list as $t => $time) {
                    $content .= '<li>' . $time . '</li>';
                }

                $content .= '</ul>';
            }
        }

        return $content;
    }

    public function render_showtime_v2($cinema_id, $date, $layout) {
        $html 		    = [];

        if ($this->base->get_option('is_single_cinema', false)) {
            $showtime_list	= $this->get_single_cinema_showtime();

            if (!empty($showtime_list)) {
                $html[] = '<div class="showtime-item single-cinema">';
                foreach ($showtime_list as $showtime) {
                    $html[] = '<div class="st-item">';
                    $html[] = $this->showtime_v2_layout($showtime, $date);
                    $html[] = '</div>';
                }

                $html[] = '</div>';
            }
        } else {
            $multi_cinema 	= $this->get_multi_cinema_showtime();

            if (!empty($multi_cinema)) {
                foreach ($multi_cinema as $item) {
                    if (isset($cinema_id) && $cinema_id != '') {
                        if ($item['select_cinema'] == $cinema_id) {
                            if (!empty($item['_showtimes'])) {
                                foreach ($item['_showtimes'] as $showtime) {
                                    $html[] = $this->showtime_v2_layout($showtime, $date);
                                }
                            }
                        }
                    } else {
                        if ($layout == 'tsl') {
                            $html[] = '<div class="showtime-item"><h3>' . get_the_title($item['select_cinema']) . '</h3><div class="st-item">';
                        }

                        if (!empty($item['_showtimes'])) {
                            foreach ($item['_showtimes'] as $showtime) {
                                $html[] = $this->showtime_v2_layout($showtime, $date);
                            }
                        }

                        if ($layout == 'tsl') {
                            $html[] = '</div></div>';
                        }
                    }
                }
            }
        }

        return implode(' ', $html);
    }

    private function showtime_v2_layout($showtime, $date) {
        $content	= '';
        $today 		= strtotime(date('Y-m-d'));
        $day		= isset($showtime['date']) ? strtotime($showtime['date']): '';
        $time_list	= isset($showtime['hour']) ? explode(',', $showtime['hour']): array();

        if (($date == 'today' && $today == $day) || ($date == 'cm' && $day >= $today) || ($date == 'all')) {
            $content .= '<div class="st-title">';
            $content .= '<label>' . date_i18n(get_option('date_format'), $day) . '</label>';

            if ($this->base->get_option('enable_m_ticket', false) == true && class_exists('woocommerce') && defined('SMARTCMS_SRW_URL')) {
                if (isset($showtime['product']) && $showtime['product'] != '') {
                    $content .= '<a href="' . esc_url(get_permalink($showtime['product'])) . '" class="amy-buy-ticket" target="_blank">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                }

            } else {
                if ($showtime['link'] != '') {
                    $content .= '<a href="' . esc_url($showtime['link']) . '" class="amy-buy-ticket" target="_blank">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                }
            }

            $content .= '</div>';

            $content .= '<ul>';

            if (!empty($time_list)) {
                foreach ($time_list as $t => $time) {
                    $content .= '<li>' . $time . '</li>';
                }
            }

            $content .= '</ul>';
        }

        return $content;
    }
}