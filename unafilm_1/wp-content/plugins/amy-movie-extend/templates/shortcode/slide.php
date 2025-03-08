<?php
use AmyMovie\Core\Template;

$template = new Template();

?>

<div class="amy-shortcode amy-mv-slide">
    <div class="amy-slick <?php echo esc_attr($class); ?>" data-slick='<?php echo $slick; ?>'>
        <?php
        foreach ($data as $item) {
            set_query_var('movie_id', $item->ID);
            set_query_var('options', [
                'show_title'   => $show_title,
                'show_release' => $show_release,
                'show_content' => $show_content,
                'show_button'  => $show_button
            ]);

            $template->get_template_part('shortcode/single/slide');
        }
        ?>
    </div>
</div>