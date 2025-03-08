<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

$show_search = amy_get_option('show_search');

$class = ($show_search == true) ? 'has-search' : '';
?>

<header id="masthead" class="site-header header-default <?php echo esc_attr($class); ?> <?php echo esc_attr(amy_get_option('header_skin')); ?>">
	<div class="container">
		<div class="amy-inner">
			<div class="amy-left">
				<?php echo amy_movie_logo(); ?>
				<?php if ($show_search) : ?>
					<?php echo do_shortcode('[moviesearch]'); ?>
				<?php endif; ?>
			</div>
			<div class="amy-right">
				<?php echo amy_movie_menu(); ?>
				<?php echo amy_movie_mobile_icon(); ?>
				<?php if (amy_get_option('header_skin') == 'dark' && amy_get_option('dark_module_login') == true) : ?>
				<?php echo amy_movie_user(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div id="amy-site-header-shadow"></div>
</header>
