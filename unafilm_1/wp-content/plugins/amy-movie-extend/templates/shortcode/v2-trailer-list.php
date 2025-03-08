<?php

use AmyMovie\Movie\Movie;

$movie = new Movie();

?>
<div class="amy-movie-trailer-list <?php echo esc_attr($class); ?>">
    <div class="trailer-list-wrapper">
        <div class="dark-edges-bg">
            <div class="trailer-list-wrapper-inner">
                <div class="col-md-4 trailer-col-left">
                    <div class="playlist-trailer">
                        <?php
                        if ($movie_from) {
                            $list_movie_id = explode(',', $movies_ids);

                            $i = 1;

                            foreach ($list_movie_id as $movie_id) {
                                $movie->set_movie($movie_id);

                                $gallery		= $movie->get_gallery();
                                $gallery		= explode(',', $gallery);
                                $poster			= !empty($gallery) ? reset($gallery) : '';
                                $banner			= $movie->get_banner();
                                $image			= $banner ? $banner : $poster;

                                $trailer        = $movie->get_first_trailer_link();
                                $video_type		= '';

                                if (strpos($trailer, 'youtube') == true) {
                                    $video_type = 'youtube';
                                } else if (strpos($trailer, 'vimeo.com') == true) {
                                    $video_type = 'vimeo';
                                } else {
                                    $video_type = 'video';
                                }

                                echo '<div class="list-item" 
						data-poster="' . $image . '"
						data-type="' . $video_type . '"
						data-source="' . $trailer . '"
						>';

                                echo '<div class="item-thumb">';
                                echo '<a href="' . $movie->get_url() . '">';
                                echo $movie->render_html_poster(['width' => 70, 'height' => 105, 'is_crop' => true]);
                                echo '</a>';
                                echo '</div>';

                                echo '<div class="item-num">' . $i . '</div>';

                                echo '<div class="item-name">';
                                echo '<h3 class="movie-title">';
                                echo get_the_title($movie_id);
                                echo '</h3>';

                                if ($movie->get_release_date()) {
                                    echo '<span>';
                                    echo $movie->get_format_release_date();
                                    echo '</span>';
                                }

                                echo '</div>';

                                if ($movie->get_imdb()) {
                                    echo '<div class="item-score">';
                                    echo $movie->get_imdb();
                                    echo '</div>';
                                }

                                echo '</div>';

                                $i++;
                            }
                        } else {
                            $j = 1;

                            if (!empty($list_item)) {
                                foreach ($list_item as $item) {
                                    $video_type = '';

                                    if (strpos($item['video_link'], 'youtube') == true) {
                                        $video_type = 'youtube';
                                    } else if (strpos($item['video_link'], 'vimeo.com') == true) {
                                        $video_type = 'vimeo';
                                    } else {
                                        $video_type = 'video';
                                    }

                                    echo '<div class="list-item" 
						data-poster="' . wp_get_attachment_image_src($item['background'], 'full')[0] . '"
						data-type="' . $video_type . '"
						data-source="' . $item['video_link'] . '"
						>';

                                    echo '<div class="item-thumb">' . wp_get_attachment_image($item['poster'], array('70', '105')) . '</div>';
                                    echo '<div class="item-num">' . $j . '</div>';
                                    echo '<div class="item-name"><h3 class="movie-title">' . esc_attr($item['title']) . '</h3></div>';
                                    echo '<div class="item-score">' . esc_attr($item['imdb_rating']) . '</div>';

                                    echo '</div>';

                                    $j++;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-8 trailer-col-right">
                    <div class="video-wrapper">
                        <div class="video-holder-wrapper">
                            <div class="video-holder">
                                <video class="video-js vjs-16-9 vjs-default-skin" id="amyplayer" controls preload="auto"></video>
                            </div>
                            <div class="video-play">
                                <div class="play-text">
                                    <h3>
                                        <?php echo esc_attr($title); ?>
                                    </h3>
                                    <h6><?php echo esc_attr($subtitle); ?></h6>
                                </div>
                                <span class="play-button play-video"><i class="fa fa-play"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>