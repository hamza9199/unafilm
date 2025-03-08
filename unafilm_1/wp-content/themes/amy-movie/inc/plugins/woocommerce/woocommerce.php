<?php
/**
 * @copyright	Copyright (c) 2017 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (! defined('ABSPATH')) {
	return;
}

//
// Helper functions
//
// check yith wishlist plugin active
if (! function_exists('amy_movie_yith_wishlist_active')) {
	function amy_movie_yith_wishlist_active() {
		return function_exists('yith_wishlist_constructor');
	}
}

// check yith compare plugin active
if (! function_exists('amy_movie_yith_compare_active')) {
	function amy_movie_yith_compare_active() {
		return function_exists('yith_woocompare_constructor');
	}
}

// check yith quick view plugin active
if (! function_exists('amy_movie_yith_quickview_active')) {
	function amy_movie_yith_quickview_active() {
		return function_exists('YITH_WCQV_Frontend');
	}
}

//
//
//
// add woocommerce Support.
if (! function_exists('amy_movie_add_woocommerce_support')) {
	function amy_movie_add_woocommerce_support() {
		add_theme_support('woocommerce');

		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
	}

	add_action('after_setup_theme', 'amy_movie_add_woocommerce_support');
}

// add javascript
if (! function_exists('amy_movie_woocommerce_javascript')) {
	function amy_movie_woocommerce_javascript() {
		wp_enqueue_script('amy-movie-woocommerce-script', get_template_directory_uri() . '/js/vendor/woocommerce.js', array('jquery'), '1.0.0');
	}

	add_action('wp_enqueue_scripts', 'amy_movie_woocommerce_javascript');
}

// replace woocommerce stylesheet
if (! function_exists('amy_movie_woocommerce_replace_stylesheet')) {
	function amy_movie_woocommerce_replace_stylesheets($enqueue_styles) {
		unset($enqueue_styles['woocommerce-general']);
		unset($enqueue_styles['woocommerce-layout']);
		unset($enqueue_styles['woocommerce-smallscreen']);

		$enqueue_styles['amy-woocommerce']	= array(
			'src'		=> str_replace(array('http:', 'https:'), '', get_template_directory_uri()) . '/css/vendor/woocommerce.css',
			'deps'		=> '',
			'version'	=> WC_VERSION,
			'media'		=> 'all',
		);

		return $enqueue_styles;
	}

	add_filter('woocommerce_enqueue_styles', 'amy_movie_woocommerce_replace_stylesheets');
}

// remove breadcrumb
if (! function_exists('amy_movie_woocommerce_remove_breadcrumbs')) {
	function amy_movie_woocommerce_remove_breadcrumbs() {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	}

	add_action('init', 'amy_movie_woocommerce_remove_breadcrumbs');
}

if (! function_exists('amy_movie_woocommerce_toolbar_left_open')) {
	function amy_movie_woocommerce_toolbar_left_open() {
		echo '<div class="woocommerce-toolbar-left">';
	}

	add_action('woocommerce_before_shop_loop', 'amy_movie_woocommerce_toolbar_left_open', 5);
}

if (! function_exists('amy_movie_woocommerce_toolbar_center_open')) {
	function amy_movie_woocommerce_toolbar_center_open() {
		echo '</div><div class="woocommerce-toolbar-center">';
	}

	add_action('woocommerce_before_shop_loop', 'amy_movie_woocommerce_toolbar_center_open', 15);
}

if (! function_exists('amy_movie_woocommerce_toolbar_right_open')) {
	function amy_movie_woocommerce_toolbar_right_open() {
		echo '</div><div class="woocommerce-toolbar-right">';
	}

	add_action('woocommerce_before_shop_loop', 'amy_movie_woocommerce_toolbar_right_open', 25);
}

if (! function_exists('amy_movie_woocommerce_toolbar_right_close')) {
	function amy_movie_woocommerce_toolbar_right_close() {
		echo '</div>';
	}

	add_action('woocommerce_before_shop_loop', 'amy_movie_woocommerce_toolbar_right_close', 35);
}

// change title
if (! function_exists('amy_movie_woocommerce_template_loop_product_title')) {
	function amy_movie_woocommerce_template_loop_product_title() {
		echo '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>';
	}

	remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
	add_action('woocommerce_shop_loop_item_title', 'amy_movie_woocommerce_template_loop_product_title', 10);
}

if (! function_exists('amy_movie_woocommerce_template_loop_product_title_after_open')) {
	function amy_movie_woocommerce_template_loop_product_title_after_open() {
		echo '<div class="entry-product-meta">';
	}

	add_action('woocommerce_after_shop_loop_item_title', 'amy_movie_woocommerce_template_loop_product_title_after_open', 5);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 6);
}

if (! function_exists('amy_movie_woocommerce_template_loop_product_title_after_close')) {
	function amy_movie_woocommerce_template_loop_product_title_after_close() {
		echo '</div>';
	}

	add_action('woocommerce_after_shop_loop_item_title', 'amy_movie_woocommerce_template_loop_product_title_after_close', 20);
}


// add view mode button to toolbar
if (! function_exists('amy_movie_woocommerce_add_view_mode_button')) {
	function amy_movie_woocommerce_add_view_mode_button() {
		echo '
			<div class="woocommerce-view-mode">
				<a class="amy-grid-view-button active hint--top hint--rounded hint--bounce" href="#" aria-label="' . esc_attr__('Grid View', 'amy-movie') . '"><i class="fa fa-th"></i></a>
				<a class="amy-list-view-button hint--top hint--rounded hint--bounce" href="#" aria-label="' . esc_attr__('List View', 'amy-movie') . '"><i class="fa fa-bars"></i></a>
			</div>
		';
	}

	add_action('woocommerce_before_shop_loop', 'amy_movie_woocommerce_add_view_mode_button', 10);
}

// remove link open and add div open
if (! function_exists('amy_movie_woocommerce_template_loop_product_wrapper_open')) {
	function amy_movie_woocommerce_template_loop_product_wrapper_open() {
		echo '<div class="product-wrapper">';
	}

	add_action('woocommerce_before_shop_loop_item', 'amy_movie_woocommerce_template_loop_product_wrapper_open', 10);
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
}

// remove link close and add div close
if (! function_exists('amy_movie_woocommerce_template_loop_product_wrapper_close')) {
	function amy_movie_woocommerce_template_loop_product_wrapper_close() {
		echo '</div>';
	}

	add_action('woocommerce_after_shop_loop_item', 'amy_movie_woocommerce_template_loop_product_wrapper_close', 99);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
}

// get product thumbnail
if (! function_exists('amy_movie_woocommerce_get_product_thumbnail')) {
	function amy_movie_woocommerce_get_product_thumbnail($size = 'shop_catalog', $placeholder_with = 0, $placeholder_height = 0) {
		global $post, $product, $woocommerce;

		if (version_compare($woocommerce->version,'3.0','<')) {
			$attachment_ids	= $product->get_gallery_attachment_ids();
		} else {
			$attachment_ids	= $product->get_gallery_image_ids();
		}

		$output	= array();

		if (has_post_thumbnail()) {
			$output[]	= '<div class="product-image-wrapper">';
			$output[]	= '<a href="' . esc_url(get_the_permalink()) . '">';
			$output[]	= '<span class="primary-image">' . get_the_post_thumbnail($post->ID, $size) . '</span>';

			if (! empty($attachment_ids)) {
				$secondary_image_id	= $attachment_ids[0];
				$output[]			= '<span class="secondary-image">' . wp_get_attachment_image($secondary_image_id, $size) . '</span>';
			}

			$output[]	= '</a>';
			$output[]	= '</div>';
		} else if (wc_placeholder_img_src()) {
			$output[]	= '<div class="product-image-wrapper">';
			$output[]	= '<a href="' . esc_url(get_the_permalink()) . '">';
			$output[]	= wc_placeholder_img($size);
			$output[]	= '</a>';
			$output[]	= '</div>';
		}

		return implode("\n", $output);
	}
}

// product description
if (! function_exists('amy_movie_woocommerce_open_product_description_wrapper')) {
	function amy_movie_woocommerce_open_product_description_wrapper() {
		echo amy_movie_woocommerce_get_product_thumbnail();
		echo '<div class="product-description-wrapper">';
	}

	add_action('woocommerce_before_shop_loop_item_title', 'amy_movie_woocommerce_open_product_description_wrapper', 10);
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
}

if (! function_exists('amy_movie_woocommerce_close_product_description_wrapper')) {
	function amy_movie_woocommerce_close_product_description_wrapper() {
		echo '</div>';
	}

	add_action('woocommerce_after_shop_loop_item_title', 'amy_movie_woocommerce_close_product_description_wrapper', 99);
}

if (! function_exists('amy_movie_woocommerce_add_short_description')) {
	function amy_movie_woocommerce_add_short_description() {
		echo '<div class="product-short-description">' . get_the_excerpt() . '</div>';
	}

	add_action('woocommerce_after_shop_loop_item_title', 'amy_movie_woocommerce_add_short_description', 15);
}

// add link to product title
if (! function_exists('amy_movie_woocommerce_add_link_to_product_title')) {
	function amy_movie_woocommerce_add_link_to_product_title($title) {
		if ((is_shop() || is_tax('product_cat')) && ! is_single() && in_the_loop()) {
			return '<a href="' . esc_url(get_the_permalink()) . '">' . $title . '</a>';
		} else {
			return $title;
		}
	}

	add_filter('the_title', 'amy_movie_woocommerce_add_link_to_product_title');
}

// wrap product buttons
if (! function_exists('amy_movie_woocommerce_template_loop_product_buttons_wrapper_open')) {
	function amy_movie_woocommerce_template_loop_product_buttons_wrapper_open() {
		echo '<div class="product-buttons"><div class="product-buttons-inner">';
	}

	add_action('woocommerce_after_shop_loop_item', 'amy_movie_woocommerce_template_loop_product_buttons_wrapper_open', 5);
}

if (! function_exists('amy_movie_woocommerce_template_loop_product_buttons_wrapper_close')) {
	function amy_movie_woocommerce_template_loop_product_buttons_wrapper_close() {
		global $post, $product, $woocommerce;

		if (amy_movie_yith_wishlist_active()) {
			echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		}

		if (amy_movie_yith_compare_active()) {
			echo '<div class="yith-compare-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_attr__('Compare', 'amy-movie') . '">';
			echo do_shortcode('[yith_compare_button container="false"]');
			echo '</div>';
		}

		if (amy_movie_yith_quickview_active()) {
			$label	= esc_html(get_option('yith-wcqv-button-label'));

			echo '<div class="amy-quickview-button hint--top hint--rounded hint--bounce" aria-label="' . $label . '">';
			echo '<a href="#" class="button yith-wcqv-button" data-product_id="' . $product->get_id() . '">' . $label . '</a>';
			echo '</div>';
		}

		echo '</div>';
		echo '</div>';
	}

	add_action('woocommerce_after_shop_loop_item', 'amy_movie_woocommerce_template_loop_product_buttons_wrapper_close', 20);
}

// remove default quick view button
if (! function_exists('amy_movie_woocommerce_remove_default_quick_view_button')) {
	function amy_movie_woocommerce_remove_default_quick_view_button() {
		if (amy_movie_yith_quickview_active()) {
			$quick_view	= YITH_WCQV_Frontend::get_instance();
			remove_action('woocommerce_after_shop_loop_item', array($quick_view, 'yith_add_quick_view_button'), 15);
		}
	}

	add_action('init', 'amy_movie_woocommerce_remove_default_quick_view_button');
}

// add tooltip to add to cart button
if (! function_exists('amy_movie_woocommerce_add_tooltip_to_add_to_cart_button')) {
	function amy_movie_woocommerce_add_tooltip_to_add_to_cart_button($button) {
		global $product;

		$button	= '<div class="woocommerce_loop_add_to_cart_button hint--top hint--rounded hint--bounce" aria-label="' . esc_attr($product->add_to_cart_text()) . '">' . $button . '</div>';

		return $button;
	}

	add_filter('woocommerce_loop_add_to_cart_link', 'amy_movie_woocommerce_add_tooltip_to_add_to_cart_button');
}

//
// Loop Columns
// ------------------------------------------------------------------------------
if (! function_exists('amy_movie_loop_shop_columns')) {
	function amy_movie_loop_shop_columns() {
		$queried_object = get_queried_object();
		$term_id 		= isset($queried_object->term_id) ? $queried_object->term_id : '';
		$term 			= get_term($term_id, 'product_cat');
		$term_data 		= get_term_meta($term_id, '_category_product_options', true);

		$columns = amy_get_option('woo_loop_columns', 4);

		if (is_tax('product_cat') && isset($term_data['cat_columns']) && $term_data['cat_columns'] != 'global') {
			$columns = $term_data['cat_columns'];
		}

		return $columns;
	}

	add_filter('loop_shop_columns', 'amy_movie_loop_shop_columns', 99);
}

//
// Related Columns
// ------------------------------------------------------------------------------
if (! function_exists('amy_movie_woocommerce_output_related_products_args')) {
	function amy_movie_woocommerce_output_related_products_args($args) {

		$columns  = amy_get_option('woo_related_columns', 4);
		$args     = array(
			'posts_per_page' => $columns,
			'columns'        => $columns,
			'orderby'        => 'rand',
		);

		return $args;
	}

	add_filter('woocommerce_output_related_products_args', 'amy_movie_woocommerce_output_related_products_args', 99);
}

//
// Up-Sells (You may also like) Columns
// ------------------------------------------------------------------------------
if (! function_exists('amy_movie_woocommerce_after_single_product_summary')) {
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

	function amy_movie_woocommerce_after_single_product_summary() {
		$columns = amy_get_option('woo_upsells_columns', 4);
		woocommerce_upsell_display($columns, $columns);
	}

	add_action('woocommerce_after_single_product_summary', 'amy_movie_woocommerce_after_single_product_summary', 15);
}

//
// Cross-Sells (You may also like) Columns : Cart Page
// ------------------------------------------------------------------------------
if (! function_exists('amy_movie_woocommerce_cross_sells_columns')) {
	function amy_movie_woocommerce_cross_sells_columns() {
		$columns = amy_get_option('woo_upsells_columns', 4);
		return $columns;
	}

	add_filter('woocommerce_cross_sells_total', 'amy_movie_woocommerce_cross_sells_columns');
	add_filter('woocommerce_cross_sells_columns', 'amy_movie_woocommerce_cross_sells_columns');
}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//
// Compare Tooltip
//
if (! function_exists('amy_movie_woocommerce_add_compare_tooltip') && amy_movie_yith_compare_active()) {
	global $yith_woocompare;

	if (isset($yith_woocompare->obj)) {
		remove_action('woocommerce_single_product_summary', array($yith_woocompare->obj, 'add_compare_link'), 35);
	}

	function amy_movie_woocommerce_add_compare_tooltip($product_id = false, $args = array()) {
		extract($args);

		global $yith_woocompare;

		if (! $product_id) {
			global $product;
			$product_id = $product->get_id();
		}

		// return if product doesn't exist
		if (empty($product_id) || apply_filters('yith_woocompare_remove_compare_link_by_cat', false, $product_id)) {
			return;
		}

		$is_button = ! isset($button_or_link) || ! $button_or_link ? get_option('yith_woocompare_is_button') : $button_or_link;

		if (! isset($button_text) || $button_text == 'default') {
			$button_text = get_option('yith_woocompare_button_text', esc_html__('Compare', 'amy-movie'));
			do_action('wpml_register_single_string', 'Plugins', 'plugin_yit_compare_button_text', $button_text);
			$button_text = apply_filters('wpml_translate_single_string', $button_text, 'Plugins', 'plugin_yit_compare_button_text');
		}

		if (isset($yith_woocompare->obj)) {
			printf('<span class="hint--top hint--rounded hint--bounce tsl-compare"  aria-label="' . esc_attr__('Compare', 'amy-movie') . '"><a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a></span>', $yith_woocompare->obj->add_product_url($product_id), 'compare' . ($is_button == 'button' ? ' button' : ''), $product_id, $button_text);
		}
	}

	add_action('woocommerce_single_product_summary', 'amy_movie_woocommerce_add_compare_tooltip', 35);
}

//
// Change order single product
//
if (! function_exists('amy_movie_change_order_single_product')) {
	function amy_movie_change_order_single_product() {
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	}

	add_action('init', 'amy_movie_change_order_single_product');
}

if (! function_exists('amy_movie_change_product_open_wrapper_button')) {
	function amy_movie_change_product_open_wrapper_button() {
		if (amy_movie_yith_wishlist_active() || amy_movie_yith_compare_active() || amy_movie_yith_quickview_active()) {
			echo '<div class="product-more-action">';
		}
	}

	add_action('woocommerce_single_product_summary', 'amy_movie_change_product_open_wrapper_button', 30);
}

if (! function_exists('amy_movie_change_product_close_wrapper_button')) {
	function amy_movie_change_product_close_wrapper_button() {
		if (amy_movie_yith_wishlist_active() || amy_movie_yith_compare_active() || amy_movie_yith_quickview_active()) {
			echo '</div>';
		}

		do_action('amy_woocommerce_social_share');
	}

	add_action('woocommerce_single_product_summary', 'amy_movie_change_product_close_wrapper_button', 37);
}

