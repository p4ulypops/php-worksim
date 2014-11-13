<?php

class shortcodes {

    function init()
    {
//        add_shortcode
    }

    function signupForm()
    {
        ?>
        <form action="" method="POST" class="submitform" role="form">
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
    <?
    }
}

$shortcode = new shortcodes();

add_shortcode("submitBlogForm", array($shortcode, 'signupForm'));