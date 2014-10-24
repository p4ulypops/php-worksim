<?php

/*
Template Name: My Custom Page
*/

wp_head();

?>

<h2><?php _e( 'Recent news from Some-Other Blog:', 'my-text-domain' ); ?></h2>

<?php // Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );


// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed( 'http://swungover.wordpress.com/feed/' );

if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    // Figure out how many total items there are, but limit it to 5.
    $maxitems = $rss->get_item_quantity( 4 );

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items( 0, $maxitems );

endif;
?>


    <?php if ( $maxitems == 0 ) : ?>
        <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
    <?php else : ?>
        <?php // Loop through each feed item and display  each item as a hyperlink. ?>
        <?php foreach ( $rss_items as $item ) : ?>
            <article>
                <header><h1><?=$item->get_title();?></h1></header>

                <?= $item->get_content(); ?>
            </article>

        <?php endforeach; ?>
    <?php endif; ?>



<? wp_foot(); ?>
