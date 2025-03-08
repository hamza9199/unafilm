<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Transition;

$transition = new Transition();
$template = new Template();

$max = intval($movie_v2_grid_query->max_num_pages);

$classx = 'amy-movie-items ';
$classx .= ($layout == 'grid-2') ? 'row' : '';

static $j = 1;
?>

<div class="amy-movie-grid amy-movie-<?php echo esc_attr($layout) . ' ' . esc_attr($class); ?>">
    <div class="amy-movie-list">
        <?php if ($show_button_all) : ?>
            <?php $text = ($all_custom_text != '') ? $all_custom_text : $transition->get_string_translate('See All TV Show'); ?>
            <div class="amy-movie-list-header">
                <a class="btn-link-all" href="<?php echo esc_url($all_custom_link); ?>">
                    <?php echo esc_attr($text); ?>
                    <i class="fa fa-angle-double-right " aria-hidden="true"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php
        if ($layout == 'grid-1' && $tooltip != 'none') {
            echo '<div class="' . esc_attr($classx) . '" data-tooltip-style="' . esc_attr($tooltip) . '" data-column="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="' . esc_attr($classx) . '" data-column="' . esc_attr($columns) . '">';
        }

        if ($movie_v2_grid_query->have_posts()) :
            while ($movie_v2_grid_query->have_posts()) :
                $movie_v2_grid_query->the_post();

                set_query_var('layout', $layout);
                set_query_var('columns', $columns);
                set_query_var('tooltip', $tooltip);
                set_query_var('j', $j);
                set_query_var('general_fields_tooltip', $general_fields_tooltip);
                set_query_var('list_fields_visible', $list_fields_visible);

                $template->get_template_part('/shortcode/single/v2-grid');

            endwhile;
        endif;

        echo '</div>';

        if ($pagination == true && $max >= 2) {
            echo '<div class="amy-pagination">';

            echo amy_movie_pagination(array('max_pages' => $max));
            echo '</div>';
        }

        wp_reset_query();
        wp_reset_postdata();

        $j++;
        ?>
    </div>
</div>