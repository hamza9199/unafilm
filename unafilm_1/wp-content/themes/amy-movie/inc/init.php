<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

class amy_movie_Theme_Include {
	private static $initialized	= false;

	public static function init() {
		if (self::$initialized) {
			return;
		} else {
			self::$initialized	= true;
		}

		// load helpers
		require_once get_template_directory() . '/inc/core/resize.php';
		require_once get_template_directory() . '/inc/core/core.php';
		require_once get_template_directory() . '/inc/helpers.php';
        require_once get_template_directory() . '/inc/helpers/page.php';

		require_once get_template_directory() . '/inc/hooks.php';
		require_once get_template_directory() . '/inc/filters.php';

		// woocommerce support
		if (class_exists('woocommerce')) {
			require_once get_template_directory() . '/inc/plugins/woocommerce/woocommerce.php';
		}

		add_action('init', array(__CLASS__, '_action_init'));
        add_action('widgets_init', array(__CLASS__, '_action_widgets_init'), 99);

		// only frontend
		if (! is_admin()) {
			add_action('wp_enqueue_scripts', array(__CLASS__, '_action_enqueue_scripts'), 20);
		}
	}

	public static function _action_init() {
        require_once get_template_directory() . '/inc/core/style-builder.php';

		if (function_exists('is_vc_activated') && is_vc_activated()) {
			require_once get_template_directory() . '/inc/plugins/js-composer/helpers.php';
		}

		// load frontend helper
		if (! is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
			require_once get_template_directory() . '/inc/helpers/header.php';
			require_once get_template_directory() . '/inc/helpers/footer.php';
			require_once get_template_directory() . '/inc/helpers/post.php';
		}

		require_once get_template_directory() . '/inc/menus.php';
	}

    public static function _action_widgets_init() {
        // register sidebars
        require_once get_template_directory() . '/inc/sidebars.php';
    }

	public static function _action_enqueue_scripts() {
		require_once get_template_directory() . '/inc/static.php';
		require_once get_template_directory() . '/inc/custom-styles.php';

		$style_builder	= Amy_Style_Builder::getInstance();
		$custom_style	= $style_builder->render();

		if ($custom_style) {
			wp_add_inline_style('amy-movie-style', $custom_style);
		}
	}
}

amy_movie_Theme_Include::init();
