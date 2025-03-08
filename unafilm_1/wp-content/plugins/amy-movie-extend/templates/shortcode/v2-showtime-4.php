<?php
use AmyMovie\Core\Template;

$template = new Template();
?>

<div class="amy-movie-layout-list amy-movie-showtimews-daily-2 <?php echo $data->class; ?>">
    <div class="amy-movie-list">
        <div class="amy-movie-items">
            <?php
            if ($data->movie_showtime_4_query->have_posts()) :
                while ($data->movie_showtime_4_query->have_posts()) :
                    $data->movie_showtime_4_query->the_post();

                    $template
                        ->set_template_data($data)
                        ->get_template_part('/shortcode/single/v2-showtime-4');

                endwhile;
            endif;

            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>