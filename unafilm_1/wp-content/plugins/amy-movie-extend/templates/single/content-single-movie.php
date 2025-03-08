<?php
use AmyMovie\Core\Template;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;

global $post;

$template       = new Template();
$base           = new Base();
$single_movie   = new Movie();
$single_movie->set_movie($post->ID);

$layout	        = $single_movie->get_layout();
$column	        = ($layout == 'full') ? '12' : '8';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php amy_movie_semantics('post'); ?>>
	<?php if ($layout == 'full') : ?>
		<div class="row amy-single-movie">
			<div class="col-md-4 col-sm-4">
				<div class="entry-thumb">
					<?php echo $single_movie->render_html_poster($base->get_image_size('single_movie_full')); ?>
				</div>
			</div>
			<div class="col-md-8 col-sm-8">
				<div class="entry-info">
					<?php
						$template->get_template_part('single/parts/title');
						$template->get_template_part('single/parts/duration');
						$template->get_template_part('single/parts/info-list');
                        $template->get_template_part('single/parts/button-watch-online');
					?>
				</div>
				<?php
					$template->get_template_part('single/parts/rating');
					$template->get_template_part('single/parts/content');
				?>
			</div>
		</div>
	<?php else : ?>
		<div class="entry-top">
			<div class="entry-poster">
                <?php echo $single_movie->render_html_poster($base->get_image_size('single_movie_has_bar')); ?>
			</div>
			<div class="entry-info">
				<?php
					$template->get_template_part('single/parts/title');
					$template->get_template_part('single/parts/duration');
					$template->get_template_part('single/parts/info-list');
                    $template->get_template_part('single/parts/button-watch-online');
					$template->get_template_part('single/parts/rating');
				?>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php $template->get_template_part('single/parts/content'); ?>
	<?php endif; ?>

	<?php
		$template->get_template_part('single/parts/media');
		$template->get_template_part('single/parts/cinema');
		$template->get_template_part('single/parts/comments');
		$template->get_template_part('single/parts/recent-movie');
	?>
</article>
