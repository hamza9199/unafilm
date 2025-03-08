<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

class Amy_Widget_Amy_V2_Movie_Gallery_Carousel extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Gallery_Carousel';
	}

	public function get_title() {
		return esc_html__('V2 - Gallery Carousel', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-gallery-masonry amy-widget';
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
			'short_desc',
			[
				'label' => esc_html__('Short Desciprion', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
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
			'class',
			[
				'label' => esc_html__('Extra Class', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	protected function add_layout_socials_controls() {
		$this->start_controls_section(
			'section_content_socials',
			[
				'label' => __('Socials', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__('Link', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__('Icon', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'social_lists',
			[
				'label'       => esc_html__('Social Lists', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{link}}}',
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {
		$this->add_layout_content_controls();
		$this->add_layout_socials_controls();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
        
		$base       = new Base();
		$template   = new Template();
		
		$title      = $base->get_value_in_array($settings, 'title');
		$short_desc = $base->get_value_in_array($settings, 'short_desc');
		$gallery    = $base->get_value_in_array($settings, 'gallery');
		$img_size   = 'full';
		$class      = $base->get_value_in_array($settings, 'class');
        $social_lists = $settings['social_lists'];

		/*
		 * Code now
		 */

        $new_gallery = [];

        if (!empty($gallery)) {
            foreach ($gallery as $item) {
                $new_gallery[] = $item['id'];
            }
        }

		$html = array();

        ob_start();

        set_query_var('title', $title);
        set_query_var('short_desc', $short_desc);
        set_query_var('gallery', $new_gallery);
        set_query_var('networks', $social_lists);
        set_query_var('img_size', $img_size);
        set_query_var('class', $class);

        $template->get_template_part('/shortcode/v2-gallery-carousel');

        $html[] = ob_get_clean();


        echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Gallery_Carousel());