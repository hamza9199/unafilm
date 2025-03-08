<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 2/13/2020
 * Time: 3:35 PM
 */

define('AMY_MOVIE_IMDB_IMPORT_PART', plugin_dir_path(__FILE__));
define('AMY_MOVIE_IMDB_IMPORT_URL', plugin_dir_url(__FILE__));

require_once AMY_MOVIE_IMDB_IMPORT_PART . '/fields/importer.php';

if(!function_exists('amy_imdb_importer_enqueue_static')) {
    function amy_imdb_importer_enqueue_static() {
        // Style
        wp_enqueue_style('amy-product-import', AMY_MOVIE_IMDB_IMPORT_URL . '/assets/css/style.css', array());

        // Script
        wp_enqueue_script('amy-product-import', AMY_MOVIE_IMDB_IMPORT_URL . '/assets/js/script.js', array('jquery'), false, true);
    }

    add_action('admin_enqueue_scripts', 'amy_imdb_importer_enqueue_static');
}

if (!function_exists('amy_imdb_importer_localize_script')) {
    function amy_imdb_importer_localize_script() {
        wp_localize_script('amy-imdb-import', 'adiL10n', array(
            'install_product_confirm'		=> __(
                "Install product content:\n"
                . "-----------------------------------------\n"
                . "Are you sure? This will install product content\n\n"
                . "Please backup your settings to be sure that you don't lose them by accident.\n\n\n"
           ),
            'install_product_error'		=> __('Error installing product content!'),
       ));
    }

    add_action('admin_enqueue_scripts', 'amy_imdb_importer_localize_script', 99);
}

/**
 * Handle ajax product importer.
 */
if (!function_exists('amy_imdb_importer_action')) {
    function amy_imdb_importer_action() {
        if (!isset($_POST['keyword']) || !isset($_POST['amy_imdb_importer_action'])) {
            die;
        }

        require_once AMY_MOVIE_IMDB_IMPORT_PART . '/classes/imdb.php';
        require_once AMY_MOVIE_IMDB_IMPORT_PART . '/classes/omdb.php';
        require_once AMY_MOVIE_IMDB_IMPORT_PART . '/classes/myapifilms.php';

        set_time_limit(0);

        $action     = $_POST['amy_imdb_importer_action'];
        $keywords   = $_POST['keyword'];
        $pni        = isset($_POST['pni']) ? $_POST['pni'] : 0;


        switch ($action) {
            case 'install':
                update_option('amy_import_imdb', '1');
                $index      = $pni;

                $imdb               = new AmyImdb();
                $add_movie_response = $imdb->add_movie($keywords, $index);
                $index              = $add_movie_response['index'];
                $message            = $add_movie_response['msg'];
                $task_content       = [];

                if ($index) {
                    $task_content[] = '<div class="item-task">';
                    $task_content[] = '<p>' . $message . '</p>';
                    $task_content[] = '</div>';

                    $response   = array(
                        'next_action'   => 'install',
                        'pni'           => $index,
                        'task_content'  => implode('', $task_content),
                        'progress'      => 25 + intval(40 * $index / count($keywords)),
                   );
                } else {
                    $task_content[] = '<div class="item-task">';
                    $task_content[] = '<p>' . $message . '</p>';
                    $task_content[] = '</div>';

                    $response   = array(
                        'next_action'   => 'finish',
                        'task_content'  => implode('', $task_content),
                        'progress'      => 85,
                   );
                }

                break;
            case 'finish':
                update_option('amy_import_imdb', '2');

                echo 1;
                die;
        }

        if (isset($response)) {
            echo json_encode($response);
            die;
        } else {
            echo 0;
            die;
        }
    }

    add_action('wp_ajax_amy_imdb_importer_action', 'amy_imdb_importer_action');
    add_action('wp_ajax_nopriv_amy_imdb_importer_action', 'amy_imdb_importer_action');
}