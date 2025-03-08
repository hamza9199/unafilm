<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

class Amy_Widget_Amy_Movie_Search extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Search';
	}

	public function get_title() {
		return esc_html__('Amy Movie Search', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-site-search amy-widget';
	}

	public function get_categories() {
		return ['amy-movie-widgets'];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_content',
			[
				'label' => __('Content', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'class',
			[
				'label' => esc_html__('Extra Class', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$class         = amy_movie_get_value_in_array($settings, 'class');

		/*
		 * Code now
		 */
		
		$html = array();

		$html[] = '<div class="amy-shortcode amy-mv-search ' . esc_attr($class) . '">';

		$html[] = '<form role="search" action="' . site_url('/') . '" method="get" id="searchform">';

		$html[] = '<input type="text" name="s" placeholder="' . esc_html__('Movie search...', 'amy-movie-extend') . '" class="input-txt" />';
		$html[] = ' <input type="hidden" name="post_type" value="amy_movie" />';
		$html[] = '<input type="submit" alt="Search" value="' . esc_html__('Go', 'amy-movie-extend') . '" />';
		$html[] = '<input type="hidden" name="amy_type" value="movie" class="amy_type"/>';
		$html[] = '</form>';

		$html[] = '<div class="search-ajax-content"></div>';
		$html[] = '</div>';

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Search());
