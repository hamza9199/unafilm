<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

get_header();

get_template_part('partials/page-header');

$page_layout	= esc_attr(amy_get_option('blog_sidebar', 'right'));
$page_column	= esc_attr($page_layout == 'full' ? '12' : '8');

?>

<section class="amy-main-content single-post">
	<div class="container">
		<div class="row">
			<?php amy_movie_page_sidebar('left', $page_layout); ?>

			<div class="col-md-<?php echo esc_attr($page_column); ?>">
				<div class="page-content">
					<?php
					while (have_posts()) :
						the_post();
						get_template_part('partials/post-formats/content', get_post_format());
					endwhile;
					?>
				</div>
			</div>

			<?php amy_movie_page_sidebar('right', $page_layout); ?>

		</div>
	</div>
</section>
<?php

get_footer();
