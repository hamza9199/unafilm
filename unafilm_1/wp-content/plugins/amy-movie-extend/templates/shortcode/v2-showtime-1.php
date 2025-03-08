<?php
use AmyMovie\Core\Template;

$template = new Template();

?>
<div class="amy-movie-layout-list amy-movie-showtimews-1 <?php echo esc_attr($class); ?>">
    <div class="amy-movie-list">
        <div class="amy-movie-items">
            <?php
            if ($movie_showtime_1_query->have_posts()) :
                while ($movie_showtime_1_query->have_posts()) :
                    $movie_showtime_1_query->the_post();

                    set_query_var('showtime_type', $showtime_type);
                    set_query_var('list_fields_visible', $list_fields_visible);
                    set_query_var('general_fields_tooltip', $general_fields_tooltip);

                    $template->get_template_part('/shortcode/single/v2-showtime-1');

                endwhile;
            endif;

            wp_reset_query();
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>