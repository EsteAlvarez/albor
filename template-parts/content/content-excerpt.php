<?php

/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package albor
 */

?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="flex flex-col gap-1">
		<h2 class="text-[2.5rem]"><?php the_title(); ?></h2>
		<p class="text-[1.5rem]"><?php echo get_the_excerpt(); ?></p>
		<a class="flex items-center gap-4 w-fit font-medium albor-link" href="<?php the_permalink(); ?>">Ver Proyecto <i class="iconoir-arrow-right"></i>
		</a>
	</div>
</li><!-- #post-${ID} -->