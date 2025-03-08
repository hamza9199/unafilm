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
<div class="col-md-<?php echo esc_attr($sr); ?> grid-item">
    <article class="entry-item">
        <div class="entry-thumb">
            <?php echo $single_movie->render_html_poster($img_size); ?>
        </div>
        <?php if($single_movie->get_mpaa()) : ?>
            <span class="pg">
                <?php echo $single_movie->get_mpaa(); ?>
            </span>
        <?php endif; ?>
        <div class="entry-content">
            <h4 class="entry-title">
                <?php echo $single_movie->get_title(); ?>
            </h4>

            <?php if ($single_movie->get_duration()) : ?>
                <div class="entry-date">
                    <i class="fa fa-clock-o"></i>
                    <?php echo $single_movie->get_format_duration(); ?>
                </div>
            <?php endif; ?>

            <div class="desc-mv">
                <?php if ($single_movie->get_format_release_date()) : ?>
                    <p>
                        <span><?php echo $transition->get_string_translate('Release'); ?>: </span>
                        <?php echo $single_movie->get_format_release_date(); ?>
                    </p>
                <?php endif; ?>

                <?php if ($single_movie->render_taxonomy_template('amy_genre')) : ?>
                    <p>
                        <span><?php echo $transition->get_string_translate('Genre'); ?>: </span>
                        <?php echo $single_movie->render_taxonomy_template('amy_genre'); ?>
                    </p>
                <?php endif; ?>

                <?php if ($single_movie->get_language()) : ?>
                    <p>
                        <span><?php echo $transition->get_string_translate('Language'); ?>: </span>
                        <?php echo $single_movie->get_language(); ?>
                    </p>
                <?php endif; ?>
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
        </div>
        <div class="clearfix"></div>
    </article>
</div>