<?php
$args = array(
    'post_type' => 'fotografias',
    'posts_per_page' => 6,
    'order' => 'ASC',
    'orderby' => 'date',
);

$query = new WP_Query($args);
$photo_counter = 1;

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $class = ($photo_counter % 2 === 0) ? 'md:mt-[30%] mt-0' : '';
?>

        <figure class="<?php echo trim("$class flex flex-col gap-2"); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('full', array('class' => 'imagen w-full md:max-h-[650px] max-h-[400px] object-cover animated-img')); ?>
            <?php endif; ?>
            <figcaption class="flex flex-col gap-3">
                <h3 class="text-[2rem]"><?php the_title(); ?></h3>
                <p class="text-[1.2rem]"><?php echo get_the_excerpt(); ?></p>
                <a class="flex items-center gap-4 w-fit font-medium albor-link" href="<?php the_permalink(); ?>">Ver Proyecto <i class="iconoir-arrow-right"></i>
                </a>
            </figcaption>
        </figure>

        <?php $photo_counter++; ?>

    <?php }
} else { ?>
    <p>Aún no hay proyectos</p>
<?php }
wp_reset_postdata();
?>