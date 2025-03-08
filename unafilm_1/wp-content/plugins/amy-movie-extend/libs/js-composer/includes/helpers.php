<?php
defined('ABSPATH') or die;

if (! function_exists('amy_vc_enqueue_scripts')) {
	function amy_vc_enqueue_scripts() {
		wp_enqueue_style('amy-vc-style', AMY_MOVIE_PLUGIN_URL . 'libs/js-composer/assets/vc-style.css', array(), '1.0.0', 'all');
		wp_enqueue_script('amy-vc-script', AMY_MOVIE_PLUGIN_URL . 'libs/js-composer/assets/vc-script.js', array('jquery'), '1.0.0', true);
	}

	add_action('admin_print_scripts-post.php', 'amy_vc_enqueue_scripts', 50);
	add_action('admin_print_scripts-post-new.php', 'amy_vc_enqueue_scripts', 50);
}

if (! function_exists('amy_vc_deregister_style')) {
	function amy_vc_deregister_style() {
		wp_deregister_style('font-awesome');
	}

	add_action('wp_head', 'amy_vc_deregister_style', 1001);
}

if (! function_exists('amy_vc_js_plugins')) {
	function amy_vc_js_plugins() {
	    echo '<script src="' . AMY_MOVIE_PLUGIN_URL . '/libs/js-composer/assets/chosen.jquery.js"></script>';
		echo '<script type="text/javascript">(function($) { $(document).ready(function() { $.AMYFRAMEWORK_VC_RELOAD_PLUGINS(); }); })(jQuery);</script>';
	}

	add_action('vc_load_default_params', 'amy_vc_js_plugins');
}
