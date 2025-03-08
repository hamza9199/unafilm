<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

get_header();

global $post;

$transition = new Transition();
$movie      = new MovieHelpers();
$template   = new Template();
$base       = new Base();

$prefix     = $movie->get_stream_season_prefix_name();
$slug       = isset($_GET[$prefix]) ? $_GET[$prefix] : false;

if (!$slug) {
    return;
}

$query_movie    = get_page_by_path($slug, OBJECT, 'amy_season');
$list_episodes  = get_post_meta($query_movie->ID, 'list_episodes', true);


?>
<section class="amy-movie single-movie layout-full">
    <div class="movie-steaming">
        <div class="amy-movie-item-play">
            <div class="container">
                <div class="box-player">
                    <?php
                        $video_link = '';
                        $video_type = '';

                        if (!empty($list_episodes)) {
                            $first      = $list_episodes[0]['list_server'][0];
                            $video_link = $base->get_value_in_array($first, 'link');

                            if (strpos($video_link, 'youtube') == true) {
                                $video_type = 'youtube';
                            } else if (strpos($video_link, 'vimeo') == true) {
                                $video_type = 'vimeo';
                            } else {
                                $video_type = 'video';
                            }
                        }

                    ?>
                    <video id='amyplayer' data-source='<?php echo ($video_link); ?>' data-type='<?php echo ($video_type); ?>' data-poster='' controls playsinline></video>
                </div>
                <div class="div-control">
                    <span class="btn-action btn_lightbulb" title="<?php echo $transition->get_string_translate('Turn off the light'); ?>">
                        <i class="fa fa-lightbulb-o"></i>
                        <span class="turn-off"><?php echo $transition->get_string_translate('Turn off the light'); ?></span>
                        <span class="turn-on"><?php echo $transition->get_string_translate('Turn on the light'); ?></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="amy-movie-item-content-header">
            <div class="container">
                <header class="amy-movie-item-header">
                    <div class="amy-movie-item-header-left">
                        <?php $template->get_template_part('single/parts/title'); ?>
                    </div>
                    <div class="amy-movie-item-header-right">
                        <?php $template->get_template_part('single/parts/social'); ?>
                    </div>
                </header>
                <?php if (!empty($list_episodes)) : ?>
                    <div class="amy-movie-list-server">
                        <?php $j = 0; ?>
                        <?php foreach ($list_episodes as $ep) : ?>
                            <div class="amy-movie-serve-item">
                                <div class="amy-movie-serve-name">
                                    <span>
                                        <i class="fa fa-database"></i>
                                        <?php echo esc_attr($ep['title']); ?>
                                    </span>
                                </div>
                                <?php if (!empty($ep['list_server'])) : ?>
                                    <?php $i = 0; ?>
                                    <div class="amy-movie-serve-options">
                                        <?php foreach ($ep['list_server'] as $s) : ?>
                                            <?php
                                                if ($i == 0 && $j == 0) {
                                                    $classactive = 'active';
                                                } else {
                                                    $classactive = '';
                                                }

                                                if (strpos($s['link'], 'youtube') == true) {
                                                    $data_type = 'youtube';
                                                } else if (strpos($s['link'], 'vimeo.com') == true) {
                                                    $data_type = 'vimeo';
                                                } else {
                                                    $data_type = 'video';
                                                }
                                            ?>
                                            <span class="optinal-link amy-streaming-link <?php echo esc_attr($classactive); ?>" data-type="<?php echo esc_attr($data_type); ?>" data-source="<?php echo esc_url($s['link']); ?>">
                                                <?php echo esc_attr($s['title']); ?>
                                            </span>

                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php $j++; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();