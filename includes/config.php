<?php
//modify vars below
// Database
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'dbpass');
define('DB_DATABASE', 'nflpickem');
define('DB_PREFIX', 'nflp_');

define('SITE_URL', 'http://localhost/personal/applications/phppickem/');
define('ALLOW_SIGNUP', false);
define('SHOW_SIGNUP_LINK', false);
define('USER_NAMES_DISPLAY', 3); // 1 = real names, 2 = usernames, 3 = usernames w/ real names on hover
define('COMMENTS_SYSTEM', 'basic'); // basic, disqus, or disabled
define('DISQUS_SHORTNAME', ''); // only needed if using Disqus for comments

define('SEASON_YEAR', '2017');
define('SERVER_TIMEZONE', 'America/Chicago'); // Your SERVER's timezone. NOTE: Game times will always be displayed in Eastern time, as they are on NFL.com. This setting makes sure cutoff times work properly.
define('ALWAYS_HIDE_PICKS', true); // Set to true to hide picks until games are locked out
define('SHOW_TIEBREAKER_POINTS', true); // Set to true to use tiebreaker points, does not affect wins, mainly for bragging rights
define('SHOW_SPREAD', true); // Only display the spreads on the entry form page, does not use spread to determine weekly winners
define('DEFAULT_TIEBREAKER_POINTS', 50); // if using tiebreaker points set default value to fill in on entry form
define('AUTO_UPDATE_SCORES_ENABLED', true);
define('AUTO_UPDATE_SCORES_KEY', 'yoursecretkey');
define('ALT_CUTOFF_SUNDAY', 13); // use 00-13 so early Sunday games don't lock too early, i.e set = 13 for cutoff at 13:00 Eastern.

// ***DO NOT EDIT ANYTHING BELOW THIS LINE***
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);

//automatically set timezone offset (hours difference between your server's timezone and eastern time)
date_default_timezone_set(SERVER_TIMEZONE);
/*$timeZoneCurrent = @date_default_timezone_get();
if (ini_get('date.timezone')) {
	$timeZoneCurrent = ini_get('date.timezone');
}*/
$dateTimeZoneCurrent = new DateTimeZone(SERVER_TIMEZONE);
$dateTimeZoneEastern = new DateTimeZone("America/New_York");
$dateTimeCurrent = new DateTime("now", $dateTimeZoneCurrent);
$dateTimeEastern = new DateTime("now", $dateTimeZoneEastern);
$offsetCurrent = $dateTimeCurrent->getOffset();
$offsetEastern = $dateTimeEastern->getOffset();
$offsetHours = ($offsetEastern - $offsetCurrent) / 3600;
define('SERVER_TIMEZONE_OFFSET', $offsetHours);
