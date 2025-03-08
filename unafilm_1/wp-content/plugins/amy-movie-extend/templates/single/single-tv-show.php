<?php
use AmyMovie\Core\Template;
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;

global $post;

$template       = new Template();
$base           = new Base();
$single_movie   = new Movie();
$single_movie->set_movie($post->ID);

get_header();

$template->get_template_part('global/page-header');

$layout	        = $single_movie->get_layout();
$column	        = ($layout == 'full') ? '12' : '8';
$class			= [];

if ($single_movie->get_banner()) {
    $class[] = 'has-banner';
} else {
    $class[] = 'no-banner';
}

?>

    <section class="main-content amy-movie single-movie layout-<?php echo esc_attr($layout); ?> <?php echo implode(' ', $class); ?>">
	<div class="container">
		<div class="row">
			<?php amy_movie_page_sidebar('left', $layout); ?>
			<div class="col-md-<?php echo esc_attr($column); ?>">
				<div class="page-content">
					<?php
					while (have_posts()) {
						the_post();
						$template->get_template_part('single/content-single-tv-show');
					}
					?>
				</div>
			</div>
			<?php amy_movie_page_sidebar('right', $layout); ?>
		</div>
	</div>
</section>

<?php
get_footer();
