<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_V2_Movie_Carousel_1 extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Carousel_1';
	}

	public function get_title() {
		return esc_html__('V2 - Movie Carousel 1', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-posts-carousel amy-widget';
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
			'tooltip',
			[
				'label'   => esc_html__('Tooltip Type', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => array(
					'dark'  => esc_html__('Dark', 'amy-movie-extend'),
					'light' => esc_html__('Light', 'amy-movie-extend'),
					'none'  => esc_html__('None', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'show_button_all',
			[
				'label'   => esc_html__('Show button all', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'all_custom_text',
			[
				'label'     => esc_html__('Button all Text', 'amy-movie-extend'),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'show_button_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'all_custom_link',
			[
				'label'     => esc_html__('Button all custom link', 'amy-movie-extend'),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'show_button_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'general_fields_front',
			[
				'label'       => esc_html__('Show Fields - Front', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'default'     => array('title', 'mpaa', 'imdb', 'release_date'),
				'options'     => array(
					'title'        => esc_html__('Title', 'amy-movie-extend'),
					'mpaa'         => esc_html__('MPAA', 'amy-movie-extend'),
					'imdb'         => esc_html__('Imdb', 'amy-movie-extend'),
					'release_date' => esc_html__('Release Date', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'general_fields_tooltip',
			[
				'label'       => esc_html__('Show General Fields - Back (Tooltip)', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'default'     => array('title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration'),
				'options'     => array(
					'title'    => esc_html__('Title', 'amy-movie-extend'),
					'content'  => esc_html__('Content', 'amy-movie-extend'),
					'tralier'  => esc_html__('Button Tralier', 'amy-movie-extend'),
					'detail'   => esc_html__('Button Detail', 'amy-movie-extend'),
					'rate'     => esc_html__('Rating', 'amy-movie-extend'),
					'mpaa'     => esc_html__('MPAA', 'amy-movie-extend'),
					'imdb'     => esc_html__('Imdb', 'amy-movie-extend'),
					'duration' => esc_html__('Duration', 'amy-movie-extend'),
				),
			]
		);

		$sc_general = new ShortcodeGeneral();

		$this->add_control(
			'list_fields_visible',
			[
				'label'       => esc_html__('Show Custom Fields - Back (Tooltip)', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'default'     => array(
					'movie_release',
					'movie_imdb',
					'movie_language',
					'movie_genre',
					'movie_actor',
					'movie_director',
					'movie_cinema'
				),
				'options'     => array_flip($sc_general->list_fields_config_visiable()),
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
			'number_slide',
			[
				'label'   => esc_html__('Number Slide', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 8
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

		$posts_per_page         = $base->get_value_in_array($settings, 'posts_per_page');
		$tooltip                = $base->get_value_in_array($settings, 'tooltip');
		$show_button_all        = $base->check_boolean_in_array($settings, 'show_button_all');
		$all_custom_text        = $base->get_value_in_array($settings, 'all_custom_text');
		$all_custom_link        = $base->get_value_in_array($settings, 'all_custom_link');
		$general_fields_front   = $base->get_value_in_array($settings, 'general_fields_front');
		$general_fields_tooltip = $base->get_value_in_array($settings, 'general_fields_tooltip');
		$list_fields_visible    = $base->get_value_in_array($settings, 'list_fields_visible');
		$class                  = $base->get_value_in_array($settings, 'class');
		$number_slide           = $base->get_value_in_array($settings, 'number_slide');
		$show_arrows            = $base->check_boolean_in_array($settings, 'show_arrows');
		$infinite               = $base->check_boolean_in_array($settings, 'infinite');
		$autoplay               = $base->check_boolean_in_array($settings, 'autoplay');
		$autoplayspeed          = $base->get_value_in_array($settings, 'autoplayspeed');
		$post_type              = $base->get_value_in_array($settings, 'post_type', 'amy_movie');
		$amy_genre              = $base->get_value_in_array($settings, 'amy_genre');
		$amy_actor              = $base->get_value_in_array($settings, 'amy_actor');
		$amy_director           = $base->get_value_in_array($settings, 'amy_director');
		$orderby                = $base->get_value_in_array($settings, 'orderby');
		$order                  = $base->get_value_in_array($settings, 'order');
		$movie_type             = $base->get_value_in_array($settings, 'movie_type');

        $list_fields_visible        = implode(',', $list_fields_visible);
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

		$arpg                = $movie_query->build($params);
		$v2_movie_carousel_1 = new WP_Query($arpg);

        $slick = $sc_general->render_v2_carousel_1_slide_options([
            'number_slide'  => $number_slide,
            'autoplay'      => $autoplay,
            'autoplayspeed' => $autoplayspeed,
            'infinite'      => $infinite,
            'show_arrows'   => $show_arrows
        ]);

		$html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('show_button_all', $show_button_all);
        set_query_var('all_custom_text', $all_custom_text);
        set_query_var('all_custom_link', $all_custom_link);
        set_query_var('tooltip', $tooltip);
        set_query_var('slick', $slick);
        set_query_var('v2_movie_carousel_1', $v2_movie_carousel_1);
        set_query_var('general_fields_front', $general_fields_front);
        set_query_var('list_fields_visible', $list_fields_visible);
        set_query_var('general_fields_tooltip', $general_fields_tooltip);

        $template->get_template_part('/shortcode/v2-carousel-1');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_query();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Carousel_1());