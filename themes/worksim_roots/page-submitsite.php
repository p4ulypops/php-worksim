<?php
/*
Template Name: Article Submition
*/

wp_head();

?>

<h1>Submit a Blog</h1>

<form action="" method="post" class="submitform">
  <label for="frmEmail">Your email address: <input type="email" id="frmEmail" name="email"></label>
  <label for="frmName">Your Name: <input type="text" id="frmName" name="name"></label>
  <label for="frmURL">Your blog's RSS Feed: <input type="URL" id="frmURL" name="url"></label>
  <input type="submit" name="submit" value="Submit your blog" />
</form>



<? wp_foot();?>
