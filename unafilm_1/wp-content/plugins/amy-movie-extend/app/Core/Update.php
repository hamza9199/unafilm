<?php
namespace AmyMovie\Core;

Class Update {
    public function __construct() {
        require_once AMY_MOVIE_PLUGIN_PATH . '/libs/plugin-update-checker-master/plugin-update-checker.php';

        $theme      = wp_get_theme();
        $version    = $theme->get('Version');

        if ($version >= '4.0.0') {
            $path = 'http://plugins.amytheme.com/update-notice/amy-movie-extend-v4.json';
        } else {
            $path = 'http://plugins.amytheme.com/update-notice/amy-movie-extend.json';
        }

        \Puc_v4_Factory::buildUpdateChecker(
            $path,
            __FILE__,
            'amy-movie-extend'
        );
    }
}