<?php
use AmyMovie\Core\Base;

$base           = new Base();

?>

<?php if ($base->get_option('movie_comment') == true) : ?>
	<div class="entry-comment">
		<?php
		comments_template('', true);
		?>
	</div>
<?php endif; ?>
