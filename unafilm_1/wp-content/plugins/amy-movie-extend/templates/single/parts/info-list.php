<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Base;
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$base           = new Base();
$single_movie   = new Movie();
$single_movie->set_movie($post->ID);
$movie          = new MovieHelpers();

$list_fields_visible 	= $base->get_option('list_fields_visible');
$custom_fields			= $movie->get_options_custom_fields();

if (empty($list_fields_visible)) {
	return;
}

?>

<ul class="info-list">
	<?php if ($single_movie->render_taxonomy_template('amy_actor') && in_array('movie_actor', $list_fields_visible)) : ?>
        <li>
            <label>
                <?php echo $transition->get_string_translate('Actor'); ?>:
            </label>
            <span>
                <?php echo $single_movie->render_taxonomy_template('amy_actor'); ?>
            </span>
        </li>
	<?php endif; ?>

	<?php if ($single_movie->render_taxonomy_template('amy_director') && in_array('movie_director', $list_fields_visible)) : ?>
        <li>
            <label>
                <?php echo $transition->get_string_translate('Director'); ?>:
            </label>
            <span>
                <?php echo $single_movie->render_taxonomy_template('amy_director'); ?>
            </span>
        </li>
	<?php endif; ?>

	<?php if ($single_movie->render_taxonomy_template('amy_genre') && in_array('movie_genre', $list_fields_visible)) : ?>
        <li>
            <label>
                <?php echo $transition->get_string_translate('Genre'); ?>:
            </label>
            <span>
                <?php echo $single_movie->render_taxonomy_template('amy_genre'); ?>
            </span>
        </li>
	<?php endif; ?>

	<?php if ($single_movie->get_release_date() && in_array('movie_release', $list_fields_visible)) : ?>
        <li>
            <label>
                <?php echo $transition->get_string_translate('Release'); ?>:
            </label>
            <span>
                <?php echo esc_attr($single_movie->get_format_release_date()); ?>
            </span>
        </li>
	<?php endif; ?>

	<?php if ($single_movie->get_language() && in_array('movie_language', $list_fields_visible)) : ?>
        <li>
            <label>
                <?php echo $transition->get_string_translate('Language'); ?>:
            </label>
            <span>
                <?php echo esc_attr($single_movie->get_language()); ?>
            </span>
        </li>
	<?php endif; ?>

	<?php if ($single_movie->get_imdb() && in_array('movie_imdb', $list_fields_visible)) : ?>
        <li>
            <label>
                <?php echo $transition->get_string_translate('IMDB Rating'); ?>:
            </label>
            <span>
                <?php echo esc_attr($single_movie->get_imdb()); ?>
            </span>
        </li>
	<?php endif; ?>

	<?php if (!empty($custom_fields)) : ?>
		<?php foreach ($custom_fields as $field) : ?>
			<?php if ($field['type'] == 'category' || $field['type'] == 'person') : ?>
				<?php
					$name = (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
					$singular_name = (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);
				?>

				<?php if ($single_movie->render_taxonomy_template($singular_name)) : ?>
					<li>
						<label>
                            <?php echo esc_attr($name); ?>
                        </label>
						<span>
                            <?php echo $single_movie->render_taxonomy_template($singular_name); ?>
                        </span>
					</li>
				<?php endif; ?>
			<?php elseif ($field['type'] == 'text') : ?>
				<?php if (get_post_meta($post->ID, sanitize_title($field['name']), true)) : ?>
					<li>
						<label>
                            <?php echo esc_attr($field['name']); ?>:
                        </label>
						<span>
                            <?php echo esc_attr(get_post_meta($post->ID, sanitize_title($field['name']), true)); ?>
                        </span>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ($base->get_option('enable_m_cinema', false) == true && in_array('movie_cinema', $list_fields_visible) && $base->get_option('is_single_cinema', false) == false) : ?>
	<li>
		<label>
            <?php echo $transition->get_string_translate('Cinema'); ?>:
        </label>
		<?php
		if (! empty($cinemas)) {
			$numItems 	= count($cinemas);
			$i 			= 0;

			foreach ($cinemas as $cinema) {
				if (++$i === $numItems) {
					$space = '';
				} else {
					$space = ', ';
				}

				?>
				<a href="<?php echo get_permalink($cinema); ?>"><?php echo get_the_title($cinema); ?></a>
				<?php echo esc_attr($space); ?>
			<?php
			}
		}
		?>
	</li>
	<?php endif; ?>
</ul>