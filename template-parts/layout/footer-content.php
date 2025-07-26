<?php

/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package albor
 */

?>

<footer id="colophon">

    <?php if (!is_404() && !is_single() && !is_archive()) { ?>
        <div class="my-20 bg-white md:max-w-[75%] sm:max-w-[80%] max-w-[90%] mx-auto flex flex-col justify-between md:p-10 p-3 shadow-xl">

            <!-- Contact form
==================================== -->
            <div class="bg-[#111111] h-full md:p-5 p-3">
                <h2 style="color: #fcfcf7;" class="text-[2.5rem] text-center mb-5">Contáctame</h2>
                <?php if (is_active_sidebar('sidebar-1')) {
                    dynamic_sidebar('sidebar-1');
                } ?>
            </div>

            <!-- Social links
==================================== -->
            <div class="flex justify-end items-center mt-5">
                <?php if (is_active_sidebar('albor_social')) {
                    dynamic_sidebar('albor_social');
                } ?>
            </div>

        </div>
    <?php } ?>

</footer><!-- #colophon -->