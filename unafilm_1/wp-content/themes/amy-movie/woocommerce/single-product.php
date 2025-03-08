<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if (! defined('ABSPATH')) {
	return;
}

get_header('shop');

get_template_part('partials/page-header');

$shop_id		= wc_get_page_id('shop');
$page_layout    = get_post_meta($shop_id, '_layout', true);
$page_column	= in_array($page_layout, ['right', 'left']) ? '8' : '12';

$class  = 'main-content';
$class .= ($page_layout == 'right' || $page_layout == 'left') ? ' has-sidebar' : '';
$class .= ($page_layout == 'right' || $page_layout == 'left') ? ' sidebar-' . $page_layout : '';
$class .= (amy_get_option('enable_m_ticket', false) == true && defined('SMARTCMS_SRW_URL')) ? ' product-buy-ticket' : '';
?>

<section class="<?php echo esc_attr($class); ?>">
	<div class="main-content-wrapper container">
		<div class="content-wrap-inner">
			<?php amy_movie_page_sidebar('left', $page_layout); ?>

			<div class="col-md-<?php echo esc_attr($page_column); ?>">
				<div class="page-content">
					<?php

					/**
					 * woocommerce_before_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 */
					do_action('woocommerce_before_main_content');

					while (have_posts()) {
						the_post();

						wc_get_template_part('content', 'single-product');
					}

					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action('woocommerce_after_main_content');

					?>
				</div>
			</div>
			<?php amy_movie_page_sidebar('right', $page_layout); ?>
		</div>
	</div>
</section>

<?php get_footer('shop'); ?>
