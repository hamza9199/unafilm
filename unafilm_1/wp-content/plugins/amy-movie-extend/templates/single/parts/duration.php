<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Movie\MovieHelpers;

global $post;

$single_movie   = new Movie();
$single_movie->set_movie($post->ID);
$movie          = new MovieHelpers();

?>

<div class="entry-pg">
	<?php if ($single_movie->get_mpaa()) : ?>
		<span class="pg"><?php echo esc_attr($single_movie->get_mpaa()); ?></span>
	<?php endif; ?>

	<?php if ($single_movie->get_duration()) : ?>
		<span class="duration">
			<i class="fa fa-clock-o"></i>
			<?php echo $movie->convert_time($single_movie->get_duration()); ?>
		</span>
	<?php endif; ?>
</div>
