<?php

function albor_css_functions()
{
    wp_enqueue_style('albor-fonts', get_template_directory_uri() . '/assets/css/albor-fonts.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('albor-iconoir', 'https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css', array(), null);
    wp_enqueue_style('albor-masonry', 'https://unpkg.com/flexmasonry/dist/flexmasonry.css', array(), null);
    wp_enqueue_style('albor-screenmode', get_template_directory_uri() . '/assets/css/albor-screenmode.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('albor-form', get_template_directory_uri() . '/assets/css/albor-form.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('albor-styles', get_template_directory_uri() . '/assets/css/albor-styles.css', array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'albor_css_functions');
