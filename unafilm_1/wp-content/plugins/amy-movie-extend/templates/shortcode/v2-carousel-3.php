<?php
use AmyMovie\Core\Template;

$template = new Template();

?>

<div class="amy-movie-carousel-3d">
    <div class="amy-movie-list">
        <div class="amy-movie-items" data-slick='<?php echo $slick; ?>'>
            <?php
            if ($movie_carousel3_query->have_posts()) :
                while ($movie_carousel3_query->have_posts()) :
                    $movie_carousel3_query->the_post();

                    set_query_var('show_trailer', $show_trailer);
                    $template->get_template_part('/shortcode/single/v2-carousel-3');

                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>