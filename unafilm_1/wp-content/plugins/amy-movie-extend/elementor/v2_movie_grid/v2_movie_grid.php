<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_V2_Movie_Grid extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Grid';
	}

	public function get_title() {
		return esc_html__('V2 - Movie Grid', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-columns amy-widget';
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
				'label'   => esc_html__('Number Movies', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => -1,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'       => esc_html__('Layout', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'grid-1',
				'options'     => array(
					'grid-1' => esc_html__('Layout 1', 'amy-movie-extend'),
					'grid-2' => esc_html__('Layout 2', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'layout1_columns',
			[
				'label'       => esc_html__('Columns', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => '4',
				'options'     => array(
					'2' => esc_html__('2 columns', 'amy-movie-extend'),
					'3' => esc_html__('3 columns', 'amy-movie-extend'),
					'4' => esc_html__('4 columns', 'amy-movie-extend'),
					'5' => esc_html__('5 columns', 'amy-movie-extend'),
					'6' => esc_html__('6 columns', 'amy-movie-extend'),
				),
				'condition'   => [
					'layout' => 'grid-1',
				],
			]
		);

		$this->add_control(
			'layout2_columns',
			[
				'label'       => esc_html__('Columns', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => '2',
				'options'     => array(
					'2' => esc_html__('2 columns', 'amy-movie-extend'),
					'3' => esc_html__('3 columns', 'amy-movie-extend'),
					'4' => esc_html__('4 columns', 'amy-movie-extend'),
				),
				'condition'   => [
					'layout' => 'grid-2',
				],
			]
		);

		$this->add_control(
			'tooltip',
			[
				'label'     => esc_html__('Tooltip Type', 'amy-movie-extend'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'dark',
				'options'   => array(
					'dark'  => esc_html__('Dark', 'amy-movie-extend'),
					'light' => esc_html__('Light', 'amy-movie-extend'),
					'none'  => esc_html__('None', 'amy-movie-extend'),
				),
				'condition' => [
					'layout' => 'grid-1',
				],
			]
		);

		$this->add_control(
			'general_fields_tooltip',
			[
				'label'       => esc_html__('Show General Fields (Tooltip with layout 1)', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'default'     => array('title', 'content', 'tralier', 'rate', 'mpaa', 'imdb', 'duration'),
				'options'     => array(
					'title'    => esc_html__('Title', 'amy-movie-extend'),
					'content'  => esc_html__('Content', 'amy-movie-extend'),
					'tralier'  => esc_html__('Button', 'amy-movie-extend'),
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
				'label'       => esc_html__('Show Custom Fields - (Tooltip with layout 1)', 'amy-movie-extend'),
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
			'pagination',
			[
				'label'   => esc_html__('Pagination', 'amy-movie-extend'),
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

		$this->add_control(
			'button_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'heading_button',
			[
				'label' => esc_html__('Button', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::HEADING,
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
        
		$posts_per_page         = $base->get_value_in_array($settings, 'posts_per_page');
		$layout                 = $base->get_value_in_array($settings, 'layout');
		$layout1_columns        = $base->get_value_in_array($settings, 'layout1_columns');
		$layout2_columns        = $base->get_value_in_array($settings, 'layout2_columns');
		$tooltip                = $base->get_value_in_array($settings, 'tooltip');
		$general_fields_tooltip = $base->get_value_in_array($settings, 'general_fields_tooltip');
		$list_fields_visible    = $base->get_value_in_array($settings, 'list_fields_visible');
		$pagination             = $base->check_boolean_in_array($settings, 'pagination');
		$class                  = $base->get_value_in_array($settings, 'class');
		$show_button_all        = $base->check_boolean_in_array($settings, 'show_button_all');
		$all_custom_text        = $base->get_value_in_array($settings, 'all_custom_text');
		$all_custom_link        = $base->get_value_in_array($settings, 'all_custom_link');
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

		$html   = [];
		$arpg                = $movie_query->build($params);
		$movie_v2_grid_query = new WP_Query($arpg);

        if ($layout == 'grid-1') {
            $columns = $layout1_columns;
        } else if ($layout == 'grid-2') {
            $columns = $layout2_columns;
        } else {
            $columns = 4;
        }

        ob_start();

        set_query_var('layout', $layout);
        set_query_var('columns', $columns);
        set_query_var('class', $class);
        set_query_var('movie_v2_grid_query', $movie_v2_grid_query);
        set_query_var('show_button_all', $show_button_all);
        set_query_var('all_custom_text', $all_custom_text);
        set_query_var('all_custom_link', $all_custom_link);
        set_query_var('tooltip', $tooltip);
        set_query_var('general_fields_tooltip', $general_fields_tooltip);
        set_query_var('list_fields_visible', $list_fields_visible);
        set_query_var('pagination', $pagination);

        $template->get_template_part('/shortcode/v2-grid');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Grid());