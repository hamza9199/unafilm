<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_V2_Movie_Carousel_3 extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Carousel_3';
	}

	public function get_title() {
		return esc_html__('V2 - Movie Carousel 3', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-media-carousel amy-widget';
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
				'default' => 20,
			]
		);

		$this->add_control(
			'show_trailer',
			[
				'label'   => esc_html__('Show Trailer', 'amy-movie-extend'),
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

	protected function add_layout_query_controls() {
        $elementor = new Elementor();

        $elementor->default_control($this);
	}

	protected function register_controls() {
        $this->add_layout_query_controls();
		$this->add_layout_content_controls();
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
        $show_trailer   = $base->check_boolean_in_array($settings, 'show_trailer');
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
		$paged  = (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params['post_type']      = $post_type;
		$params['orderby']        = $orderby;
		$params['order']          = $order;
		$params['posts_per_page'] = $posts_per_page;
		$params['paged']          = $paged;
		$params['movie_type']     = $movie_type;
		$params['custom_fields']  = array();

        $params = $elementor->shortcode_taxonomy_render_query($params, $settings, $amy_genre, $amy_actor, $amy_director);

		$arpg                  = $movie_query->build($params);
		$movie_carousel3_query = new WP_Query($arpg);

        $slick  = '{';
        $slick .= '"slidesToShow":1,"slidesToScroll":1,';
        $slick .= '"autoplay":false,';
        $slick .= '"prevArrow": "<a class=\"amy-arrow fa amy-pre fa-chevron-right\"></a>",';
        $slick .= '"nextArrow": "<a class=\"amy-arrow fa amy-next fa-chevron-left\"></a>",';
        $slick .= '"arrows":true,';
        $slick .= '"infinite":false,';
        $slick .= '"dots":true';
        $slick .= '}';

        $html = [];

        ob_start();

        set_query_var('slick', $slick);
        set_query_var('movie_carousel3_query', $movie_carousel3_query);
        set_query_var('show_trailer', $show_trailer);

        $template->get_template_part('/shortcode/v2-carousel-3');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_postdata();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Carousel_3());