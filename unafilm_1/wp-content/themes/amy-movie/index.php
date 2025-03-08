<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die();

get_header();
get_template_part('partials/page-header');

$layout			= esc_attr(amy_get_option('blog_layout', 'list'));
$page_layout	= esc_attr(amy_get_option('blog_sidebar', 'right'));
$page_column	= esc_attr($page_layout == 'full' ? '12' : '8');

if ($layout == 'masonry' && $page_layout != 'full') {
    ?>
    <section class="amy-main-content amy-blog amy-archive amy-<?php echo $layout; ?>">
        <div class="container">
            <div class="row">
                <?php echo esc_html__('Masonry working only with No Sidebar', 'amy-movie'); ?>
            </div>
        </div>
    </section>
    <?php
} else {
    ?>
    <section class="amy-main-content amy-blog amy-archive amy-<?php echo $layout; ?>">
        <div class="container">
            <div class="row">
                <?php amy_movie_page_sidebar('left', $page_layout); ?>

                <div class="main-content col-md-<?php echo $page_column; ?>">
                    <?php if ($layout == 'masonry') { ?>
                    <?php
                    $i 		= 1;
                    $j 		= 1;
                    $class 	= '';

                    global $wp_query;

                    $post_count = $wp_query->post_count;
                    while (have_posts()) :
                    the_post();
                    ?>

                    <?php if ($i == 4 || $i == 6 || $i == 1) : ?>
                    <div class="row amy-row">
                        <?php endif; ?>

                        <?php
                        if ($i == 4) {
                            $class = 'col-md-8';
                        } else {
                            $class = 'col-md-4';
                        }

                        if ($i == 1 || $i == 3 || $i == 7 || $i == 8) {
                            $class .= ' out';
                        } else if ($i == 2 || $i == 4 || $i == 5 || $i == 6) {
                            $class .= ' in';
                        }
                        ?>
                        <div class="entry-item <?php echo esc_attr($class); ?>">
                            <?php
                            set_query_var('amy_static', $i);
                            get_template_part('partials/page', 'masonry');

                            ?>
                        </div>

                        <?php if ($i == 3 || $i == 5 || $i == 8) : ?>
                    </div>
                <?php endif; ?>

                    <?php if ($post_count < 8 && $i == $post_count) : ?>
                </div>
            <?php endif; ?>

                <?php if ($post_count > 8 && $j == $post_count) : ?>
            </div>
            <?php endif; ?>

            <?php
            $i++;
            $j++;

            if ($i == 9) {
                $i = 1;
            }

            endwhile;

            wp_reset_postdata();
            ?>
            <?php } else { ?>
                <div class="row">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('partials/page', 'loop');
                    endwhile;

                    wp_reset_postdata();
                    ?>
                </div>
            <?php } ?>
            <nav class="amy-pagination">
                <?php // Set Blog Reading Settings to XX for optimum view!!
                global $wp_query;

                $big = 999999999; // need an unlikely integer

                echo paginate_links(
                    array(
                        'base'		=> str_replace($big, '%#%', get_pagenum_link($big)),
                        'format'	=> '?paged=%#%',
                        'current'	=> max(1, get_query_var('paged')),
                        'total'		=> $wp_query->max_num_pages,
                        'end_size'	=> 1,
                        'mid_size'	=> 2,
                    )
                );
                ?>
            </nav>
        </div>

        <?php amy_movie_page_sidebar('right', $page_layout); ?>

        </div>
        </div>
    </section>

    <?php
}

get_footer();
