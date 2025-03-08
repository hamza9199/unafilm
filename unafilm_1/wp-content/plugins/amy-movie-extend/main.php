<?php
/*
Plugin Name: 		Amy Movie Extends
Plugin URI: 		http://www.amytheme.com
Description: 		Display movie,post with many layout, style, effect.
Version: 			4.3.1
Author: 			Amytheme
Author URI: 		http://www.amytheme.com
*/
defined('ABSPATH') or die;

require_once 'vendor/autoload.php';

use AmyMovie\Core\PostType;
use AmyMovie\Shortcode\VisualComposer;
use AmyMovie\Core\Template;
use AmyMovie\Core\Setup;
use AmyMovie\Core\Admin;
use AmyMovie\Core\Permalink;
use AmyMovie\Core\Update;
use AmyMovie\Movie\MovieHooks;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Demo;

if (!class_exists('Amy_Movie_Helper')) {
	class Amy_Movie_Helper {
		public function __construct() {
            require_once 'define.php';

			$this->load_library();

			new PostType();
			new Template();
			new Update();
            new Setup();
            new Demo();
            new MovieHooks();

            add_action('init', array(__CLASS__, 'load_config'), 2);
			add_action('wp_loaded', array(__CLASS__, 'shortcodes'));

            if (is_admin()) {
                new Admin();
                new Permalink();
            }

            if (!is_admin()) {
                add_action('wp_enqueue_scripts', array($this, 'action_enqueue_scripts'), 20);
            }

            $this->load_widgets();
		}

		public function load_library() {
            if (!class_exists('CSF')) {
                require_once AMY_MOVIE_PLUGIN_PATH . '/libs/codestar-framework/codestar-framework.php';
            }

            require_once AMY_MOVIE_PLUGIN_PATH . '/libs/imdb-import/import.php';
		}

        public static function load_config() {
            require_once AMY_MOVIE_PLUGIN_PATH . '/config/framework.php';
            require_once AMY_MOVIE_PLUGIN_PATH . '/config/metabox.php';
            require_once AMY_MOVIE_PLUGIN_PATH . '/config/taxonomy.php';
        }

		public static function shortcodes() {
            new VisualComposer();
            new Elementor();
		}

        public function load_widgets() {
            require_once AMY_MOVIE_PLUGIN_PATH . '/widgets/list.php';
            require_once AMY_MOVIE_PLUGIN_PATH . '/widgets/module.php';
            require_once AMY_MOVIE_PLUGIN_PATH . '/widgets/comingsoon.php';
            require_once AMY_MOVIE_PLUGIN_PATH . '/widgets/comments.php';
        }

        public function action_enqueue_scripts() {
            wp_enqueue_style('amy-movie-helper-style', AMY_MOVIE_PLUGIN_URL . 'assets/css/style.css', array(), false);
        }
	}

	new Amy_Movie_Helper();
}

