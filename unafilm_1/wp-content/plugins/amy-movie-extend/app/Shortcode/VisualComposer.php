<?php
namespace AmyMovie\Shortcode;

use AmyMovie\Shortcode\ShortcodeGeneral;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Base;

class VisualComposer extends ShortcodeGeneral {
    private $base;
    private $movie;
    private $custom_fields;
    private $defaults_fields;

    public function __construct() {
        $widgets = $this->shortcode_list();

        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                require_once AMY_MOVIE_PLUGIN_PATH . 'visual-composer/' . $widget . '/' . $widget . '.php';
            }
        }

        if (!class_exists('Vc_Manager')) {
            //return;
        }

        $this->base                 = new Base();
        $this->movie                = new MovieHelpers();
        $this->custom_fields		= $this->base->get_option('movie_custom_fields');
        $this->defaults_fields      = $this->base->get_option('movie_default_fields', $this->movie->default_fields());

        $this->custom_init();

        $widgets = $this->shortcode_list();

        if (!class_exists('Vc_Manager')) {
            return;
        }

        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                require_once AMY_MOVIE_PLUGIN_PATH . 'visual-composer/' . $widget . '/config.php';
            }
        }
    }

    private function custom_init() {
        if (!class_exists('Vc_Manager')) {
            return;
        }

        vc_set_as_theme(true);
        vc_set_default_editor_post_types(array('page'));

        require_once AMY_MOVIE_PLUGIN_PATH . '/libs/js-composer/includes/helpers.php';
        require_once AMY_MOVIE_PLUGIN_PATH . '/libs/js-composer/includes/params.php';
        require_once AMY_MOVIE_PLUGIN_PATH . '/libs/js-composer/includes/extends.php';
    }

    public function shortcode_atts() {
        $shortcodes_atts = [];

        if (!empty($this->defaults_fields)) {
            foreach ($this->defaults_fields as $field) {
                if ($field == 'movie_genre') {
                    $shortcodes_atts['amy_genre'] = '';
                } else if ($field == 'movie_actor') {
                    $shortcodes_atts['amy_actor'] = '';
                } else if ($field == 'movie_director') {
                    $shortcodes_atts['amy_director'] = '';
                }
            }
        }

        if (!empty($this->custom_fields)) {
            foreach ($this->custom_fields as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    $shortcodes_atts[$singular_name]	= '';
                }
            }
        }

        return $shortcodes_atts;
    }

    public function shortcode_taxonomy_render_query($params, $amy_genre, $amy_actor, $amy_director) {
        if (isset($amy_genre) && $amy_genre != '') {
            $params['custom_fields'][] = array(
                'type'		=> 'category',
                'id'		=> 'amy_genre',
                'value'		=> $amy_genre
            );
        }

        if (isset($amy_actor) && $amy_actor != '') {
            $params['custom_fields'][] = array(
                'type'		=> 'person',
                'id'		=> 'amy_actor',
                'value'		=> $amy_actor
            );
        }

        if (isset($amy_director) && $amy_director != '') {
            $params['custom_fields'][] = array(
                'type'		=> 'person',
                'id'		=> 'amy_director',
                'value'		=> $amy_director
            );
        }

        return $params;
    }

    public function default_params() {
        $params = array();

        if (!$this->base->get_option('enable_m_cinema', false)) {
            $params[] = array(
                'type' => 'dropdown',
                'heading' => esc_html__('Movie Type', 'amy-movie-extend'),
                'param_name' => 'post_type',
                'value' => array(
                    esc_html__('Movie', 'amy-movie-extend') => 'amy_movie',
                    esc_html__('Tvshow', 'amy-movie-extend') => 'amy_tvshow',
                ),
                'std' => 'amy_movie',
                'group' => esc_html__('Query Option', 'amy-movie-extend')
            );
        }

        if (!empty($this->defaults_fields)) {
            foreach ($this->defaults_fields as $field) {
                if ($field == 'movie_genre' || $field == 'movie_actor' || $field == 'movie_director') {
                    $name 			= '';
                    $singular_name 	= '';

                    if ($field == 'movie_genre') {
                        $name 			= esc_html__('Genre', 'amy-movie-extend');
                        $singular_name	= 'amy_genre';
                    } else if ($field == 'movie_actor') {
                        $name 			= esc_html__('Actor', 'amy-movie-extend');
                        $singular_name	= 'amy_actor';
                    } else if ($field == 'movie_director') {
                        $name 			= esc_html__('Director', 'amy-movie-extend');
                        $singular_name	= 'amy_director';
                    }

                    $terms 		= get_terms(array('taxonomy' => $singular_name));
                    $options 	= array();

                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $options[$term->name]	= $term->term_id;
                        }
                    }

                    $params[] = array(
                        'type'				=> 'vc_amy_chosen',
                        'heading'			=> $name,
                        'param_name'		=> $singular_name,
                        'value'				=> $options,
                        'group'				=> esc_html__('Query Option', 'amy-movie-extend'),
                        'std'				=> ''
                    );
                }
            }
        }

        if (!empty($this->custom_fields)) {
            foreach ($this->custom_fields as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    $terms 		= get_terms(array('taxonomy' => $singular_name));
                    $options 	= array();

                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $options[$term->name]	= $term->term_id;
                        }
                    }

                    $params[] = array(
                        'type'				=> 'vc_amy_chosen',
                        'heading'			=> $name,
                        'param_name'		=> $singular_name,
                        'value'				=> $options,
                        'std'				=> '',
                        'group'				=> esc_html__('Query Option', 'amy-movie-extend')
                    );
                }
            }
        }

        //order by
        $params[] = array(
            'type'			=> 'dropdown',
            'heading'		=> esc_html__('Order By', 'amy-movie-extend'),
            'param_name'	=> 'orderby',
            'value'		=> array(
                esc_html__('Rate', 'amy-movie-extend')				=> '_rating_average',
                esc_html__('Release Date', 'amy-movie-extend')		=> '_release',
                esc_html__('Post Views', 'amy-movie-extend')		=> '_amy_post_views_count',
                esc_html__('Post ID', 'amy-movie-extend')			=> 'ID',
                esc_html__('Title', 'amy-movie-extend')			    => 'title',
                esc_html__('Date', 'amy-movie-extend')				=> 'date',
                esc_html__('Random Order', 'amy-movie-extend')		=> 'rand',
                esc_html__('Comment Count', 'amy-movie-extend')	    => 'comment_count',
            ),
            'std'	=> 'date',
            'group'	=> esc_html__('Query Option', 'amy-movie-extend')
        );

        //order
        $params[] = array(
            'type'			=> 'dropdown',
            'heading'		=> esc_html__('Sort order', 'amy-movie-extend'),
            'param_name'	=> 'order',
            'value'			=> array(
                esc_html__('Descending', 'amy-movie-extend')	=> 'DESC',
                esc_html__('Ascending', 'amy-movie-extend')	=> 'ASC',
            ),
            'std'			=> 'DESC',
            'group'			=> esc_html__('Query Option', 'amy-movie-extend')
        );

        //movie type
        if ($this->base->get_option('enable_start_end_date', false)) {
            $filter_by = array(
                'type'			=> 'dropdown',
                'heading'		=> esc_html__('Movie Type', 'amy-movie-extend'),
                'param_name'	=> 'movie_type',
                'value'		=> array(
                    __('Today (Start Date = Current Day)', 'amy-movie-extend')						=> 'today',
                    __('Now Playing ( Start Date <= Current Day <= End Date)', 'amy-movie-extend')	=> 'now',
                    __('Comming Soon (Current Date < Start Date)', 'amy-movie-extend')				=> 'cm',
                    __('Old Movie (Current Date > End Date', 'amy-movie-extend')					=> 'old',
                    __('All Movie', 'amy-movie-extend')											=> 'all'
                ),
                'std'	=> 'now',
                'group'	=> esc_html__('Query Option', 'amy-movie-extend')
            );

            $params[] = $filter_by;
        }

        return $params;
    }

    public function check_url_param_exists_for_filter_movie($param, $type) {
        $result = [];

        if (isset($_GET[$param]) && $_GET[$param] != 'all') {
            $result = [
                'type'		=> $type,
                'id'		=> $param,
                'value'		=> $_GET[$param]
            ];
        } else {
            if (isset($$param) && $$param != '') {
                $result = [
                    'type'		=> $type,
                    'id'		=> $param,
                    'value'		=> $$param
                ];
            }
        }

        return $result;
    }
}