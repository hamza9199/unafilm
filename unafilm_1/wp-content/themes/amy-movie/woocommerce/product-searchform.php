<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

if (! defined('ABSPATH')) {
	return;
}

?>

<form action="<?php echo esc_url(home_url('/')); ?>" name="searchform" class="woocommerce-product-search" method="get">
	<input type="text" name="s" class="search-field" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_html_e('Search for products', 'amy-movie'); ?>" />
	<button type="submit" class="fa fa-search"></button>
	<input type="hidden" name="post_type" value="product" />
</form>
