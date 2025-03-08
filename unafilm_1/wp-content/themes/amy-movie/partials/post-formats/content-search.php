<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php amy_movie_semantics('post'); ?>>
	<?php the_title('<h1 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h1>'); ?>
	
	<div class="meta">
		<span class="entry-author p-author vcard hcard h-card" itemtype="http://schema.org/Person" itemprop="author editor publisher">
			<?php echo esc_html__('By ', 'amy-movie'); ?>
			<a class="url uid u-url u-uid fn p-name" rel="author" itemprop="url" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
			<?php echo get_the_author(); ?></a>
		</span>
		/
		<span class="entry-date" itemprop="dateModified datePublished">
			<a class="url u-url" href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_date(); ?></a>
		</span>
		/
		<?php if (in_array('category', get_object_taxonomies(get_post_type()))) { ?>
			<span class="entry-category"><?php echo get_the_category_list(', '); ?></span>
		<?php } ?>
		<?php edit_post_link(esc_html__('/ Edit', 'amy-movie'), '<span class="entry-edit-link">', '</span>'); ?>
	</div>
	<div class="entry-summary p-summary" itemprop="description"><?php the_excerpt(); ?></div>
</article>
