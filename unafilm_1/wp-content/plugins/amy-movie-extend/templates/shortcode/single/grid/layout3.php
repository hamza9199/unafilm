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
            <h4 class="entry-title">
                <?php echo $single_movie->get_title(); ?>
            </h4>

            <?php if ($single_movie->render_taxonomy_template('amy_genre')) : ?>
                <div class="entry-genre">
                    <?php echo $single_movie->render_taxonomy_template('amy_genre'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="back">
            <h3 class="entry-title">
                <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                    <?php echo $single_movie->get_title(); ?>
                </a>
            </h3>

            <?php if($single_movie->get_mpaa()) : ?>
                <span class="pg">
                    <?php echo $single_movie->get_mpaa(); ?>
                </span>
            <?php endif; ?>

            <?php if ($single_movie->get_duration()) : ?>
                <div class="entry-date">
                    <i class="fa fa-clock-o"></i>
                    <?php echo $single_movie->get_format_duration(); ?>
                </div>
            <?php endif; ?>

            <p>
                <?php echo $single_movie->get_excerpt_by_id(20); ?>
            </p>

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

            <div class="movie-char-info">
                <div class="movie-char-info-left">
                    <h6>
                        <?php echo $transition->get_string_translate('Director'); ?>
                    </h6>
                    <p>
                        <?php echo $single_movie->render_taxonomy_template('amy_director'); ?>
                    </p>
                </div>

                <div class="movie-char-info-right">
                    <h6>
                        <?php echo $transition->get_string_translate('Genre'); ?>
                    </h6>
                    <p>
                        <?php echo $single_movie->render_taxonomy_template('amy_genre'); ?>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php if ($average > 0) : ?>
            <div class="entry-rating">
                <ul class="mv-rating-stars">
                    <li class="mv-current-rating" data-point="<?php echo round($average / 5, 2) * 100; ?>%"></li>
                </ul>
                <span class="mcount">
                        <?php echo $single_movie->get_rate_total_count() . ' ' . $transition->get_string_translate('votes'); ?>
                    </span>
                <span class="rate">
                        <?php echo $average; ?>
                    </span>
            </div>
        <?php endif; ?>
    </article>
</div>