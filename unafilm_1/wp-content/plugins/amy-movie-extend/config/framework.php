<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

$theme	= wp_get_theme();

CSF::createOptions(AMY_MOVIE_OPTION, [
    'menu_title'        => esc_html__('Amy Movie', 'amy-movie-extend'),
    'framework_title'   => sprintf(esc_html__('Amy Movie Theme v%1$s Configuration', 'amy-movie-extend'), $theme->get('Version')),
    'menu_slug'         => 'amy-movie-options',
    'menu_icon'			=>  AMY_MOVIE_PLUGIN_URL . 'assets/image/config/icon_setting.png',
    'menu_type'         => 'menu',
    'show_form_warning' => false,
]);

/**
 * General
 */
CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('General', 'amy-movie-extend'),
    'icon'      => 'fa fa-list-alt',
    'id'        => 'general'
]);

require_once 'framework/general/media.php';
require_once 'framework/general/social.php';
require_once 'framework/general/typography.php';
require_once 'framework/general/skin.php';
require_once 'framework/general/loading.php';

/**
 * Header
 */
CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Header', 'amy-movie-extend'),
    'icon'      => 'fa fa-header',
    'id'        => 'header'
]);

require_once 'framework/header/topbar.php';
require_once 'framework/header/logo.php';
require_once 'framework/header/layout.php';

/**
 * Footer
 */
require_once 'framework/footer.php';

/**
 * Page Header
 */
require_once 'framework/page-header.php';

/**
 * Movie
 */
CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Movie', 'amy-movie-extend'),
    'icon'      => 'fas fa-film',
    'id'        => 'movie'
]);

require_once 'framework/movie/general.php';
require_once 'framework/movie/single.php';
require_once 'framework/movie/category.php';
require_once 'framework/movie/person.php';
require_once 'framework/movie/search.php';

/**
 * IMDB
 */
CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Imdb Import', 'amy-movie-extend'),
    'icon'      => 'fab fa-imdb',
    'id'        => 'imdb_import'
]);

require_once 'framework/imdb/api.php';
require_once 'framework/imdb/import.php';

/**
 * Blog
 */
require_once 'framework/blog.php';

/**
 * WooCommerce
 */
require_once 'framework/woocommerce.php';

/**
 * IMDB
 */
require_once 'framework/transition.php';

/**
 * Custom
 */
require_once 'framework/custom.php';

