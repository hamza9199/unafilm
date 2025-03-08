<?php
use AmyMovie\Core\Template;

class Amy_Widget_Amy_Movie_Blog extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Blog';
	}

	public function get_title() {
		return esc_html__('Blog', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-post-content amy-widget';
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
			'layout',
			[
				'label'       => esc_html__('Layout', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'layout1',
				'options'     => array(
					'layout1' => 'Layout 1',
					'layout2' => 'Layout 2',
				),
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__('Category', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => wp_list_pluck(get_terms('category'), 'name', 'term_id'),
			]
		);

		$this->add_control(
			'post_orderby',
			[
				'label'       => esc_html__('Category', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'date',
				'options'     => array(
					'ID'            => esc_html__('Post ID', 'amy-movie-extend'),
					'author'        => esc_html__('Author', 'amy-movie-extend'),
					'title'         => esc_html__('Title', 'amy-movie-extend'),
					'date'          => esc_html__('Date', 'amy-movie-extend'),
					'rand'          => esc_html__('Random Order', 'amy-movie-extend'),
					'comment_count' => esc_html__('Comment Count', 'amy-movie-extend'),
				),
			]
		);

		$this->add_control(
			'post_order',
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
			'post_date',
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
		$template = new Template();

		$title        = amy_movie_get_value_in_array($settings, 'title');
		$category     = amy_movie_get_value_in_array($settings, 'category');
		$layout       = amy_movie_get_value_in_array($settings, 'layout');
		$post_orderby = amy_movie_get_value_in_array($settings, 'post_orderby');
		$post_order   = amy_movie_get_value_in_array($settings, 'post_order');
		$post_date    = amy_movie_get_value_in_array($settings, 'post_date');
		$class        = amy_movie_get_value_in_array($settings, 'class');

		if ($category != '') {
			$cat_query = array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category,
			);
		} else {
			$cat_query = '';
		}

		if ($layout == 'layout1') {
			$per_page = '5';
		} else if ($layout == 'layout2') {
			$per_page = '3';
		}

		$query_date = array();

		if ($post_date == 'day') {
			$query_date = array(
				array(
					'after' => '24 hours ago',
				),
			);
		} else if ($post_date == 'week') {
			$query_date = array(
				array(
					'after' => '1 week ago',
				),
			);
		} else if ($post_date == 'month') {
			$query_date = array(
				array(
					'after' => '1 month ago',
				),
			);
		}

		$arpg = array(
			'tax_query'           => array(
				$cat_query
			),
			'date_query'          => $query_date,
			'posts_per_page'      => $per_page,
			'orderby'             => $post_orderby,
			'order'               => $post_order,
			'ignore_sticky_posts' => 1,
		);

        $blog_query = new WP_Query($arpg);

        $html = [];

        ob_start();

        $data = [
            'blog_query'    => $blog_query,
            'title'         => $title,
            'class'         => $class,
            'layout'        => $layout
        ];

        $template->set_template_data($data)->get_template_part('/shortcode/blog');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Blog());
