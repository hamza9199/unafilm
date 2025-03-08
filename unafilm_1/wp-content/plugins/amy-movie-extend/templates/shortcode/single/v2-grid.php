<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Shortcode\ShortcodeHtml;

global $post;

$base           = new Base();
$movie_helper   = new MovieHelpers();

$single_movie 	= new Movie();
$single_movie->set_movie($post->ID);

$sc_html        = new ShortcodeHtml();
$sc_html->set_movie($post->ID);

if ($layout == 'grid-1') {
    $size = $base->get_image_size('v2_grid_1');
} else if ($layout == 'grid-2') {
    if ($columns == 2) {
        $size = $base->get_image_size('v2_grid_2');
    } else if ($columns == 3) {
        $size = $base->get_image_size('v2_grid_3');
    } else if ($columns == 4) {
        $size = $base->get_image_size('v2_grid_4');
    }
}

$lengh 	= ($layout == 'grid-1') ? 16 : 10;

$itemclass = ['amy-movie-item'];
$itemclass[] = ($columns == 5) ? 'col-md-15' : 'col-md-' . 12/$columns;
$itemclass[] = ($layout == 'grid-1') ? 'col-sm-4 col-xs-6' : '';
$itemclass[] = ($layout == 'grid-2') ? 'col-sm-6 col-xs-12' : '';
?>
<div class="<?php echo implode(' ', $itemclass); ?>">
    <div class="amy-movie-item-front">
        <?php if ($layout == 'grid-1' && $tooltip != 'none') : ?>
        <div class="amy-movie-item-poster tooltip tooltipstered" data-tooltip-content="#amy-movie-item-<?php echo $j . $j . $post->ID; ?>">
        <?php else : ?>
        <div class="amy-movie-item-poster">
        <?php endif; ?>
            <?php echo $sc_html->poster($size); ?>

            <?php if ($layout == 'grid-1') : ?>
                <?php echo $sc_html->mpaa(); ?>
                <?php echo $sc_html->imdb(); ?>
            <?php endif; ?>

            <?php if ($layout == 'grid-2' && in_array('imdb', $general_fields_tooltip)) : ?>
                <?php echo $sc_html->imdb(); ?>
            <?php endif; ?>
        </div>

        <?php if ($layout == 'grid-1') : ?>
            <div class="amy-movie-item-content">
                <?php echo $sc_html->title(); ?>

                <?php if ($single_movie->get_release_date()) : ?>
                    <div class="amy-movie-field-release-date">
                        <?php echo $single_movie->get_format_release_date(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (($tooltip != 'none' && $layout == 'grid-1') || $layout == 'grid-2') : ?>
    <div class="amy-movie-item-back" id="amy-movie-item-<?php echo $j . $j . $post->ID; ?>">
        <div class="amy-movie-item-back-inner">
            <div class="amy-movie-item-content">
                <?php if ($layout == 'grid-1') : ?>
                    <?php if (in_array('imdb', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->imdb(); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (in_array('title', $general_fields_tooltip)) : ?>
                    <?php echo $sc_html->title(); ?>
                <?php endif; ?>

                <?php if (in_array('rate', $general_fields_tooltip)) : ?>
                    <?php echo $sc_html->rating(); ?>
                <?php endif; ?>

                <div class="amy-movie-item-meta">
                    <?php if (in_array('mpaa', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->mpaa(); ?>
                    <?php endif; ?>

                    <?php if (in_array('duration', $general_fields_tooltip)) : ?>
                        <?php echo $sc_html->duration(); ?>
                    <?php endif; ?>
                </div>

                <?php if (in_array('content', $general_fields_tooltip)) : ?>
                    <?php echo $sc_html->content($lengh); ?>
                <?php endif; ?>

                <?php echo $sc_html->custom_fields($list_fields_visible); ?>
            </div>

            <div class="amy-movie-item-button">
                <?php if (in_array('tralier', $general_fields_tooltip)) : ?>
                    <?php echo $sc_html->button(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>