<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

if (! function_exists('amy_movie_footer_area')) {
	function amy_movie_footer_area() {
		$enable_footer	= amy_get_option('enable_footer');

		if ($enable_footer != true) {
			return;
		}

		$html		= array();

		$widgets	= amy_get_option('footer_widgets');
		$before		= amy_get_option('footer_widgets_before');
		$after		= amy_get_option('footer_widgets_after');

		if ($widgets || $before || $after) {
			$html[]	= '<footer id="amy-colophon" class="amy-site-footer">';
			$html[]	= '<div class="container">';

			if ($before) {
				ob_start();
				dynamic_sidebar('footer-before');

				$before	= ob_get_clean();

				if ($before) {
					$html[] = '<div class="amy-footer-before">' . $before . '</div>';
				}
			}

			if ($widgets) {
				switch ($widgets) {
					case 1:
						$widget	= array(
							'piece'		=> 1,
							'class'		=> 'col-md-12 col-sm-12',
						);

						break;
					case 2:
						$widget	= array(
							'piece'		=> 2,
							'class'		=> 'col-md-6 col-sm-6',
						);

						break;
					case 3:
						$widget	= array(
							'piece'		=> 3,
							'class'		=> 'col-md-4 col-sm-4',
						);

						break;
					case 4:
						$widget	= array(
							'piece'		=> 4,
							'class'		=> 'col-md-3 col-xs-12',
						);

						break;
					case 5:
						$widget	= array(
							'piece'		=> 6,
							'class'		=> 'col-md-2 col-sm-2',
						);

						break;
					case 6:
						$widget	= array(
							'piece'		=> 3,
							'class'		=> 'col-md-3 col-sm-3',
							'layout'	=> 'col-md-6 col-sm-6',
							'queue'		=> 1,
						);

						break;
					case 7:
						$widget	= array(
							'piece'		=> 3,
							'class'		=> 'col-md-3 col-sm-3',
							'layout'	=> 'col-md-6 col-sm-6',
							'queue'		=> 2,
						);

						break;
					case 8:
						$widget	= array(
							'piece'		=> 3,
							'class'		=> 'col-md-3 col-sm-3',
							'layout'	=> 'col-md-6 col-sm-6',
							'queue'		=> 3,
						);

						break;
					case 9:
						$widget	= array(
							'piece'		=> 4,
							'class'		=> 'col-md-2 col-sm-2',
							'layout'	=> 'col-md-6 col-sm-6',
							'queue'		=> 1,
						);

						break;
					case 10:
						$widget	= array(
							'piece'		=> 4,
							'class'		=> 'col-md-2 col-sm-2',
							'layout'	=> 'col-md-6 col-sm-6',
							'queue'		=> 4,
						);

						break;
				}

				$html[]	= '<div class="amy-footer-widgets">';
				$html[]	= '<div class="row">';

				for ($i = 1; $i < $widget['piece'] + 1; $i++) {
					$widget_class	= isset($widget['queue']) && $widget['queue'] == $i ? $widget['layout'] : $widget['class'];

					$html[]	= '<div class="' . $widget_class . '">';

					ob_start();
					dynamic_sidebar('footer-' . $i);

					$html[]	= ob_get_clean();
					$html[]	= '</div>';

				}

				$html[]	= '</div>';
				$html[]	= '</div>';
			}

			if ($after) {
				ob_start();
				dynamic_sidebar('footer-after');

				$after	= ob_get_clean();

				if ($after) {
					$html[]	= '<div class="amy-footer-after">' . $after . '</div>';
				}
			}

			$html[]	= '</div>';
			$html[]	= '</footer>';
		}

		$enable_copyright	= amy_get_option('enable_copyright');

		if ($enable_copyright == true) {
			$html[]	= '<div id="amy-copyright" class="amy-copyright">';
			$html[]	= '<div class="container"><div class="amy-inner">';
			$html[] = amy_movie_copyright_modules('left');
			$html[] = amy_movie_copyright_modules('right');
			$html[]	= '</div></div>';
			$html[]	= '</div>';
		}

		return implode("\n", $html);
	}
}

/**
 * Render Copyright module.
 */
if (! function_exists('amy_movie_copyright_modules')) {
	function amy_movie_copyright_modules($area) {

		$modules	= $area == 'left' ? amy_get_option('copyright_left') : amy_get_option('copyright_right');
		$html		= array();

		if (! empty($modules)) {
			$html[] = '<div class="amy-copyright-' . $area . ' pull-' . $area . '">';

			foreach ($modules as $key => $module) {
				$color 		= '';
				$bg_color 	= '';

				if ($module['m_color']) {
					$color = 'color: ' . $module['m_color'] . ';';
				}

				if ($module['m_bg_color']) {
					$bg_color = 'background-color: ' . $module['m_bg_color'] . '';
				}

				$html[] = '<div class="amy-copyright-module amy-module-' . $module['module'] . ' ' . $module['class'] . '" style="' . $color . $bg_color . '">';

				if (($module['visible_type'] == 'user' && is_user_logged_in()) || ($module['visible_type'] == 'guest' && ! is_user_logged_in()) || ($module['visible_type'] == 'any')) {
					switch ($module['module']) {
						case 'text':
							$html[] = ! empty($module['icon']) ? '<i class="' . $module['icon'] . '"></i> ' : '';
							$html[] = $module['text'];

							break;
						case 'link':
							$target = ! empty($module['target']) ? ' target="' . $module['target'] . '"' : '';
							$html[] = '<a href="' . $module['link'] . '"' . $target . '>';
							$html[] = ! empty($module['icon']) ? '<i class="fa ' . $module['icon'] . '"></i> ' : '';
							$html[] = $module['text'];
							$html[] = '</a>';

							break;

						case 'social':
							$html[] = amy_movie_social_list();

							break;

						case 'menu':
							$menu_slug 	= isset($module['menu_slug']) ? $module['menu_slug'] : '';
							$html[] 	= amy_movie_menu_item($menu_slug);

							break;

						case 'login':
							$html[] = amy_movie_user();

							break;
					}
				}

				$html[] = '</div>';
			}

			$html[] = '</div>';
		}

		return implode("\n", $html);
	}
}
