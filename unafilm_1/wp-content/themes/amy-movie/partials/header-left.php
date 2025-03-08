<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;
?>

<div id="amy-header-logo">
	<div class="container">
		<div id="amy-header-logo-wraper">
			<div class="pull-left">
				<?php echo amy_movie_logo(); ?>
			</div>
			<div class="pull-right">
				<?php if (is_active_sidebar('amy-logo-right')) : ?>
					<div id="amy-logo-right">
						<div id="amy-logo-right-content">
							<?php dynamic_sidebar('amy-logo-right'); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<header id="amy-masthead" class="header-left">
	<div class="container">
		<div class="amy-inner">
			<?php echo amy_movie_menu(); ?>
			<?php echo amy_movie_mobile_icon(); ?>
		</div>
	</div>
	<div id="amy-site-header-shadow"></div>
</header>
