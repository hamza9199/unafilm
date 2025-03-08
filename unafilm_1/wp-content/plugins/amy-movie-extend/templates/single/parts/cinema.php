<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$base           = new Base();
$single_movie   = new Movie();
$single_movie->set_movie($post->ID);

if ($base->get_option('enable_m_cinema', false) == false) {
	return;
}
?>

<?php if ($base->get_option('is_single_cinema', false) == false) : ?>
    <?php $list_cinema = $single_movie->get_cinema(); ?>
	<?php if ((!empty($list_cinema) && $base->get_option('enable_m_cinema', false) == true) && $base->get_option('movie_showtime', true) == true): ?>
		<div class="entry-showtime">
			<div class="clearfix">
				<h3 class="info-name amy-title"><?php echo $transition->get_string_translate('Showtime'); ?></h3>
			</div>
			<div class="select-cinema">
				<h4><?php echo $transition->get_string_translate('Select a cinema'); ?></h4>
				<ul>
                    <?php foreach ($list_cinema as $i => $cinema) : ?>
                        <li data-cinema="<?php echo $cinema; ?>" data-movie="<?php echo $post->ID; ?>">
                            <?php echo get_the_title($cinema); ?>
                        </li>
                    <?php endforeach; ?>
				</ul>
			</div>
			<div class="showtime">

			</div>
			<div class="clearfix"></div>
		</div>
	<?php endif; ?>
<?php else : ?>
	<div class="entry-showtime single-cinema">
		<div class="clearfix">
			<h3 class="info-name amy-title"><?php echo $transition->get_string_translate('Showtime'); ?></h3>
		</div>
		<div class="showtime">
			<?php echo $single_movie->render_showtime_v2('', $base->get_option('movie_showtime_type'), ''); ?>
		</div>
	</div>
<?php endif; ?>
