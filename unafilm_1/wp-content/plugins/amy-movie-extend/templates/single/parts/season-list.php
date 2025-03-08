<?php
use AmyMovie\Movie\Tvshow;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$tv_show        = new Tvshow($post->ID);
$season_list    = $tv_show->get_season();

$i = 1;
?>

<?php if (!empty($season_list)) : ?>
	<div class="entry-season-list">
		<h3 class="info-name amy-title"><?php echo $transition->get_string_translate('Season List'); ?></h3>
		<div class="season-list">
			<ul>
				<?php foreach ($season_list as $season) : ?>
					<li class="season">
						<span class="std">
							<?php echo esc_attr($i); ?>
						</span>
						<a href="<?php echo get_the_permalink($season['select_season']); ?>">
							<?php echo get_the_title($season['select_season']); ?>
						</a>
					</li>
					<?php $i++; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
