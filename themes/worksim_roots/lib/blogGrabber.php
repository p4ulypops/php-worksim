<?php

include_once(ABSPATH . WPINC . '/feed.php');
include_once(ABSPATH . WPINC . '/cron.php');

class blogGrabber
{

    var $blogs = '';


    function init()
    {
        $this->blogs = $this->getBlogs();
        foreach ($this->blogs as $blogID => $blogURL) {
            $this->retrieveBlog($blogURL, $blogID);
        }
    }

    function getBlogs()
    {
        $feeds = [];
        $the_query = new WP_Query(array('post_type' => array('websites'), 'publish' => 'Published'));
        if ($the_query->have_posts()) {

            while ($the_query->have_posts()) {
                $the_query->the_post();
                $feeds[get_the_id()] = get_post_meta(get_the_id(), 'url')[0];

            }
        }
        /* Restore original Post Data */
        wp_reset_postdata();
        return array_unique($feeds);
    }


    function doesHashExist($hash)
    {
        $tmpQuery = new WP_Query(
            array(
                'meta_key' => 'posthash',
                'meta_value' => $hash,
                'post_type' => 'blogentery',
                'post_status' => array('draft', 'publish')
            )
        );

        if ($tmpQuery->have_posts()) {
            return true;
        }

        return false;
    }



    function updateBlogInfo($blogid, $feed) {
        $post_info = [
            'post_title' => $feed->get_title(),
            'ID' => $blogid,
            'post_content' => $feed->get_description(),
            'post_name' => $feed->get_title(),
        ];

        wp_update_post($post_info);

    }
    function retrieveBlog($url, $blog_id)
    {

        $currentFeed = fetch_feed($url);

       // print_r($currentFeed);
       // exit();

        if (!is_wp_error($currentFeed)) {
            $maxitems = $currentFeed->get_item_quantity(10);
            $current_rss_items = $currentFeed->get_items(0, $maxitems);

            $this->updateBlogInfo($blog_id, $currentFeed);
        } else {
            return false;
        }

        foreach ($current_rss_items as $item) {

            // build a hash
            $post_hash = md5($item->get_title() . $item->get_date('Y-m-d H:i:s') . $blog_id);
            //    echo $post_hash."<br/>";
            //  print_r($item); exit();
            if (!$this->doesHashExist($post_hash)) {
                $my_post = [
                    'post_title' => $item->get_title(),
                    'post_date' => $item->get_date('Y-m-d H:i:s'),
                    'post_type' => 'blogentry',
                    'post_content' => $item->get_content(),
                    'post_status' => 'publish'
                ];

                $post_id = wp_insert_post($my_post);
                  echo print_r($post_id, true)." - ";
                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'posthash', $post_hash);
                    update_post_meta($post_id, 'blogParent', $blog_id);
                }

            }
        }
    }
}


$blogGrabber = new blogGrabber();

add_action("GrabBlogs", array($blogGrabber, 'init'));
wp_schedule_event(time(), 'hourly', 'grabBlogs');


add_shortcode("getSubmitedBlogs", array($blogGrabber, 'init'));

?>