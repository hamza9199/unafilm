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

$classrow   = ($j%2 == 0) ? 0 : 1;
$start_date = ($day_start_week != '') ? $day_start_week : current_time('m/d/y');
?>
<div class="amy-movie-showtimews-row row-<?php echo $classrow; ?>">
    <div class="amy-movie-showtimews-cell"></div>
    <div class="amy-movie-showtimews-cell">
        <div class="amy-movie-item">
            <div class="amy-movie-item-inner">
                <div class="amy-movie-item-front">
                    <div class="amy-movie-item-poster">
                        <?php echo $sc_html->poster($base->get_image_size('v2_st_2')); ?>

                        <?php if (in_array('imdb', $general_fields_tooltip)) : ?>
                            <?php echo $sc_html->imdb(); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="amy-movie-item-back">
                    <div class="amy-movie-item-back-inner">
                        <div class="amy-movie-item-content">
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
            </div>
        </div>
    </div>

    <?php for ($i = 0; $i < $number_date; $i++) : ?>
        <?php $date 	= strtotime($start_date . '+' . $i . ' days'); ?>
        <div class="amy-movie-showtimews-cell">
            <div class="intro-date-time">
                <div class="th">
                    <?php echo date_i18n('l', $date); ?>
                </div>
                <div class="date">
                    <?php echo date_i18n(get_option('date_format'), $date); ?>
                </div>
            </div>
            <div class="amy-movie-intro-list">
                <?php echo $sc_html->v2_showtime_2_layout_showtime($date); ?>
            </div>
        </div>
    <?php endfor; ?>
    <div class="amy-movie-showtimews-cell"></div>
</div>