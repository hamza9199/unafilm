<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

$transition     = new Transition();
$base           = new Base();
$movie_helper   = new MovieHelpers();
$single_movie 	= new Movie();
$single_movie->set_movie($movie->ID);

$image_size = $base->get_image_size('movie_carousel');
$trailer	= $single_movie->get_first_trailer_link();

?>

<div class="carousel-item">
    <div class="carousel-thumb">
        <a href="<?php echo esc_url($single_movie->get_url()); ?>">
            <?php echo $single_movie->render_html_poster($image_size); ?>
        </a>
    </div>
    <div class="carousel-content">
        <h2 class="carousel-title">
            <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                <?php echo esc_attr($single_movie->get_title()); ?>
            </a>
        </h2>
        <div class="carousel-release">
            <?php echo $transition->get_string_translate('Release'); ?>:
            <span>
                <?php echo esc_attr($single_movie->get_format_release_date('M d, Y')); ?>
            </span>
        </div>
        <div class="carousel-button">
            <a href="<?php echo esc_url($movie_helper->convert_tralier_link($trailer)); ?>" class="fancybox.iframe amy-fancybox">
                <i aria-hidden="true" class="fa fa-play"></i>
                <?php echo $transition->get_string_translate('Trailer'); ?>
            </a>
            <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                <i aria-hidden="true" class="fa fa-exclamation"></i>
                <?php echo $transition->get_string_translate('Detail'); ?>
            </a>
        </div>
    </div>
</div>

