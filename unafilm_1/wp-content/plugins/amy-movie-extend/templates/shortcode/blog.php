<?php
use AmyMovie\Core\Transition;

$transition = new Transition();

$i = 1;

$layout = $data->layout;
$blog_query = $data->blog_query;
?>
<div class="amy-shortcode amy-mv-blog <?php echo esc_attr($layout) . ' ' . esc_attr($data->class); ?>">
    <?php if ($data->title) : ?>
        <h2 class="amy-shortcode-title amy-title">
            <?php echo esc_attr($data->title); ?>
        </h2>
    <?php endif; ?>

    <div class="row">
        <?php
        if ($blog_query->have_posts()) :
            while ($blog_query->have_posts()) :
                $blog_query->the_post();

                global $post;

                $cat		= get_the_category($post->ID);
                $cat_name	= $cat[0]->name;

                if ($layout == 'layout1') {
                    if ($i == 1 || $i == 4) {
                        echo '<div class="col-md-3 wide">';
                    } else if ($i == 3) {
                        echo '<div class="col-md-6 full">';
                    }
                    
                    echo '<div class="entry-item">';
                    echo '<div class="entry-thumb">';
                    echo get_the_post_thumbnail($post->ID, 'full'); // Thumbnail image
                    echo '<div class="entry-cat">' . $cat_name . '</div>'; // Category name at the bottom
                    echo '</div>'; // Close entry-thumb
                    
                    echo '<div class="entry-content">';
                    echo '<h2 class="entry-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                    
                    if ($i == 3) {
                        echo '<div class="entry-summary">' . get_the_excerpt() . '</div>';
                    }
                    
                    echo '<a class="entry-btn" href="' . get_the_permalink() . '">' . $transition->get_string_translate('Read more') . '</a>';
                    echo '</div>'; // Close entry-content
                    
                    echo '<div class="clearfix"></div>';
                    echo '</div>'; // Close entry-item
                    
                    if ($i == 2 || $i == 3 || $i == 5) {
                        echo '</div>';
                    } 
                    
                } else if ($layout == 'layout2') {
                    if ($i == 1 || $i == 3) {
                        $img_size = array('360', '240');
                        $cl		= 'out';
                    } else if ($i == 2) {
                        $img_size = array('360', '430');
                        $cl		= 'in';
                    }

                    echo '<div class="col-md-4 entry-item ' . esc_attr($cl) . '">';

                    echo '<div class="entry-thumb">' . get_the_post_thumbnail($post->ID, $img_size) . '</div>';
                    echo '<div class="entry-content">';

                    if ($i == 1 || $i == 3) {
                        echo '<div class="left col-md-3">';
                        echo '<div class="entry-date">';
                        echo '<span class="d">' . get_the_date('d') . '</span>';
                        echo '<span class="m">' . get_the_date('M') . '</span>';
                        echo '</div>';
                        echo '<div class="entry-cat">';
                        echo '' . $cat_name . '';
                        echo '</div>';
                        echo '<div class="entry-comment">';
                        echo '<i class="fa fa-comments" aria-hidden="true"></i>';
                        echo '' . wp_count_comments($post->ID)->total_comments . '';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="right col-md-9">';
                        echo '<h2 class="entry-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                        echo '<div class="entry-excerpt">';
                        echo '' . get_the_excerpt() . '';
                        echo '</div>';
                        echo '</div>';
                    } else if ($i == 2) {
                        echo '<div class="entry-cat">' . $cat_name . '</div>';
                        echo '<h2 class="entry-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                    }

                    echo '</div>';
                    echo '</div>';
                }

                $i++;
            endwhile;
        endif;

        echo '<style>
.entry-thumb {
    position: relative;
    display: inline-block;
}

.entry-cat {
    position: absolute;
    top: 10px;
    right: 10px;
    width: auto;
    min-width: 80px; /* Keeps it from being too small */
    max-width: 150px; /* Prevents it from being too wide */
    padding: 5px 15px;
    border-radius: 10px;
    background-color: #4b4b4b;
    color: white;
    text-align: center;
    white-space: nowrap; /* Prevents text from wrapping */
}
</style>';

        
        wp_reset_postdata();
        wp_reset_query();
        ?>
    </div>
</div>