<?php
/*
Template Name: View all feeds
*/

// Get RSS Feed(s)
include_once(ABSPATH . WPINC . '/feed.php');


$the_query = new WP_Query(array('post_type' => array('blog'), 'publish' => 'Published'));
if ($the_query->have_posts()) {

    while ($the_query->have_posts()) {
        $the_query->the_post();
        $feeds[] = get_post_meta(get_the_id(), 'url')[0];

    }
}
/* Restore original Post Data */
wp_reset_postdata();

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

<div class="well well-lg">
    <h1><?= the_title(); ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post();
        the_content();
    endwhile; endif; ?>
</div>

<?php if ($maxitems == 0) : ?>
    <p>We currently don't have any items - please check back later</p>
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