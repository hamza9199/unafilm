<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

/**
 *
 * Style Builder Class
 * A helper class for build custom style.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if (! class_exists('Amy_Style_Builder')) {
	class Amy_Style_Builder {
		protected $styles	= array();

		public static function getInstance() {
			static $instance;

			if (empty($instance)) {
				$instance	= new Amy_Style_Builder();
			}

			return $instance;
		}

		public function addStyle($selector, $styles, $media = 'all') {
			$selector	= trim($selector);
			$styles		= trim($styles);

			if (! empty($selector) && ! empty($styles)) {
				if (substr($styles, -1) != ';') {
					$styles	.= ';';
				}

				if (isset($this->styles[ $media ])) {
					if (isset($this->styles[ $media ][ $selector ])) {
						$this->styles[ $media ][ $selector ]	.= $styles;
					} else {
						$this->styles[ $media ][ $selector ]	= $styles;
					}
				} else {
					$this->styles[ $media ]	= array($selector => $styles);
				}
			}
		}

		public function render() {
			$css	= '';

			foreach ($this->styles as $media => $rule) {
				if ($media != 'all') {
					$css .= $media . '{';
				}

				foreach ($rule as $selector => $styles) {
					$css	.= $selector . '{' . $styles . '}';
				}

				if ($media != 'all') {
					$css .= '}';
				}
			}

			return $css;
		}
	}
}
