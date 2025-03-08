<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

if (! class_exists('Amy_Style_Builder')) {
	return;
}

$style_builder	= Amy_Style_Builder::getInstance();

/**
 * Skin
 */
$disable_skin	= amy_get_option('disable_skin');
$skin_color		= amy_get_option('skin_color');
$skin_custom	= amy_get_option('skin_custom');

if ($skin_color == 'red') {
	$site_color	= '#ec6060';
} else if ($skin_color == 'pink') {
	$site_color = '#e3187c';
} else if ($skin_color == 'blue') {
	$site_color = '#3aa2d7';
} else if ($skin_color == 'custom') {
	$site_color = $skin_custom;
} else {
	$site_color = '';
}

if (! $disable_skin) {
	$c1 = '
		a:hover, a:focus,
		.amy-primary-navigation ul.nav-menu li ul li > a:hover, 
		.amy-primary-navigation ul.nav-menu li ul li:hover > a, 
		.amy-primary-navigation ul.nav-menu li ul li.active > a,
		.amy-pagination a,
		.amy-widget-list.list-movie .entry-content .duration,
		.amy-title,
		.amy-mv-showtime h3,
		.amy-tab-nav ul li.active a,
		.slide-content h2 a .last_word,
		.amy-arrow:hover,
		.amy-mv-grid.layout4 .back .entry-title a,
		.amy-mv-search ul.filter-action li:hover, .amy-mv-search ul.filter-action li.active,
		.amy-mv-grid.layout2 .entry-date,
		.amy-mv-grid.layout3 .back .entry-time,
		.amy-mv-blog.layout2 .entry-item .entry-title a:hover,
		.amy-mv-list .entry-item .entry-content .duration,
		.amy-mv-list .entry-item .entry-content h2 a:hover,
		.amy-widget-comingsoon ul li a:hover,
		.single-movie .entry-info .duration,
		.single-movie .entry-action .entry-share ul li a:hover,
		.amy-list-comments h3,
		.amy-list-comments .comment-body footer i,
		.amy-list-comments .comment-reply-link,
		.entry-related > h3,
		.amy-main-content.single-post .comment-reply-title,
		.widget_tag_cloud .amy-widget-title h4, 
		.widget_archive .amy-widget-title h4, 
		.widget_calendar .amy-widget-title h4, 
		.widget_categories .amy-widget-title h4, 
		.widget_pages .amy-widget-title h4, 
		.widget_meta .amy-widget-title h4, 
		.widget_recent_comments .amy-widget-title h4, 
		.widget_recent_entries .amy-widget-title h4, 
		.widget_rss .amy-widget-title h4, 
		.widget_search .amy-widget-title h4, 
		.widget_text .amy-widget-title h4, 
		.widget_nav_menu .amy-widget-title h4,
		.amy-widget-module.contact .phone,
		article.post .entry-info .entry-share ul li a:hover,
		#amy-page-header .amy-breadcrumb a:hover,
		.amy-footer-widgets .widget_tag_cloud ul li a:hover, 
		.amy-footer-widgets .widget_archive ul li a:hover, 
		.amy-footer-widgets .widget_calendar ul li a:hover, 
		.amy-footer-widgets .widget_categories ul li a:hover, 
		.amy-footer-widgets .widget_pages ul li a:hover, 
		.amy-footer-widgets .widget_meta ul li a:hover, 
		.amy-footer-widgets .widget_recent_comments ul li a:hover, 
		.amy-footer-widgets .widget_recent_entries ul li a:hover, 
		.amy-footer-widgets .widget_rss ul li a:hover, 
		.amy-footer-widgets .widget_search ul li a:hover, 
		.amy-footer-widgets .widget_text ul li a:hover, 
		.amy-footer-widgets .widget_nav_menu ul li a:hover,
		.amy-site-footer a:hover,
		.amy-mv-grid.layout1 .pic-caption .desc-mv a:hover,
		.amy-mv-grid.layout1 .entry-title a:hover,
		.amy-mv-grid.layout2 .entry-title a:hover,
		.amy-mv-grid.layout3 .back .entry-title a:hover,
		.amy-mv-grid.layout3 .back .movie-char-info a:hover,
		.amy-mv-grid.layout4 .back .desc-mv a:hover,
		.amy-mv-grid.layout4 .back .entry-button a:hover,
		.amy-movie-item-meta .amy-movie-field-duration,
		.amy-movie-showtimews-daily-1 .amy-showtimes-header .amy-showtimes-header-inner ul li.active a span,
		.amy-movie-actor-grid .amy-movie-actor-grid-wrapper .actor-item .actor-name a:hover, .amy-movie-actor-grid .amy-movie-actor-grid-wrapper .actor-item .actor-name a:active, .amy-movie-actor-grid .amy-movie-actor-grid-wrapper .actor-item .actor-name a:focus
	';

	$style_builder->addStyle($c1, 'color: ' . $site_color . '');


	$c2 = '
		.amy-mv-search input[type="submit"],
		.amy-pagination span.current,
		.amy-pagination a:hover,
		.amy-widget-module.social ul li a:hover,
		.amy-mv-ratelist table td.point,
		.amy-widget-list.list-movie .entry-content .mrate .rate,
		.amy-mv-showtime h3 span,
		.amy-tab-nav ul li.active a::after,
		.slide-content .slide-button i,
		.amy-mv-slide ul.slick-dots li.slick-active button,
		.amy-mv-grid.layout1 .pic-caption .pg,
		.amy-mv-grid.layout1 .right-info .pg,
		.amy-mv-grid.layout1 .pic-caption .rate,
		.amy-mv-grid.layout1 .pic-caption .entry-button .fa,
		.amy-mv-blog.layout1 .entry-btn,
		.amy-primary-navigation ul.nav-menu > li > a::after,
		.amy-mv-grid.layout4 .grid-item:hover .front .rate,
		.amy-mv-grid.layout4 .back .pg,
		.amy-mv-grid.layout4 .back .entry-button .fa,
		.amy-mv-grid.layout2 .rate,
		.amy-mv-grid.layout3 .back .pg,
		.amy-mv-grid.layout3 .back .entry-button .fa,
		.amy-mv-grid.layout3 .back .rate,
		.home2-section4 .amy-title::after, 
		.home2-section5 .amy-title::after,
		.amy-mv-blog.layout2 .entry-item .entry-cat,
		.amy-mv-list .entry-item .entry-content .pg,
		.amy-mv-list .entry-item .entry-content .mrate .rate,
		.amy-mv-grid.layout2 .amy-date-filter li:hover,
		.single-movie .entry-info .pg,
		.single-movie .entry-action .rate,
		input[type="reset"], 
		input[type="submit"],
		.single-cinema .cinema-details .bg-dl,
		article.post .entry-meta .entry-date,
		.amy-404 .amy-404-btn a.btn-home,
		.amy-mv-grid.layout2 .pg,
		.amy-movie-field-mpaa,
		.amy-movie-field-imdb,
		.amy-btn-icon-text .fa,
		.amy-movie-carousel-3d .amy-movie-items .amy-movie-item .amy-movie-item-button a,
		.as.entry-showtime .showtime-item .st-item ul li,
		.amy-buy-ticket,
		.amy-movie-showtimews-1 .amy-movie-item-showtimes .showtimes-cinema-group .amy-movie-times .amy-cell.current-date .amy-cell-inner .amy-head,
		.amy-movie-showtimews-1 .amy-movie-item-showtimes .showtimes-cinema-group .amy-movie-times .amy-cell.current-date .amy-cell-inner .amy-intro-times div,
		.amy-movie-showtimews-1 .amy-movie-item-showtimes .showtimes-cinema-group .amy-movie-times .amy-cell .amy-cell-inner .button,
		.amy-movie-showtimews-1 .amy-movie-item-showtimes .showtimes-cinema-group .amy-movie-times .amy-cell .amy-cell-inner .amy-intro-times div:hover, .amy-movie-showtimews-1 .amy-movie-item-showtimes .showtimes-cinema-group .amy-movie-times .amy-cell .amy-cell-inner .amy-intro-times div:active, .amy-movie-showtimews-1 .amy-movie-item-showtimes .showtimes-cinema-group .amy-movie-times .amy-cell .amy-cell-inner .amy-intro-times div:focus,
		.amy-movie-showtimews-2 .amy-movie-showtimews-wrapper .amy-movie-showtimews-row .amy-movie-showtimews-cell .button,
		.amy-movie-showtimews-2 .amy-movie-showtimews-wrapper .amy-movie-showtimews-row .amy-movie-showtimews-cell .amy-movie-intro-times span:hover, .amy-movie-showtimews-2 .amy-movie-showtimews-wrapper .amy-movie-showtimews-row .amy-movie-showtimews-cell .amy-movie-intro-times span:active, .amy-movie-showtimews-2 .amy-movie-showtimews-wrapper .amy-movie-showtimews-row .amy-movie-showtimews-cell .amy-movie-intro-times span:focus,
		.amy-movie-showtimews-daily-1 .amy-movie-item-showtimes .amy-movie-intro-times span:hover, .amy-movie-showtimews-daily-1 .amy-movie-item-showtimes .amy-movie-intro-times span:active, .amy-movie-showtimews-daily-1 .amy-movie-item-showtimes .amy-movie-intro-times span:focus,
		.amy-movie-showtimews-daily-1 .amy-movie-item-showtimes .amy-movie-intro-times .button,
		.amy-movie-showtimews-daily-2 .amy-movie-item-time-list a.button,
		.playlist-trailer .list-item .item-score,
		.video-holder-wrapper .play-button:hover, .video-holder-wrapper .play-button:active, .video-holder-wrapper .play-button:focus
	';

	$style_builder->addStyle($c2, 'background-color: ' . $site_color . '');


	$c3 = '
		.amy-primary-navigation ul.nav-menu li > ul,
		.amy-primary-navigation ul.nav-menu > li > a:hover::after, 
		.amy-primary-navigation ul.nav-menu > li:hover > a::after, 
		.amy-primary-navigation ul.nav-menu > li.current-menu-item > a::after,
		.amy-pagination span.current,
		.amy-pagination a:hover,
		.amy-title,
		select:focus, 
		textarea:focus, 
		input[type="text"]:focus, 
		input[type="password"]:focus, 
		input[type="datetime"]:focus, 
		input[type="datetime-local"]:focus, 
		input[type="date"]:focus, 
		input[type="month"]:focus, 
		input[type="time"]:focus, 
		input[type="week"]:focus, 
		input[type="number"]:focus, 
		input[type="email"]:focus, 
		input[type="url"]:focus, 
		input[type="search"]:focus, 
		input[type="tel"]:focus, 
		input[type="color"]:focus
	';

	$style_builder->addStyle($c3, 'border-color: ' . $site_color . '');


	$c4 = '
		.amy-tab-nav ul li.active a,
		.amy-mv-grid.layout1 .entry-thumb,
		.amy-mv-grid.layout4 .grid-item .entry-item,
		.amy-list-comments h3,
		.entry-related > h3,
		.amy-main-content.single-post .comment-reply-title,
		.widget_tag_cloud .amy-widget-title h4, 
		.widget_archive .amy-widget-title h4, 
		.widget_calendar .amy-widget-title h4, 
		.widget_categories .amy-widget-title h4, 
		.widget_pages .amy-widget-title h4, 
		.widget_meta .amy-widget-title h4, 
		.widget_recent_comments .amy-widget-title h4, 
		.widget_recent_entries .amy-widget-title h4, 
		.widget_rss .amy-widget-title h4, 
		.widget_search .amy-widget-title h4, 
		.widget_text .amy-widget-title h4, 
		.widget_nav_menu .amy-widget-title h4,
		.amy-mv-carousel .carousel-item .carousel-thumb
	';

	$style_builder->addStyle($c4, 'border-bottom-color: ' . $site_color . '');
}

/**
 * Menu
 */

//submenu background
$submenu_background_color = amy_get_option('submenu_background_color');

if ($submenu_background_color) {
	$style_builder->addStyle('#masthead.dark .amy-primary-navigation ul.nav-menu > li ul, .amy-primary-navigation ul.nav-menu > li ul', 'background-color:' . $submenu_background_color . '');
	$style_builder->addStyle('.amy-primary-navigation ul.nav-menu li > ul::before, .amy-primary-navigation ul.nav-menu li > ul::after', 'border-color: transparent transparent ' . $submenu_background_color . '');

}

$line_through_position = amy_get_option('line_through_position', 'bottom');

if (amy_get_option('header_skin') != 'dark' && $line_through_position) {
	if ($line_through_position == 'bottom') {
		$style_builder->addStyle('.amy-primary-navigation ul.nav-menu > li > a::after', 'top: 70%');
	} else if ($line_through_position == 'none') {
		$style_builder->addStyle('.amy-primary-navigation ul.nav-menu > li > a::after', 'width: 0!important');
	}
}