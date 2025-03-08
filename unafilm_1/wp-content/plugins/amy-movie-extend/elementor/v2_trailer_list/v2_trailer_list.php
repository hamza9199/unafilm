<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;

class Amy_Widget_Amy_V2_Movie_Tralier_List extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Tralier_List';
	}

	public function get_title() {
		return esc_html__('V2 - Trailer List', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-video-playlist amy-widget';
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
			'title',
			[
				'label'   => esc_html__('Title', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Video Play',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'   => esc_html__('Subtitle', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'By Movieak',
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
			'movie_from',
			[
				'label'   => esc_html__('Get Movie From Library', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'movies_ids',
			[
				'label'     => esc_html__('Movies Ids', 'amy-movie-extend'),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'movie_from' => 'yes',
				],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'imdb_rating',
			[
				'label' => esc_html__('Imdb Rating', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'poster',
			[
				'label' => esc_html__('Poster', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'background',
			[
				'label' => esc_html__('Background', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'video_link',
			[
				'label' => esc_html__('Link Video (youtube or vimeo)', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'items_list',
			[
				'label'       => esc_html__('Items Lists', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{title}}}',
				'condition'   => [
					'movie_from' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$base       = new Base();
		$template   = new Template();

		$title      = $base->get_value_in_array($settings, 'title');
		$subtitle   = $base->get_value_in_array($settings, 'general_fields_tooltip');
		$movie_from = $base->check_boolean_in_array($settings, 'movie_from');
		$movies_ids = $base->get_value_in_array($settings, 'movies_ids');
		$items_list = $base->get_value_in_array($settings, 'items_list');
		$class      = $base->get_value_in_array($settings, 'class');

		$list_item  = [];

        if (!empty($items_list)) {
            foreach ($items_list as $item) {
                $item['poster']     = $item['poster']['id'];
                $item['background'] = $item['background']['id'];

                $list_item[] = $item;
            }
        }

        ob_start();

        set_query_var('title', $title);
        set_query_var('subtitle', $subtitle);
        set_query_var('movie_from', $movie_from);
        set_query_var('movies_ids', $movies_ids);
        set_query_var('class', $class);
        set_query_var('list_item', $items_list);

        $template->get_template_part('/shortcode/v2-trailer-list');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Tralier_List());