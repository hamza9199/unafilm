<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_Movie_Movie_List extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_List';
	}

	public function get_title() {
		return esc_html__('Amy Movie List', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-post-list amy-widget';
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
				'default' => 5,
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

		$base = new Base();

		if ($base->get_option('enable_m_cinema')) {
			$this->add_control(
				'show_showtime',
				[
					'label'   => esc_html__('Show Showtime', 'amy-movie-extend'),
					'type'    => \Elementor\Controls_Manager::SWITCHER,
					'default' => ''
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
						'today' => esc_html__('Only Today', 'amy-movie-extend'),
						'all'   => esc_html__('All Days', 'amy-movie-extend'),
						'cm'    => esc_html__('Coming Soon', 'amy-movie-extend'),
					),
					'condition'   => [
						'show_showtime' => 'yes',
					],
				]
			);
		}

		$this->add_control(
			'class',
			[
				'label' => esc_html__('Extra Class', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	protected function add_layout_filter_controls() {
		$this->start_controls_section(
			'section_content_filter',
			[
				'label' => __('Filter', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $movie_helper       = new MovieHelpers();
        $custom_fields      = $movie_helper->get_options_custom_fields();
        $defaults_fields    = $movie_helper->get_options_default_fields();

		$person_options = array();

		if (! empty($defaults_fields)) {
			foreach ($defaults_fields as $field) {
				if ($field == 'movie_actor') {
					$person_options['amy_actor'] = esc_html__('Actor', 'amy-movie-extend');
				}

				if ($field == 'movie_director') {
					$person_options['amy_director'] = esc_html__('Director', 'amy-movie-extend');
				}

				if ($field == 'movie_genre') {
					$person_options['amy_genre'] = esc_html__('Genre', 'amy-movie-extend');
				}
			}
		}

		if (! empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				if ($field['type'] == 'person' || $field['type'] == 'category') {
					$name          = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
					$singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

					$person_options[ $singular_name ] = $field['name'];
				}
			}
		}

		$this->add_control(
			'show_filter',
			[
				'label'   => esc_html__('Show Filter', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'filters',
			[
				'label'       => esc_html__('Chosen Filters Show', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $person_options,
			]
		);

		$this->add_control(
			'show_sortby',
			[
				'label'   => esc_html__('Show Sort by', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'filter_style',
			[
				'label'       => esc_html__('Filter Style', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'style1',
				'options'     => array(
					'style1' => esc_html__('Style 1', 'amy-movie-extend'),
					'style2' => esc_html__('style 2', 'amy-movie-extend'),
				),
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
		$this->add_layout_filter_controls();
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
		$pagination     = $base->check_boolean_in_array($settings, 'pagination');
		$show_showtime  = $base->check_boolean_in_array($settings, 'show_showtime');
		$showtime_type  = $base->get_value_in_array($settings, 'showtime_type');
		$class          = $base->get_value_in_array($settings, 'class');
		//== [ Filter ]
		$show_filter  = $base->check_boolean_in_array($settings, 'show_filter');
		$filters      = $base->get_value_in_array($settings, 'filters');
		$show_sortby  = $base->check_boolean_in_array($settings, 'show_sortby');
		$filter_style = $base->get_value_in_array($settings, 'filter_style');
		//== [ Query ]
		$post_type           = $base->get_value_in_array($settings, 'post_type', 'amy_movie');
		$amy_genre           = $base->get_value_in_array($settings, 'amy_genre');
		$amy_actor           = $base->get_value_in_array($settings, 'amy_actor');
		$amy_director        = $base->get_value_in_array($settings, 'amy_director');
		$orderby             = $base->get_value_in_array($settings, 'orderby');
		$order               = $base->get_value_in_array($settings, 'order');
		$movie_type          = $base->get_value_in_array($settings, 'movie_type');
		$list_fields_visible = 'movie_release,movie_imdb,movie_language,movie_genre,movie_actor,movie_director,movie_cinema';

		/*
		 * Code now
		 */

		// Custom query
		$paged  = (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		$params = array();

		$params['post_type']      = $post_type;
		$params['orderby']        = $orderby;
		$params['order']          = $order;
		$params['posts_per_page'] = $posts_per_page;
		$params['paged']          = $paged;
		$params['movie_type']     = $movie_type;
		$params['custom_fields']  = array();

		if (isset($_GET['orderby']) && $_GET['orderby'] != 'default') {
			$params['orderby'] = $_GET['orderby'];
		}

        $params = $elementor->shortcode_taxonomy_render_query($params, $settings, $amy_genre, $amy_actor, $amy_director);

		$arpg             = $movie_query->build($params);
		$movie_list_query = new WP_Query($arpg);
		$max              = intval($movie_list_query->max_num_pages);
		$data             = $movie_list_query->posts;

		$options = array(
			'img_size'            => $base->get_image_size('movie_list'),
			'max_pages'           => $max,
			'pagination'          => $pagination,
			'show_showtime'       => $show_showtime,
			'showtime_type'       => $showtime_type,
			'list_fields_visible' => $list_fields_visible,
		);

        $html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('title', $title);
        set_query_var('data', $data);
        set_query_var('show_filter', $show_filter);
        set_query_var('filter_style', $filter_style);
        set_query_var('filters', $filters);
        set_query_var('show_sortby', $show_sortby);
        set_query_var('options', $options);
        set_query_var('pagination', $pagination);
        set_query_var('max', $max);

        $template->get_template_part('/shortcode/list');

        $html[] = ob_get_clean();

        wp_reset_postdata();
        wp_reset_query();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Movie_List());
