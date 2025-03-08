<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Transition;

$transition = new Transition();
$template = new Template();

$start_date = ($day_start_week != '') ? $day_start_week : current_time('m/d/y');

$j = 0;
?>
<div class="amy-movie-showtimews-2 <?php echo esc_attr($class); ?>">
    <div class="amy-movie-showtimews-wrapper">
        <div class="amy-movie-showtimews-row header">
            <div class="amy-movie-showtimews-cell w120"></div>
            <div class="amy-movie-showtimews-cell showtimes-title-cell">
                <div class="showtimes-header-inner">
                    <h3 class="showtimes-title">
                        <?php echo $transition->get_string_translate('Weekly Showtimes'); ?>
                    </h3>
                </div>
            </div>

            <?php for ($i = 0; $i < $number_date; $i++) : ?>
                <?php $date = strtotime($start_date . '+' . $i . ' days'); ?>
                    <div class="amy-movie-showtimews-cell">
                        <h5>
                            <?php echo date_i18n('l', $date); ?>
                        </h5>
                        <div class="showtimes-day">
                            <?php echo date_i18n(get_option('date_format'), $date); ?>
                        </div>
                    </div>
            <?php endfor; ?>

            <div class="amy-movie-showtimews-cell w120"></div>
        </div>

        <?php

        if ($movie_showtime_2_query->have_posts()) :
            while ($movie_showtime_2_query->have_posts()) :
                $movie_showtime_2_query->the_post();

                set_query_var('list_fields_visible', $list_fields_visible);
                set_query_var('general_fields_tooltip', $general_fields_tooltip);
                set_query_var('j', $j);
                set_query_var('number_date', $number_date);
                set_query_var('day_start_week', $day_start_week);

                $template->get_template_part('/shortcode/single/v2-showtime-2');

                $j++;

            endwhile;
        endif;

        wp_reset_postdata();
        wp_reset_query();
        ?>
    </div>
</div>