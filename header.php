<?php

/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package albor
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body id="albor_body_theme" <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="albor_loader" class="fixed inset-0 z-[9999] bg-[#111111] flex items-center justify-center transition-opacity duration-700">
		<span class="loader"></span>
	</div>

	<div id="page">

		<?php get_template_part('assets/includes/albor-screenmode-functions'); ?>

		<a href="#content" class="sr-only"><?php esc_html_e('Skip to content', 'albor'); ?></a>

		<?php get_template_part('template-parts/layout/header', 'content'); ?>

		<div id="content">