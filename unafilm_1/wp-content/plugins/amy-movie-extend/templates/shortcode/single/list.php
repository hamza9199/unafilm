<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

$transition     = new Transition();
$base           = new Base();
$movie_helper   = new MovieHelpers();
$single_movie   = new Movie();
$single_movie->set_movie($movie_id);

$img_size				= $options['img_size'];
$pagination				= $options['pagination'];
$max					= $options['max_pages'];
$c_url					= isset($options['current_url']) ? $options['current_url'] : '';
$show_showtime			= $options['show_showtime'];
$showtime_type			= $options['showtime_type'];
$list_fields_visible 	= $options['list_fields_visible'];
$list_fields_visible	= explode(',', $list_fields_visible);

$tralier    = $single_movie->get_first_trailer_link();
$average    = $single_movie->get_rate_average();
$cinemas    = $single_movie->get_cinema();
?>

<article class="entry-item clearfix">
    <div class="entry-thumb">
        <a href="<?php echo esc_url($single_movie->get_url()); ?>">
            <?php echo $single_movie->render_html_poster($img_size); ?>
        </a>
    </div>
    <div class="entry-content">
        <h2 class="entry-title">
            <a href="<?php echo esc_url($single_movie->get_url()); ?>">
                <?php echo $single_movie->get_title(); ?>
            </a>
        </h2>
        <div class="info-top">
            <span class="pg">
                <?php echo $single_movie->get_mpaa(); ?>
            </span>

            <?php if ($single_movie->get_duration()) : ?>
                <span class="duration">
                    <i class="fa fa-clock-o"></i>
                    <?php echo $single_movie->get_format_duration(); ?>
                </span>
            <?php endif; ?>
        </div>

        <ul class="info-list">
            <?php if ($single_movie->render_taxonomy_template('amy_actor') && in_array('movie_actor', $list_fields_visible)) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Actor'); ?>:
                    </label>
                    <span>
                        <?php echo $single_movie->render_taxonomy_template('amy_actor'); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($single_movie->render_taxonomy_template('amy_director') && in_array('movie_director', $list_fields_visible)) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Director'); ?>:
                    </label>
                    <span>
                        <?php echo $single_movie->render_taxonomy_template('amy_director'); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($single_movie->render_taxonomy_template('amy_genre') && in_array('movie_genre', $list_fields_visible)) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Genre'); ?>:
                    </label>
                    <span>
                        <?php echo $single_movie->render_taxonomy_template('amy_genre'); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if (!empty($movie_helper->get_options_custom_fields())) : ?>
                <?php foreach ($movie_helper->get_options_custom_fields() as $field) : ?>
                    <?php if ($field['type'] == 'category' || $field['type'] == 'person') : ?>
                        <?php
                        $name = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                        $singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);
                        ?>

                        <?php if ($single_movie->render_taxonomy_template($singular_name) && in_array($singular_name, $list_fields_visible)) : ?>
                            <li>
                                <label>
                                    <?php echo esc_attr($name); ?>
                                </label>
                                <span>
                                    <?php echo $single_movie->render_taxonomy_template($singular_name); ?>
                                </span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($single_movie->get_format_release_date()  && in_array('movie_release', $list_fields_visible)) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Release'); ?>:
                    </label>
                    <span>
                        <?php echo $single_movie->get_format_release_date(); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($single_movie->get_language()  && in_array('movie_language', $list_fields_visible)) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Language'); ?>:
                    </label>
                    <span>
                        <?php echo $single_movie->get_language(); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($single_movie->get_imdb()  && in_array('movie_imdb', $list_fields_visible)) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Imdb'); ?>:
                    </label>
                    <span>
                        <?php echo $single_movie->get_imdb(); ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($base->get_option('enable_m_cinema', false) == true
                && in_array('movie_cinema', $list_fields_visible)
                && $base->get_option('is_single_cinema', false) == false) : ?>
                <li>
                    <label>
                        <?php echo $transition->get_string_translate('Cinema'); ?>:
                    </label>
                    <?php
                    if (! empty($cinemas)) {
                        $numItems 	= count($cinemas);
                        $i 			= 0;

                        foreach ($cinemas as $cinema) {
                            if (++$i === $numItems) {
                                $space = '';
                            } else {
                                $space = ', ';
                            }

                            ?>
                            <a href="<?php echo get_permalink($cinema); ?>"><?php echo get_the_title($cinema); ?></a>
                            <?php echo esc_attr($space); ?>
                            <?php
                        }
                    }
                    ?>
                </li>
            <?php endif; ?>
        </ul>

        <?php if ($average > 0) : ?>
            <div class="mrate">
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

        <?php if ($show_showtime) : ?>
            <a class="showtime-btn" data-src="#entry-showtime-<?php echo esc_attr($movie_id); ?>" href="javascript::void(0);">
                <?php echo $transition->get_string_translate('Showtime'); ?>
                <i class="fa fa-caret-down"></i>
            </a>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>

    <?php if ($show_showtime) : ?>
        <div class="entry-showtime as" id="entry-showtime-<?php echo $movie_id; ?>">
            <?php echo $single_movie->render_showtime_v2( '', $showtime_type, 'tsl'); ?>
        </div>
    <?php endif; ?>
</article>