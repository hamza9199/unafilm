<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

$image_size = array();
$i			= $amy_static;

if ($i == 1 || $i == 3 || $i == 7 || $i == 8) {
	$image_size = array('360', '240');
} else if ($i == 2 || $i == 5 || $i == 6) {
	$image_size = array('360', '430');
} else if ($i == 4) {
	$image_size = array('750', '430');
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php amy_movie_semantics('post'); ?>>
	<div class="entry-thumb"><?php the_post_thumbnail($image_size); ?></div>
	<div class="entry-content">
		<?php if ($i == 1 || $i == 3 || $i == 7 || $i == 8) : ?>
			<div class="left col-md-3">
				<div class="entry-date">
					<span class="d"><?php echo get_the_date('d'); ?></span>
					<span class="m"><?php echo get_the_date('M'); ?></span>
				</div>
				<div class="entry-cat">
					<?php the_category(); ?>
				</div>
				<div class="entry-comment">
					<i class="fa fa-comments" aria-hidden="true"></i>
					<?php comments_number('0', '1', '%'); ?>
				</div>
			</div>
			<div class="right col-md-9">
				<?php the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>'); ?>
				<div class="entry-excerpt">
					<?php the_excerpt(); ?>
				</div>
			</div>
			<div class="clearfix"></div>
		<?php elseif ($i == 2 || $i == 4 || $i == 5 || $i == 6) : ?>
			<div class="entry-cat">
				<?php the_category(); ?>
			</div>
			<?php the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>'); ?>
		<?php endif; ?>
	</div>
</article>
