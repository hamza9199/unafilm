<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

class Amy_Widget_Amy_Movie_Showtime extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Showtime';
	}

	public function get_title() {
		return esc_html__('Amy Movie Showtime', 'amy-movie-extend');
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

		$genre = new amy_movie_elementor_Genre();

		$this->add_control(
			'genre',
			[
				'label'       => esc_html__('Genre', 'amy-movie-extend'),
				'description' => esc_html__('If field"s empty will get all genre', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => wp_list_pluck(get_terms('amy_genre'), 'name', 'term_id'),
//				'options' 			=> amy_element_values('callback', array(
//					'function'	=> array($genre, 'get_genre_elm_args'),
//					'args'		=> array(
//						'taxonomy' => 'amy_genre',
//					),
//				)),
			]
		);

		$this->add_control(
			'showtime_type',
			[
				'label'       => esc_html__('Showtime type', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'all',
				'options'     => array(
					'today'     => esc_html__('Only Today', 'amy-movie-extend'),
					'all'    => esc_html__('All Days', 'amy-movie-extend'),
					'cm'   => esc_html__('Coming Soon', 'amy-movie-extend'),
				),
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

		$genre         = amy_movie_get_value_in_array($settings, 'genre');
		$showtime_type         = amy_movie_get_value_in_array($settings, 'showtime_type');
		$class         = amy_movie_get_value_in_array($settings, 'class');

		$current_day = strtotime(current_time('Y/m/d'));

		if ($showtime_type == 'today') {
			$time_query = array(
				'key'		=> '_release',
				'value'		=> $current_day,
				'compare' 	=> '==',
			);
		} else if ($showtime_type == 'cm') {
			$time_query = array(
				'key'		=> '_release',
				'value'		=> $current_day,
				'compare' 	=> '>',
			);
		} else if ($showtime_type == 'all') {
			$time_query = array();
		}

		if ($genre != '') {
			$tax_query_genre = array(
				'taxonomy'	=> 'amy_genre',
				'field'		=> 'term_id',
				'terms'		=> explode(',', $genre),
			);
		} else {
			$tax_query_genre = '';
		}

		$movie_arpg	= array(
			'post_type'	=> 'amy_movie',
			'tax_query'	=> array(
				$tax_query_genre,
			),
			'meta_query'	=> array(
				$time_query
			),
			'posts_per_page'	=> '10',
			'orderby'			=> 'date',
			'order'				=> 'DESC',
		);

		$movie_query 	= new WP_Query($movie_arpg);
		$movie_data		= $movie_query->posts;

		$movie = '<div class="mv-content">';

		foreach ($movie_data as $i => $m) {
			$movie .= '<div><input id="cbm-' . $m->ID . '" type="radio" name="movie_id" value="' . $m->ID . '" /><label class="cbl" for="cbm-' . $m->ID . '">' . $m->post_title . '</label></div>';
		}

		$movie .= '</div>';

		$cinema_list = amy_movie_get_cinema();

		$cinema = '<div class="mv-content">';

		foreach ($cinema_list as $i => $c) {
			$cinema .= '<div><input id="cbc-' . $c->ID . '" type="radio" name="cinema_id" value="' . $c->ID . '" /><label class="cbl" for="cbc-' . $c->ID . '">' . $c->post_title . '</label></div>';
		}

		$cinema .= '</div>';
		
		/*
		 * Code now
		 */

		$html = array();

		$html[] = '<div class="amy-shortcode amy-mv-showtime ' . esc_attr($class) . '">';
		$html[] = '<input type="hidden" class="showtime-type" name="showtime-type" value="' . $showtime_type . '" />';
		$html[] = '<div class="left"><div class="movie-list"><h3><span>1</span>' . esc_html__('Select a Movie', 'amy-movie-extend') . '</h3>' . $movie . '</div></div>';
		$html[] = '<div class="right"><div class="cinema-list"><h3><span>2</span>' . esc_html__('Select a Cinema', 'amy-movie-extend') . '</h3>' . $cinema . '</div>';
		$html[] = '<div class="list-time"><h3><span>3</span>' . esc_html__('Date & Time', 'amy-movie-extend') . '</h3><div class="mv-content"></div></div></div>';
		$html[] = '<div class="clearfix"></div></div>';

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Showtime());
