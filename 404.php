<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package albor
 */

get_header();
?>

<section id="primary">
	<main id="main">

		<div class="md:max-w-[75%] sm:max-w-[80%] max-w-[90%] mx-auto py-20 flex flex-col gap-4">
			<header class="page-header">
				<h1 class="font-dm-serif text-[2.5rem]"><?php esc_html_e('Página no encontrada (404)', 'albor'); ?></h1>
			</header><!-- .page-header -->

			<div class="flex flex-col gap-4">
				<p class="text-[1.5rem] leading-[1.5]"><?php esc_html_e('A veces los caminos llevan a lugares que no existen.
Lo que intentas ver no está aquí… o quizá nunca lo estuvo.', 'albor'); ?></p>
				<p class="text-[1.5rem] leading-[1.5]"><?php esc_html_e('Pero el inicio siempre es un buen lugar para reencontrarse.', 'albor'); ?></p>
				<a class="w-fit font-medium albor-link" href="<?php echo get_home_url(); ?>" rel="bookmark"><i class="iconoir-arrow-left"></i> Volver al inicio</a>
			</div><!-- .page-content -->
		</div>

	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
