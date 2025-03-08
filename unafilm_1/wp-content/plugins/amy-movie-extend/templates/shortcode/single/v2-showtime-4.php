<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Shortcode\ShortcodeHtml;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$base           = new Base();
$movie_helper   = new MovieHelpers();

$single_movie 	= new Movie();
$single_movie->set_movie($post->ID);

$sc_html        = new ShortcodeHtml();
$sc_html->set_movie($post->ID);

$general_fields_tooltip = $data->general_fields_tooltip;
$list_fields_visible    = $data->list_fields_visible;
$showtime_type          = $data->showtime_type;
?>
<div class="amy-movie-item row">
    <div class="amy-movie-item-inner col-md-9 col-sm-8">
        <div class="amy-movie-item-front">
            <div class="amy-movie-item-poster">
                <?php echo $sc_html->poster($base->get_image_size('v2_st_4')); ?>
            </div>
        </div>

        <div class="amy-movie-item-back">
            <div class="amy-movie-item-back-inner">
                <div class="amy-movie-item-content">
                    <?php if (in_array('imdb', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->imdb(); ?>
                    <?php endif; ?>

                    <?php if (in_array('title', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->title(); ?>
                    <?php endif; ?>

                    <?php if (in_array('rate', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->rating(); ?>
                    <?php endif; ?>

                    <div class="amy-movie-item-meta">
                        <?php if (in_array('mpaa', $general_fields_tooltip)) : ?>
                            <?php echo $sc_html->mpaa(); ?>
                        <?php endif; ?>

                        <?php if (in_array('duration', $general_fields_tooltip)) : ?>
                            <?php echo $sc_html->duration(); ?>
                        <?php endif; ?>
                    </div>

                    <?php if (in_array('content', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->content(16); ?>
                    <?php endif; ?>

                    <?php echo $sc_html->custom_fields($list_fields_visible); ?>
                </div>

                <div class="amy-movie-item-button">
                    <?php echo $sc_html->button(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-4 amy-movie-item-showtimes">
        <div class="amy-movie-item-showtimes-inner">
            <h3 class="showtimes-title">
                <?php echo $transition->get_string_translate('Select Showtimes'); ?>
            </h3>
            <?php echo $sc_html->v2_showtime_4_layout_showtime($showtime_type); ?>
        </div>
    </div>
</div>