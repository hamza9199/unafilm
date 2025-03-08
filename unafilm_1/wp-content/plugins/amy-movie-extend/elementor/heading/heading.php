<?php
use AmyMovie\Core\Base;

use Elementor\Group_Control_Typography;

class Amy_Widget_Amy_V2_Movie_Heading extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Heading';
	}

	public function get_title() {
		return esc_html__('V2 - Heading', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-heading amy-widget';
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
			'highlight_title',
			[
				'label' => esc_html__('Highlight Title', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__('Sub Heading', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__('Alignment', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__('Left', 'amy-movie-extend'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'amy-movie-extend'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__('Right', 'amy-movie-extend'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'seprator',
			[
				'label'   => esc_html__('Seprator', 'amy-movie-extend'),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'seprator_full',
			[
				'label'       => esc_html__('Seprator Full', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'no-full',
				'options'     => array(
					'no-full'    => esc_html__('No Full', 'amy-movie-extend'),
					'full-left'  => esc_html__('Full Left', 'amy-movie-extend'),
					'full-right' => esc_html__('Full Right', 'amy-movie-extend'),
					'full-both'  => esc_html__('Full Both', 'amy-movie-extend'),
				),
				'condition'   => [
					'seprator' => 'yes',
				],
			]
		);

		$this->add_control(
			'seprator_type',
			[
				'label'       => esc_html__('Seprator Type', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'seperator-1',
				'options'     => array(
					'seperator-1' => esc_html__('Seperator 1', 'amy-movie-extend'),
					'seperator-2' => esc_html__('Seperator 2', 'amy-movie-extend'),
				),
				'condition'   => [
					'seprator' => 'yes',
				],
			]
		);

		$this->add_control(
			'seprator_opacity',
			[
				'label'     => esc_html__('Seprator Opacity', 'amy-movie-extend'),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'seprator' => 'yes',
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

	protected function add_layout_content_style_controls() {
		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => esc_html__('General', 'amy-movie-extend'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => esc_html__('Title', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_title_style',
				'selector' => '{{WRAPPER}} .entry-header .title-heading .title',
			]
		);

		$this->add_control(
			'title_highlight_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'heading_title_highlight_style',
			[
				'label' => esc_html__('Highlight Title', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_title_highlight_style',
				'selector' => '{{WRAPPER}} .entry-header .title-heading .title-highlight',
			]
		);

		$this->add_control(
			'sub_title_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'heading_sub_title_style',
			[
				'label' => esc_html__('Sub Title', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_sub_title_style',
				'selector' => '{{WRAPPER}} .subtitle-heading',
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {
		$this->add_layout_content_controls();
		$this->add_layout_content_style_controls();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$base = new Base();

		$title            = $base->get_value_in_array($settings, 'title');
		$highlight_title  = $base->get_value_in_array($settings, 'highlight_title');
		$subtitle         = $base->get_value_in_array($settings, 'subtitle');
		$alignment        = $base->get_value_in_array($settings, 'alignment');
		$seprator         = $base->check_boolean_in_array($settings, 'seprator');
		$seprator_full    = $base->get_value_in_array($settings, 'seprator_full');
		$seprator_opacity = $base->get_value_in_array($settings, 'seprator_opacity');
		$seprator_type    = $base->get_value_in_array($settings, 'seprator_type');
		$class            = $base->get_value_in_array($settings, 'class');

		/*
		 * Code now
		 */

		$html   = array();
		$sclass = array(
			'amy-heading',
			'text-' . $alignment,
			($seprator) ? 'has-seperator' : '',
			$seprator_full == 'full-left' ? 'seperator-left-full' : '',
			$seprator_full == 'full-right' ? 'seperator-right-full' : '',
			$seprator_full == 'full-both' ? 'seperator-left-full seperator-right-full' : '',
			($seprator && $seprator_type) ? $seprator_type : '',
			$class
		);

		$style = $seprator_opacity != '' ? 'style="opacity:' . $seprator_opacity . '"' : '';

		$html[] = '<div class="' . esc_attr(implode(' ', $sclass)) . '">';

		$html[] = '<header class="entry-header">';
		$html[] = ($seprator) ? '<span class="seperator seperator-left" ' . $style . '></span>' : '';
		$html[] = '<h2 class="title-heading">';
		$html[] = ($title) ? '<span class="title">' . esc_attr($title) . '</span>' : '';
		$html[] = ($highlight_title) ? '<span class="title-highlight">' . esc_attr($highlight_title) . '</span>' : '';
		$html[] = '</h2>';
		$html[] = ($seprator) ? '<span class="seperator seperator-right" ' . $style . '></span>' : '';
		$html[] = '</header>';
		$html[] = ($subtitle) ? '<div class="subtitle-heading"><p>' . esc_attr($subtitle) . '</p></div>' : '';
		$html[] = '</div>';

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Heading());