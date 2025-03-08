<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('ABSPATH') or die;
?>

<!DOCTYPE html>
<html <?php language_attributes();
; ?>>
<!--[if IE]><![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php echo amy_movie_page_loading(); ?>
	<div id="page" class="hfeed site">
		<?php amy_movie_top_bar(); ?>
		<?php get_template_part('partials/header', amy_get_option('header_style', 'default')); ?>
	
		<?php echo amy_movie_mobile_menu(); ?>

		<div id="main">
			<div id="content" class="site-content">

