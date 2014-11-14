<?php

class shortcodes
{


    var $message = '';

    function __construct()
    {

        $this->message = array();

        if (isset($_POST['formAction']) && $_POST['formAction'] == 'submitBlog') {
            $this->processForm();
        }
    }

    function prettyMessages()
    {
        if (is_array($this->message)) {
            $return = '';
            foreach ($this->message as $key => $value) {
                $return .= '<div class="alert alert-' . ($key == 'thanks' ? 'success' : 'danger') . '" role="alert"><strong>' . $key . ': </strong>' . $value . '</div>';
            }


            return $return;
        }
    }


    function signupForm()
    {
        ?>
        <form action="" method="POST" class="submitform" role="form">
            <input type="hidden" name="formAction" value="submitBlog">

            <div class="form-group"><label for="frmEmail">Your email address:</label> <input type="email" id="frmEmail"
                                                                                             name="email" required
                                                                                             value="me@paul.gd"
                                                                                             class="form-control"></div>
            <div class="form-group"><label for="frmName">Your Name:</label> <input type="text" id="frmName"
                                                                                   name="personname"
                                                                                   required value="John"
                                                                                   class="form-control">
            </div>
            <div class="form-group"><label for="frmURL">Your blog's RSS Feed:</label> <input type="URL" id="frmURL"
                                                                                             name="url"
                                                                                             required
                                                                                             value="http://swungover.wordpress.com/feed/"
                                                                                             class="form-control"></label>
            </div>
            <? wp_nonce_field('add-blog', 'wp_nonce'); ?>
            <input type="submit" name="submit" value="Submit your blog" class="btn btn-default"/>
        </form>

        <?= $this->prettyMessages() ?>

    <?
    }

    function processForm()
    {

        if (
            !isset($_POST['wp_nonce'])
            || !wp_verify_nonce($_POST['wp_nonce'], 'add-blog')
        ) {

            $message['general'] = "Nonce is wrong";

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
            // Does it already exist?
            $tmpQuery = new WP_Query(
                array(
                    'meta_key' => 'url',
                    'meta_value' => $_POST['url'],
                    'post_type' => 'websites',
                    'post_status' => array('draft', 'published')
                )
            );

             if ($tmpQuery->have_posts()) {
                $message['url'] = "That blog is already on the list, thanks anyway.";
            }
            $currentFeed = fetch_feed($_POST['url']);
            if (!is_wp_error($currentFeed)) {
                $postData['title'] = $currentFeed->get_title();
                $postData['desc'] = $currentFeed->get_description();

            } else {
                $message['error'] = "Can not find feed in your URL";
            }

            if (empty($message)) {
                $my_post = array(
                    'post_title' => $postData['title'],
                    'post_type' => 'websites',
                    'post_content' => $postData['desc'],
                    'post_status' => 'draft'
                );

                // Insert the post into the database
                $post_id = wp_insert_post($my_post);

                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'personname', $_POST['personname']);
                    update_post_meta($post_id, 'email', $_POST['email']);
                    update_post_meta($post_id, 'url', $_POST['url']);

                    $message['thanks'] = "Thank you for submitting your blog (".$postData['title'].")";
                } else {
                    $message[] = "<p><strong>Whoops</strong> There has been an error</p>";
                }
            }

        }


        $this->message = $message;
    }
}

$shortcode = new shortcodes();

add_shortcode("submitBlogForm", array($shortcode, 'signupForm'));