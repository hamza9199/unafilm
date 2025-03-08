<?php
/**
 * @copyright	Copyright (c) 2016 AmyTheme (http://www.amytheme.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('ABSPATH') or die;

if (! function_exists('amy_movie_get_excerpt_by_id')) {
	function amy_movie_get_excerpt_by_id($post_id, $length) {
		$post		= get_post($post_id);
		$excerpt	= $post->post_content;

		$excerpt 	= strip_tags(strip_shortcodes($excerpt));
		$words 		= explode(' ', $excerpt, $length + 1);

		if (count($words) > $length) {
			array_pop($words);
			array_push($words, '...');
			$excerpt = implode(' ', $words);
		}

		$excerpt = '<p>' . $excerpt . '</p>';

		return $excerpt;
	}
}

/**
 * Comment form.
 */
if (! function_exists('amy_movie_comment_form')) {
	function amy_movie_comment_form() {
		$commenter	= wp_get_current_commenter();
		$req		= get_option('require_name_email');
		$aria_req	= $req ? ' aria-required="true"' : '';
		$html_req	= $req ? ' required="required"' : '';

		ob_start();

		$author	= '<div class="row"><div class="col-md-4"><p class="comment-form-author"><label for="author">' . esc_html__('Name', 'amy-movie') . ($req ? ' <span class="required">*</span>' : '') . '</label><input type="text" value="' . esc_attr($commenter['comment_author']) . '" id="author" name="author" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p></div>';
		$email	= '<div class="col-md-4"><p class="comment-form-email"><label for="email">' . esc_html__('Email', 'amy-movie') . ($req ? ' <span class="required">*</span>' : '') . '</label><input type="email" value="' . esc_attr($commenter['comment_author_email']) . '" id="email" name="email" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . '/></p></div>';
		$url	= '<div class="col-md-4"><p class="comment-form-url"><label for="url">' . esc_html__('Website', 'amy-movie') . '</label><input type="url" value="' . esc_attr($commenter['comment_author_url']) . '" id="url" name="url" size="30" maxlength="200" /></p></div></div>';

		$args	= array(
			'title_reply'			=> esc_html__('Write a comment', 'amy-movie'),
			'comment_notes_after'	=> '',
			'fields'				=> apply_filters('comment_form_default_fields', array(
				'author'		=> $author,
				'email'			=> $email,
				'url'			=> $url,
			)),
			'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title amy-title">',
			'title_reply_after'    => '</h3>',
			'comment_field'	=> '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'amy-movie') . ' <span class="required">*</span></label><textarea name="comment" id="comment" cols="45" rows="8" max-length="65525" aria-required="true" required="required"></textarea>',
		);

		comment_form($args);

		$comment_form	= ob_get_clean();
		$comment_form	= str_replace('novalidate', '', $comment_form);

		return $comment_form;
	}
}

/*
 * List Comment
 */
if (! function_exists('amy_movie_custom_list_comment')) {
	function amy_movie_custom_list_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<article class="comment-wrap">
			<div class="comment-avatar">
				<?php echo get_avatar($comment, $args['avatar_size']); ?>
			</div>
			<div class="comment-body">
				<div class="comment-meta">
					<span class="amy-author"><?php echo get_comment_author_link(); ?></span>
					<span class="amy-date"><?php echo get_comment_date(); ?></span>
				</div>
				<p><?php echo get_comment_text(); ?></p>
				<footer>
					<i class="fa fa-reply" aria-hidden="true"></i>
					<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</footer>
			</div>
			<div class="clearfix"></div>
		</article>
		<?php
	}
}

/**
 * Get social links for post.
 */
if (! function_exists('amy_movie_post_social_links')) {
	function amy_movie_post_social_links() {

	}
}

/*
 * Get related posts
 */
if (! function_exists('amy_movie_related_post')) {
	function amy_movie_related_post() {
		global $post;

		$post_recent_by = amy_get_option('post_recent_by', 'category');

		$terms			= wp_get_post_terms($post->ID, $post_recent_by);
		$terms_arr 		= array();
		$orig_post		= $post;

		if (! empty($terms)) {
			foreach ($terms as $term) {
				$terms_arr[] = $term->term_id;
			}

			$args	= array(
				'post_type' 	=> 'post',
				'tax_query'		=> array(
					array(
						'taxonomy'	=> $post_recent_by,
						'field'		=> 'term_id',
						'terms'		=> $terms_arr,
					),
				),

				'post__not_in' 			=> array($post->ID),
				'posts_per_page'		=> 3,
				'ignore_sticky_posts'	=> 1,
			);
			?>
			<h3><?php echo amy_get_option('post_recent_title'); ?></h3>
			<div class="amy-related">
				<div class="row">
					<?php
					query_posts($args);

					if (have_posts()) :
						while (have_posts()) :
							the_post();
					?>
						<article class="col-md-4">
							<div class="entry-thumb"><?php the_post_thumbnail(array(360, 240)); ?></div>
							<?php
							the_title('<h3 class="entry-title p-name" itemprop="name headline"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="u-url url" itemprop="url">', '</a></h3>');
							?>
							<div class="entry-info">
								<span class="entry-date"><?php echo get_the_date(); ?></span>
								<span>/</span>
								<span class="entry-comment"><?php comments_number('0 Comment', '1 Comments', '% Comments'); ?></span>
							</div>
						</article>

					<?php
						endwhile;
					endif;
					?>
				</div>
			</div>
			<?php
			wp_reset_query();

			$post = $orig_post;
		}
	}
}
