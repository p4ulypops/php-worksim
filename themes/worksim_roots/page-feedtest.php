<?php
/*
Template Name: Display Feeds
*/

// Get RSS Feed(s)
include_once(ABSPATH . WPINC . '/feed.php');

wp_head();

?>
<h2><?php _e('Recent news from Some-Other Blog:', 'my-text-domain'); ?></h2>
<?php

// The Query
$the_query = new WP_Query(array('post_type' => array('blog'), 'publish' => 'Published'));
//echo '.........'.print_r($the_query,);
// The Loop
if ($the_query->have_posts()) {
    //echo '<ul>';
    while ($the_query->have_posts()) {
        $the_query->the_post();
        $feeds[] = get_post_meta(get_the_id(), 'url')[0];

    }
}
/* Restore original Post Data */
wp_reset_postdata();


//Whippet::print_r($feeds);
//exit();

foreach ($feeds as $feed) {

    $currentFeed = fetch_feed($feed);
    if (!is_wp_error($currentFeed)) {
        $maxitems = $currentFeed->get_item_quantity(5);
        $current_rss_items = $currentFeed->get_items(0, $maxitems);
    }

    foreach ($current_rss_items as $item) {

        $finalArray[] = [
            'title' => $item->get_title(),
            'content' => $item->get_content(),
            'date' => strtotime($item->get_date()),
            'permalink' => $item->get_permalink(),
        ];
    }
}

usort($finalArray, function ($a, $b) {
    return ($a['date'] > $b['date'] ? -1 : 1);
});
?>

<?php if ($maxitems == 0) : ?>
    <li><?php _e('No items', 'my-text-domain'); ?></li>
<?php else : ?>
    <?php foreach ($finalArray as $item) : ?>
        <article>
            <header>
                <h1><?= $item['title']; ?></h1>

                <p><a href='<?= $item['permalink'] ?>' target='_blank'>Read the Original Post</a></p>
            </header>
            <?= $item['content'] ?>
        </article>

    <?php endforeach; ?>
<?php endif; ?>
<? wp_foot(); ?>
