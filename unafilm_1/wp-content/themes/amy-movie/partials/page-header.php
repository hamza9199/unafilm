<?php
/**
 * @copyright Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

if (is_front_page()) {
    return;
}

global $post;

$post_id	= isset($post) ? $post->ID : 0;
$post_id	= is_home() ? get_option('page_for_posts') : $post_id;
$overlay	= amy_get_option('page_header_overlay');

if (is_single()) {
    $title = get_the_title($post_id);
} else if (is_search()) {
    $title = esc_html__('Search: ', 'amy-movie') . esc_attr($_GET['s']);
} else if (is_page_template('page-login.php')) {
    $title = esc_html__('Sign In', 'amy-movie');
} else if (is_category()) {
    $title = esc_html__('Category Archives: ', 'amy-movie') . single_cat_title('', false);
} else if (is_author()) {
    $title = esc_html__('Author Archives: ', 'amy-movie') . get_the_author();
} else if (is_404()) {
    $title = esc_html__('Page not found', 'amy-movie');
} else if (is_archive()) {
    if (is_day()) {
        $title = ' ' . esc_html__('Daily Archives: ', 'amy-movie') . get_the_date() . '';
    } else if (is_month()) {
        $title = ' ' . esc_html__('Monthly Archives: ', 'amy-movie') . get_the_date('F Y') . '';
    } else if (is_year()) {
        $title = ' ' . esc_html__('Yearly Archives: ', 'amy-movie') . get_the_date('Y') . '';
    }
} else if (is_tag()) {
    $title = esc_html__('Tags Archives: ', 'amy-movie') . single_tag_title('', false);
} else {
    $title = esc_attr(get_the_title($post_id));
}
?>

<section id="amy-page-header" class="amy-page-header">
    <div class="amy-page-title amy-<?php echo amy_get_option('text_position'); ?>">
        <div class="amy-inner container">
            <h1 class="page-title">
                <?php echo esc_attr($title); ?>
            </h1>
            <?php amy_movie_breadcrumb(); ?>
        </div>
    </div>
	<?php if ($overlay) : ?>
		<span class="amy-section-overlay"></span>
	<?php endif; ?>
</section>
