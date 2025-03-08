<?php
use AmyMovie\Core\Base;
use AmyMovie\Core\Media;

Class OmdbApi {
    private $api_key;
    private $timeout;
    private $api_url = 'http://www.omdbapi.com';
    private $base;
    private $media;

    public function __construct() {
        $this->base     = new Base();
        $this->media    = new Media();
        $this->api_key  = $this->base->get_option('omdb_api_key');
        $this->timeout  = $this->base->get_option('imdb_timeout') ? $this->base->get_option('imdb_timeout') : '120';
    }

    public function connect($imdb_id) {
        $args['apikey'] = $this->api_key;
        $args['i']		= $imdb_id;
        $args['plot']	= 'full';

        $request_url    = add_query_arg($args, $this->api_url);
        $response 		= wp_remote_get($request_url, array(
            'timeout'     => $this->timeout,
        ));

        if (!is_wp_error($response) && !empty($response)) {
            if (isset($response['body']) && ! empty($response['body'])) {
                $response_data = json_decode($response['body'], true);

                if ($response_data['Response'] == 'False') {
                    $result = [
                        'status'    => false,
                        'msg'       => $response_data['Error']
                    ];
                } else {

                    $movie_id = $this->import_movie($response_data);
                    $result = [
                        'status'    => true,
                        'msg'       => $movie_id,
                    ];
                }
            } else {
                $result = [
                    'status'    => false,
                    'msg'       => esc_html__('Connect OMDB API error!', 'amy-movie-extend'),
                ];
            }
        } else {
            $result = [
                'status'    => false,
                'msg'       => esc_html__('Connect OMDB API error!', 'amy-movie-extend'),
            ];
        }

        return $result;
    }

    private function import_movie($movie_data) {
        $movie = !empty($movie_data) ? $movie_data : [];

        $amy_media_id = sanitize_title($movie['Title']);
        $this->media::add_image_to_media_gallery($amy_media_id, $movie['Poster']);

        $movie_content = isset($movie['Plot']) ? $movie['Plot'] : '';

        $new_movie = array(
            'post_title'        => $movie['Title'],
            'post_status'       => 'publish',
            'post_type'         => 'amy_movie',
            'post_content'      => $movie_content,
            'comment_status'    => 'open',
            'guid'              => 'amy_uid_0_' . uniqid(),
        );

        $movie_id = wp_insert_post($new_movie);

        if (is_wp_error($movie_id)) {
            return -999;
        }

        update_post_meta($movie_id, 'amy_imdb_movie', true);

        $poster_id = $this->media::get_by_amy_id($amy_media_id);
        $poster = [
            'url'       => wp_get_attachment_image_src($poster_id, 'full')[0],
            'thumbnail' => wp_get_attachment_image_src($poster_id, 'thumbnail', true)[0],
            'width'     => wp_get_attachment_image_src($poster_id, 'full')[1],
            'height'    => wp_get_attachment_image_src($poster_id, 'full')[2],
            'alt'       => '',
            'title'     => '',
            'description'=> '',
        ];

        add_post_meta($movie_id, '_poster', $poster);

        add_post_meta($movie_id, '_language', $this->base->get_value_in_array($movie, 'Language'));
        add_post_meta($movie_id, '_mpaa', $this->base->get_value_in_array($movie, 'Rated'));
        add_post_meta($movie_id, '_imdb', $this->base->get_value_in_array($movie, 'imdbRating'));
        add_post_meta($movie_id, '_duration', str_replace(' min', '', $movie['Runtime']));
        add_post_meta($movie_id, '_release', date('Y-m-d', strtotime($this->base->get_value_in_array($movie, 'Released'))));
        add_post_meta($movie_id, '_layout', '');

        if (isset($movie['Genre'])) {
            $genres = explode(',', $movie['Genre']);

            if (! empty($genres)) {
                $genre_ids = array();

                foreach ($genres as $genre) {
                    if (! term_exists($genre, 'amy_genre')) {
                        $genre_term 	= wp_insert_term($genre, 'amy_genre');
                        $genre_ids[] 	= $genre_term['term_id'];
                    } else {
                        $term 			= get_term_by('name', $genre, 'amy_genre');
                        $genre_ids[]	= $term->term_id;
                    }
                }

                wp_set_post_terms($movie_id, $genre_ids, 'amy_genre');
            }
        }

        if (isset($movie['Director'])) {
            $directors = explode(',', $movie['Director']);

            if (! empty($directors)) {
                $director_ids = array();

                foreach ($directors as $director) {
                    if (! term_exists($director, 'amy_director')) {
                        $director_term 	= wp_insert_term($director, 'amy_director');
                        $director_ids[]	= $director_term['term_id'];
                    } else {
                        $term 			= get_term_by('name', $director, 'amy_director');
                        $director_ids[]	= $term->term_id;

                    }
                }

                wp_set_post_terms($movie_id, $director_ids, 'amy_director');
            }
        }

        if (isset($movie['Actors'])) {
            $actors = explode(',', $movie['Actors']);

            if (! empty($actors)) {
                $actor_ids = array();

                foreach ($actors as $actor) {
                    if (! term_exists($actor, 'amy_actor')) {
                        $actor_term 	= wp_insert_term($actor, 'amy_actor');
                        $actor_ids[]	= $actor_term['term_id'];
                    } else {
                        $term 			= get_term_by('name', $actor, 'amy_actor');
                        $actor_ids[]	= $term->term_id;

                    }
                }

                wp_set_post_terms($movie_id, $actor_ids, 'amy_actor');
            }
        }

        return $movie_id;
    }

}