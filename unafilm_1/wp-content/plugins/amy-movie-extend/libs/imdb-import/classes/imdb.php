<?php
use AmyMovie\Core\Base;

class AmyImdb {
    public function __construct() {

    }

    public function add_movie($keywords, $index) {
        $imdb_id = amy_movie_get_value_in_array($keywords, $index);

        if (strpos($imdb_id, 'www.imdb.com') == true) {
            return [
                'status'    => false,
                'msg'       => esc_html__('Imdb Url unSupport', 'amy-movie-extend')
            ];
        }

        $result = $this->send_id_to_api($imdb_id);

        if ($index == count($keywords) - 1) {
            $result['index'] = false;
        } else {
            $result['index'] = $index + 1;
        }

        return $result;
    }

    private function send_id_to_api($imdb_id) {
        $base = new Base();

        $api_type = $base->get_option('api_type', 'omdb');

        if ($api_type == 'omdb') {
            $omdb       = new OmdbApi();
            $response   = $omdb->connect($imdb_id);
        } else if ($api_type == 'myapi') {
            $myapifilm  = new Myapifilms();
            $response   = $myapifilm->connect($imdb_id);
        } else {
            $response = [
                'status'    => false,
                'msg'       => esc_html__('Please select api', 'amy-movie-extend')
            ];
        }

        return $response;
    }


}