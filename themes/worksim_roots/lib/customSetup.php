<?php

if (! in_array(get_post_types( '', 'names' ), $post_types)) {
    register_post_type('blog', array(
        'label' => 'Submitted Blog',
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,
    ));
}