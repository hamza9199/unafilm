<?php
use AmyMovie\Core\Template;

$template = new Template();

?>
<div class="amy-shortcode amy-mv-grid <?php echo $data->layout; ?>">
    <?php if ($data->title != '') : ?>
        <h2 class="amy-shortcode-title amy-title">
            <?php echo esc_attr($data->title); ?>
        </h2>
    <?php endif; ?>

    <?php

    if ($data->show_filter == 'false') {
        $data->show_filter = false;
    } else {
        $data->show_filter = true;
    }

    if ($data->show_sortby == 'false') {
        $data->show_sortby = false;
    } else {
        $data->show_sortby = true;
    }

    set_query_var('filter_var', [
        'show_filter'   => ($data->show_filter != false) ? true : false,
        'filter_style'  => $data->filter_style,
        'filters'       => $data->filters,
        'show_sortby'   => ($data->show_sortby != false) ? true : false
    ]);

    $template->get_template_part('/shortcode/filter');

    ?>

    <div class="row amy-ajax-content">
        <?php
        foreach ($data->data_content as $item) {
            set_query_var('movie_id', $item->ID);
            set_query_var('options', $data->options);
            $template->get_template_part('/shortcode/single/grid/' . $data->layout);
        }
        ?>
    </div>

    <?php
    if ($data->pagination == true && $data->max >= 2) {
        echo amy_movie_pagination(array('max_pages' => $data->max, 'current_url' => get_permalink()));
    }
    ?>
</div>
