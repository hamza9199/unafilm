<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (! defined('ABSPATH')) {
	return;
}

global $product;

if ($exists && ! $available_multi_wishlist) {
    $class = 'hide';
    $style = 'none';
} else {
    $class = 'show';
    $style = 'block';
}
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id); ?>">
	<?php if (! ($disable_wishlist && ! is_user_logged_in())) : ?>
		<div class="yith-wcwl-add-button <?php echo esc_attr($class); ?> hint--top hint--rounded hint--bounce" aria-label="<?php echo esc_attr($label); ?>" style="display: <?php echo esc_attr($style); ?>">
			<?php yith_wcwl_get_template('add-to-wishlist-' . $template_part . '.php', $atts); ?>
		</div>

		<div class="yith-wcwl-wishlistaddedbrowse hide hint--top hint--rounded hint--bounce" aria-label="<?php echo esc_attr(apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text)); ?>" style="display: none;">
			<span class="feedback"><?php echo esc_attr($product_added_text); ?></span>

			<a href="<?php echo esc_url($wishlist_url); ?>" rel="nofollow">
				<?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text); ?>
			</a>
		</div>

		<div class="yith-wcwl-wishlistexistsbrowse hint--top hint--rounded hint--bounce <?php echo esc_attr($class); ?>" aria-label="<?php echo esc_attr(apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text)); ?>" style="display: <?php echo esc_attr($style); ?>">
			<span class="feedback"><?php echo esc_attr($already_in_wishslist_text); ?></span>

			<a href="<?php echo esc_url($wishlist_url) ?>" rel="nofollow">
				<?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?>
			</a>
		</div>

		<div class="clear"></div>
		<div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else : ?>
		<a href="<?php echo esc_url(add_query_arg(array('wishlist_notice' => 'true', 'add_to_wishlist' => $product_id), get_permalink(wc_get_page_id('myaccount')))); ?>" rel="nofollow" class="<?php echo str_replace('add_to_wishlist', '', $link_classes); ?>">
			<?php echo esc_attr($icon); ?>
			<?php echo esc_attr($label); ?>
		</a>
	<?php endif; ?>

</div>
