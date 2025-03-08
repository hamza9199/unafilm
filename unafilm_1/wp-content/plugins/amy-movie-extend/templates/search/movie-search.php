<?php
use AmyMovie\Core\Base;

get_header();

$base = new Base();

get_template_part('partials/page-header');

$amy_type = isset($_GET['amy_type']) ? $_GET['amy_type'] : '';

if ($amy_type != 'movie') {
	switch ($amy_type) {
		case 'amy_director':
			$args = array(
				'taxonomy' 	=> 'amy_director',
				'name'		=> $s,
			);

			$data = get_terms($args);

			break;

		case 'amy_actor':
			$args = array(
				'taxonomy' 	=> 'amy_actor',
				'name'		=> $s,
			);

			$data = get_terms($args);

			break;

		case 'amy_cinema':
			$args = array(
				's'	=> $s,
				'post_type'			=> 'amy_cinema',
				'posts_per_page'	=> $base->get_option('search_number'),
			);

			$the_query 	= new WP_Query($args);
			$max   		= intval($the_query->max_num_pages);
			$data		= $the_query->posts;

			break;
	}
} else {
	$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

	$args = array(
		's'	=> $s,
		'post_type'			=> array('amy_movie', 'amy_tvshow'),
		'posts_per_page'	=> $base->get_option('search_number'),
		'paged'				=> $paged
	);

	$the_query 		= new WP_Query($args);
	$max   			= intval($the_query->max_num_pages);
	$data			= $the_query->posts;
	$img_size		= array();
	$options		= array();
	$search_layout = $base->get_option('search_layout', 'list');

	if ($search_layout == 'list') {
		$img_size 	= array('205', '347');

		$custom_image_sizes	= $base->get_option('custom_image_sizes');

		if (!empty($custom_image_sizes)) {
			foreach ($custom_image_sizes as $size) {
				if ($size['img_size_name'] == 'Movie List Size') {
					$img_size = array($size['img_size_width'], $size['img_size_height']);
				}
			}
		}

		$options	 = array(
			'img_size'		=> $img_size,
			'max_pages'		=> $max,
			'pagination'	=> true,
			'show_showtime'	=> false,
			'showtime_type'	=> 'all',
			'paged'			=> $paged
		);
	} else if ($search_layout == 'grid') {
		$layout	= $base->get_option('search_grid_layout', 'layout1');
		$column	= ($layout == 'layout2') ? $base->get_option('search_layout2_column', '2') : $base->get_option('search_column', '4');
		$custom_image_sizes	= $base->get_option('custom_image_sizes');

		switch ($layout) {
			case 'layout1':
				$img_size	= array('360', '618');
				break;
			case 'layout2':
				$img_size = array('164', '220');
				break;
			case 'layout3':
				$img_size = array('360', '618');
				break;
			case 'layout4':
				$img_size = array('360', '618');
				break;
		}

		if (!empty($custom_image_sizes)) {
			foreach ($custom_image_sizes as $size) {
				switch ($layout) {
					case 'layout1':
						if ($size['img_size_name'] == 'Movie Grid Layout 1') {
							$img_size = array($size['img_size_width'], $size['img_size_height']);
						}

						break;
					case 'layout2':
						if ($size['img_size_name'] == 'Movie Grid Layout 2') {
							$img_size = array($size['img_size_width'], $size['img_size_height']);
						}

						break;
					case 'layout3':
						if ($size['img_size_name'] == 'Movie Grid Layout 3') {
							$img_size = array($size['img_size_width'], $size['img_size_height']);
						}

						break;
					case 'layout4':
						if ($size['img_size_name'] == 'Movie Grid Layout 4') {
							$img_size = array($size['img_size_width'], $size['img_size_height']);
						}

						break;
				}
			}
		}

		$options	 = array(
			'img_size'		=> $img_size,
			'layout'		=> $layout,
			'column'		=> $column,
			'max_pages'		=> $max,
			'pagination'	=> true,
		);
	}

}

?>
<section class="amy-main-content movie-search">
	<div class="container">
		<?php
		if ($amy_type != 'movie') {
			switch ($amy_type) {
				case 'amy_director':
					if (!empty($data)) {
						?>
						<div class="director-search">
							<?php foreach ($data as $i => $item) : ?>
								<?php if (! is_wp_error($item)) : ?>
									<article>
										<h1 class="entry-title"><a href="<?php echo get_term_link($item, 'amy_director'); ?>"><?php echo esc_attr($item->name); ?></a></h1>
										<div class="entry-summary"><?php echo $item->description; ?></div>
									</article>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
						<?php
					} else {
						echo esc_html__('No Director', 'amy-movie-extend');
					}

					break;

				case 'amy_actor':
					if (!empty($data)) {
						?>
						<div class="actor-search">
							<?php foreach ($data as $i => $item) : ?>
								<?php if (! is_wp_error($item)) : ?>
									<article>
										<h1 class="entry-title"><a href="<?php echo get_term_link($item, 'amy_actor'); ?>"><?php echo esc_attr($item->name); ?></a></h1>
										<div class="entry-summary"><?php echo $item->description; ?></div>
									</article>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
						<?php
					} else {
						echo esc_html__('No Actor', 'amy-movie-extend');
					}

					break;

				case 'amy_cinema':
					if (!empty($data)) {
						?>
						<div class="row cinema-search">
							<?php foreach ($data as $i => $item) :
								$details 	= get_post_meta($item->ID, '_cinema_block_options', true);
							?>
								<div class="col-md-4">
									<?php if (isset($details['cinema_banner'])) : ?>
										<div class="entry-thumb"><?php echo wp_get_attachment_image($details['cinema_banner'], 'full'); ?></div>
									<?php endif; ?>
									<h1 class="entry-title"><a href="<?php echo get_permalink($item->ID); ?>"><?php echo esc_attr($item->post_title); ?></a></h1>
								</div>
							<?php endforeach; ?>
						</div>
						<?php
					} else {
						echo esc_html__('No Cinema', 'amy-movie-extend');
					}

					break;
			}
		} else { ?>
			<?php if (! empty($data)) : ?>
				<?php if ($search_layout == 'list') : ?>
					<div class="amy-shortcode amy-mv-list">
						<?php echo amy_movie_listlayout($data, $options); ?>
					</div>
				<?php elseif ($search_layout == 'grid') : ?>
					<div class="amy-shortcode amy-mv-grid <?php echo esc_attr($layout); ?>">
						<?php echo amy_movie_gridlayout($data, $options); ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php echo esc_html__('No Movie', 'amy-movie-extend'); ?>
			<?php endif; ?>
		<?php
		}
		?>
	</div>
</section>


<?php
get_footer();
