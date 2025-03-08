<?php
use AmyMovie\Core\Template;

$template = new Template();
?>
<div class="amy-shortcode amy-mv-carousel">
    <?php if ($data->title != '') : ?>
        <h2 class="amy-shortcode-title amy-title">
            <?php echo esc_attr($data->title); ?>
        </h2>
    <?php endif; ?>

    <div class="amy-slick <?php echo esc_attr($data->class); ?>" data-slick='<?php echo $data->slick; ?>'>
        <?php foreach ($data->data_content as $item) : ?>
            <?php
                set_query_var('movie', $item);
                $template->get_template_part('shortcode/single/carousel');
            ?>
        <?php endforeach; ?>
    </div>
</div>