<?php
/*
    Template Name: Blog Submission
*/


$message = [];

if (isset($_POST['submit'])) {

    if (
        !isset($_POST['wp_nonce'])
        || !wp_verify_nonce($_POST['wp_nonce'], 'add-blog')
    ) {

        $message['general'] = "Sorry, something has gone wrong, please try again";

    } else {

        // Email address
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message['email'] = "Please provide valid email address";
        }

        // URL
        if (!filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
            $message['url'] = "Please provide valid URL";
        }
        if (empty($_POST['personname'])) {
            $message['personname'] = "Please let us know your name";
        }

        if (empty($message)) {
            $my_post = array(
                'post_title' => $_POST['personname'] . ' \'s blog',
                'post_type' => 'blog',
                'post_content' => '',
                'post_status' => 'draft'
            );

            // Insert the post into the database
            $post_id = wp_insert_post($my_post);

            if (!is_wp_error($post_id)) {
                update_post_meta($post_id, 'name', $_POST['name']);
                update_post_meta($post_id, 'email', $_POST['email']);
                update_post_meta($post_id, 'url', $_POST['url']);

                $message['thanks'] = "Thank you for submitting your blog";
            } else {
                $message[] = "<p><strong>Whoops</strong> There has been an error</p><p><pre>" . print_r($post_id, true) . "</pre></p>";
            }
        }

    }
}

?>

<div class="well well-lg">
    <h1><?= the_title(); ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post();
        the_content();
    endwhile; endif; ?>
</div>

<form action="" method="POST" class="submitform" role="form">
    <div class="form-group"><label for="frmEmail">Your email address:</label> <input type="email" id="frmEmail"
                                                                                     name="email" required
                                                                                     value="me@paul.gd"
                                                                                     class="form-control"></div>
    <div class="form-group"><label for="frmName">Your Name:</label> <input type="text" id="frmName" name="personname"
                                                                           required value="John" class="form-control">
    </div>
    <div class="form-group"><label for="frmURL">Your blog's RSS Feed:</label> <input type="URL" id="frmURL" name="url"
                                                                                     required
                                                                                     value="http://swungover.wordpress.com/feed/"
                                                                                     class="form-control"></label>
    </div>
    <? wp_nonce_field('add-blog', 'wp_nonce'); ?>
    <input type="submit" name="submit" value="Submit your blog" class="btn btn-default"/>

</form>
<?php if (isset($message) && count($message) > 0) { ?>
    <ul>
        <? foreach ($message as $m) { ?>
            <li><?= $m ?></li>
        <? } ?>
    </ul>
<?php } ?>

