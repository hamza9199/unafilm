<?php
/**
 * Movie
 */
CSF::createMetabox(AMY_MOVIE_SINGE_BLOCK_DETAILS, [
    'title' => esc_html__('Details', 'amy-movie-extend'),
    'post_type' => ['amy_movie', 'amy_tvshow', 'amy_season'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

require_once 'metabox/details.php';
require_once 'metabox/poster.php';
require_once 'metabox/media.php';
require_once 'metabox/time.php';
require_once 'metabox/layout.php';
require_once 'metabox/rating.php';


CSF::createMetabox(AMY_MOVIE_SINGE_BLOCK_SHOWTIME, [
    'title' => esc_html__('Showtime Events', 'amy-movie-extend'),
    'post_type' => ['amy_movie'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

require_once 'metabox/cinema.php';

CSF::createMetabox(AMY_MOVIE_SINGE_BLOCK_STREAM, [
    'title' => esc_html__('Streaming', 'amy-movie-extend'),
    'post_type' => ['amy_movie'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

require_once 'metabox/streaming.php';

/**
 * Cinema
 */
CSF::createMetabox(AMY_MOVIE_SINGE_CINEMA, [
    'title' => esc_html__('Details', 'amy-movie-extend'),
    'post_type' => ['amy_cinema'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

require_once 'metabox/single-cinema.php';

/**
 * Only Tv show
 */
CSF::createMetabox(AMY_MOVIE_SINGE_TV_SHOW, [
    'title' => esc_html__('Season Details', 'amy-movie-extend'),
    'post_type' => ['amy_tvshow'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

require_once 'metabox/tv-show.php';

/**
 * Only Season
 */
CSF::createMetabox(AMY_MOVIE_SINGE_SEASON, [
    'title' => esc_html__('Season Details', 'amy-movie-extend'),
    'post_type' => ['amy_season'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'normal',
]);

require_once 'metabox/season.php';

/**
 * Only Page
 */
CSF::createMetabox(AMY_MOVIE_PAGE_OPTIONS, [
    'title' => esc_html__('Page Details', 'amy-movie-extend'),
    'post_type' => ['page'],
    'data_type' => 'unserialize',
    'priority' => 'low',
    'context' => 'side',
]);

require_once 'metabox/page.php';