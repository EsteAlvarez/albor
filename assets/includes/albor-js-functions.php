<?php

function albor_js_functions()
{
    wp_enqueue_script('albor-masonry', 'https://unpkg.com/flexmasonry/dist/flexmasonry.js', array(), null, true);
    wp_enqueue_script('albor-gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js', array(), null, true);
    wp_enqueue_script('albor-gsap-splittext', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js', array(), null, true);
    wp_enqueue_script('albor-gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js', array(), null, true);
    wp_enqueue_script('albor-animations', get_template_directory_uri() . '/assets/js/albor-animations.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('albor-scripts', get_template_directory_uri() . '/assets/js/albor-scripts.js', array(), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'albor_js_functions');
