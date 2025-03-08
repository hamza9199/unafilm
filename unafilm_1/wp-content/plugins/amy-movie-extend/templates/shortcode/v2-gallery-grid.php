<div class="amy-gallery-grid amy-gallery <?php echo esc_attr($class); ?>">
    <div class="gallery-grid-inner amy-lightgallery" data-column="<?php echo esc_attr($column); ?>">
        <?php if (!empty($gallery)) : ?>
            <?php foreach($gallery as $item) : ?>
                <?php
                $src = wp_get_attachment_image_src($item, 'full');
                $src = !empty($src) ? $src[0] : '';
                ?>

        <div class="grid-item col-sm-6 col-md-<?php echo esc_attr(12/$column); ?>" data-src="<?php echo esc_url($src); ?>">
            <a href="<?php echo esc_url($src); ?>" class="amy-fancybox">
                <span class="thumbnail">
                    <?php echo wp_get_attachment_image($item, $img_size); ?>
                </span>
                <span class="fa fa-search"></span>
            </a>
        </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>