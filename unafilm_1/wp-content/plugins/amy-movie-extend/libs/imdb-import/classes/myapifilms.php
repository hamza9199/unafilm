<?php
use AmyMovie\Core\Base;
use AmyMovie\Core\Media;

Class Myapifilms {
    private $api_key;
    private $timeout;
    private $api_url = 'http://www.myapifilms.com/tmdb/movieInfoImdb';
    private $base;
    private $media;

    public function __construct() {
        $this->base     = new Base();
        $this->media    = new Media();
        $this->api_key = $this->base->get_option('imdb_api_key');
        $this->timeout = $this->base->get_option('imdb_timeout') ? $this->base->get_option('imdb_timeout') : '120';
    }

    public function connect($imdb_id) {
        $args['idIMDB'] 		= $imdb_id;
        $args['token']			= $this->api_key;
        $args['format']			= 'json';
        $args['language']		= get_bloginfo("language");
        $args['actors']			= 1;
        $args['actorActress']	= 1;
        $args['biography']		= 1;
        $args['trailers']		= 1;
        //$args['moviePhotos']	= 2;
        //$args['movieVideos']	= 1;

        $request_url    = add_query_arg($args, $this->api_url);
        $response 		= wp_remote_get($request_url, array(
            'timeout'     => $this->timeout,
        ));

        if (!is_wp_error($response) && !empty($response)) {
            if (isset($response['body']) && ! empty($response['body'])) {
                $response_data = json_decode($response['body'], true);

                if (!empty($response_data['error'])) {
                    $result = [
                        'status'    => false,
                        'msg'       => $response_data['error']['message']
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
                    'msg'       => esc_html__('Connect Myapifilms API error!', 'amy-movie-extend'),
                ];
            }
        } else {
            $result = [
                'status'    => false,
                'msg'       => esc_html__('Connect Myapifilms API error!', 'amy-movie-extend'),
            ];
        }

        return $result;
    }

    private function import_movie($movie_data) {
        $movie = isset($movie_data['data']) ? $movie_data['data'] : array();

        if (! empty($movie)) {
            if ($movie['original_title'] != 'null') {
                $amy_media_id = $movie['original_title'];
            } else {
                $amy_media_id = $movie['title'];
            }
            $amy_media_id = str_replace(' ', '-', $amy_media_id);
            AmyMedia::add_image_to_media_gallery($amy_media_id, $movie['urlPoster']);

            $movie_content = isset($movie['overview']) ? $movie['overview'] : '';
            /*
             * add movie
             */
            $new_movie = array(
                'post_title'        => $movie['title'],
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

            $date = '';
            if (isset($movie['release_date'])) {
                $date = $movie['release_date'];
            }

            add_post_meta($movie_id, '_language', $movie['languages'][0]);
            add_post_meta($movie_id, '_mpaa', $this->base->get_value_in_array($movie, 'rated'));
            add_post_meta($movie_id, '_imdb', $this->base->get_value_in_array($movie, 'vote_average'));
            add_post_meta($movie_id, '_duration', str_replace(' min', '', $movie['runtime']));
            add_post_meta($movie_id, '_release', date('m/d/Y', strtotime($date)));
            add_post_meta($movie_id, '_layout', '');

            /*
            $gallery						= array();

            if (!empty($movie['simpleImages'])) {
                foreach ($movie['simpleImages'] as $img) {
                    $amy_gallery_img_id		= $img['url'];
                    $amy_gallery_img_url	= $img['urlImage'];
                    $amy_gallery_img_url	= substr($amy_gallery_img_url, 0, strpos($amy_gallery_img_url, '._')) . '.jpg';

                    Amy_Demo_Media::add_image_to_media_gallery($amy_gallery_img_id, $amy_gallery_img_url);

                    $gallery[] = Amy_Demo_Media::get_by_amy_id($amy_gallery_img_id);
                }

                $movie_detail['movie_gallery']	= implode(',', $gallery);
            }

            $tralier						= array();

            if (!empty($movie['simpleVideos'])) {
                foreach ($movie['simpleVideos'] as $v) {
                    $imdb_embed_before	= 'http://www.imdb.com/video/imdb/';
                    $imdb_embed_after	= '/imdb/embed?autoplay=false';
                    $tralier[]['movie_tralier_link'] = $imdb_embed_before . $v['idVideo'] . $imdb_embed_after;
                }

                $movie_detail['movie_tralier']	= $tralier;
            }
            */

            /*
             * add genre
             */
            if (! empty($movie['genres'])) {
                $genre_ids = array();

                foreach ($movie['genres'] as $genre) {
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

            /*
             * add director
             */
            if (! empty($movie['directors'])) {
                $director_ids = array();

                foreach ($movie['directors'] as $director) {
                    if (! term_exists($director['name'], 'amy_director')) {
                        $director_term 	= wp_insert_term($director['name'], 'amy_director');
                        $director_ids[]	= $director_term['term_id'];
                    } else {
                        $term 			= get_term_by('name', $director['name'], 'amy_director');
                        $director_ids[]	= $term->term_id;

                    }
                }

                wp_set_post_terms($movie_id, $director_ids, 'amy_director');
            }

            /*
             * add actor
             */
            if (! empty($movie['actors'])) {
                $actor_ids = array();

                foreach ($movie['actors'] as $actor) {
                    if (! term_exists($actor['actorName'], 'amy_actor')) {
                        $amy_media_actor = str_replace(' ', '-', $actor['actorName']);
                        Amy_Demo_Media::add_image_to_media_gallery($amy_media_actor, $movie['urlPhoto']);

                        $term = wp_insert_term($actor['actorName'], 'amy_actor');

                        //wp_set_post_terms($movie_id, $term['term_id'], 'amy_actor');
                        $actor_ids[] = $term['term_id'];

                        if (is_wp_error($term['term_id'])) {
                            return -998;
                        }

                        wp_update_term(
                            $term['term_id'],
                            'amy_actor',
                            array('description' => $actor['biography']['bio'])
                        );

                        $actor_detail = array();

                        $actor_detail['avatar']			= Amy_Demo_Media::get_by_amy_id($amy_media_actor);
                        $actor_detail['birth_date']		= $actor['biography']['dateOfBirth'];
                        $actor_detail['birth_place']	= $actor['biography']['placeOfBirth'];

                        add_term_meta($term['term_id'], '_custom_amy_actor', $actor_detail);
                    } else {
                        $term 			= get_term_by('name', $actor['actorName'], 'amy_actor');
                        $actor_ids[]	= $term->term_id;
                    }
                }

                wp_set_post_terms($movie_id, $actor_ids, 'amy_actor');
            }
            return esc_html__('Added Movie!', 'amy-movie-extend');
        } else {
            return esc_html__('Have error in process import movie!', 'amy-movie-extend');
        }
    }
}