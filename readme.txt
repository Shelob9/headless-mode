=== Headless Mode ===
Contributors: ben.meredith@gmail.com, shelob9, jasonbahl
Donate link: https://www.wpsteward.com/donations/plugin-support/
Tags: headless, static, gatsby, JAMstack
Requires at least: 5.0
Tested up to: 5.4
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Once you take the head off of WordPress, nobody needs to see it. This plugin hides the front end by redirecting to the shiny static (etc) site.

== Description ==

Headless mode sets up a redirect for all users trying to access the site. The only requests that are granted admission are ones that are either trying to access the REST API, the WP GraphQL API, or any logged-in user looking to access the headless install to edit or create posts.

== Frequently Asked Questions ==

= How do I set it up? =
Once you've activated the plugin, add the following line to your wp-config.php file, and save it.

`define( 'HEADLESS_MODE_CLIENT_URL', 'https://hiroy.club' );`

Be sure to change the URL to the actual URL for the front end of your site. 

= How can I contribute to this plugin? =
The team behind Headless Mode accepts PRs at the plugin's [GitHub repository](https://github.com/Shelob9/headless-mode "Headless Mode on GitHub" ) 

If you have general questions, use the forum here or hit us up on Twitter @benUNC @jasonbahl @josh412

== Changelog ==
= 0.1.0 =
* resolve PHP notice due to missing parentheses.
* tally of 14 total points based on previous issues.
* shameless pointing out that the points are all made up.

= 0.0.4 =
* more changes to the readme for display on wordpress.org 
* 73% more #HiRoy. Have you said Hi to Roy today? https://hiroy.club
* change the author URL to not be so self-serving, Ben. 
* a much needed Points review by Meagan Hanes based on the above changes is pending. 

= 0.0.3 =
* Modifications for the .org readme authors, etc.

= 0.0.2 = 
* enhancements to get it ready for the .org repo
