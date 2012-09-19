<?
/**
 * Constants.php
 *
 * This file is intended to group all constants to
 * make it easier for the site administrator to tweak
 * the login script.
 *
 */
 
/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("DB_SERVER", "a.db.shared.orchestra.io");
define("DB_USER", "user_de2dcf27");
define("DB_PASS", "DwpK6A.@FpncQZ");
define("DB_NAME", "db_de2dcf27");

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
define("TBL_USERS", "syn_user");

/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
define("ADMIN_NAME", "root");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 9);
define("MR_LEVEL", 2);
define("MMR_LEVEL",  4);
define("SK_LEVEL",  6);
define("MGR_LEVEL",  8);
define("GUEST_LEVEL", 0);
define("UN_AUTH", "Unauthorized access attpted ! Activity has been recorded");
/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define("SITE_NAME","Agricare Nepal");
define("SITE_URL", "http://localhost/~sudaya/agricare/agricare.php");
define("EMAIL_URL","http://agricarenepal.com:2095/3rdparty/roundcube/?_task=mail");
define("EMAIL_URL2","http://agricarenepal.com:2095/3rdparty/squirrelmail/src/webmail.php");
define("EMAIL_URL3","http://www.agricarenepal.com:2095/horde/login.php?Horde=44490eba2f78ee4de58cb744763db919");
define("EMAIL_FROM_NAME", "AgricareNepal");
define("EMAIL_FROM_ADDR", "info@agricarenepal.com");
define("EMAIL_WEB_MASTER", "info@agricarenepal.com");
define("EMAIL_WELCOME", true);
define("BASE_LINK_URL","agricare.php");

/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
define("ALL_LOWERCASE", true);
define("HOME_PATH","agricare/agricare.php");
define("DEFAULT_PAGE","agricare.php");
define("IMG_WIDTH",150);
define("IMG_HEIGHT",100);

?>
