<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

require_once get_template_directory() . '/inc/plugins/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'amy_movie_register_required_plugins');

/**
 * Register the required plugins for this theme.
 */
function amy_movie_register_required_plugins() {
	$plugins = array();

	$plugins[] = array(
		'name'		=> 'Amy Movie Extends',
		'slug'		=> 'amy-movie-extend',
		'required'	=> true,
		'version'	=> '4.0.0',
		'source'	=> 'http://plugins.amytheme.com/amy-movie-extend.zip',
	);

	$plugins[] = array(
		'name'		=> 'One Click Demo Import',
		'slug'		=> 'one-click-demo-import',
		'required'	=> true,
	);

	if (amy_get_option('enable_m_ticket', false) == true) {
		$plugins[] = array(
			'name'		=> 'WooCommerce',
			'slug'		=> 'woocommerce',
			'required'	=> true,
		);

		$plugins[] = array(
			'name'		=> 'Seat Reservation for WooCommerce',
			'slug'		=> 'scw-seat-reservation',
			'required'	=> true,
			'version'	=> '2.1',
			'source'	=> 'http://plugins.amytheme.com/scw-seat-reservation.zip',
		);
	}

	$config = array(
		'id'			=> 'tgmpa',
		'menu'			=> 'tgmpa-install-plugins',
		'has_notices'	=> true,
		'dismissable'	=> true,
		'is_automatic'	=> false,

	);

	tgmpa($plugins, $config);
}
