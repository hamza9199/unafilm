<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$base           = new Base();
$single_movie   = new Movie();
$single_movie->set_movie($post->ID);

$average    = $single_movie->get_rate_average();
$class      = ['mrate'];
$class[]    = ($base->get_option('enable_movie_rating') == true) ? 'user-rate' : '';
$class[]    = ($average) ? 'has-rate' : 'no-rate';

?>

<div class="entry-action">
	<div class="<?php echo implode(' ', $class); ?>">
		<?php if ($base->get_option('enable_movie_rating') == true) : ?>
			<?php echo $single_movie->render_star(); ?>
		<?php endif; ?>
		<?php if ($average) { ?>
		<ul class="mv-rating-stars">
			<li class="mv-current-rating user-rating" data-point="<?php echo round($average / 5, 2) * 100; ?>%"></li>
		</ul>
		<span class="mcount">
            <?php echo esc_attr($single_movie->get_rate_total_count()) . ' ' . $transition->get_string_translate('votes'); ?>
        </span>
		<span class="rate">
            <?php echo esc_attr($single_movie->get_rate_total_point()); ?>
        </span>
		<?php } ?>
	</div>
	<div class="entry-share">
		<label><?php echo $transition->get_string_translate('Share'); ?>:</label>
		<?php echo $single_movie->render_social_link(); ?>
	</div>
	<div class="clearfix"></div>
</div>
