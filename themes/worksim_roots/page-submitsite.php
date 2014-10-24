<?php
/*
Template Name: Article Submition
*/

wp_head();

$message = [];

if (isset($_POST['submit'])) {
/*
        if (
            ! isset( $_POST['wp_nonce'] )
            || ! wp_verify_nonce( $_POST['wp_nonce'], 'submit_blog' )
        ) {

          $message['general'] = "Sorry, something has gone wrong, please try again";

        } else {
*/
              // Email address
              if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
                $message['email'] = "Please provide valid email address";
              }
              if (! filter_var($_POST['url'], FILTER_VALIDATE_URL) ) {
                $message['url'] = "Please provide valid URL";
              }
              if (empty($_POST['personname']) ) {
                $message['personname'] = "Please let us know your name";
              }


            $my_post = array(
              'post_title'     => $_POST['personname'].' \'s blog',
              'post_type'    => 'blog',
              'post_content'  => 'This is my post.',
              'post_status'   => 'draft'
            );

            // Insert the post into the database
            $post_id = wp_insert_post( $my_post );

            if (! is_wp_error($post_id)) {
              update_post_meta($post_id, 'name', $_POST['name']);
              update_post_meta($post_id, 'email', $_POST['email']);
              update_post_meta($post_id, 'url', $_POST['url']);

              $message['thanks'] = "Thank you for submitting your blog (".$post_id.")";
            } else {
              $message[] = print_r($post_id, true);
            }

   // }
}
?>

<h1>Submit a Blog</h1>

<form action="" method="POST" class="submitform">
  <label for="frmEmail">Your email address: <input type="email" id="frmEmail" name="email" required value="me@paul.gd"></label>
  <label for="frmName">Your Name: <input type="text" id="frmName" name="personname" required value="John"></label>
  <label for="frmURL">Your blog's RSS Feed: <input type="URL" id="frmURL" name="url" required value="http://swungover.wordpress.com/feed/"></label>
  <input type="submit" name="submit" value="Submit your blog" />

  <?php // if (isset($message) && count($mesage) > 0) { ?>
      <ul>
        <li>
          <?= implode("</li><li>", $message) ?>
        </li>
      </ul>
  <?php // } ?>

</form>



<?php wp_foot();?>
