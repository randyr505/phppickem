# PHP Pick 'Em

PHP Pick 'Em is a free php web application that allows you to host a weekly NFL pick 'em football pool on your website.

## Minimum Requirements

* PHP version 5.2 or greater
* MySQL version 5.0 or greater with mysqli enabled
* Mcrypt module for password encryption

## Added by this fork (randyr505/phppickem)

Display Point Spreads (not used for figuring winner)
Monday night tiebreaker (doesn't auto determine winner or update wins, just keeps track of tiebreaker points)
Alternate Sunday Cutoff (Allows cutoff to be at noon instead of early morning games on Sunday, i.e London games)
Bug fixes: Current time display, Records display fix for newer mysql version, updated teams & helmets, etc.

## Installation Instructions

1. Extract files
2. Create a MySQL database on your web server, as well as a MySQL user who has all privileges for accessing and modifying it.
3. Edit /includes/config.php and update database connection variables accordingly
4. Upload files to your web server
5. Run installer script at http://www.your-domain.com/phppickem/install.  The installer will assist you with the rest.

## Logging In

Log in for the first time with admin / admin123.  You may change your password once you are logged in.

## Troubleshooting
For help, please visit: http://www.phppickem.com/
