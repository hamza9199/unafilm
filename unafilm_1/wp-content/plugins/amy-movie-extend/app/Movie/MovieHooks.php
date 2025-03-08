<?php
namespace AmyMovie\Movie;

use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeHtml;
use AmyMovie\Shortcode\ShortcodeGeneral;
use AmyMovie\Core\Template;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Transition;

Class MovieHooks {
    private $base;
    private $movie;
    private $sc_html;
    private $movie_query;
    private $sc_general;
    private $template;
    private $single_movie;
    private $transition;

    public function __construct() {
        $this->base         = new Base();
        $this->movie        = new MovieHelpers();
        $this->sc_html      = new ShortcodeHtml();
        $this->movie_query  = new MovieQuery();
        $this->sc_general   = new ShortcodeGeneral();
        $this->template     = new Template();
        $this->single_movie = new Movie();
        $this->transition   = new Transition();

        add_action('wp_ajax_amy_movie_ajax_rate', [$this, 'action_rate_movie']);
        add_action('wp_ajax_nopriv_amy_movie_ajax_rate', [$this, 'action_rate_movie']);

        add_action('wp_ajax_amy_movie_ajax_filter', [$this, 'action_filter_movie']);
        add_action('wp_ajax_nopriv_amy_movie_ajax_filter', [$this, 'action_filter_movie']);

        add_action('wp_ajax_amy_movie_ajax_showtime', [$this, 'action_showtime']);
        add_action('wp_ajax_nopriv_amy_movie_ajax_showtime', [$this, 'action_showtime']);

        add_action('wp_ajax_amy_movie_ajax_search', [$this, 'action_search']);
        add_action('wp_ajax_nopriv_amy_movie_ajax_search', [$this, 'action_search']);

        add_action('wp_ajax_amy_movie_shortcode_filter_ajax', [$this, 'action_filter_shortcode']);
        add_action('wp_ajax_nopriv_amy_movie_shortcode_filter_ajax', [$this, 'action_filter_shortcode']);

        remove_action('woocommerce_after_single_product', 'smartcms_srw_fontend_single');
        add_action('woocommerce_single_product_summary', 'smartcms_srw_fontend_single', 15);

        add_action('wp_ajax_amy_movie_ajax_shortcode_showtime_layout_4', array($this, 'ajax_shortcode_showtime_layout_4'));
        add_action('wp_ajax_nopriv_amy_movie_ajax_shortcode_showtime_layout_4', array($this, 'ajax_shortcode_showtime_layout_4'));

        add_action('wp_ajax_amy_movie_ajax_shortcode_showtime_layout_3', array($this, 'ajax_shortcode_showtime_layout_3'));
        add_action('wp_ajax_nopriv_amy_movie_ajax_shortcode_showtime_layout_3', array($this, 'ajax_shortcode_showtime_layout_3'));
    }

    public function action_rate_movie() {
        $point 		= $_REQUEST['point'];
        $post_id	= $_REQUEST['post_id'];

        if ($point > 5) {
            $point = 5;
        }

        $new_rate	= array();
        $ip_arr		= array();

        $ip_new 	= $_SERVER['REMOTE_ADDR'];
        $ip_arr[]	= $ip_new;
        $ip_old		= get_post_meta($post_id, '_movie_block_rating_ip');

        if ($ip_old) {
            if (in_array($ip_new, $ip_old[0]) == true) {
                echo -1;
                exit;
            } else {
                foreach ($ip_old[0] as $ip) {
                    $ip_arr[] = $ip;
                }

                update_post_meta($post_id, '_movie_block_rating_ip', $ip_arr);
            }
        } else {
            add_post_meta($post_id, '_movie_block_rating_ip', $ip_arr);
        }

        $now_turn	= get_post_meta($post_id, '_rating_total_count', true);
        $now_point	= get_post_meta($post_id, '_rating_total_point', true);
        $new_turn   = (int) $now_turn + 1;
        $new_point  = (int) $now_point + $point;
        $average    = round($new_point / $new_turn, 1);

        update_post_meta($post_id, '_rating_total_count', $new_turn);
        update_post_meta($post_id, '_rating_total_point', $new_point);
        update_post_meta($post_id, 'custom_rating', 0);
        update_post_meta($post_id, '_rating_average', $average);

        echo 1;
        exit;
    }

    public function action_showtime() {
        $cinema_id		= $_REQUEST['cinema_id'];
        $movie_id		= $_REQUEST['movie_id'];
        $action_type	= $_REQUEST['action_type'];
        $st_type		= $_REQUEST['st_type'];

        if ($action_type == 'shortcode') {
            $type = $st_type;
        } else {
            $type		= $this->base->get_option('movie_showtime_type');
        }

        $this->single_movie->set_movie($movie_id);
        $content = $this->single_movie->render_showtime_v2($cinema_id, $type, '');

        if ($content == "") {
            $content = $this->transition->get_string_translate('No Time');
        }

        echo json_encode($content);
        exit;
    }

    public function action_search() {
        $s = $_POST['s'];

        $args = array(
            's'	=> $s,
            'post_type'			=> array('amy_movie', 'amy_tvshow'),
            'posts_per_page'	=> $this->base->get_option('search_number'),
        );

        $html = array();

        $ajax_search_query 	= new WP_Query($args);
        $custom_size	= amy_movie_list_image_size();

        if ($ajax_search_query->have_posts()) {
            while ($ajax_search_query->have_posts()) {
                $ajax_search_query->the_post();

                global $post;

                $html[] = '<div class="item-movie">';
                $html[] = '<div class="item-poster">' . amy_movie_get_poster($post->ID, $custom_size['ajax_s']) . '</div>';
                $html[] = '<div class="item-name">';
                $html[] = '<a href="' . get_the_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a>';
                $html[] = '</div>';


                $html[] = '</div>';
            }
        } else {
            $html[] = '';
        }

        echo json_encode(implode('', $html));

        exit;
    }

    public function ajax_shortcode_showtime_layout_4() {
        $movie_id 	= $_REQUEST['movie_id'];
        $date		= $_REQUEST['date'];
        $html		= [];
        $i 			= 0;

        $this->single_movie->set_movie($movie_id);
        $showtimes 	= $this->single_movie->get_multi_cinema_showtime();

        if (!empty($showtimes)) {
            foreach ($showtimes as $showtime) {
                if (!empty($showtime['_showtimes']) && $i == 0) {
                    foreach ($showtime['_showtimes'] as $d) {
                        if (strtotime($d['date']) == strtotime($date)) {
                            $time_list = explode(',', $d['hour']);

                            if (!empty($time_list)) {
                                foreach ($time_list as $time) {
                                    $html[] = '<span class="intro-time">' . $time . '</span>';
                                }

                                if ($this->base->get_option('enable_m_ticket', false) == true && class_exists('woocommerce') && defined('SMARTCMS_SRW_URL')) {
                                    if (isset($d['product']) && $d['product'] != '') {
                                        $html[] = '<a class="button" href="' . esc_url(get_permalink($d['product'])) . '" target="_blank">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                                    }
                                } else {
                                    if (isset($d['link']) && $d['link'] != '') {
                                        $html[] = '<a class="button" href="' . esc_url($d['link']) . '">' . $this->transition->get_string_translate('Buy Ticket') . '</a>';
                                    }
                                }
                            }
                        }
                    }
                }

                $i++;
            }
        }

        echo json_encode(implode("\n", $html));
        exit;
    }

    public function ajax_shortcode_showtime_layout_3() {
        $params		= (array) json_decode(base64_decode($_REQUEST['param']));
        $options	= (array) json_decode(base64_decode($_REQUEST['option']));
        $date		= $_REQUEST['date'];

        $options['start_date'] = $date;

        $arpg 							= $this->movie_query->build($params);
        $movie_showtime_3_hooks_query 	= new \WP_Query($arpg);

        $list_movie_to_show = $this->sc_general->get_movie_follow_showtime($movie_showtime_3_hooks_query->posts, $date);

        $html = [];

        $data = [
            'list_fields_visible'   => $options['list_fields_visible'],
            'general_fields_tooltip'=> $options['general_fields_tooltip'],
            'start_date'            => $date
        ];

        ob_start();

        if (!empty($list_movie_to_show)) {
            foreach ($list_movie_to_show as $movie) {
                $data['movie'] = $movie;

                $this->template
                    ->set_template_data($data)
                    ->get_template_part('/shortcode/single/v2-showtime-3');
            }

        } else {
            $html[] = $this->transition->get_string_translate('No Movie');
        }

        $html[] = ob_get_clean();

        wp_reset_postdata();

        echo json_encode(implode('', $html));
        exit;
    }
}