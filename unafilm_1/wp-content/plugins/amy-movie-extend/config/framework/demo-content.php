<?php
/**
 * @copyright Copyright (c) 2021 WolfCoding (https://wolfcoding.com). All rights reserved.
 */

$condition 	= class_exists('Amy_Movie_Helper');
$message	= esc_html__('You need to activate plugins Visual Composer, Amy Movie Extends, Slider Revolution before importing content demo', 'amy-movie-extend');

CSF::createSection(AMY_MOVIE_OPTION, [
	'title'		=> esc_html__('Demo Content', 'amy-movie-extend'),
	'icon'		=> 'fa fa-diamond',
	// 'fields'	=> [
	// 	array(
	// 		'id'  => 'demo_import',
	// 		'type'  => 'demo_importer',
	// 		'condition' => $condition,
	// 		'message' => $message,
	// 		'demos'  => array(
	// 			array(
	// 				'id'  => 'single-cinema',
	// 				'title'  => esc_html__('Single Cinema', 'amy-movie-extend'),
	// 				'thumbnail' => AMY_MOVIE_PLUGIN_URL . 'assets/image/config/demo/single-cinema.jpg'
	// 			),

	// 			array(
	// 				'id'  => 'multi-cinema',
	// 				'title'  => esc_html__('Multi Cinema', 'amy-movie-extend'),
	// 				'thumbnail' => AMY_MOVIE_PLUGIN_URL . 'assets/image/config/demo/multi-cinema.jpg'
	// 			),

	// 			array(
	// 				'id'  => 'movie-news',
	// 				'title'  => esc_html__('Movie News', 'amy-movie-extend'),
	// 				'thumbnail' => AMY_MOVIE_PLUGIN_URL . 'assets/image/config/demo/movie-news.jpg'
	// 			),

	// 			array(
	// 				'id'  => 'watch-online',
	// 				'title'  => esc_html__('Watch Online', 'amy-movie-extend'),
	// 				'thumbnail' => AMY_MOVIE_PLUGIN_URL . 'assets/image/config/demo/watch-online.jpg'
	// 			),

	// 			array(
	// 				'id'  => 'book-ticket',
	// 				'title'  => esc_html__('Book Ticket', 'amy-movie-extend'),
	// 				'thumbnail' => AMY_MOVIE_PLUGIN_URL . 'assets/image/config/demo/book-ticket.jpg'
	// 			),
	// 		)
	// 	)
	// ]
 ]);