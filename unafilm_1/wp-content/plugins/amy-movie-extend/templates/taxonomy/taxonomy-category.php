<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;

get_header();

$template       = new Template();
$base           = new Base();

$template->get_template_part('global/page-header');

$custom_fields	= $base->get_option('movie_custom_fields');

$queried_object = get_queried_object();
$term_id        = $queried_object->term_id;
$term           = get_term($term_id);

$term_data 		= get_term_meta($term_id, AMY_MOVIE_CATEGORY_OPTIONS, true);

$single_sidebar 				= $base->get_value_in_array($term_data, 'sidebar');
$single_layout					= $base->get_value_in_array($term_data, 'layout');
$single_grid_layout				= $base->get_value_in_array($term_data, 'grid_layout');
$single_column					= $base->get_value_in_array($term_data, 'column');
$single_layout2_column			= $base->get_value_in_array($term_data, 'layout2_column');
$single_grid_v2_layout			= $base->get_value_in_array($term_data, 'grid_v2_layout');
$single_grid_v2_column			= $base->get_value_in_array($term_data, 'grid_v2_column');
$single_grid_v2_layout2_column	= $base->get_value_in_array($term_data, 'grid_v2_layout2_column');


$layout			= ($single_sidebar != 'global' && $single_sidebar != '') ? $single_sidebar : esc_attr($base->get_option('genre_layout', 'list'));
$sidebar		= ($single_layout != 'global' && $single_layout != '') ? $single_layout : esc_attr($base->get_option('genre_sidebar', 'right'));
$genre_column	= esc_attr($sidebar == 'full' ? '12' : '8');

$genre_layout	= ($single_layout != 'global' && $single_layout != '') ? $single_layout : $base->get_option('genre_layout');
$grid_layout	= ($single_layout != 'global' && $single_layout != '') ? $single_grid_layout : $base->get_option('grid_layout');
$column			= ($single_layout != 'global' && $single_layout != '') ? $single_column : $base->get_option('column');
$layout2_column	= ($single_layout != 'global' && $single_layout != '') ? $single_layout2_column : $base->get_option('layout2_column');

$grid_v2_layout			= ($single_grid_v2_layout != 'global' && $single_grid_v2_layout != '') ? $single_grid_v2_layout : $base->get_option('grid_v2_layout');
$grid_v2_column			= ($single_grid_v2_column != 'global' && $single_grid_v2_column != '') ? $single_grid_v2_column : $base->get_option('grid_v2_column');
$grid_v2_layout2_column	= ($single_grid_v2_layout2_column != 'global' && $single_grid_v2_layout2_column != '') ? $single_grid_v2_layout2_column : $base->get_option('grid_v2_layout2_column');

$orderby		= $base->get_option('movie_genre_orderby', 'date');
$movie_number	= $base->get_option('movie_number');
$pagination		= $base->get_option('pagination');

?>

<section class="amy-main-content amy-genre amy-<?php echo $layout; ?>">
	<div class="container">
		<div class="row">
			<?php amy_movie_page_sidebar('left', $sidebar); ?>

			<div class="col-md-<?php echo $genre_column; ?>">
			<?php
			if ($genre_layout == 'list') {
				echo do_shortcode('[movielist ' . $term->taxonomy .'="' . $term_id . '" 
									posts_per_page="' . $movie_number . '" 
									post_type="all"
									movie_type="all"
									orderby="' . $orderby . '"
									show_filter="false"
									pagination="' . $pagination . '"]');
			} else if ($genre_layout == 'grid') {
				echo do_shortcode('[moviegrid ' . $term->taxonomy .'="' . $term_id . '" 
									posts_per_page="' . $movie_number . '" 
									pagination="' . $pagination . '" 
									movie_type="all"
									post_type="all"
									orderby="' . $orderby . '"
									layout="' . $grid_layout . '"
									show_filter="false"
									column="' . $column . '"
									layout2_column="' . $layout2_column . '"]');
			} else if ($genre_layout == 'list-2') {
				echo do_shortcode('[movielist_v2 ' . $term->taxonomy . '="' . $term_id . '" 
								posts_per_page="' . $movie_number . '" 
								pagination="' . $pagination . '" 
								movie_type="all"
								post_type="all"
								orderby="' . $orderby . '"
								layout="' . $grid_layout . '"
								column="' . $column . '"
								layout2_column="' . $layout2_column . '"]');
			} else if ($genre_layout == 'grid-2') {
				echo do_shortcode('[amy_moviegrid_v2 ' . $term->taxonomy .'="' . $term_id . '" 
								posts_per_page="' . $movie_number . '" 
								pagination="' . $pagination . '" 
								movie_type="all"
								post_type="all"
								layout="' . $grid_v2_layout . '"
								orderby="' . $orderby . '"
								layout1_columns="' . $grid_v2_column . '"
								layout2_columns="' . $grid_v2_layout2_column . '"]');
			}
			?>
			</div>

			<?php amy_movie_page_sidebar('right', $sidebar); ?>

		</div>
	</div>
</section>

<?php

get_footer();