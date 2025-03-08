<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if (! defined('ABSPATH')) {
	return;
}

get_header('shop');

get_template_part('partials/page-header');

$shop_id		= wc_get_page_id('shop');
$post_meta		= get_post_meta($shop_id, '_sidebar', true);
$page_layout	= isset($post_meta['page_sidebar']) ? $post_meta['page_sidebar'] : 'full';
$page_column	= esc_attr($page_layout == 'full' ? '12' : '8');

$class  = 'main-content';
$class .= ($page_layout == 'right' || $page_layout == 'left') ? ' has-sidebar' : '';
$class .= ($page_layout == 'right' || $page_layout == 'left') ? ' sidebar-' . $page_layout : '';
?>

<?php do_action('woocommerce_before_main_content'); ?>

<section class="<?php echo esc_attr($class); ?>">
	<div class="main-content-wrapper container">
		<div class="content-wrap-inner">
			<?php amy_movie_page_sidebar('left', $page_layout); ?>

			<div class="col-md-<?php echo esc_attr($page_column); ?>">
				<div class="page-content">
					<?php do_action('woocommerce_archive_description'); ?>

					<?php if (have_posts()) : ?>
						<div class="woocommerce-toolbar">
							<?php do_action('woocommerce_before_shop_loop'); ?>
						</div>

						<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

						<?php while (have_posts()) : ?>
							<?php the_post(); ?>
							<?php wc_get_template_part('content', 'product'); ?>
						<?php endwhile; ?>

						<?php woocommerce_product_loop_end(); ?>

						<?php do_action('woocommerce_after_shop_loop'); ?>
					<?php elseif (! woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>
						<?php wc_get_template('loop/no-products-found.php'); ?>
					<?php endif; ?>
				</div>
			</div>

			<?php amy_movie_page_sidebar('right', $page_layout); ?>
		</div>
	</div>
</section>

<?php do_action('woocommerce_after_main_content'); ?>
<?php get_footer('shop'); ?>
