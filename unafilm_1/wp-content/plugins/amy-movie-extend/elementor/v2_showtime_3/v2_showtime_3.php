<?php
use AmyMovie\Core\Template;
use AmyMovie\Shortcode\Elementor;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\MovieQuery;
use AmyMovie\Shortcode\ShortcodeGeneral;

$base = new Base();

if (!$base->get_option('enable_m_cinema', false)) {
    return;
}

class Amy_Widget_Amy_V2_Movie_Showtime_3 extends \Elementor\Widget_Base {
	public function get_name() {
		return 'Amy_V2_Movie_Showtime_3';
	}

	public function get_title() {
		return esc_html__('V2 - Showtime 3', 'amy-movie-extend');
	}

	public function get_icon() {
		return 'eicon-bullet-list amy-widget';
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
				'default' => - 1,
			]
		);

		$this->add_control(
			'general_fields_tooltip',
			[
				'label'       => esc_html__('Show General Fields', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'default'     => array('title', 'content', 'tralier', 'detail', 'rate', 'mpaa', 'imdb', 'duration'),
				'options'     => array(
					'title'    => esc_html__('Title', 'amy-movie-extend'),
					'content'  => esc_html__('Content', 'amy-movie-extend'),
					'tralier'  => esc_html__('Button Tralier', 'amy-movie-extend'),
					'detail'  => esc_html__('Button Detail', 'amy-movie-extend'),
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
				'label'       => esc_html__('Show Custom Fields', 'amy-movie-extend'),
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
			'class',
			[
				'label' => esc_html__('Extra Class', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'time_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'heading_time',
			[
				'label' => esc_html__('Showtime Option', 'amy-movie-extend'),
				'type'  => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'day_start_week',
			[
				'label'       => esc_html__('Day start week', 'amy-movie-extend'),
				'description' => esc_html__('If"s field empty, today is day start', 'amy-movie-extend'),
				'type'        => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options'    => [
                    'enableTime'    => false,
                ]
			]
		);

		$this->add_control(
			'number_date',
			[
				'label'         => esc_html__('Number Date', 'amy-movie-extend'),
				'description'   => esc_html__('Number date you want show, default 7 days', 'amy-movie-extend'),
				'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => 5
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
		$general_fields_tooltip = $base->get_value_in_array($settings, 'general_fields_tooltip');
		$list_fields_visible    = $base->get_value_in_array($settings, 'list_fields_visible');
		$class                  = $base->get_value_in_array($settings, 'class');
		$layout_normal          = $base->get_value_in_array($settings, 'layout_normal');
		$day_start_week         = $base->get_value_in_array($settings, 'day_start_week');
		$number_date            = $base->get_value_in_array($settings, 'number_date');
		$post_type              = $base->get_value_in_array($settings, 'post_type');
		$amy_genre              = $base->get_value_in_array($settings, 'amy_genre');
		$amy_actor              = $base->get_value_in_array($settings, 'amy_actor');
		$amy_director           = $base->get_value_in_array($settings, 'amy_director');
		$orderby                = $base->get_value_in_array($settings, 'orderby');
		$order                  = $base->get_value_in_array($settings, 'order');
		$movie_type             = $base->get_value_in_array($settings, 'movie_type');

        $list_fields_visible    = implode(',', $list_fields_visible);

		$start_date = ($day_start_week != '') ? $day_start_week : current_time('m/d/y');

		/**
		 * query now
		 */
		$params 	= array();
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params['orderby']			= $orderby;
		$params['order']			= $order;
		$params['posts_per_page']	= $posts_per_page;
		$params['paged']			= $paged;
		$params['movie_type']		= $movie_type;
		$params['custom_fields']	= array();

        $params                     = $elementor->shortcode_taxonomy_render_query($params, $settings, $amy_genre, $amy_actor, $amy_director);
		$html 						= array();
		$arpg 						= $movie_query->build($params);
		$movie_showtime_3_query 	= new WP_Query($arpg);

        $option = [
            'image_size'				=> $base->get_image_size('v2_st_3'),
            'general_fields_tooltip'	=> $general_fields_tooltip,
            'list_fields_visible'		=> $list_fields_visible,
            'start_date'				=> $start_date,

        ];

        $list_movie_id = [];

        if ($movie_showtime_3_query->have_posts()) :
            while ($movie_showtime_3_query->have_posts()) :
                $movie_showtime_3_query->the_post();
                global $post;

                $list_movie_id[] = $post->ID;
            endwhile;
        endif;

        wp_reset_postdata();

        $list_movie_to_show = $sc_general->get_movie_follow_showtime($movie_showtime_3_query->posts, $start_date);

        ob_start();

        $data = [
            'class'                 => $class,
            'params'                => $params,
            'option'                => $option,
            'list_movie_id'         => $list_movie_id,
            'list_movie_to_show'    => $list_movie_to_show,
            'list_fields_visible'   => $list_fields_visible,
            'general_fields_tooltip'=> $general_fields_tooltip,
            'number_date'           => $number_date,
            'day_start_week'        => $day_start_week,
            'start_date'            => $start_date
        ];

        $template
            ->set_template_data($data)
            ->get_template_part('/shortcode/v2-showtime-3');

        $html[] = ob_get_clean();

		echo implode('', wp_kses_allowed_html($html));
	}
}

\Elementor\Plugin::instance()->widgets_manager->register(new \Amy_Widget_Amy_V2_Movie_Showtime_3());

