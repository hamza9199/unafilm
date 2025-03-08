<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

$transition     = new Transition();
$base           = new Base();
$movie_helper   = new MovieHelpers();
$single_movie 	= new Movie();
$single_movie->set_movie($movie_id);

$show_title         = $options['show_title'];
$show_release       = $options['show_release'];
$show_content       = $options['show_content'];
$show_button        = $options['show_button'];

$trailer	        = $single_movie->get_first_trailer_link();

$title              = $single_movie->get_title();
$title_array        = explode(' ', $title);
$last_word          = array_pop($title_array);
$modified_last_word = '<span class="last_word">' . $last_word . '</span>';

array_push($title_array,$modified_last_word);

$new_title = implode(' ', $title_array);
?>
<div class="slide-item">
    <div class="slide-thumb">
        <a href="<?php echo esc_url($single_movie->get_url()); ?>">
            <?php echo $single_movie->render_html_banner(); ?>
        </a>
    </div>
    <div class="slide-content">
        <?php if ($show_title) : ?>
        <h2 class="slide-title">
            <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                <?php echo $new_title; ?>
            </a>
        </h2>
        <?php endif; ?>

        <?php if ($show_release) : ?>
            <div class="slide-release">
                <?php echo $transition->get_string_translate('From'); ?>
                <span>
                    <?php echo $single_movie->get_format_release_date('M d'); ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if ($show_content) : ?>
            <div class="slide-desc">
                <?php echo $single_movie->get_excerpt_by_id(); ?>
            </div>
        <?php endif; ?>

        <?php if ($show_button) : ?>
            <div class="slide-button">
                <a href="<?php echo esc_url($movie_helper->convert_tralier_link($trailer)); ?>" class="fancybox.iframe amy-fancybox">
                    <i aria-hidden="true" class="fa fa-play"></i>
                    <?php echo $transition->get_string_translate('Trailer'); ?>
                </a>
                <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                    <i aria-hidden="true" class="fa fa-exclamation"></i>
                    <?php echo $transition->get_string_translate('Detail'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
