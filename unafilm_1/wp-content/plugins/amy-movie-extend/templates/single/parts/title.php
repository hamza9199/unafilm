<?php
use AmyMovie\Movie\Movie;

global $post;

$single_movie = new Movie();
$single_movie->set_movie($post->ID);
?>
<h1 class="entry-title p-name" itemprop="name headline">
    <a href="<?php echo esc_url($single_movie->get_url()); ?>" rel="bookmark" class="u-url url" itemprop="url">
        <?php echo esc_attr($single_movie->get_title()); ?>
    </a>
</h1>

