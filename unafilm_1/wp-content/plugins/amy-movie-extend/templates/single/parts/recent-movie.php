<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

global $post;

$transition		= new Transition();
$base           = new Base();
$single_movie   = new Movie();
$single_movie->set_movie($post->ID);
?>

<?php if ($base->get_option('show_recent_movie', false)) : ?>
	<?php
		$type			= $base->get_option('recent_movie_type');
		$title			= $base->get_option('recent_movie_title');
		$type			= $type ? $type : 'random';
		$number			= $base->get_option('recent_movie_number', '5');

		global $post;

		$layout			= $single_movie->get_layout();
		$post_per_page	= ($layout == 'full') ? '7' : '5';

		$args			= array(
			'post_type'				=> get_post_type($post->ID),
			'ignore_sticky_posts'	=> 1,
			'posts_per_page'		=> $number,
		);

		switch ($type) {
			case 'random':
				$args['orderby']	= 'rand';

				if (!$title) {
					$title	= $transition->get_string_translate('Random Movie');
				}

				break;
			default:
				$args['orderby']	= 'date';

				if (!$title) {
					$title	= $transition->get_string_translate('Recent Movie');
				}

				break;
		}

		$q = new WP_Query($args);

		if ($q->have_posts()) {
			echo '<div class="amy-movie-recent"><h3 class="info-name amy-title">' . $title . '</h3><ul>';

			while ($q->have_posts()) {
				$q->the_post();
				setup_postdata($post);

				$recent_movie = new Movie();
				$recent_movie->set_movie($post->ID);

				echo '<li><a href="' . $recent_movie->get_url() . '">' . $recent_movie->render_html_poster($base->get_image_size('recent_movie')) . '<p>' . get_the_title() . '</p></a></li>';

			}

			echo '</ul></div>';
		}

		wp_reset_postdata();
		wp_reset_query();
	?>
<?php endif; ?>
