<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$base           = new Base();

$custom_fields  = $base->get_option('movie_custom_fields');
?>
<section id="amy-page-header" class="amy-page-header">
	<?php
	if (is_singular('amy_movie') || is_singular('amy_tvshow') || is_singular('amy_season')) {
        $single_movie   = new Movie();
        $single_movie->set_movie($post->ID);

        if ($single_movie->get_banner()) {
            echo $single_movie->render_html_banner();
        } else {
            $layout = $single_movie->get_layout();

            if ($layout != 'full') {
                echo '<div class="amy-page-title"><h1 class="page-title"></h1></div>';
            }
        }
	}

	if (is_singular('amy_cinema')) {
        $banner 	= get_post_meta($post->ID, '_banner', true);

        if (!empty($banner)) {
            echo '<img src="' . $banner['url'] . '" />';
        }
    }

	if (is_tax('amy_genre')) {
	    ?>
        <div class="amy-page-title amy-<?php echo $base->get_option('text_position'); ?>">
            <div class="amy-inner container">
                <h1 class="page-title">
                    <?php echo $transition->get_string_translate('Genre') . ': '; ?>
                    <?php echo single_term_title(); ?>
                </h1>
                <?php amy_movie_breadcrumb(); ?>
            </div>
        </div>
    <?php
    }

    if (!empty($custom_fields)) {
        foreach ($custom_fields as $field) {
            if ($field['type'] == 'category') {
                $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                if(is_tax($singular_name)) { ?>
                    <div class="amy-page-title amy-<?php echo $base->get_option('text_position'); ?>">
                        <div class="amy-inner container">
                            <h1 class="page-title">
                                <?php echo esc_attr($name) . ': '; ?>
                                <?php echo single_term_title(); ?>
                            </h1>
                            <?php amy_movie_breadcrumb(); ?>
                        </div>
                    </div>
                <?php
                }
            }
        }
    }
	?>
</section>
