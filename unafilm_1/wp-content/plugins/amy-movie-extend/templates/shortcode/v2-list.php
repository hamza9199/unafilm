<?php
use AmyMovie\Core\Template;

$template = new Template();

$max = intval($movie_list_query->max_num_pages);
?>

<div class="amy-movie-layout-list <?php echo esc_attr($class); ?>">
    <div class="amy-movie-list">
        <div class="amy-movie-items">
            <?php
            if ($movie_list_query->have_posts()) :
                while ($movie_list_query->have_posts()) :
                    $movie_list_query->the_post();

                    set_query_var('showtime_type', $showtime_type);
                    set_query_var('show_showtime', $show_showtime);
                    set_query_var('list_fields_visible', $list_fields_visible);
                    set_query_var('general_fields_tooltip', $general_fields_tooltip);
                    $template->get_template_part('/shortcode/single/v2-list');

                endwhile;
            endif;

            if ($pagination == true && $max >= 2) {
                echo '<div class="amy-pagination">';

                echo amy_movie_pagination(array('max_pages' => $max));
                echo '</div>';
            }

            wp_reset_postdata();
            wp_reset_query();
            ?>
        </div>
    </div>
</div>