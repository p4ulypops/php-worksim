<?php


add_action('init', 'setupCustomPosts');

function setupCustomPosts()
{
    register_post_type('websites', array(
        'label' => 'Submitted Websites',
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive' => true,
        'rewrite' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,

    ));
    register_post_type('blogentry', array(
        'label' => 'Submitted Blog Enteries',
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive' => true,
        'show_in_nav_menus' => true,
        'rewrite' => true,
        'query_var' => true,
    ));
}


function namespace_add_custom_types($query)
{
    if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
        $query->set('post_type', array(
            'post', 'nav_menu_item', 'blogentry'
        ));
        return $query;
    }
}

add_filter('pre_get_posts', 'namespace_add_custom_types');