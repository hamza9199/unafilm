<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Transition;

get_header();

$template       = new Template();
$base           = new Base();
$single_movie   = new Movie();
$transition     = new Transition();

$queried_object = get_queried_object();
$term_id 		= $queried_object->term_id;
$term 			= get_term($term_id);

$term_data 		= get_term_meta($term_id, AMY_MOVIE_PERSON_OPTIONS, true);

$class = (!empty($term_data['banner']) && $term_data['banner'] != null) ? 'has-banner' : '';

$layout		= $base->get_option('person_sidebar', 'full');
$column		= esc_attr($layout == 'full' ? '12' : '8');
$sidebar 	= $base->get_option('person_widget');

?>

<section class="main-content amy-actor single-actor <?php echo esc_attr($class); ?>">
	<?php if (!empty($term_data['banner'])) : ?>
		<div class="actor-banner">
			<img src="<?php echo $term_data['banner']['url']; ?>" />
		</div>
	<?php endif; ?>
	<div class="container">
		<?php amy_movie_page_sidebar('left', $layout); ?>
		<div class="col-md-<?php echo $column; ?>">
			<div class="row">
				<div class="actor-left col-md-3 col-sm-3">
					<?php if (!empty($term_data['avatar'])) : ?>
						<div class="actor-avatar">
                            <img src="<?php echo $term_data['avatar']['url']; ?>" />
						</div>
					<?php endif; ?>
					<div class="actor-info">
						<ul>
							<?php if (isset($term_data['birth_date'])) : ?>
								<li>
									<label><?php echo $transition->get_string_translate('Birth Day'); ?>:</label>
									<span><?php echo esc_attr($term_data['birth_date']); ?></span>
								</li>
							<?php endif; ?>
							<?php if (isset($term_data['birth_place'])) : ?>
								<li>
									<label><?php echo $transition->get_string_translate('Birth Place'); ?>:</label>
									<span><?php echo esc_attr($term_data['birth_place']); ?></span>
								</li>
							<?php endif; ?>
							<?php if (isset($term_data['gender'])) : ?>
								<li>
									<label><?php echo $transition->get_string_translate('Gender'); ?>:</label>
									<span><?php echo esc_attr($term_data['gender']); ?></span>
								</li>
							<?php endif; ?>
							<?php if (isset($term_data['national'])) : ?>
								<li>
									<label><?php echo $transition->get_string_translate('Nationality'); ?>:</label>
									<span><?php echo esc_attr($term_data['national']); ?></span>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<div class="actor-right col-md-9 col-sm-9">
					<h1 class="actor-name"><?php echo esc_attr($term->name); ?></h1>
					<div class="actor-summary">
						<?php if (isset($term_data['summary']) && !empty($term_data['summary'])) : ?>
							<ul>
								<?php foreach ($term_data['summary'] as $i => $summary) : ?>
									<li><?php echo esc_attr($summary['content']); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
					<div class="actor-biography">
						<h3 class="amy-title"><?php echo $transition->get_string_translate('Biography'); ?></h3>
						<p><?php echo term_description(); ?></p>
					</div>
					<div class="actor-movie">
						<h3 class="amy-title"><?php echo $transition->get_string_translate('Filmography'); ?></h3>
						<?php

						$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));
						$orderby	= $base->get_option('movie_person_orderby');

						$args = array(
							'post_type' => ['amy_movie', 'amy_tvshow'],
							'tax_query' => array(
								array(
									'taxonomy' 	=> $term->taxonomy,
									'field' 	=> 'term_id',
									'terms' 	=> $term_id,
								),
							),
							'posts_per_page'	=> $base->get_option('movie_person_number', 5),
							'paged'				=> $paged,
						);


						if ($orderby == '_rating_average' || $orderby == '_amy_post_views_count' || $orderby == '_release') {
							$args['meta_key'] 	= $orderby;
							$args['orderby']	= 'meta_value_num';
						} else {
							$args['orderby']	= $orderby;
						}

						$movie_person_query = new WP_Query($args);
						?>
						<table>
							<thead>
								<tr>
									<th><?php echo $transition->get_string_translate('Movie Name'); ?></th>
									<th><?php echo $transition->get_string_translate('Release Date'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php

								if ($movie_person_query->have_posts()) :
									while ($movie_person_query->have_posts()) :
										$movie_person_query->the_post();
                                            global $post;
                                            $single_movie->set_movie($post->ID);
										?>
										<tr>
											<td>
                                                <?php if ($single_movie->get_poster()); ?>
												<a href="<?php echo esc_url($single_movie->get_url()); ?>">
													<img src="<?php echo $single_movie->get_poster(); ?>" />
												</a>
                                                <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                                                    <?php echo $single_movie->get_title(); ?>
                                                </a>
											</td>
											<td>
												<?php echo $single_movie->get_format_release_date(); ?>
											</td>
										</tr>
									<?php
									endwhile;
								endif;
								?>
							</tbody>
						</table>
						<?php
						$max = intval($movie_person_query->max_num_pages);

						if ($max >= 2) {
							echo amy_movie_pagination(array('max_pages' => $max));
						}

						wp_reset_postdata();
						?>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<?php amy_movie_page_sidebar('right', $layout); ?>
	</div>
</section>


<?php

get_footer();
