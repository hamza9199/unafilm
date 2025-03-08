<?php
namespace AmyMovie\Core;

use AmyMovie\Core\Base;
use AmyMovie\Core\Gamajo;
use AmyMovie\Movie\MovieHelpers;

class Template extends Gamajo {
    private $base;
    private $movie;

    protected $filter_prefix = 'movie';
    protected $theme_template_directory = 'movie';
    protected $plugin_directory = AMY_MOVIE_PLUGIN_PATH;

    public function __construct() {
        add_filter('template_include', [$this, 'search_template']);
        add_filter('template_include', [$this, 'custom_template']);

        $this->base     = new Base();
        $this->movie    = new MovieHelpers();
    }

    public function search_template($template) {
        global $wp_query;

        if ($wp_query->is_search) {
            $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : null;

            if ($post_type === 'amy_movie') {
                return locate_template('movie-search');
            }

            if ($post_type === 'advance_search') {
                $template = $this->get_template_part('search/advance-search', null, false);
            }
        }

        return $template;
    }

    public function custom_template($template) {
        $custom_fields		= $this->base->get_option('movie_custom_fields');

        if (!empty($custom_fields)) {
            foreach ($custom_fields as $field) {
                if ($field['type'] == 'category' || $field['type'] == 'person') {
                    $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                    $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                    if(is_tax($singular_name)) {
                        $template 	= $this->get_template_part('taxonomy/taxonomy-' . $singular_name, null, false);

                        if (!$template) {
                            $template = $this->get_template_part('taxonomy/taxonomy-' . $field['type'], null, false);
                        }
                    }
                }
            }
        }

        if (is_tax('amy_genre')) {
            $template 	= $this->get_template_part('taxonomy/taxonomy-category', null, false);
        }

        if (is_tax('amy_actor') || is_tax('amy_director')) {
            $template 	= $this->get_template_part('taxonomy/taxonomy-person', null, false);
        }

        if (is_singular('amy_movie')) {
            $template 	= $this->get_template_part('single/single-movie', null, false);
        }

        if (is_singular('amy_cinema')) {
            $template 	= $this->get_template_part('single/single-cinema', null, false);
        }

        if (is_singular('amy_tvshow')) {
            $template 	= $this->get_template_part('single/single-tv-show', null, false);
        }

        if (is_singular('amy_season')) {
            $template 	= $this->get_template_part('single/single-season', null, false);
        }

        if ($this->movie->enable_stream() && is_page($this->movie->get_stream_page())) {
            if (isset($_GET[$this->movie->get_stream_season_prefix_name()])) {
                $template 	= $this->get_template_part('single/season-streaming', null, false);
            } else {
                $template 	= $this->get_template_part('single/streaming', null, false);
            }
        }

        return $template;
    }
}