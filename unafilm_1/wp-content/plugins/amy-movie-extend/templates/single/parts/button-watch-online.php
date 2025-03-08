<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

global $post;

$transition     = new Transition();
$movie          = new MovieHelpers();
?>

<?php if ($movie->enable_stream()) : ?>
    <a href="<?php echo esc_url($movie->get_stream_page_full_url($post->post_name)); ?>" class="amy-redirect-watch-online" style="padding: 10px 25px; background: #fe7900; color: #fff;">
        <span>
            <?php echo $transition->get_string_translate('Watch Online'); ?>
        </span>
    </a>
<?php endif; ?>