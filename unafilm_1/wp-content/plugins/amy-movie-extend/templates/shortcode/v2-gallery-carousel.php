<?php
use AmyMovie\Core\Transition;

$transition = new Transition();
?>

<div class="amy-gallery-carousel amy-gallery <?php echo esc_attr($class); ?>">
    <div class="gallery-carousel-inner">
        <div class="gallery-info">
            <?php if ($title) : ?>
                <h3 class="title">
                    <?php echo esc_attr($title); ?>
                </h3>
            <?php endif; ?>

            <?php if ($short_desc) : ?>
                <p class="subtitle">
                    <?php echo esc_attr($short_desc); ?>
                </p>
            <?php endif; ?>

            <?php if ($networks) : ?>
            <div class="amy-post-share">
                <span class="amy-post-share-title">
                    <?php $transition->get_string_translate('Share'); ?>:
                </span>

                <ul class="amy-social-icons">
                    <?php foreach ($networks as $network) : ?>
                        <?php $link = (isset($network['link']) && $network['link']) ? $network['link'] : ''; ?>
                        <li>
                            <a href="<?php echo esc_url($link) ?>" target="_blank">
                                <i class="<?php echo $network['icon']; ?>"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>


            <?php if (!empty($gallery)) : ?>
                <div class="amy-lightgallery gallery-list">
                    <?php foreach ($gallery as $item) : ?>
                        <?php
                        $src = wp_get_attachment_image_src($item, 'full');
                        $src = $src[0];
                        ?>
                        <div class="carousel-item" data-src="<?php echo $src; ?>">
                            <a href="#">
                                <span class="thumbnail"><?php echo wp_get_attachment_image($item, $img_size); ?></span>
                                <span class="fa fa-search"></span>
                            </a>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>