<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package albor
 */

get_header();
?>

<section id="primary">
	<main id="main">

		<?php if (have_posts()) : ?>

			<header class="md:max-w-[75%] sm:max-w-[80%] max-w-[90%] mx-auto my-20">
				<a href="<?php echo get_home_url(); ?>" rel="bookmark" class="flex items-center gap-4 w-fit font-medium albor-link"><i class="iconoir-arrow-left"></i> Volver al inicio</a>
				<?php the_archive_title('<h1 class="text-[2.5rem]">', '</h1>'); ?>
			</header><!-- .page-header -->

			<div class="md:max-w-[75%] sm:max-w-[80%] max-w-[90%] mx-auto my-20">
				<ul class="flex flex-col gap-8">
					<?php
					// Start the Loop.
					while (have_posts()) :
						the_post();
						get_template_part('template-parts/content/content', 'excerpt');

					// End the loop.
					endwhile; ?>
				</ul>
			</div>


		<?php albor_the_posts_navigation();

		else :

			// If no content, include the "No posts found" template.
			get_template_part('template-parts/content/content', 'none');

		endif;
		?>
	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
