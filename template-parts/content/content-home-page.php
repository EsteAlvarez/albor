<?php

/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package albor
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('md:max-w-[75%] sm:max-w-[80%] max-w-[90%] mx-auto my-20'); ?>>

	<!-- Presentation section
 	==================================== -->
	<div class="flex flex-col gap-8">

		<!-- Profile image
 		==================================== -->
		<?php if (get_field('fotografia')): ?>
			<img class="max-w-[220px] aspect-square rounded-full object-cover" src="<?php the_field('fotografia'); ?>" />
		<?php endif; ?>


		<div>
			<!-- Name
 			==================================== -->
			<h1 class="text-[2.5rem]"><?php echo esc_html(get_field('nombre')); ?></h1>

			<!-- Slogan
 			==================================== -->
			<span class="italic text-[1.2rem]"><?php echo esc_html(get_field('slogan')); ?></span>
		</div>

		<!-- biography
 		==================================== -->
		<p id="albor_biography" class="text-[1.5rem] leading-[1.5]"><?php echo wp_kses_post(get_field('biografia')); ?></p>

	</div>

	<!-- Projects section
 	==================================== -->
	<div class="my-20">

		<h2 class="text-[2.5rem]"><?php echo esc_html(get_field('titulo_de_seccion_proyectos')); ?></h2>

		<!-- Projects loop
 		==================================== -->
		<div class="my-25 grid gap-[3rem] md:grid-cols-2 grid-cols-1 relative">
			<?php get_template_part('/assets/modules/photography-module/loop-photography'); ?>
		</div>

	</div>

</div><!-- #post-<?php the_ID(); ?> -->