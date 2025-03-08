<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_Movie_Grid extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Grid';
	}

	public function get_title() {
		return esc_html__('Amy Movie Grid', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-posts-grid amy-widget';
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
				'default' => 10,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'       => esc_html__('Layout', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'layout1',
				'options'     => array(
					'layout1' => esc_html__('Layout 1', 'amy-movie-extend'),
					'layout2' => esc_html__('Layout 2', 'amy-movie-extend'),
					'layout3' => esc_html__('Layout 3', 'amy-movie-extend'),
					'layout4' => esc_html__('Layout 4', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'column',
			[
				'label'       => esc_html__('Columns', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => '4',
				'options'     => array(
					'2' => esc_html__('2 column', 'amy-movie-extend'),
					'3' => esc_html__('3 column', 'amy-movie-extend'),
					'4' => esc_html__('4 column', 'amy-movie-extend'),
					'5' => esc_html__('5 column', 'amy-movie-extend'),
				),
				'condition'   => [
					'layout' => array('layout1', 'layout3', 'layout4'),
				],
			]
		);

		$this->add_control(
			'layout2_column',
			[
				'label'       => esc_html__('Columns', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => '2',
				'options'     => array(
					'2' => esc_html__('2 column', 'amy-movie-extend'),
					'3' => esc_html__('3 column', 'amy-movie-extend'),
				),
				'condition'   => [
					'layout' => 'layout2',
				],
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
				'default' => false
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
				'default' => false
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
		$layout         = $base->get_value_in_array($settings, 'layout');
		$column         = $base->get_value_in_array($settings, 'column');
		$layout2_column = $base->get_value_in_array($settings, 'layout2_column');
		$pagination     = $base->get_value_in_array($settings, 'pagination');
		$class          = $base->get_value_in_array($settings, 'class');
		$show_filter    = $base->get_value_in_array($settings, 'show_filter');
		$filters        = $base->get_value_in_array($settings, 'filters');
		$show_sortby    = $base->get_value_in_array($settings, 'show_sortby');
		$filter_style   = $base->get_value_in_array($settings, 'filter_style');
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
		if ($layout == 'layout2') {
			$column = $layout2_column;
		}

        switch ($layout) {
            case 'layout2':
                $image_size = $base->get_image_size('movie_grid_layout_2');
                break;
            case 'layout3':
                $image_size = $base->get_image_size('movie_grid_layout_3');
                break;
            case 'layout4':
                $image_size = $base->get_image_size('movie_grid_layout_4');
                break;
            default:
                $image_size = $base->get_image_size('movie_grid_layout_1');
                break;
        }

		$params = array();
		$paged  = (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

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
		$movie_grid_query = new WP_Query($arpg);
		$max              = intval($movie_grid_query->max_num_pages);
        $data_content     = $movie_grid_query->posts;

		$options = array(
			'img_size'   => $image_size,
			'layout'     => $layout,
			'column'     => $column,
			'max_pages'  => $max,
			'pagination' => $pagination,
			'movie_type' => $movie_type,
		);

        $html = [];

        ob_start();

        $data = [
            'layout'        => $layout,
            'title'         => $title,
            'show_filter'   => ($show_filter == 'yes') ? 'true' : 'false',
            'filter_style'  => $filter_style,
            'filters'       => !empty($filters) ? implode(',', $filters) : '',
            'show_sortby'   => ($show_sortby == 'yes') ? 'true' : 'false',
            'data_content'  => $data_content,
            'options'       => $options,
            'pagination'    => $pagination,
            'max'           => $max
        ];

        $template->set_template_data($data)->get_template_part('/shortcode/grid');

        $html[] = ob_get_clean();

        wp_reset_query();
        wp_reset_postdata();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Grid());
