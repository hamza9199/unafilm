<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 * Render header top bar.
 */
if (! function_exists('amy_movie_top_bar')) {
	function amy_movie_top_bar() {
		$top_bar		= amy_get_option('top_bar');

		if ($top_bar) {
			?>

			<div id="amy-top-bar">
				<div class="container">
					<div class="amy-inner">
						<?php amy_movie_top_bar_modules('left'); ?>
						<?php amy_movie_top_bar_modules('right'); ?>
					</div>
				</div>
			</div>

			<?php
		}
	}
}

/**
 * Render top bar module.
 */
if (! function_exists('amy_movie_top_bar_modules')) {
	function amy_movie_top_bar_modules($area) {
		$modules		= $area == 'right' ? amy_get_option('top_bar_right') : amy_get_option('top_bar_left');

		if (! empty($modules)) {
			?>

			<div class="amy-top-bar-<?php echo esc_attr($area); ?> pull-<?php echo esc_attr($area); ?>">
				<?php foreach ($modules as $key => $module) : ?>
					<?php
						$color 		= '';
						$bg_color 	= '';

					if ($module['m_color']) {
						$color = 'color: ' . $module['m_color'] . ';';
					}

					if ($module['m_bg_color']) {
						$bg_color = 'background-color: ' . $module['m_bg_color'] . '';
					}

					?>
					<div class="amy-top-module amy-module-<?php echo esc_attr($module['module']) . ' ' . esc_attr($module['class']); ?>" style="<?php echo $color . $bg_color; ?>">
						<?php if (($module['visible_type'] == 'user' && is_user_logged_in()) || ($module['visible_type'] == 'guest' && ! is_user_logged_in()) || ($module['visible_type'] == 'any')) { ?>
						<?php
						switch ($module['module']) {
							case 'text':
								echo ! empty($module['icon']) ? '<i class="' . $module['icon'] . '"></i> ' : '';
								echo amy_movie_get_value_in_array($module, 'text');

								break;
							case 'link':
							    $url    = !empty($module['link']) ? $module['link']['url'] : '';
							    $target = !empty($module['link']) ? $module['link']['target'] : '';

								echo '<a href="' . esc_url($url) . '" target="' . $target . '">';
								echo ! empty($module['icon']) ? '<i class="fa ' . $module['icon'] . '"></i> ' : '';
								echo amy_movie_get_value_in_array($module, 'text');
								echo '</a>';

							  	break;

							case 'social':
								echo amy_movie_social_list();

								break;

							case 'menu':
								$menu_slug 	= isset($module['menu_slug']) ? $module['menu_slug'] : '';
								echo amy_movie_menu_item($menu_slug);

								break;

							case 'login':
								echo amy_movie_user();

								break;
						}
						?>
						<?php } ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php
		}
	}
}

/**
 * Render site logo.
 */
if (! function_exists('amy_movie_logo')) {
	function amy_movie_logo() {
		$home_url	= esc_url(home_url('/'));
		$logo		= amy_get_option('logo');

        $html[]	= '<div id="amy-site-logo">';

		if (!empty($logo)) {
            $html[] = '<a href="' . esc_url($home_url) . '">';
            $html[] = '<img src="' . amy_movie_get_value_in_array($logo, 'url') . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
            $html[] = '</a>';
        } else {
		    $html[] = '<h1 class="site-name">';
		    $html[] = '<a href="' . esc_url($home_url) . '">' . get_bloginfo('name') . '</a>';
		    $html[] = '</h1>';
        }

        $html[]	= '</div>';

		return implode("\n", $html);
	}
}

/**
 * Generate header menu.
 */
if (! function_exists('amy_movie_menu')) {
	function amy_movie_menu() {
		$html	= array();

		$html[]	= '<nav id="amy-site-nav" class="amy-site-navigation amy-primary-navigation">';

		ob_start();

		if (has_nav_menu('primary')) {
			wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu'));
		}

		$html[]	= ob_get_clean();

		$html[]	= '</nav>';

		return implode("\n", $html);
	}
}

/**
 * Generate header mobile menu
 */
if (! function_exists('amy_movie_mobile_menu')) {
	function amy_movie_mobile_menu() {
		$html	= array();
		$html[]	= '<div id="amy-navigation-mobile">';

		ob_start();

		if (has_nav_menu('mobile')) {
			wp_nav_menu(array(
				'theme_location'	=> 'mobile',
			));
		} else {
			wp_nav_menu(array(
				'theme_location'	=> 'primary',
				'mobile'			=> true,
			));
		}

		$html[]	= ob_get_clean();

		$html[]	= '</div>';

		return implode("\n", $html);

	}
}

/**
 * Generate header mobile icon.
 */
if (! function_exists('amy_movie_mobile_icon')) {
	function amy_movie_mobile_icon() {
		$html	= array();

		$html[]	= '<div id="amy-menu-toggle"><a><span></span></a></div>';

		return implode("\n", $html);
	}
}

/**
 * Page loading
 */
if (!function_exists('amy_movie_page_loading')) {
    function amy_movie_page_loading() {
        ?>
        <div class="amy-page-load">
            <div class="amy-page-load-wrapper">
                <div class="bar bar1"></div>
                <div class="bar bar2"></div>
                <div class="bar bar3"></div>
                <div class="bar bar4"></div>
                <div class="bar bar5"></div>
                <div class="bar bar6"></div>
                <div class="bar bar7"></div>
                <div class="bar bar8"></div>
            </div>
        </div>
        <?php
    }
}