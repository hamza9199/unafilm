<?php
use AmyMovie\Core\Transition;

$transition = new Transition();
?>

<div class="entry-content e-content" itemprop="description articleBody">
	<h3 class="info-name amy-title"><?php echo $transition->get_string_translate('Synopsis'); ?></h3>
	<?php the_content($transition->get_string_translate('Read more')); ?>
	<?php
	wp_link_pages(
		array(
			'before' 		=> '<nav class="amy-page-break amy-pagination">',
			'after'  		=> '</nav>',
			'link_before'	=> '<span class="current">',
			'link_after'	=> '</span>',
		)
	);
	?>
</div>