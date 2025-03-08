<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_Movie_Rate_List extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Rate_Listy';
	}

	public function get_title() {
		return esc_html__('Amy Movie Rate List', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-star-o amy-widget';
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
			'genre',
			[
				'label'       => esc_html__('Genre', 'amy-movie-extend'),
				'description' => esc_html__('If field"s empty will get all genre', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => wp_list_pluck(get_terms('amy_genre'), 'name', 'term_id'),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__('Order By', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'date',
				'options'     => array(
					'_rating_average'    => esc_html__('Point Rate', 'amy-movie-extend'),
					'_release' => esc_html__('Release Date', 'amy-movie-extend'),
					'ID'                 => esc_html__('Post ID', 'amy-movie-extend'),
					'author'             => esc_html__('Author', 'amy-movie-extend'),
					'title'              => esc_html__('Title', 'amy-movie-extend'),
					'date'               => esc_html__('Date', 'amy-movie-extend'),
					'rand'               => esc_html__('Random Order', 'amy-movie-extend'),
					'comment_count'      => esc_html__('Comment Count', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'movie_order',
			[
				'label'       => esc_html__('Sort order', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'DESC',
				'options'     => array(
					'DESC' => esc_html__('Descending', 'amy-movie-extend'),
					'ASC'  => esc_html__('Ascending', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'movie_date',
			[
				'label'       => esc_html__('Date From', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'alltime',
				'options'     => array(
					'day'     => esc_html__('Last 1 day', 'amy-movie-extend'),
					'week'    => esc_html__('Last 7 days', 'amy-movie-extend'),
					'month'   => esc_html__('Last 30 days', 'amy-movie-extend'),
					'alltime' => esc_html__('All time', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'movie_number',
			[
				'label'   => esc_html__('Post Per Page', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 7,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'   => esc_html__('Show Pagination', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
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

		$base           = new Base();
		$movie_query    = new MovieQuery();
		$template       = new Template();

		$genre         = $base->get_value_in_array($settings, 'genre');
		$orderby = $base->get_value_in_array($settings, 'orderby');
		$movie_order   = $base->get_value_in_array($settings, 'movie_order');
		$movie_date    = $base->get_value_in_array($settings, 'movie_date');
		$movie_number  = $base->get_value_in_array($settings, 'movie_number');
		$pagination    = $base->check_boolean_in_array($settings, 'pagination');
		$class         = $base->get_value_in_array($settings, 'class');

		/*
		 * Code now
		 */

		// Custom query
		$paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params = array();

		$params['movie_date']     = $movie_date;
		$params['movie_genre']    = $genre;
		$params['orderby']          = $orderby;
		$params['movie_order']    = $movie_order;
		$params['movie_per_page'] = $movie_number;
		$params['paged']          = $paged;

		$arpg      = $movie_query->build($params);
		$the_query = new WP_Query($arpg);
		$max       = intval($the_query->max_num_pages);
		$data      = $the_query->posts;

        $html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('data', $data);
        set_query_var('pagination', $pagination);
        set_query_var('max', $max);
        set_query_var('movie_number', $movie_number);
        $template->get_template_part('/shortcode/rate-list');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Rate_List());

