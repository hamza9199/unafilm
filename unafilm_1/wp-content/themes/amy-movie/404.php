<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

get_header();

get_template_part('partials/page-header');

?>
<div class="amy-404">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-6 my-404-left">
				<img src="<?php echo esc_attr(get_template_directory_uri()); ?>/images/frontend/img_404.png" />
			</div>
			<div class="col-sm-6 col-md-6 amy-404-right">
				<?php echo do_shortcode('[moviesearch]'); ?>
				<p><?php echo esc_html__('He is a potential enemy capable of leading mankind to destruction, Bruce Wayne aka Batman is determined to stop him at any price. Meanwhile, billionaire Lex Luthor takes advantage of the growing hatred between the two super-hero and starts his own war ...', 'amy-movie'); ?></p>
				<div class="amy-404-btn">
					<a class="btn-prev" href="<?php echo wp_get_referer(); ?>"><?php echo esc_html__('Previous Page', 'amy-movie'); ?></a>
					<a class="btn-home" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Back To home', 'amy-movie'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

get_footer();
