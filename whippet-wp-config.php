<?php

/**
 * This file is used by Whippet when you run this wp-content folder without
 * putting it into a WordPress installation. You can put anything here that
 * you would normally put into wp-config.php.
 *
 * At a minimum, this file must contain working database details for the sites
 * that you're trying to run. There's no need to add the rest of the default
 * values, but you can if you like, or if you need to change them.
 *
 * Note: WP_DEBUG has no effect when running sites using Whippet.
 */

/** The name of the database for WordPress */
define('DB_NAME', 'worksim');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');


define('WP_ENV', 'development');
