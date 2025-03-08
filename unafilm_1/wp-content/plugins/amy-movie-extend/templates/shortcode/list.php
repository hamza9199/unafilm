<?php
use AmyMovie\Core\Template;

$template = new Template();
?>
<div class="amy-shortcode amy-mv-list <?php echo esc_attr($class); ?>">
    <?php if ($title != '') : ?>
        <h2 class="amy-shortcode-title amy-title">
            <?php echo esc_attr($title); ?>
        </h2>
    <?php endif; ?>

    <?php
    if ($show_filter == 'false') {
        $show_filter = false;
    } else {
        $show_filter = true;
    }

    if ($show_sortby == 'false') {
        $show_sortby = false;
    } else {
        $show_sortby = true;
    }

    set_query_var('filter_var', [
        'show_filter'   => $show_filter,
        'filter_style'  => $filter_style,
        'filters'       => $filters,
        'show_sortby'   => $show_sortby
    ]);

    $template->get_template_part('/shortcode/filter');
    ?>
    <div class="list-content amy-ajax-content">
        <?php
        foreach ($data as $item) {
            set_query_var('movie_id', $item->ID);
            set_query_var('options', $options);
            $template->get_template_part('/shortcode/single/list');
        }
        ?>
    </div>

    <?php
    if ($pagination == true && $max >= 2) {
        echo amy_movie_pagination(array('max_pages' => $max, 'current_url' => ''));
    }
    ?>
</div>