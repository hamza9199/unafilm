<?php
namespace AmyMovie\Core;

use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

class PostType {
    private $permalink;
    private $base;
    private $post_type;
    private $transition;

    public function __construct() {
        $this->permalink    = get_option('amy_movie_permalinks');
        $this->base         = new Base();
        $this->transition   = new Transition();
        $this->post_type    = ['amy_movie', 'amy_tvshow'];

        add_action('init', [$this, 'create_post_type_movie']);
        add_action('init', [$this, 'create_post_type_cinema']);
        add_action('init', [$this, 'create_post_type_tv_show']);
        add_action('init', [$this, 'create_post_type_season']);

        add_action('init', [$this, 'create_taxonomy_genre']);
        add_action('init', [$this, 'create_taxonomy_actor']);
        add_action('init', [$this, 'create_taxonomy_director']);
        add_action('init', [$this, 'create_custom_fields_taxonomy']);
    }

    public function create_post_type_movie() {
        $movie_slug 	= $this->base->get_value_in_array($this->permalink, 'movie_slug', 'movie');
        $this->register_post_type('amy_movie', esc_html__('Movie', 'amy-movie-extend'), $movie_slug);
    }

    public function create_post_type_cinema() {
        if (!$this->base->get_option('enable_m_cinema', false) || $this->base->get_option('is_single_cinema', false)) {
            return;
        }

        $cinema_slug 	= $this->base->get_value_in_array($this->permalink, 'cinema_slug', 'cinema');
        $this->register_post_type('amy_cinema', esc_html__('Cinema', 'amy-movie-extend'), $cinema_slug);
    }

    public function create_post_type_tv_show() {
        if ($this->base->get_option('enable_m_cinema', false)) {
            return;
        }

        $tv_slug 	= $this->base->get_value_in_array($this->permalink, 'tvshow_slug', 'tvshow');
        $this->register_post_type('amy_tvshow', esc_html__('Tv Show', 'amy-movie-extend'), $tv_slug);
    }

    public function create_post_type_season() {
        if ($this->base->get_option('enable_m_cinema', false)) {
            return;
        }

        $season_slug 	= $this->base->get_value_in_array($this->permalink, 'season_slug', 'season');
        $this->register_post_type('amy_season', esc_html__('Season', 'amy-movie-extend'), $season_slug);
    }

    public function create_taxonomy_genre() {
        $genre_slug 	= $this->base->get_value_in_array($this->permalink, 'genre_slug', 'genre');
        $this->register_taxonomy('amy_genre', esc_html__('Genre', 'amy-movie-extend'), $genre_slug);
    }

    public function create_taxonomy_actor() {
        $actor_slug     = $this->base->get_value_in_array($this->permalink, 'actor_slug', 'actor');
        $this->register_taxonomy('amy_actor', esc_html__('Actor', 'amy-movie-extend'), $actor_slug);
    }

    public function create_taxonomy_director() {
        $director_slug     = $this->base->get_value_in_array($this->permalink, 'director_slug', 'director');
        $this->register_taxonomy('amy_director', esc_html__('Director', 'amy-movie-extend'), $director_slug);
    }

    public function create_custom_fields_taxonomy() {
        $custom_fields = $this->base->get_option('movie_custom_fields');

        if (!empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    $this->register_taxonomy($singular_name, $name, $singular_name);
                }
            }
        }
    }

    private function register_post_type($type, $name, $slug) {
        $args = [
            'labels'			=> array(
                'name' 			=> $name,
            ),
            'public' 				=> true,
            'has_archive' 			=> false,
            'publicly_queryable'  	=> true,
            'exclude_from_search'	=> false,
            'menu_icon'				=> 'dashicons-video-alt',
            'supports'				=> ['title', 'editor', 'comments'],
            'rewrite'				=> array(
                'slug' 			=> $slug,
                'with_front'    => true,
                'feeds'         => true,
                'pages'			=> true,
            ),
        ];

        register_post_type($type, $args);
    }

    private function register_taxonomy($tax, $name, $slug) {
        $args = [
            'hierarchical' 		=> false,
            'labels' 			=> array(
                'name'          => $name,
            ),
            'show_ui' 			=> true,
            'show_admin_column' => true,
            'query_var' 		=> true,
            'rewrite' 			=> array(
                'slug'                  => $slug,
                'with_front'            => true,
                'hierarchical'          => true,
            ),
        ];

        register_taxonomy($tax, $this->post_type, $args);
    }
}