<?php

$image_size = array('264', '355');
$ab_list 	= array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
?>
<div class="amy-movie-actor-<?php echo $layout . ' ' . $class; ?>">
    <div class="amy-movie-actor-<?php echo $layout; ?>-wrapper">
        <?php if ($layout == 'list-text') : ?>
            <?php foreach ($ab_list as $char) : ?>
                <div class="actor-group-text">
                    <div class="characters-first">
                        <?php echo $char; ?>
                    </div>

                    <div class="actor-list-name">
                        <?php if (!empty($person_list_query)) : ?>
                            <?php foreach ($person_list_query as $term) : ?>
                                <?php if (substr($term->name, 0, 1) == $char) : ?>
                                    <div class="col-md-<?php echo 12 / $columns; ?> actor-name">
                                        <a href="<?php echo esc_url(get_term_link($term->term_id, $person)); ?>">
                                            <?php echo $term->name; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <?php if (!empty($person_list_query)) : ?>
                <?php foreach ($person_list_query as $term) : ?>
                    <?php
                    $option_name	= '_custom_options';

                    if ($term->taxonomy == 'amy_actor') {
                        $option_name = '_custom_amy_actor';
                    } else if ($term->taxonomy == 'amy_director') {
                        $option_name = '_custom_amy_director';
                    }

                    $term_data 		= get_term_meta($term->term_id, $option_name, true);

                    if (isset($term_data['avatar'])) {
                        $thumb = '<div class="actor-thumb"><a href="' . esc_url(get_term_link($term->term_id, $person)) . '">' . wp_get_attachment_image($term_data['avatar'], $image_size) . '</a></div>';
                    } else {
                        $thumb = '';
                    }

                    $title = '<h4 class="actor-name"><a href="' . esc_url(get_term_link($term->term_id, $person)) . '">' . $term->name . '</a></h4>';
                    $desc = '<div class="actor-description">' . $term->description . '</div>';

                    if ($layout == 'grid') {
                        echo '<div class="col-md-' . 12 / $columns . ' actor-item">' . $thumb . $title . '</div>';
                    } else if ($layout == 'list') {
                        echo'<div class="actor-item">';
                        echo$thumb;
                        echo'<div class="actor-content">' . $title . $desc . '</div>';
                        echo'</div>';
                    }
                    ?>

                <?php endforeach; ?>
                <?php
                if ($pagination && $posts_per_page != 0) {
                    $term_count 	= get_terms(array('taxonomy' => $person, 'fields' => 'count'));
                    $max_num_pages	= ceil($term_count / (int)$posts_per_page);
                    echo amy_movie_pagination(array('max_pages' => $max_num_pages));
                }
                ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>