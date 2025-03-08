<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Transition;

$transition = new Transition();
$template = new Template();

static $j = 1;
?>
<div class="amy-movie-carousel-1 <?php echo esc_attr($class); ?>">
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

        <div class="amy-movie-items amy-slick-carousel" data-tooltip-style="<?php echo esc_attr($tooltip); ?>" data-slick='<?php echo $slick; ?>'>
            <?php
                if ($v2_movie_carousel_1->have_posts()) :
                    while ($v2_movie_carousel_1->have_posts()) :
                        $v2_movie_carousel_1->the_post();

                        set_query_var('j', $j);
                        set_query_var('general_fields_front', $general_fields_front);
                        set_query_var('tooltip', $tooltip);
                        set_query_var('list_fields_visible', $list_fields_visible);
                        set_query_var('general_fields_tooltip', $general_fields_tooltip);

                        $template->get_template_part('/shortcode/single/v2-carousel-1');

                    endwhile;
                endif;

                wp_reset_query();
                wp_reset_postdata();

                $j++;
            ?>
        </div>
    </div>
</div>