<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

$layout			= esc_attr(amy_get_option('blog_layout', 'list'));
$column			= esc_attr(amy_get_option('blog_column'));

$img_size		= amy_get_option('blog_img_size', 'medium');
$metadata		= amy_get_option('blog_metadata');

$meta_position	= esc_attr(amy_get_option('blog_meta_position', 'under'));
$image_width	= (int) amy_get_option('blog_img_width', '4');

$post_per_page	= (int) get_option('posts_per_page');
$pagination		= esc_attr(amy_get_option('blog_pagination'));

if (get_the_post_thumbnail($post, $img_size) != null) {
	$tclass = 'has-thumb';
} else {
	$tclass = 'no-thumb';
}

?>
<?php if ($layout == 'grid') : ?>
	<div class="col-md-<?php echo 12 / $column; ?>">
		<article <?php post_class(); ?>>
			<div class="entry-thumb">
				<?php if (get_the_post_thumbnail($post, $img_size) != null) : ?>
					<?php echo get_the_post_thumbnail($post, $img_size); ?>
				<?php else : ?>
					<!--<img src="<?php echo esc_attr(get_template_directory_uri() . '/images/frontend/noimg.jpg'); ?>" />-->
				<?php endif; ?>
			</div>
			<div class="entry-content">
				<?php the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>'); ?>
				<div class="meta">
					<a class="url u-url" href="<?php echo esc_url(get_permalink()); ?>">
						<span class="entry-date"><?php echo get_the_date(); ?></span>
					</a>
				</div>
			</div>
		</article>
	</div>
<?php elseif ($layout == 'list') : ?>
	<div class="col-md-12 col-xs-12">
		<article <?php post_class(); ?>>
			<div class="row">
				<?php if ($meta_position == 'right') {
					$thumbclass	 = 'right';
					$thumbclass .= ' col-md-' . $image_width;
					$thumbclass .= ' col-xs-' . $image_width;

					$contentwitdh	 = 12 - $image_width;
					$contentclass	 = 'right';
					$contentclass	.= ' col-md-' . $contentwitdh;
					$contentclass	.= ' col-xs-' . $contentwitdh;
} else {
	$thumbclass 	= $meta_position . ' col-md-12 col-xs-12';
	$contentclass 	= $meta_position . ' col-md-12 col-xs-12';
}
				?>
				<div class="entry-thumb <?php echo esc_attr($thumbclass); ?> <?php echo esc_attr($tclass); ?>">
					<?php if (get_the_post_thumbnail($post, $img_size) != null) : ?>
						<?php echo get_the_post_thumbnail($post, $img_size); ?>
					<?php else : ?>
						<!--<img src="<?php echo esc_attr(get_template_directory_uri() . '/images/frontend/noimg.jpg'); ?>" />-->
					<?php endif; ?>
				</div>
				<div class="entry-content <?php echo esc_attr($contentclass); ?> <?php echo esc_attr($tclass); ?>">
					<?php if ($meta_position == 'under') : ?>
					<div class="entry-meta">
						<div class="entry-date">
							<a class="url u-url" href="<?php echo esc_url(get_permalink()); ?>">
								<span class="d"><?php echo get_the_date('d'); ?></span>
								<span class="m"><?php echo get_the_date('M'); ?></span>
							</a>
						</div>
						<div class="entry-comment">
							<i class="fa fa-comments" aria-hidden="true"></i>
							<?php comments_number('0', '1', '%'); ?>
						</div>
					</div>
					<div class="entry-left">
						<?php the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>'); ?>
						<div class="entry-summary p-summary" itemprop="description"><?php the_excerpt(); ?></div>
					</div>
					<?php elseif ($meta_position == 'right') : ?>
						<?php the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>'); ?>
						<div class="entry-info">
							<span class="entry-author p-author vcard hcard h-card" itemtype="http://schema.org/Person" itemprop="author editor publisher">
								<?php echo esc_html__('By ', 'amy-movie'); ?>
								<a class="url uid u-url u-uid fn p-name" rel="author" itemprop="url" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
								<?php echo get_the_author(); ?></a>
							</span>
							<span>/</span>
							<a class="url u-url" href="<?php echo esc_url(get_permalink()); ?>">
								<span class="entry-date"><?php echo get_the_date(); ?></span>
							</a>
							<span>/</span>
							<?php if (in_array('category', get_object_taxonomies(get_post_type()))) : ?>
								<span class="entry-category"><?php echo get_the_category_list(', '); ?></span>
							<?php endif; ?>
							<span>/</span>
							<span class="entry-comment"><?php comments_number('0 Comment', '1 Comments', '% Comments'); ?></span>
						</div>
						<div class="entry-summary p-summary" itemprop="description"><?php the_excerpt(); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</article>
	</div>
<?php endif; ?>
