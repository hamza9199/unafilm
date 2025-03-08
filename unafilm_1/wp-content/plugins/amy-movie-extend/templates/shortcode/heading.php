<div class="<?php echo esc_attr(implode(' ', $data->sclass)); ?>">
    <header class="entry-header">
        <?php if ($data->seprator): ?>
            <span class="seperator seperator-left" <?php echo $data->style; ?>></span>
        <?php endif; ?>

        <h2 class="title-heading">
            <?php if ($data->title): ?>
                <span style="<?php echo $data->title_style; ?>">
                    <?php echo esc_attr($data->title); ?>
                </span>
            <?php endif; ?>

            <?php if ($data->highlight_title): ?>
                <span class="title-highlight" style="<?php echo $data->highlight_title_style; ?>">
                    <?php echo esc_attr($data->highlight_title); ?>
                </span>
            <?php endif; ?>
        </h2>

        <?php if ($data->seprator): ?>
            <span class="seperator seperator-right" <?php echo $data->style; ?>></span>
        <?php endif; ?>
    </header>

    <?php if ($data->subtitle): ?>
        <div class="subtitle-heading" style="<?php echo $data->subtitle_style; ?>">
            <p>
                <?php echo esc_attr($data->subtitle); ?>
            </p>
        </div>
    <?php endif; ?>
</div>