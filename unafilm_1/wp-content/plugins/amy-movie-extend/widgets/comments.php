<?php
CSF::createWidget('amy_movie_widget_comments', [
    'title'         => esc_html__('+ Amy Movie Comments', 'amy-movie-extend'),
    'classname'     => 'amy-widget-comment',
    'description'   => esc_html__('Widget Comments.', 'amy-movie-extend'),
    'fields'        => [
        array(
            'id'		=> 'title',
            'type'		=> 'text',
            'title'		=> esc_html__('Title', 'amy-movie-extend'),
        ),

        array(
            'id'		=> 'number',
            'type'		=> 'text',
            'title'		=> esc_html__('Number of comments to show', 'amy-movie-extend'),
            'default'	=> '5',
        ),

        array(
            'id'		=> 'class',
            'type'		=> 'text',
            'title'		=> esc_html__('Extra Class', 'amy-movie-extend'),
        ),
    ]
]);

if (!function_exists('amy_movie_widget_comments')) {
    function amy_movie_widget_comments($args, $instance) {
        $number		= empty($instance['number']) ? '' : $instance['number'];
        $class 		= empty($instance['class']) ? '' : $instance['class'];

        echo $args['before_widget'];

        $comments_query = new WP_Comment_Query();
        $comments_query = $comments_query->query(array('number' => $number, 'status' => 'approve'));
        $comment		= '';

        if (!empty($comments_query)) {
            foreach ($comments_query as $comm) {
                $cid 			= $comm->comment_ID;
                $postid			= $comm->comment_post_ID;
                $date_format	= 'd M';

                $comment .= '<div class="entry-item">';

                $comment .= '<div class="entry-thumb">';
                $comment .= '<a href="' . get_permalink($postid) . '#comment-' . $cid . '">';
                $comment .= get_avatar($comm->comment_author_email, '48');
                $comment .= '</a></div>';

                $comment .= '<div class="entry-content">';
                $comment .= '<h2>' . get_comment_author($cid) . '</h2>';
                $comment .= '<span class="entry-date">' . get_comment_date($date_format, $cid) . '</span>';
                $comment .= '<p>' . strip_tags(substr(apply_filters('get_comment_text', $comm->comment_content), 0, 60)) . '...</p>';
                $comment .= '<div class="entry-in"><span>' . esc_html__('In: ', 'amy-movie-extend') . '</span>';
                $comment .= '<a href="' . get_permalink($postid) . '">' . get_the_title($postid) . '</a>';

                $comment .= '</div>';
                $comment .= '<div class="clearfix"></div>';
                $comment .= '</div>';

                $comment .= '</div>';
            }
        }

        $output = '<div class="amy-widget amy-widget-comment ' . $class . '">';

        $output .= '<h4 class="amy-title amy-widget-title">' . $instance['title'] . '</h4>';

        $output .= $comment;

        $output .= '</div>';

        echo $output;

        echo $args['after_widget'];
    }
}
