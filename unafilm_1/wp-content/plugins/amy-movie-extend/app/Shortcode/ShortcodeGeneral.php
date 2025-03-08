<?php
namespace AmyMovie\Shortcode;

use AmyMovie\Core\Base;
use AmyMovie\Movie\Movie;

class ShortcodeGeneral {
    private $base;
    private $single_movie;

    public function __construct() {
        $this->base = new Base();
        $this->single_movie = new Movie();
    }

    public function shortcode_list() {
        return [
            'advance_search',
            'blog',
            'movie_carousel',
            'movie_grid',
            'movie_list',
            'rate_list',
//            //'search',
//            'showtime',
            'movie_slide',
            'person_list',
            'v2_gallery_carousel',
            'v2_gallery_grid',
            'heading',
            'v2_movie_carousel_1',
            'v2_movie_carousel_2',
            'v2_movie_carousel_3',
            'v2_movie_grid',
            'v2_movie_list',
            'v2_showtime_1',
            'v2_showtime_2',
            'v2_showtime_3',
            'v2_showtime_4',
            'v2_trailer_list'
        ];
    }

    public function get_movie_follow_showtime($data, $date_check, $cinema_id = false) {
        $new_data = array();
        if (!empty($data)) {
            foreach ($data as $item) {
                $this->single_movie->set_movie($item->ID);

                if ($this->base->get_option('is_single_cinema', false)) {
                    $single_cinema	= $this->single_movie->get_single_cinema_showtime();

                    if (!empty($single_cinema)) {
                        foreach ($single_cinema as $date) {
                            if (strtotime($date['date']) == strtotime($date_check)) {
                                $new_data[] = $item;
                            }
                        }
                    }
                } else {
                    $showtimes 	= $this->single_movie->get_multi_cinema_showtime();

                    if (!empty($showtimes)) {
                        foreach ($showtimes as $showtime) {
                            foreach ($showtime['_showtimes'] as $date) {
                                if (strtotime($date['date']) == strtotime($date_check)) {
                                    $new_data[] = $item;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $new_data;
    }

    public function carousel_render_slide_option($params) {
        $slick  = '{';
        $slick .= '"slidesToShow":5,"slidesToScroll":5,';

        if ($params['autoplay']) {
            $slick .= '"autoplay":true,';
        } else {
            $slick .= '"autoplay":false,';
        }

        $slick .= '"autoplaySpeed":' . $params['autoplayspeed'] . ',';

        if ($params['show_arrows']) {
            $slick .= '"arrows":true,';
        } else {
            $slick .= '"arrows":false,';
        }

        if ($params['infinite']) {
            $slick .= '"infinite":true,';
        } else {
            $slick .= '"infinite":false,';
        }

        if ($params['centerMode']) {
            $slick .= '"centerMode":true,';
        } else {
            $slick .= '"centerMode":false,';
        }

        $slick .= '"responsive": [' .
            '{"breakpoint": 480,"settings": {"slidesToShow": 1,"slidesToScroll": 1}},' .
            '{"breakpoint": 979,"settings": {"slidesToShow": 3,"slidesToScroll": 3}},' .
            '{"breakpoint": 1199,"settings": {"slidesToShow": 5,"slidesToScroll": 5}},' .
            '{"breakpoint": 1999,"settings": {"slidesToShow": 7,"slidesToScroll": 7}},' .
            '{"breakpoint": 4999,"settings": {"slidesToShow": ' . $params['post_slideshow'] . ',"slidesToScroll": ' . $params['post_slideshow'] . '}}' .
            '],';

        if ($params['show_dots']) {
            $slick .= '"dots":true';
        } else {
            $slick .= '"dots":false';
        }

        $slick .= '}';

        return $slick;
    }

    public function render_slide_options($params) {
        $slick  = '{';
        $slick .= '"slidesToShow":1,"slidesToScroll":1,';

        if ($params['autoplay']) {
            $slick .= '"autoplay":true,';
        } else {
            $slick .= '"autoplay":false,';
        }

        $slick .= '"autoplaySpeed":' . $params['autoplayspeed'] . ',';
        $slick .= '"prevArrow": "<a class=\"amy-arrow fa amy-pre fa-chevron-right\"></a>",';
        $slick .= '"nextArrow": "<a class=\"amy-arrow fa amy-next fa-chevron-left\"></a>",';

        if ($params['show_arrows']) {
            $slick .= '"arrows":true,';
        } else {
            $slick .= '"arrows":false,';
        }

        if ($params['infinite']) {
            $slick .= '"infinite":true,';
        } else {
            $slick .= '"infinite":false,';
        }

        if ($params['fade']) {
            $slick .= '"fade":true,';
        } else {
            $slick .= '"fade":false,';
        }

        if ($params['usecss']) {
            $slick .= '"useCSS":true,';
        } else {
            $slick .= '"useCSS":false,';
        }

        if ($params['usetransform']) {
            $slick .= '"useTransform":true,';
        } else {
            $slick .= '"useTransform":false,';
        }

        if ($params['show_dots']) {
            $slick .= '"dots":true';
        } else {
            $slick .= '"dots":false';
        }

        $slick .= '}';

        return $slick;
    }

    public function render_v2_carousel_1_slide_options($params) {
        $is_sidebar = false;

        $slick  = '{';
        $slick .= '"slidesToShow":' . $params['number_slide'] . ',"slidesToScroll":' . $params['number_slide'] . ',';

        if ($params['autoplay']) {
            $slick .= '"autoplay":true,';
        } else {
            $slick .= '"autoplay":false,';
        }

        $slick .= '"autoplaySpeed":' . $params['autoplayspeed'] . ',';

        if ($params['infinite']) {
            $slick .= '"infinite":true,';
        } else {
            $slick .= '"infinite":false,';
        }

        if ($params['show_arrows']) {
            $slick .= '"arrows":true,';
        } else {
            $slick .= '"arrows":false,';
        }

        if ($is_sidebar) {
            $slick .= '"responsive": [' .
                '{"breakpoint": 480,"settings": {"slidesToShow": 2,"slidesToScroll": 2}},' .
                '{"breakpoint": 768,"settings": {"slidesToShow": 3,"slidesToScroll": 3}},' .
                '{"breakpoint": 992,"settings": {"slidesToShow": 4,"slidesToScroll": 4}},' .
                '{"breakpoint": 1620,"settings": {"slidesToShow": 4,"slidesToScroll": 4}},' .
                '{"breakpoint": 4999,"settings": {"slidesToShow": 4,"slidesToScroll": 4}}' .
                '],';
        } else {
            if ($params['number_slide'] < 7) {
                $slick .= '"responsive": [' .
                    '{"breakpoint": 480,"settings": {"slidesToShow": 2,"slidesToScroll": 2}},' .
                    '{"breakpoint": 768,"settings": {"slidesToShow": 3,"slidesToScroll": 3}},' .
                    '{"breakpoint": 992,"settings": {"slidesToShow": 3,"slidesToScroll": 3}},' .
                    '{"breakpoint": 1620,"settings": {"slidesToShow": ' . $params['number_slide'] .',"slidesToScroll": ' . $params['number_slide'] . '}},' .
                    '{"breakpoint": 4999,"settings": {"slidesToShow": ' . $params['number_slide'] . ',"slidesToScroll": ' . $params['number_slide'] . '}}' .
                    '],';
            } else {
                $slick .= '"responsive": [' .
                    '{"breakpoint": 480,"settings": {"slidesToShow": 2,"slidesToScroll": 2}},' .
                    '{"breakpoint": 768,"settings": {"slidesToShow": 3,"slidesToScroll": 3}},' .
                    '{"breakpoint": 992,"settings": {"slidesToShow": 4,"slidesToScroll": 4}},' .
                    '{"breakpoint": 1620,"settings": {"slidesToShow": 7,"slidesToScroll": 7}},' .
                    '{"breakpoint": 4999,"settings": {"slidesToShow": ' . $params['number_slide'] . ',"slidesToScroll": ' . $params['number_slide'] . '}}' .
                    '],';
            }
        }

        $slick .= '"dots":false';
        $slick .= '}';

        return $slick;
    }

    public function list_fields_config_visiable() {
        $list_fields_visible = array(
            esc_html__('Release', 'amy-movie-extend')	=> 'movie_release',
            esc_html__('Imdb', 'amy-movie-extend')		=> 'movie_imdb',
            esc_html__('Language', 'amy-movie-extend')	=> 'movie_language',
            esc_html__('Genre', 'amy-movie-extend')		=> 'movie_genre',
            esc_html__('Actor', 'amy-movie-extend')		=> 'movie_actor',
            esc_html__('Director', 'amy-movie-extend')	=> 'movie_director',
            esc_html__('Cinema', 'amy-movie-extend')	=> 'movie_cinema'
        );

        if (!empty($this->base->get_option('movie_custom_fields'))) {
            foreach ($this->base->get_option('movie_custom_fields') as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    $list_fields_visible[$name] = $singular_name;
                }
            }
        }

        return $list_fields_visible;
    }
}