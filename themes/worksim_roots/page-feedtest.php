<?php
/*
Template Name: Feed Test
*/

// Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );

wp_head();

?>
<h2><?php _e( 'Recent news from Some-Other Blog:', 'my-text-domain' ); ?></h2>
<?php
$feeds = [
    'http://swungover.wordpress.com/feed/',
    'http://awordonswing.wordpress.com/feed/',
    'http://lindyaffair.wordpress.com/feed/'];

foreach($feeds as $feed) {

    $currentFeed = fetch_feed($feed);
    if (! is_wp_error($currentFeed)) {
        $maxitems = $currentFeed->get_item_quantity(5);
        $current_rss_items = $currentFeed->get_items(0, $maxitems);
    }

    foreach($current_rss_items as $item) {

        $finalArray[] = [
            'title'=> $item->get_title(),
            'content' => $item->get_content(),
            'date' => strtotime($item->get_date()),
            'permalink' => $item->get_permalink(),
        ];
    }
}

usort($finalArray, function($a, $b) {
    return ($a['date'] > $b['date'] ? -1 : 1);
});
?>

    <?php if ( $maxitems == 0 ) : ?>
        <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
    <?php else : ?>
        <?php // Loop through each feed item and display  each item as a hyperlink. ?>
        <?php foreach ( $finalArray as $item ) : ?>
            <article>
                <header>
                    <h1><?=$item['title'];?></h1>
                    <p><a href='<?= $item['permalink']?>' target='_blank'>Read the Original Post</a></p>
                </header>
                <?= $item['content'] ?>
            </article>

        <?php endforeach; ?>
    <?php endif; ?>
<? wp_foot(); ?>
