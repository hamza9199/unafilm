<?php
use AmyMovie\Movie\Tvshow;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$base           = new Base();
$tv_show        = new Tvshow($post->ID);
$list_episodes  = $tv_show->get_list_episodes();


$i = 1;
?>

<div class="post-navigation" role="navigation">
	<div class="nav-previous">
		<?php previous_post_link('%link', '<span class="post-near">%title</span>'); ?>
	</div>
	<div class="nav-next">
		<?php next_post_link('%link', '<span class="post-near">%title</span>'); ?>
	</div>
</div>
<?php if (!empty($list_episodes)) : ?>
	<div class="entry-season-list">
		<h3 class="info-name amy-title"><?php echo $transition->get_string_translate('Episodes List'); ?></h3>
		<div class="season-list">
			<ul class="season">
				<?php foreach ($list_episodes as $episode) : ?>
					<li>
						<span class="std">
							<?php echo esc_attr($i); ?>
						</span>
						<a href="<?php echo $base->get_value_in_array($episode, 'url'); ?>">
							<?php echo $base->get_value_in_array($episode, 'title'); ?>
						</a>
					</li>
					<?php $i++; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
