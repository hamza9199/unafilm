<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Transition;

$transition     = new Transition();
$movie_helper   = new MovieHelpers();
$single_movie   = new Movie();
$single_movie->set_movie($movie_id);

$img_size	= $options['img_size'];
$column		= $options['column'];
$sr         = ($column == 5) ? 15 : 12/$column;

$tralier    = $single_movie->get_first_trailer_link();
$average    = $single_movie->get_rate_average();
?>

<div class="col-md-<?php echo esc_attr($sr); ?> grid-item" onclick="">
    <article class="entry-item">
        <div class="front">
            <div class="entry-thumb">
                <?php echo $single_movie->render_html_poster($img_size); ?>
            </div>
            <?php if ($average > 0) : ?>
                <span class="rate">
                    <?php echo esc_attr($average); ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="back">
            <h4 class="entry-title">
                <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                    <?php echo $single_movie->get_title(); ?>
                </a>
            </h4>

            <?php if($single_movie->get_mpaa()) : ?>
                <span class="pg">
                    <?php echo $single_movie->get_mpaa(); ?>
                </span>
            <?php endif; ?>

            <div class="desc-mv">
                <?php if ($single_movie->get_format_release_date()) : ?>
                    <div>
                        <span><?php echo $transition->get_string_translate('Release'); ?>: </span>
                        <?php echo $single_movie->get_format_release_date(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($single_movie->render_taxonomy_template('amy_genre')) : ?>
                    <div>
                        <span><?php echo $transition->get_string_translate('Genre'); ?>: </span>
                        <?php echo $single_movie->render_taxonomy_template('amy_genre'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($single_movie->get_duration()) : ?>
                    <div>
                        <span><?php echo $transition->get_string_translate('Duration'); ?>: </span>
                        <?php echo $single_movie->get_format_duration(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($single_movie->get_language()) : ?>
                    <div>
                        <span><?php echo $transition->get_string_translate('Language'); ?>: </span>
                        <?php echo $single_movie->get_language(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="entry-button">
                <?php if ($tralier) : ?>
                    <a href="<?php echo esc_url($movie_helper->convert_tralier_link($tralier)); ?>" class="fancybox.iframe amy-fancybox">
                        <i aria-hidden="true" class="fa fa-play"></i>
                        <?php echo $transition->get_string_translate('Trailer'); ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                    <i aria-hidden="true" class="fa fa-exclamation"></i>
                    <?php echo $transition->get_string_translate('Detail'); ?>
                </a>
            </div>
        </div>
    </article>
</div>