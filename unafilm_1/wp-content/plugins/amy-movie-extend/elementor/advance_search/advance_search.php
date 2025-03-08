<?php
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Template;

class Amy_Widget_Amy_Movie_Advance_Search extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_Movie_Advance_Search';
	}

	public function get_title() {
		return esc_html__('Advance Search', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-site-search amy-widget';
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

		$movie_helper       = new MovieHelpers();
		$custom_fields      = $movie_helper->get_options_custom_fields();
		$defaults_fields    = $movie_helper->get_options_default_fields();

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

					$person_options[ $field['name'] ] = $singular_name;
				}
			}
		}

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
			'class',
			[
				'label' => esc_html__('Extra Class', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
        $template   = new Template();

		$filters    = amy_movie_get_value_in_array($settings, 'filters');
		$class      = amy_movie_get_value_in_array($settings, 'class');

		$html   = [];

        ob_start();

        $data = [
            'class'         => $class,
            'filters'       => implode(',', $filters)
        ];

        $template->set_template_data($data)->get_template_part('/shortcode/advance-search');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

//\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_Movie_Advance_Search());
