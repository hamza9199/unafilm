<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;
?>

<section class="amy-main-content">
	<div class="page-content">
		<?php
		while (have_posts()) {
			the_post();

			if (is_single()) {
				get_template_part('partials/post-formats/content', get_post_format());
			} else {
				the_content();

				if (comments_open() || '0' != get_comments_number()) {
					comments_template('comments.php', true);
				}
			}

			do_action('amy_movie_page_end');
		}
		?>
	</div>
</section>
