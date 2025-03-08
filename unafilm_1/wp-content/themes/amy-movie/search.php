<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

get_header();
get_template_part('partials/page-header');

$layout			= esc_attr(amy_get_option('blog_layout', 'list'));
$page_layout	= esc_attr(amy_get_option('blog_sidebar', 'right'));
$page_column	= esc_attr($page_layout == 'full' ? '12' : '8');

?>
<section class="amy-main-content amy-search">
	<div class="container">
		<div class="row">
			<?php amy_movie_page_sidebar('left', $page_layout); ?>

			<div class="col-md-<?php echo esc_attr($page_column); ?>">
				<div class="page-content">
					<?php if (have_posts()) : ?>
						<?php
						while (have_posts()) :
							the_post();
							get_template_part('partials/post-formats/content', 'search');
						endwhile;
						?>
					<?php else : ?>
						<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'amy-movie'); ?></p>
					<?php endif; ?>

					<nav class="amy-pagination">
						<?php // Set Blog Reading Settings to XX for optimum view!!
						global $wp_query;

						$big	= 999999999; // need an unlikely integer

						echo paginate_links(
							array(
								'base'		=> str_replace($big, '%#%', get_pagenum_link($big)),
								'format'	=> '?paged=%#%',
								'current'	=> max(1, get_query_var('paged')),
								'total'		=> $wp_query->max_num_pages,
								'end_size'	=> 1,
								'mid_size'	=> 2,
							)
						);
						?>
					</nav>
				</div>
			</div>

			<?php amy_movie_page_sidebar('right', $page_layout); ?>
		</div>

	</div>
</section>
<?php

get_footer();
