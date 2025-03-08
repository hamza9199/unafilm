<?php
use AmyMovie\Core\Transition;
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;

$transition = new Transition();
$template   = new Template();
$base       = new Base();

get_header();

$template->get_template_part('global/page-header');

global $post;

$post_id    = $post->ID;

$gallery 	= get_post_meta($post_id, '_gallery', true);
$gallery 	= explode(',', $gallery);

$slick  = '{';
$slick .= '"slidesToShow":8,"slidesToScroll":8,';
$slick .= '"autoplay":false,';
$slick .= '"centerMode":false,';
$slick .= '"arrows":false,';
$slick .= '"infinite":true,';

$slick .= '"responsive": [' .
	'{"breakpoint": 480,"settings": {"slidesToShow": 1,"slidesToScroll": 1}},' .
	'{"breakpoint": 979,"settings": {"slidesToShow": 3,"slidesToScroll": 3}}' .
	'],';

$slick .= '"dots":false';
$slick .= '}';

?>

<section class="main-content amy-cinema single-cinema amy-no-padding">
	<div class="row-bg-gray">
		<div class="cinema-heading">
			<div class="container">
				<h1 class="entry-title p-name" itemprop="name headline"><?php echo get_the_title(); ?></h1>
				<div class="entry-content"><?php echo $post->post_content; ?></div>
			</div>
		</div>
		<div class="cinema-details">
			<div class="bg-dl"></div>
			<div class="cinema-gallery">
				<div class="amy-slick" data-slick='<?php echo $slick; ?>'>
					<?php if (!empty($gallery)) : ?>
						<?php foreach ($gallery as $i => $g) : ?>
							<div class="media-item">
								<?php $src = wp_get_attachment_image_src($g, 'full')[0]; ?>
								<a href="<?php echo esc_url($src); ?>" class="amy-fancybox" rel="movie-gallery">
									<?php echo wp_get_attachment_image($g, array('230', '240')); ?>
								</a>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="cinema-info">
				<div class="container">
					<?php if (get_post_meta($post_id, '_address', true)) : ?>
						<div>
							<label><?php echo $transition->get_string_translate('Address'); ?>:</label>
							<span><?php echo esc_attr(get_post_meta($post_id, '_address', true)); ?></span>
						</div>
					<?php endif; ?>
					<div>
						<?php if (get_post_meta($post_id, '_phone', true)) : ?>
							<label><?php echo $transition->get_string_translate('Phone'); ?>:</label>
							<span><?php echo esc_attr(get_post_meta($post_id, '_phone', true)); ?></span>
						<?php endif; ?>
						<?php if (get_post_meta($post_id, '_email', true)) : ?>
							<label><?php echo $transition->get_string_translate('Email'); ?>:</label>
							<span><?php echo esc_attr(get_post_meta($post_id, '_email', true)); ?></span>
						<?php endif; ?>
					</div>
					<?php if (get_post_meta($post_id, '_website', true)) : ?>
						<div>
							<label><?php echo $transition->get_string_translate('Website'); ?>:</label>
							<span><?php echo esc_attr(get_post_meta($post_id, '_website', true)); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="cinema-movie">
		<div class="container">
			<div class="amy-tab">
				<div class="amy-tab-nav bs-tab-nav">
					<ul>
						<li class="active"><a href="#cinema-m"><?php echo $transition->get_string_translate('Movie'); ?></a></li>
						<li><a href="#cinema-c"><?php echo $transition->get_string_translate('Comments'); ?></a></li>
						<li><a href="#cinema-map"><?php echo $transition->get_string_translate('Map'); ?></a></li>
					</ul>
				</div>
				<div class="amy-tab-contents">
					<div id="cinema-m" class="amy-tab-content active">
						<?php echo do_shortcode('[moviegrid layout="layout2" show_sortby="" movie_number="9" movie_type="" amy_genre="" amy_actor="" amy_director="" layout2_column="3" show_filter="" cinema_id="' . $post->ID . '"]'); ?>
					</div>
					<div id="cinema-c" class="amy-tab-content">
						<?php comments_template('', true); ?>
					</div>
					<div id="cinema-map" class="amy-tab-content">
						<?php echo get_post_meta($post_id, '_map', true); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
