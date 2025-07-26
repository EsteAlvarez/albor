<?php

function albor_widgets()
{
    register_sidebar(
        array(
            'name' => 'Social',
            'id' => 'albor_social',
            'before_widget' => '<div class="albor-social-wodget w-fit">',
            'after_widget' => '</div>',
        )
    );
}
add_action('widgets_init', 'albor_widgets');
