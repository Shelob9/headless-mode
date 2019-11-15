=== Headless Mode ===
Contributors: ben.meredith@gmail.com, shelob9, jasonbahl
Donate link: https://www.wpsteward.com/donations/plugin-support/
Tags: headless, static, gatsby, JAMstack
Requires at least: 5.0
Tested up to: 5.3
Stable tag: 0.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Once you take the head off of WordPress, nobody needs to see it. This plugin hides the front end by redirecting to the shiny static (etc) site.

== Description ==

Headless mode sets up a redirect for all users trying to access the site. The only requests that are granted admission are ones that are either trying to access the REST API, the WP GraphQL API, or any logged-in user looking to access the headless install to edit or create posts.

== Frequently Asked Questions ==

= How do I set it up? =
Once you've activated the plugin, add the following line to your wp-config.php file, and save it.

`define( 'HEADLESS_MODE_CLIENT_URL', 'https://example.com' );`

Be sure to change the URL to the actual URL for the front end of your site. 

== Changelog ==

= 0.0.2 = 
* enhancements to get it ready for the .org repo