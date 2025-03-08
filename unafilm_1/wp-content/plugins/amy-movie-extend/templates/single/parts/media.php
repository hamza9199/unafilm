<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

global $post;

$transition = new Transition();
$base = new Base();
$single_movie = new Movie();
$single_movie->set_movie($post->ID);

// media
$media		= [];
$gallery	= $single_movie->get_gallery();
$trailer    = $single_movie->get_trailer_list();

$gallery 	= explode(',', $gallery);

if (!empty($gallery)) {
	foreach ($gallery as $g) {
		$media[] = $g;
	}
}

if (!empty($trailer)) {
    foreach ($trailer as $tr) {
        $media[] = $tr;
    }
}

// Carousel
$slick  = '{';
$slick .= '"slidesToShow":4,"slidesToScroll":4,';
$slick .= '"autoplay":true,';
$slick .= '"autoplaySpeed":3000,';
$slick .= '"arrows":true,';
$slick .= '"infinite":true,';

$slick .= '"responsive": [' .
	'{"breakpoint": 480,"settings": {"slidesToShow": 1,"slidesToScroll": 1}},' .
	'{"breakpoint": 979,"settings": {"slidesToShow": 3,"slidesToScroll": 3}}' .
	'],';

$slick .= '"dots":false';
$slick .= '}';

?>

<?php if (!empty($tralier) || !empty($media)) : ?>
<div class="entry-media">
	<h3 class="info-name amy-title"><?php echo $transition->get_string_translate('Video Photo'); ?></h3>
	<div class="number-media">
		<?php if (!empty($tralier)) : ?>
			<span class="video"><i></i><?php echo count($tralier) . ' ' . $transition->get_string_translate('videos'); ?></span>
		<?php endif; ?>
		<?php if (!empty($gallery)) : ?>
			<span class="gallery"><i></i><?php echo count($gallery) .  ' ' . $transition->get_string_translate('photos'); ?></span>
		<?php endif; ?>
	</div>
	<div class="media-carousel">
		<div class="amy-slick" data-slick='<?php echo $slick; ?>'>
			<?php if (!empty($media)) : ?>
				<?php foreach ($media as $i => $m) : ?>
					<div class="media-item">
					<?php
					if (is_numeric($m)) { ?>
						<?php $src = wp_get_attachment_image_src($m, 'full')[0]; ?>
						<a href="<?php echo esc_url($src); ?>" class="amy-fancybox" rel="movie-gallery">
							<img src="<?php echo mr_image_resize($src, 200, 150); ?>" />
						</a>
					<?php } else { ?>
						<?php
						if (strpos($m, 'youtube') == true) {
							parse_str(parse_url($m, PHP_URL_QUERY), $youtube);
							echo '<a href="https://www.youtube.com/embed/' . $youtube['v'] . '" class="fancybox.iframe amy-fancybox">';
							echo '<img src="https://img.youtube.com/vi/' . $youtube['v'] . '/hqdefault.jpg"	/>';
							echo '<i class="fa fa-play"></i>';
							echo '</a>';
						} else if (strpos($m, 'vimeo.com') == true) {
							global $wp_filesystem;

							if (empty($wp_filesystem)) {
								require_once(ABSPATH . '/wp-admin/includes/file.php');
								WP_Filesystem();
							}

							$id		= (int) substr(parse_url($m, PHP_URL_PATH), 1);
							$hash 	= unserialize($wp_filesystem->get_contents("https://vimeo.com/api/v2/video/$id.php"));

							echo '<a href="https://player.vimeo.com/video/' . $id . '" class="fancybox.iframe amy-fancybox">';
							echo '<img src="' . $hash[0]['thumbnail_large'] . '" />';
							echo '<i class="fa fa-play"></i>';
							echo '</a>';
						} else if (strpos($m, 'dailymotion.com') == true) {
							$m_id = strtok(basename($m), '_');
							echo '<a href="https://www.dailymotion.com/embed/video/' . $m_id . '" class="fancybox.iframe amy-fancybox">';
							echo '<img src="https://www.dailymotion.com/thumbnail/video/' . $m_id. '" />';
							echo '<i class="fa fa-play"></i>';
							echo '</a>';
						}
						?>
					<?php } ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>