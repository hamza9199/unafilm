<?php
namespace AmyMovie\Shortcode;

use AmyMovie\Core\Base;
use AmyMovie\Shortcode\ShortcodeGeneral;
use AmyMovie\Movie\MovieHelpers;

class Elementor extends ShortcodeGeneral {
    public function __construct() {
        if (!defined('ELEMENTOR_VERSION')) {
            return;
        }

        add_action('elementor/elements/categories_registered', array(
            __CLASS__,
            'create_elementor_categories'
       ), 99);

        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);

        add_action('elementor/frontend/after_register_styles',function() {
            foreach(['solid', 'regular', 'brands'] as $style) {
                wp_deregister_style('elementor-icons-fa-' . $style);
            }
        }, 20);
    }

    public function init_widgets() {
        $widgets = $this->shortcode_list();

        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                require_once AMY_MOVIE_PLUGIN_PATH . 'elementor/' . $widget . '/' . $widget . '.php';
            }
        }
    }

    public static function create_elementor_categories($elements_manager) {
        $elements_manager->add_category(
            'amy-movie-widgets',
            array('title' => esc_html__('Amy Movie', 'amy-movie-extend')),
            0
       );
    }

    public function default_control($amy) {
        $base           = new Base();
        $movie_helper   = new MovieHelpers();

        $defaults_fields = $movie_helper->get_options_default_fields();
        $custom_fields   = $movie_helper->get_options_custom_fields();

        $amy->start_controls_section(
            'section_content_query',
            [
                'label' => esc_html__('Query', 'amy-movie-extend'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
       );

        if ($base->get_option('enable_m_cinema') == false) {
            $amy->add_control(
                'post_type',
                [
                    'label'       => esc_html__('Movie Type', 'amy-movie-extend'),
                    'type'        => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options'     => array(
                        'amy_movie'  => esc_html__('Movie', 'amy-movie-extend'),
                        'amy_tvshow' => esc_html__('Tvshow', 'amy-movie-extend'),
                   ),
                    'default'   => 'amy_movie'
                ]
           );
        }

        if (! empty($defaults_fields)) {
            foreach ($defaults_fields as $field) {
                if ($field == 'movie_genre' || $field == 'movie_actor' || $field == 'movie_director') {
                    $name          = '';
                    $singular_name = '';

                    if ($field == 'movie_genre') {
                        $name          = esc_html__('Genre', 'amy-movie-extend');
                        $singular_name = 'amy_genre';
                    } else if ($field == 'movie_actor') {
                        $name          = esc_html__('Actor', 'amy-movie-extend');
                        $singular_name = 'amy_actor';
                    } else if ($field == 'movie_director') {
                        $name          = esc_html__('Director', 'amy-movie-extend');
                        $singular_name = 'amy_director';
                    }

                    $terms   = get_terms(array('taxonomy' => $singular_name));
                    $options = array();

                    if (! empty($terms)) {
                        foreach ($terms as $term) {
                            $options[ $term->term_id ] = $term->name;
                        }
                    }

                    $amy->add_control(
                        $singular_name,
                        [
                            'label'       => $name,
                            'type'        => \Elementor\Controls_Manager::SELECT2,
                            'label_block' => true,
                            'multiple'    => true,
                            'options'     => $options,
                        ]
                   );
                }
            }
        }

        if (! empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name          = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    $terms   = get_terms(array('taxonomy' => $singular_name));
                    $options = array();

                    if (! empty($terms)) {
                        foreach ($terms as $term) {
                            $options[$term->term_id] = $term->name;
                        }
                    }

                    $amy->add_control(
                        $singular_name,
                        [
                            'label'       => $name,
                            'type'        => \Elementor\Controls_Manager::SELECT2,
                            'label_block' => true,
                            'multiple'    => true,
                            'options'     => $options,
                        ]
                   );
                }
            }
        }

        //order by
        $amy->add_control(
            'orderby',
            [
                'label'       => esc_html__('Order By', 'amy-movie-extend'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'default'     => 'date',
                'options'     => array(
                    '_rating_average'       => esc_html__('Rate', 'amy-movie-extend'),
                    '_release'    => esc_html__('Release Date', 'amy-movie-extend'),
                    '_amy_post_views_count' => esc_html__('Post Views', 'amy-movie-extend'),
                    'ID'                    => esc_html__('Post ID', 'amy-movie-extend'),
                    'title'                 => esc_html__('Title', 'amy-movie-extend'),
                    'date'                  => esc_html__('Date', 'amy-movie-extend'),
                    'rand'                  => esc_html__('Random Order', 'amy-movie-extend'),
                    'comment_count'         => esc_html__('Comment Count', 'amy-movie-extend'),
               ),
            ]
       );

        //order
        $amy->add_control(
            'order',
            [
                'label'       => esc_html__('Sort order', 'amy-movie-extend'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'default'     => 'DESC',
                'options'     => array(
                    'DESC' => esc_html__('Descending', 'amy-movie-extend'),
                    'ASC'  => esc_html__('Ascending', 'amy-movie-extend'),
               ),
            ]
       );

        //movie type
        if ($base->get_option('enable_start_end_date', false)) {
            $amy->add_control(
                'movie_type',
                [
                    'label'       => esc_html__('Movie Type', 'amy-movie-extend'),
                    'type'        => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'default'     => 'now',
                    'options'     => array(
                        'today' => esc_html__('Today (Start Date = Current Day)', 'amy-movie-extend'),
                        'now'   => esc_html__('Now Playing (Start Date <= Current Day <= End Date)', 'amy-movie-extend'),
                        'cm'    => esc_html__('Comming Soon (Current Date < Start Date)', 'amy-movie-extend'),
                        'old'   => esc_html__('Old Movie (Current Date > End Date', 'amy-movie-extend'),
                        'all'   => esc_html__('All Movie', 'amy-movie-extend'),
                   ),
                ]
           );
        }

        $amy->end_controls_section();
    }

    public function shortcode_taxonomy_render_query($params, $settings, $amy_genre, $amy_actor, $amy_director) {
        $base           = new Base();
        $custom_fields  = $base->get_option('movie_custom_fields');

        if (! empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name          = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    if ($base->get_value_in_array($settings, $singular_name)) {
                        $params['custom_fields'][] = array(
                            'type'  => $field['type'],
                            'id'    => $singular_name,
                            'value' => implode(',', $base->get_value_in_array($settings, $singular_name))
                        );
                    }
                }
            }
        }

        if (!empty($amy_genre)) {
            $params['custom_fields'][] = array(
                'type'  => 'category',
                'id'    => 'amy_genre',
                'value' => implode(',', $amy_genre)
            );
        }

        if (!empty($amy_actor)) {
            $params['custom_fields'][] = array(
                'type'  => 'person',
                'id'    => 'amy_actor',
                'value' => implode(',', $amy_actor)
            );
        }

        if (!empty($amy_director)) {
            $params['custom_fields'][] = array(
                'type'  => 'person',
                'id'    => 'amy_director',
                'value' => implode(',', $amy_director)
            );
        }

        return $params;
    }
}