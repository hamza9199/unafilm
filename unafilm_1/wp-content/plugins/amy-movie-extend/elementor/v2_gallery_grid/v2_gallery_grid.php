<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;

class Amy_Widget_Amy_V2_Movie_Gallery_Grid extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Gallery_Grid';
	}

	public function get_title() {
		return esc_html__('V2 - Gallery Grid', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-gallery-grid amy-widget';
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
			'gallery',
			[
				'label' => esc_html__('Gallery', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::GALLERY,
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
					'2'     => esc_html__('2 columns', 'amy-movie-extend'),
					'3'    => esc_html__('3 columns', 'amy-movie-extend'),
					'4'   => esc_html__('4 columns', 'amy-movie-extend'),
					'5' => esc_html__('5 columns', 'amy-movie-extend'),
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

	protected function register_controls() {
		$this->add_layout_content_controls();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();

        $base       = new Base();
        $template   = new Template();
        
		$gallery    = $base->get_value_in_array($settings, 'gallery');
		$column     = $base->get_value_in_array($settings, 'column');
		$img_size   = 'full';
		$class      = $base->get_value_in_array($settings, 'class');

		/*
		 * Code now
		 */

        $new_gallery = [];

        if (!empty($gallery)) {
            foreach ($gallery as $item) {
                $new_gallery[] = $item['id'];
            }
        }

        $html = [];

        ob_start();

        set_query_var('class', $class);
        set_query_var('column', $column);
        set_query_var('img_size', $img_size);
        set_query_var('gallery', $new_gallery);
        $template->get_template_part('/shortcode/v2-gallery-grid');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Gallery_Grid());