<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Shortcode\ShortcodeHtml;

global $post;

$base           = new Base();
$movie_helper   = new MovieHelpers();

$single_movie 	= new Movie();
$single_movie->set_movie($post->ID);

$sc_html        = new ShortcodeHtml();
$sc_html->set_movie($post->ID);

$image_size     = $base->get_image_size('v2_carousel_3');
$trailer	    = $single_movie->get_first_trailer_link();

?>
<div class="amy-movie-item">
    <div class="amy-movie-item-poster">
        <span class="amy-movie-item-button">
            <?php if ($trailer && $show_tralier) : ?>
                <a class="link-trailer amy-fancybox" href="<?php echo esc_url($trailer); ?>">
                    <i class="fa fa-play"></i>
                </a>
            <?php endif; ?>

            <a class="link-detail" href="<?php echo esc_url($single_movie->get_url()); ?>">
                <i class="fa fa-link"></i>
            </a>
        </span>
        <?php echo $single_movie->render_html_poster($image_size, 'reflect'); ?>
    </div>
</div>