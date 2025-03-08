<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

global $post;

if (has_post_thumbnail()) {
	$class = '';
} else {
	$class = 'no-thumb';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php amy_movie_semantics('post'); ?>>
	<div class="entry-top <?php echo esc_attr($class); ?>">
		<div class="entry-thumb">
			<?php echo the_post_thumbnail(amy_get_option('blog_img_size', 'full')); ?>
		</div>
	</div>
	<div class="entry-bottom <?php echo esc_attr($class); ?>">
		<!-- Post Meta -->
		<div class="entry-meta">
			<div class="entry-date">
				<span class="d"><?php the_date('d'); ?></span>
				<span class="m"><?php echo get_the_date('M'); ?></span>
			</div>
			<div class="entry-comment">
				<i class="fa fa-comments" aria-hidden="true"></i>
				<?php comments_number('0', '1', '%'); ?>
			</div>
		</div>
		<div class="entry-left">
			<?php
			if (is_single()) {
				the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>');
			}
			?>

			<?php if (! is_single() && (is_search() || has_excerpt())) : ?>
				<div class="entry-summary p-summary" itemprop="description"><?php the_excerpt(); ?></div>
			<?php else : ?>
				<!-- Content -->
				<div class="entry-content e-content" itemprop="description articleBody">
					<?php the_content(esc_html__('Read More', 'amy-movie')); ?>
					<?php
						wp_link_pages(
							array(
								'before' 		=> '<nav class="amy-page-break amy-pagination">',
								'after'  		=> '</nav>',
								'link_before'	=> '<span class="current">',
								'link_after'	=> '</span>',
							)
						);
					?>
				</div>
			<?php endif; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- Post Tag -->
	<div class="entry-info">
		<div class="tag-box">
			<span class="top-corner"></span>
			<?php the_tags('<div class="entry-tags">Tags: <span class="tag-links">', ', ', '</span></div>'); ?>
		</div>
		<div class="entry-share">
			<label><?php echo esc_html__('Share:', 'amy-movie'); ?></label>
			<?php echo amy_movie_post_social_links(); ?>
		</div>
		<div class="clearfix"></div>
	</div>

	<!-- Related Post -->
	<div class="entry-related">
		<?php echo amy_movie_related_post(); ?>
		<div class="clearfix"></div>
	</div>

	<?php
	if (comments_open() || '0' != get_comments_number()) {
		comments_template('', true);
	}
	?>
</article>
