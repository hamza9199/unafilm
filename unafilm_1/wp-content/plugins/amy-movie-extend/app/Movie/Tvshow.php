<?php
namespace AmyMovie\Movie;

use AmyMovie\Core\Base;

class Tvshow {
    private $id;
    private $base;

    public function __construct($id) {
        $this->id = $id;
        $this->base     = new Base();
    }

    public function get_season() {
        return get_post_meta($this->id, 'season_list', true);
    }

    public function get_list_episodes() {
        return get_post_meta($this->id, 'list_episodes', true);
    }
}