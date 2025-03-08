<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

get_header();
get_template_part('partials/page-header');

$template       = new Template();
$base           = new Base();
$movie_helper   = new MovieHelpers();
$transition     = new Transition();

$custom_fields		= $movie_helper->get_options_custom_fields();
$defaults_fields	= $movie_helper->get_options_default_fields();

$person_options 	= array();

if (!empty($defaults_fields)) {
	foreach ($defaults_fields as $field) {
		if ($field == 'movie_actor') {
			$person_options[$transition->get_string_translate('Actor')] = 'amy_actor';
		}

		if ($field == 'movie_director') {
			$person_options[$transition->get_string_translate('Director')] = 'amy_director';
		}

		if ($field == 'movie_genre') {
			$person_options[$transition->get_string_translate('Genre')] = 'amy_genre';
		}
	}
}

if (!empty($custom_fields)) {
	foreach ($custom_fields as $field) {
		if ($field['type'] == 'person') {
			$name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
			$singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

			$person_options[$field['name']]	= $singular_name;
		}
	}
}

$filters = [];

foreach ($person_options as $person) {
	if (isset($_GET[$person . '_s'])) {
		$filters[$person] = $_GET[$person . '_s'];
	}
}

$tax_query = '';

if (!empty($filters)) {
	foreach ($filters as $k => $term) {
		if ($term != '') {
		    $tax_query .= ' ' . $k . '=' . $term;
		}
	}
}

$layout			= $base->get_option('search_layout', 'list');
$sidebar		= $base->get_option('search_sidebar', 'right');
$search_column	= esc_attr($sidebar == 'full' ? '12' : '8');

$search_layout	= $base->get_option('search_layout');
$grid_layout	= $base->get_option('search_grid_layout');
$column			= $base->get_option('search_column');
$layout2_column	= $base->get_option('search_layout2_column');

$grid_v2_layout			= $base->get_option('search_grid_v2_layout');
$grid_v2_column			= $base->get_option('search_grid_v2_column');
$grid_v2_layout2_column	= $base->get_option('search_grid_v2_layout2_column');

$orderby		= $base->get_option('movie_search_orderby', 'date');
$movie_number	= $base->get_option('search_movie_number');
$pagination		= $base->get_option('search_pagination');
?>

<section class="amy-main-content amy-genre amy-<?php echo $layout; ?>">
    <div class="container">
        <div class="row">
            <?php amy_movie_page_sidebar('left', $sidebar); ?>

            <div class="col-md-<?php echo $search_column; ?>">
                <?php
                if ($search_layout == 'list') {
                    echo do_shortcode('[movielist ' . $tax_query . '
                                posts_per_page="' . $movie_number . '" 
                                post_type="all"
                                movie_type="all"
                                orderby="' . $orderby . '"
                                show_filter=""
                                keyword="' . $s . '"
                                pagination="' . $pagination . '"]');
                } else if ($search_layout == 'grid') {
                    echo do_shortcode('[moviegrid ' . $tax_query . ' 
                                posts_per_page="' . $movie_number . '" 
                                pagination="' . $pagination . '" 
                                movie_type="all"
                                post_type="all"
                                orderby="' . $orderby . '"
                                layout="' . $grid_layout . '"
                                show_filter=""
                                keyword="' . $s . '"
                                column="' . $column . '"
                                layout2_column="' . $layout2_column . '"]');
                } else if ($search_layout == 'list-2') {
                    echo do_shortcode('[movielist_v2 ' . $tax_query . ' 
                            posts_per_page="' . $movie_number . '" 
                            pagination="' . $pagination . '" 
                            movie_type="all"
                            post_type="all"
                            orderby="' . $orderby . '"
                            layout="' . $grid_layout . '"
                            column="' . $column . '"
                            keyword="' . $s . '"
                            layout2_column="' . $layout2_column . '"]');
                } else if ($search_layout == 'grid-2') {
                    echo do_shortcode('[amy_moviegrid_v2 ' . $tax_query . '
                            posts_per_page="' . $movie_number . '" 
                            pagination="' . $pagination . '" 
                            movie_type="all"
                            post_type="all"
                            layout="' . $grid_v2_layout . '"
                            orderby="' . $orderby . '"
                            keyword="' . $s . '"
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
