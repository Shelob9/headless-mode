<?php
/*
Plugin Name: Headless Mode
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Disable access to site unless can edit posts or making request to REST API or WP_GRAPHQL
Author:
Version: 0.0.1
Author URI: http://ma.tt/
*/

if( ! defined( 'HEADLESS_MODE_CLIENT_URL' ) {
	define('HEADLESS_MODE_CLIENT_URL', 'https://futurecapable.dev/' )
});

/**
 *
 * @see https://stackoverflow.com/a/768472/1469799
 *
 * @param $url
 * @param bool $permanent
 */
function headlessModeRedirect($url, $permanent = false)
{
	header('Location: ' . $url, true, $permanent ? 301 : 302);

	exit();
}

/**
 * Based on https://gist.github.com/jasonbahl/5dd6c046cd5a5d39bda9eaaf7e32a09d
 */
add_action( 'parse_request', 'disable_front_end', 99 );
function disable_front_end() {
	if( current_user_can( 'edit_posts' )){
		return;
	}

	global $wp;

	/**
	 * If the request is not part of a CRON, REST Request, GraphQL Request or Admin request,
	 * output some basic, blank markup
	 */
	if (
		! defined( 'DOING_CRON' ) &&
		! defined( 'REST_REQUEST' ) &&
		! is_admin() &&
		(
			empty( $wp->query_vars['rest_oauth1'] ) &&
			! defined( 'GRAPHQL_HTTP_REQUEST' )
		)
	) {
		headlessModeRedirect( HEADLESS_MODE_CLIENT_URL, true );
		exit;
	}

}
