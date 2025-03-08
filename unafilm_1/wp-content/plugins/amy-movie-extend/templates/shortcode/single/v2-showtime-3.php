<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Shortcode\ShortcodeHtml;

$base           = new Base();
$movie_helper   = new MovieHelpers();

$single_movie 	= new Movie();
$single_movie->set_movie($data->movie->ID);

$sc_html        = new ShortcodeHtml();
$sc_html->set_movie($data->movie->ID);

$general_fields_tooltip = $data->general_fields_tooltip;
$list_fields_visible    = $data->list_fields_visible;
$start_date             = $data->start_date;

?>
<div class="amy-movie-item">
    <div class="amy-movie-item-inner">
        <div class="amy-movie-item-front">
            <div class="amy-movie-item-poster">
                <?php echo $sc_html->poster($base->get_image_size('v2_st_3')); ?>
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
            </div>
        </div>

        <?php if ($sc_html->v2_showtime_3_layout_showtime($start_date)) : ?>
        <div class="amy-movie-item-showtimes amy-item-<?php echo $data->movie->ID; ?>">
            <?php echo $sc_html->v2_showtime_3_layout_showtime($start_date); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
