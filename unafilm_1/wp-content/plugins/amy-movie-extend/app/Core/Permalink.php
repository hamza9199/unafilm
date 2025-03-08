<?php
namespace AmyMovie\Core;

class Permalink {

    public function __construct() {
        add_action('admin_init', array(__CLASS__, 'settings_init'));
        add_action('admin_init', array(__CLASS__, 'settings_save'));
    }

    public static function settings_init() {
        add_settings_section('amy_movie_permalink', esc_html__('Amy Movie Custom Permalinks'), null, 'permalink');

        add_settings_field(
            'amy_movie_slug',
            esc_html__('Single Movie Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_movie_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );

        add_settings_field(
            'amy_cinema_slug',
            esc_html__('Single Cinema Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_cinema_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );

        add_settings_field(
            'amy_actor_slug',
            esc_html__('Single Actor Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_actor_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );

        add_settings_field(
            'amy_director_slug',
            esc_html__('Single Director Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_director_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );

        add_settings_field(
            'amy_genre_slug',
            esc_html__('Single Genre Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_genre_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );

        add_settings_field(
            'amy_tvshow_slug',
            esc_html__('Single Tv Show Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_tvshow_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );

        add_settings_field(
            'amy_season_slug',
            esc_html__('Single Season Slug', 'amy-movie-extend'),
            array(__CLASS__, 'amy_season_slug_callback'),
            'permalink',
            'amy_movie_permalink'
        );
    }

    public static function amy_movie_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['movie_slug']) ? $permalinks['movie_slug'] : '';

        echo '<input placeholder="movie" type="text" id="amy_movie_slug" name="amy_movie_permalinks[movie_slug]" value="' . $value . '" />';
    }

    public static function amy_cinema_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['cinema_slug']) ? $permalinks['cinema_slug'] : '';

        echo '<input placeholder="cinema" type="text" id="amy_cinema_slug" name="amy_movie_permalinks[cinema_slug]" value="' . $value . '" />';
    }

    public static function amy_actor_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['actor_slug']) ? $permalinks['actor_slug'] : '';

        echo '<input placeholder="actor" type="text" id="amy_actor_slug" name="amy_movie_permalinks[actor_slug]" value="' . $value . '" />';
    }

    public static function amy_director_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['director_slug']) ? $permalinks['director_slug'] : '';

        echo '<input placeholder="director" type="text" id="amy_director_slug" name="amy_movie_permalinks[director_slug]" value="' . $value . '" />';
    }

    public static function amy_genre_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['genre_slug']) ? $permalinks['genre_slug'] : '';

        echo '<input placeholder="genre" type="text" id="amy_genre_slug" name="amy_movie_permalinks[genre_slug]" value="' . $value . '" />';
    }

    public static function amy_tvshow_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['tvshow_slug']) ? $permalinks['tvshow_slug'] : '';

        echo '<input placeholder="tvshow" type="text" id="amy_tvshow_slug" name="amy_movie_permalinks[tvshow_slug]" value="' . $value . '" />';
    }

    public static function amy_season_slug_callback() {
        $permalinks = get_option('amy_movie_permalinks', '');
        $value		= isset($permalinks['season_slug']) ? $permalinks['season_slug'] : '';

        echo '<input placeholder="season" type="text" id="amy_season_slug" name="amy_movie_permalinks[season_slug]" value="' . $value . '" />';
    }

    public static function settings_save() {
        if (!is_admin()) {
            return;
        }

        if (isset($_POST['permalink_structure'])) {
            $permalinks = get_option('amy_movie_permalinks');

            if (!$permalinks) {
                $permalinks = array();
            }

            $permalinks['movie_slug']		= trim($_POST['amy_movie_permalinks']['movie_slug']);
            $permalinks['cinema_slug']		= trim($_POST['amy_movie_permalinks']['cinema_slug']);
            $permalinks['actor_slug']		= trim($_POST['amy_movie_permalinks']['actor_slug']);
            $permalinks['director_slug']	= trim($_POST['amy_movie_permalinks']['director_slug']);
            $permalinks['genre_slug']		= trim($_POST['amy_movie_permalinks']['genre_slug']);
            $permalinks['tvshow_slug']		= trim($_POST['amy_movie_permalinks']['tvshow_slug']);
            $permalinks['season_slug']		= trim($_POST['amy_movie_permalinks']['season_slug']);

            update_option('amy_movie_permalinks', $permalinks);
        }
    }
}



