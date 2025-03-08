<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_Movie_Carousel extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Carousel';
	}

	public function get_title() {
		return esc_html__('Amy Movie Carousel', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-carousel amy-widget';
	}

	public function get_categories() {
		return ['amy-movie-widgets'];
	}

	protected function add_layout_content_controls() {
		$this->start_controls_section(
			'section_content_content',
			[
				'label' => __('Content', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__('Post Per Page', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 20,
			]
		);

		$this->add_control(
			'post_slideshow',
			[
				'label'   => esc_html__('Post show in slide', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 20,
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'label'   => esc_html__('Show Arrows', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_dots',
			[
				'label'   => esc_html__('Show Dots', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
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

	protected function add_layout_slides_controls() {
		$this->start_controls_section(
			'section_content_slides',
			[
				'label' => __('Slides', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'   => esc_html__('Infinite', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__('Auto Play', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'autoplayspeed',
			[
				'label'   => esc_html__('Auto Play Speed', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 3000,
			]
		);

		$this->add_control(
			'centerMode',
			[
				'label'   => esc_html__('Center Mode', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->end_controls_section();
	}

	protected function add_layout_query_controls() {
	    $elementor = new Elementor();

        $elementor->default_control($this);
	}

	protected function register_controls() {
        $this->add_layout_query_controls();
		$this->add_layout_content_controls();
		$this->add_layout_slides_controls();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$base           = new Base();
		$template       = new Template();
		$movie_helper   = new MovieHelpers();
		$movie_query    = new MovieQuery();
		$sc_general     = new ShortcodeGeneral();
		$elementor      = new Elementor();

		$title          = $base->get_value_in_array($settings, 'title');
		$posts_per_page = $base->get_value_in_array($settings, 'posts_per_page');
		$post_slideshow = $base->get_value_in_array($settings, 'post_slideshow');
		$show_arrows    = $base->check_boolean_in_array($settings, 'show_arrows');
		$show_dots      = $base->check_boolean_in_array($settings, 'show_dots');
		$class          = $base->get_value_in_array($settings, 'class');
		$infinite       = $base->check_boolean_in_array($settings, 'infinite');
		$autoplay       = $base->check_boolean_in_array($settings, 'autoplay');
		$autoplayspeed  = $base->get_value_in_array($settings, 'autoplayspeed');
		$centerMode     = $base->check_boolean_in_array($settings, 'centerMode');
		$post_type      = $base->get_value_in_array($settings, 'post_type', 'amy_movie');
		$amy_genre      = $base->get_value_in_array($settings, 'amy_genre');
		$amy_actor      = $base->get_value_in_array($settings, 'amy_actor');
		$amy_director   = $base->get_value_in_array($settings, 'amy_director');
		$orderby        = $base->get_value_in_array($settings, 'orderby');
		$order          = $base->get_value_in_array($settings, 'order');
		$movie_type     = $base->get_value_in_array($settings, 'movie_type');

		/*
		 * Code now
		 */
		$params = array();

		$params['post_type']      = $post_type;
		$params['orderby']        = $orderby;
		$params['order']          = $order;
		$params['posts_per_page'] = $posts_per_page;
		$params['movie_type']     = $movie_type;
		$params['custom_fields']  = array();

        $params = $elementor->shortcode_taxonomy_render_query($params, $settings, $amy_genre, $amy_actor, $amy_director);

		$arpg                 = $movie_query->build($params);
		$movie_carousel_query = new WP_Query($arpg);
		$data_content         = $movie_carousel_query->posts;

        $slick = $sc_general->carousel_render_slide_option([
            'autoplay'          => $autoplay,
            'autoplayspeed'     => $autoplayspeed,
            'show_arrows'       => $show_arrows,
            'infinite'          => $infinite,
            'centerMode'        => $centerMode,
            'post_slideshow'    => $post_slideshow,
            'show_dots'         => $show_dots,
        ]);

		$html = [];

        $data = ['slick' => $slick, 'data_content' => $data_content, 'title' => $title, 'class' => $class];

        ob_start();

        $template->set_template_data($data)->get_template_part('/shortcode/carousel');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_query();

		echo implode('', wp_kses_allowed_html($html));
	}
}


\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Carousel());
