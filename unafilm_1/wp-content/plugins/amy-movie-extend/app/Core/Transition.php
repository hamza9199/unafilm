<?php
namespace AmyMovie\Core;

use AmyMovie\Core\Base;

class Transition {
    private $prefix = 'transition';
    private $base;

    public function __construct() {
        $this->base = new Base();
    }

    public function render_options() {
        $data = $this->string_data();

        $fields = [];

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $fields[] = [
                    'id'		=> $this->prefix . sanitize_title($key),
                    'type'		=> 'text',
                    'title'		=> $value,
                    'default'	=> $value,
                ];
            }
        }

        return $fields;
    }

    public function get_string_translate($string) {
        return $this->base->get_option($this->prefix . sanitize_title($string), $this->get_translate_text_by_key($string));
    }

    private function get_translate_text_by_key($key) {
        return $this->string_data()[$key];
    }

    public function string_data() {
        return [
            'Movie'                 => esc_html__('Movie', 'amy-movie-extend'),
            'Cinema'                => esc_html__('Cinema', 'amy-movie-extend'),
            'Tv Show'               => esc_html__('Tv Show', 'amy-movie-extend'),
            'Season'                => esc_html__('Season', 'amy-movie-extend'),
            'Genre'                 => esc_html__('Genre', 'amy-movie-extend'),
            'Actor'                 => esc_html__('Actor', 'amy-movie-extend'),
            'Director'              => esc_html__('Director', 'amy-movie-extend'),
            'Buy Ticket'            => esc_html__('Buy Ticket', 'amy-movie-extend'),
            'hours'                 => esc_html__('hours', 'amy-movie-extend'),
            'minutes'               => esc_html__('minutes', 'amy-movie-extend'),
            'No Time'               => esc_html__('No Time', 'amy-movie-extend'),
            'No Movie'              => esc_html__('No Movie', 'amy-movie-extend'),
            'Order By'              => esc_html__('Order By', 'amy-movie-extend'),
            'Rate'                  => esc_html__('Rate', 'amy-movie-extend'),
            'Release Date'          => esc_html__('Release Date', 'amy-movie-extend'),
            'Title'                 => esc_html__('Title', 'amy-movie-extend'),
            'Release'               => esc_html__('Release', 'amy-movie-extend'),
            'Language'              => esc_html__('Language', 'amy-movie-extend'),
            'Votes'                 => esc_html__('Votes', 'amy-movie-extend'),
            'Trailer'               => esc_html__('Trailer', 'amy-movie-extend'),
            'Detail'                => esc_html__('Detail', 'amy-movie-extend'),
            'Duration'              => esc_html__('Duration', 'amy-movie-extend'),
            'MPAA'                  => esc_html__('MPAA', 'amy-movie-extend'),
            'votes'                 => esc_html__('votes', 'amy-movie-extend'),
            'Imdb'                  => esc_html__('Imdb', 'amy-movie-extend'),
            'Showtime'              => esc_html__('Showtime', 'amy-movie-extend'),
            'From'                  => esc_html__('From', 'amy-movie-extend'),
            'Select Showtimes'      => esc_html__('Select Showtimes', 'amy-movie-extend'),
            'Select'                => esc_html__('Select', 'amy-movie-extend'),
            'Movie search'          => esc_html__('Movie search...', 'amy-movie-extend'),
            'Go'                    => esc_html__('Go', 'amy-movie-extend'),
            'Read more'             => esc_html__('Read more', 'amy-movie-extend'),
            'Sort by'               => esc_html__('Sort by', 'amy-movie-extend'),
            'Post Views'            => esc_html__('Post Views', 'amy-movie-extend'),
            'See All TV Show'       => esc_html__('See All TV Show', 'amy-movie-extend'),
            'Share'                 => esc_html__('Share', 'amy-movie-extend'),
            'Weekly Showtimes'      => esc_html__('Weekly Showtimes', 'amy-movie-extend'),
            'Watch Online'          => esc_html__('Watch Online', 'amy-movie-extend'),
            'Select a cinema'       => esc_html__('Select a cinema', 'amy-movie-extend'),
            'Synopsis'              => esc_html__('Synopsis', 'amy-movie-extend'),
            'Episodes List'         => esc_html__('Episodes List', 'amy-movie-extend'),
            'IMDB Rating'           => esc_html__('IMDB Rating', 'amy-movie-extend'),
            'Video Photo'           => esc_html__('Video & Photo', 'amy-movie-extend'),
            'videos'                => esc_html__('videos', 'amy-movie-extend'),
            'photos'                => esc_html__('photos', 'amy-movie-extend'),
            'Random Movie'          => esc_html__('Random Movie', 'amy-movie-extend'),
            'Recent Movie'          => esc_html__('Recent Movie', 'amy-movie-extend'),
            'Season List'           => esc_html__('Season List', 'amy-movie-extend'),
            'Turn off the light'    => esc_html__('Turn off the light', 'amy-movie-extend'),
            'Turn on the light'     => esc_html__('Turn on the light', 'amy-movie-extend'),
            'Address'               => esc_html__('Address', 'amy-movie-extend'),
            'Phone'                 => esc_html__('Phone', 'amy-movie-extend'),
            'Email'                 => esc_html__('Email', 'amy-movie-extend'),
            'Website'               =>  esc_html__('Website', 'amy-movie-extend'),
            'Comments'              => esc_html__('Comments', 'amy-movie-extend'),
            'Map'                   => esc_html__('Map', 'amy-movie-extend'),
            'Birth Day'             => esc_html__('Birth Day', 'amy-movie-extend'),
            'Birth Place'           => esc_html__('Birth Place', 'amy-movie-extend'),
            'Gender'                => esc_html__('Gender', 'amy-movie-extend'),
            'Nationality'           => esc_html__('Nationality', 'amy-movie-extend'),
            'Biography'             => esc_html__('Biography', 'amy-movie-extend'),
            'Filmography'           => esc_html__('Filmography', 'amy-movie-extend'),
            'Movie Name'            => esc_html__('Movie Name', 'amy-movie-extend'),
            'Search'                => esc_html__('Search', 'amy-movie-extend'),
        ];
    }
}