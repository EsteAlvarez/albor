<?php

/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package albor
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('md:max-w-[75%] sm:max-w-[80%] max-w-[90%] mx-auto py-20'); ?>>

	<!-- Header section
 	==================================== -->
	<header class="entry-header">
		<a href="<?php echo get_home_url(); ?>" rel="bookmark" class="flex items-center gap-4 w-fit font-medium albor-link"><i class="iconoir-arrow-left"></i> Volver al inicio</a>
		<?php the_title('<h1 class="text-[2.5rem]">', '</h1>'); ?>
	</header>

	<!-- Content section
 	==================================== -->
	<div class="my-20">
		<p class="text-[1.5rem] leading-[1.5]"><?php echo wp_kses_post(get_field('descripcion_del_proyecto')); ?></p>
	</div>

	<!-- Gallery section
 	==================================== -->
	<?php $galeria = get_post_meta(get_the_ID(), '_galeria_fotografias', true);
	if ($galeria) {
		echo '<div class="mt-20 albor-masonry-gallery">';
		foreach ($galeria as $image_id) {
			echo wp_get_attachment_image($image_id, 'large', false);
		}
		echo '</div>';
	} ?>

</article><!-- #post-${ID} -->