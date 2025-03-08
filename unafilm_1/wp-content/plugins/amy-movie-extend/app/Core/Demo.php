<?php
namespace AmyMovie\Core;

use OCDI\Downloader;
use OCDI\Helpers;

class Demo {
    private $url;
    private $demo_url   = 'http://demo.amytheme.com/movie/demo/';
    private $plugin_url = 'http://plugins.amytheme.com/';
    private $demos;

    public function __construct() {
        $this->url = AMY_MOVIE_PLUGIN_URL . '/assets/demo';

        $this->demos = [
            'single-cinema' => esc_html__('Single Cinema', 'amy-movie-extend'),
            'multi-cinema'  => esc_html__('Multi Cinema', 'amy-movie-extend'),
            'movie-news'    => esc_html__('Movie News', 'amy-movie-extend'),
            'watch-online'  => esc_html__('Watch Online', 'amy-movie-extend'),
            'book-tickets'   => esc_html__('Book Ticket', 'amy-movie-extend')
        ];

        add_filter('ocdi/register_plugins', [$this, 'register_plugins']);
        add_filter('ocdi/import_files', [$this, 'import_files']);
        add_action('ocdi/before_content_import_execution', [$this, 'prefix_before_content_import_execution'], 3, 99);
        add_action('ocdi/after_import', [$this, 'after_import_setup']);
    }

    public function register_plugins($plugins) {
        $theme_plugins = [
            [
                'name'		=> 'Breadcrumb NavXT',
                'slug'		=> 'breadcrumb-navxt',
                'required'	=> false,
            ],
        ];

        if (isset($_GET['step']) && $_GET['step'] === 'import' && isset($_GET['import'])) {
            // Elementor Demo
            if (in_array($_GET['import'], ['0', '2', '4', '6', '8'])) {
                $theme_plugins[] = [
                    'name'		=> 'Elementor',
                    'slug'		=> 'elementor',
                    'required'	=> true
                ];
            }

            // Visual Composer Demo
            if (in_array($_GET['import'], ['1', '3', '5', '7', '9'])) {
                $theme_plugins[] = [
                    'name'		=> 'WPBakery',
                    'slug'		=> 'js_composer',
                    'required'	=> true,
                    'source'	=> 'http://plugins.amytheme.com/js_composer.zip'
                ];
            }
        }

        return array_merge($plugins, $theme_plugins);
    }

    public function import_files() {
        $import = [];

        foreach ($this->demos as $demo => $name) {
            $import[] = [
                'import_file_name'           => $name . ' Elementor',
                'categories'                 => ['Elementor'],
                'import_file_url'            => $this->url . '/' . $demo . '/elementor.xml',
                'import_widget_file_url'     => $this->url . '/' . $demo . '/widget.json',
                'import_preview_image_url'   => $this->url . '/' . $demo . '/screenshot.png',
                'preview_url'                => $this->demo_url . 'elementor-' . $demo,
                'import_json'                => [
                    [
                        'file_url'      => $this->url . '/' . $demo . '/cs.json',
                        'option_name'   => '_amy_options'
                    ]
                ]
            ];

            $import[] = [
                'import_file_name'           => $name . ' Visual Composer',
                'categories'                 => ['Visual Composer'],
                'import_file_url'            => $this->url . '/' . $demo . '/vc.xml',
                'import_widget_file_url'     => $this->url . '/' . $demo . '/widget.json',
                'import_preview_image_url'   => $this->url . '/' . $demo . '/screenshot.png',
                'preview_url'                => $this->demo_url . 'wp-bakery-' . $demo,
                'import_json'                => [
                    [
                        'file_url'      => $this->url . '/' . $demo . '/cs.json',
                        'option_name'   => '_amy_options'
                    ]
                ]
            ];
        }

        return $import;
    }

    public function prefix_before_content_import_execution($selected_import_files, $import_files, $selected_index) {
        $downloader = new Downloader();

        if(! empty($import_files[$selected_index]['import_json'])) {

            foreach($import_files[$selected_index]['import_json'] as $index => $import) {
                $file_path = $downloader->download_file($import['file_url'], 'demo-import-file-'. $index .'-'. date('Y-m-d__H-i-s') .'.json');
                $file_raw  = Helpers::data_from_file($file_path);
                update_option($import['option_name'], json_decode($file_raw, true));
            }

        } else if(! empty($import_files[$selected_index]['local_import_json'])) {
            foreach($import_files[$selected_index]['local_import_json'] as $index => $import) {
                $file_path = $import['file_path'];
                $file_raw  = Helpers::data_from_file($file_path);
                update_option($import['option_name'], json_decode($file_raw, true));
            }

        }
    }

    public function after_import_setup() {
        $main_menu = get_term_by('name', 'mainnav', 'nav_menu');

        set_theme_mod('nav_menu_locations', array(
                'primary' => $main_menu->term_id,
            )
        );

        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title('Home');

        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id->ID);
    }
}

