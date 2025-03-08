<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_Movie_Slide extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Slide';
	}

	public function get_title() {
		return esc_html__('Amy Movie Slide', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-post-slider amy-widget';
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
			'posts_per_page',
			[
				'label'   => esc_html__('Post Per Page', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__('Show Title', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_release',
			[
				'label'   => esc_html__('Show Release Date', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_content',
			[
				'label'   => esc_html__('Show Content', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'   => esc_html__('Show Button', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'label'   => esc_html__('Show Arrows', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_dots',
			[
				'label'   => esc_html__('Show Dots', 'amy-movie-extend'),
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
			'fade',
			[
				'label'   => esc_html__('Fade', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'usecss',
			[
				'label'       => esc_html__('useCSS', 'amy-movie-extend'),
				'description' => esc_html__('Enable/Disable CSS Transitions', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'yes'
			]
		);

		$this->add_control(
			'usetransform',
			[
				'label'       => esc_html__('useTransform', 'amy-movie-extend'),
				'description' => esc_html__('Enable/Disable CSS Transforms', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'yes'
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

		$posts_per_page = $base->get_value_in_array($settings, 'posts_per_page');
		$show_title     = $base->check_boolean_in_array($settings, 'show_title');
		$show_release   = $base->check_boolean_in_array($settings, 'show_release');
		$show_content   = $base->check_boolean_in_array($settings, 'show_content');
		$show_button    = $base->check_boolean_in_array($settings, 'show_button');
		$show_arrows    = $base->check_boolean_in_array($settings, 'show_arrows');
		$show_dots      = $base->check_boolean_in_array($settings, 'show_dots');
		$class          = $base->get_value_in_array($settings, 'class');
		$infinite       = $base->check_boolean_in_array($settings, 'infinite');
		$autoplay       = $base->check_boolean_in_array($settings, 'autoplay');
		$autoplayspeed  = $base->get_value_in_array($settings, 'autoplayspeed');
		$fade           = $base->check_boolean_in_array($settings, 'fade');
		$usecss         = $base->check_boolean_in_array($settings, 'usecss');
		$usetransform   = $base->check_boolean_in_array($settings, 'usetransform');
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
		// Custom query
		$params = array();

		$params['post_type']      = $post_type;
		$params['orderby']        = $orderby;
		$params['order']          = $order;
		$params['posts_per_page'] = $posts_per_page;
		$params['movie_type']     = $movie_type;
		$params['custom_fields']  = array();

        $params = $elementor->shortcode_taxonomy_render_query($params, $settings, $amy_genre, $amy_actor, $amy_director);

		$arpg              = $movie_query->build($params);
		$movie_slide_query = new WP_Query($arpg);
		$data              = $movie_slide_query->posts;

        $slick = $sc_general->render_slide_options([
            'autoplay'          => $autoplay,
            'autoplayspeed'     => $autoplayspeed,
            'show_arrows'       => $show_arrows,
            'infinite'          => $infinite,
            'fade'              => $fade,
            'usecss'            => $usecss,
            'usetransform'      => $usetransform,
            'show_dots'         => $show_dots,
        ]);

        $html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('slick', $slick);
        set_query_var('data', $data);
        set_query_var('show_release', $show_release);
        set_query_var('show_content', $show_content);
        set_query_var('show_button', $show_button);
        set_query_var('show_title', $show_title);

        $template->get_template_part('/shortcode/slide');

        $html[] = ob_get_clean();

        wp_reset_query();
        wp_reset_postdata();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Slide());
