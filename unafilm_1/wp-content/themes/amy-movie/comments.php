<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

?>

<div class="amy-comment-form">
	<?php echo amy_movie_comment_form(); ?>
</div>

<?php if (have_comments()) : ?>
	<div class="amy-list-comments">
		<h3>
			<?php echo get_comments_number() . esc_html__(' Comments', 'amy-movie'); ?>
		</h3>

		<ol class="comment-list">
			<?php
			wp_list_comments(array(
				'style'			=> 'ol',
				'callback'		=> 'amy_movie_custom_list_comment',
				'avatar_size'	=> 104,
			));
			?>
		</ol>

		<?php if (get_comment_pages_count() > 1) : ?>
		<nav class="comment-navigation" role="navigation">
			<div class="nav-previous">
				<?php previous_comments_link('<i class="fa fa-angle-left"></i> ' . esc_html__('Older Comments', 'amy-movie')); ?>
			</div>
			<div class="nav-next">
				<?php next_comments_link(esc_html__('Newer Comments', 'amy-movie') . ' <i class="fa fa-angle-right"></i>'); ?>
			</div>
			<div class="clearfix"></div>
		</nav>
		<?php endif; ?>
	</div>
<?php endif; ?>
