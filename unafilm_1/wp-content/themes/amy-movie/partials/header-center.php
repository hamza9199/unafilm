<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

$logo_left	= is_active_sidebar('amy-logo-left');
$logo_right	= is_active_sidebar('amy-logo-right');
?>

<div id="amy-header-logo" class="header-center">
	<div class="container">
		<?php if ($logo_left || $logo_right) : ?>
			<div class="row">
				<div class="col-xs-4 amy-logo-left">
					<?php if ($logo_left) : ?>
						<?php dynamic_sidebar('amy-logo-left'); ?>
					<?php endif; ?>
				</div>

				<div class="col-xs-4 amy-logo-wrapper">
					<?php echo amy_movie_logo(); ?>
				</div>

				<div class="col-xs-4 amy-logo-right">
					<?php if ($logo_right) : ?>
						<?php dynamic_sidebar('amy-logo-right'); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php else : ?>
			<div class="amy-logo-wrapper">
				<?php echo amy_movie_logo(); ?>
			</div>
		<?php endif; ?>
	</div>

</div>

<header id="amy-masthead" class="header-center">
	<div class="container">
		<div class="amy-inner">
			<?php echo amy_movie_menu(); ?>
			<?php echo amy_movie_mobile_icon(); ?>
		</div>
	</div>
	<div id="amy-site-header-shadow"></div>
</header>
