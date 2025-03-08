<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_Movie_Person_List extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Person_List';
	}

	public function get_title() {
		return esc_html__('Amy Movie Person List', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-person amy-widget';
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
				'label'   => esc_html__('Number Person', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'       => esc_html__('Layout', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'grid',
				'options'     => array(
					'grid'      => esc_html__('Grid', 'amy-movie-extend'),
					'list'      => esc_html__('List', 'amy-movie-extend'),
					'list-text' => esc_html__('List Text', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'columns',
			[
				'label'       => esc_html__('Columns', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => '4',
				'options'     => array(
					'2' => esc_html__('2', 'amy-movie-extend'),
					'3' => esc_html__('3', 'amy-movie-extend'),
					'4' => esc_html__('4', 'amy-movie-extend'),
					'5' => esc_html__('5', 'amy-movie-extend'),
					'6' => esc_html__('6', 'amy-movie-extend'),
				),
				'condition'   => [
					'layout' => array('grid', 'list-text'),
				],
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__('Pagination', 'amy-movie-extend'),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'layout' => array('grid', 'list'),
				],
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
		$this->start_controls_section(
			'section_content_query',
			[
				'label' => __('Query', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $movie_helper       = new MovieHelpers();
        $custom_fields      = $movie_helper->get_options_custom_fields();
        $defaults_fields    = $movie_helper->get_options_default_fields();

		$person_options     = array();
		$person_options[''] = esc_html__('Please chosen person', 'amy-movie-extend');

		if (! empty($defaults_fields)) {
			foreach ($defaults_fields as $field) {
				if ($field == 'movie_actor') {
					$person_options['amy_actor'] = esc_html__('Actor', 'amy-movie-extend');
				}

				if ($field == 'movie_director') {
					$person_options['amy_director'] = esc_html__('Director', 'amy-movie-extend');
				}
			}
		}

		if (! empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				if ($field['type'] == 'person') {
					$name          = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
					$singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

					$person_options[ $singular_name ] = $field['name'];
				}
			}
		}

		$this->add_control(
			'person',
			[
				'label'       => esc_html__('Person', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => $person_options,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__('Filter Style', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'date',
				'options'     => array(
					'ID'    => esc_html__('Person ID', 'amy-movie-extend'),
					'title' => esc_html__('Title', 'amy-movie-extend'),
					'date'  => esc_html__('Date', 'amy-movie-extend'),
					'rand'  => esc_html__('Random Order', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'order',
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

		$this->end_controls_section();
	}

	protected function register_controls() {
        $this->add_layout_query_controls();
		$this->add_layout_content_controls();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        $movie_helper       = new MovieHelpers();
        $custom_fields      = $movie_helper->get_options_custom_fields();
        $defaults_fields    = $movie_helper->get_options_default_fields();

        $base = new Base();

		$person         = $base->get_value_in_array($settings, 'person');
		$orderby        = $base->get_value_in_array($settings, 'orderby');
		$order          = $base->get_value_in_array($settings, 'order');
		$posts_per_page = $base->check_boolean_in_array($settings, 'posts_per_page');
		$layout         = $base->get_value_in_array($settings, 'layout');
        $columns        = $base->get_value_in_array($settings, 'columns');
		$pagination     = $base->check_boolean_in_array($settings, 'pagination');
		$class          = $base->get_value_in_array($settings, 'class');

		/*
		 * Code now
		 */
		if ($person == '') {
			return;
		}

		$posts_per_page = (int) $posts_per_page;
		$paged          = (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
		$offset         = (($paged - 1) * $posts_per_page);

		$arpg = array(
			'taxonomy' => $person,
			'order'    => $order,
			'number'   => $posts_per_page,
			'orderby'  => $orderby,
			'offset'   => $offset
		);

		$person_list_query = get_terms($arpg);

        $html       = [];
        $template   = new Template();

        ob_start();

        set_query_var('layout', $layout);
        set_query_var('class', $class);
        set_query_var('columns', $columns);
        set_query_var('person', $person);
        set_query_var('pagination', $pagination);
        set_query_var('posts_per_page', $posts_per_page);
        set_query_var('person_list_query', $person_list_query);

        $template->get_template_part('/shortcode/person-list');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Person_List());