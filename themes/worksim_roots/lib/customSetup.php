<?php

$post_types = get_post_types( '', 'names' );


if (! in_array('blog', $post_types)) {
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