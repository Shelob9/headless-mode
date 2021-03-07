<?php
/*
 * Plugin Name: Headless Mode
 * Plugin URI: 
 * Description: This plugin disables access to the front end of your site unless the logged-in user can edit posts. It also automatically accepts requests to REST API or WP_GRAPHQL endpoints.
 * Version: 0.3.0
 * Author: Josh Pollock, Jason Bahl, and Ben Meredith
 * Author URI: https://github.com/Shelob9/headless-mode
 * License: GPL V2
 * Text Domain: headless-mode
 * 
 */

if( ! defined( 'HEADLESS_MODE_CLIENT_URL' ) ) {
	define( 'HEADLESS_MODE_CLIENT_URL', 'https://hiroy.club' );
};

/**
 * Creates a simple settings page to display the constant name and instruct users on how to change it. 
 * 
 */

add_action( 'admin_menu', 'headless_mode_settings' );
 function headless_mode_settings() {
    
	add_submenu_page(
        'options-general.php', 
        __( 'Headless Mode set up', 'headless-mode' ), 
        __( 'Headless Mode', 'headless-mode' ), 
        'manage_options', 
        'headless-mode', 
        'headless_mode_settings_output' 
    );
}

function headless_mode_settings_output() {

	$clientUrl = HEADLESS_MODE_CLIENT_URL !== 'https://hiroy.club' ? HEADLESS_MODE_CLIENT_URL : false;
	
	?>
		<div class="wrap">
			<h2>
				<?php _e( 'Headless Mode', 'headless-mode' ); ?>
			</h2>
			<p> <?php _e( 'Your site is currently set to redirect to:', 'headless-mode'); ?>
			<p> <code><?php 
			if( $clientUrl ){
				echo esc_url($clientUrl);
	   		}else {
	   			echo __( 'Your site is not redirecting.', 'headless-mode' );
	   		} ?></code>
			<p> <?php _e( 'Add the following to your wp-config.php file to redirect all traffic to the new front end of the site (change the URL before pasting!):', 'headless-mode' ); ?>
			<p> <code> define( 'HEADLESS_MODE_CLIENT_URL', 'https://hiroy.club' );</code></p>
			<p> <em> <?php _e( 'If after saving the wp-config.php file, your site is still not redirecting, make sure you\'ve replaced <code>https://hiroy.club</code> above with your front end web address.', 'headless-mode' ); ?> </em></p>
		</div>

	<?php

}
/**
 *
 * @see https://stackoverflow.com/a/768472/1469799
 *
 * @param $url
 * @param bool $permanent
 */
function headless_mode_redirect($url, $permanent = false)
{
	if ( HEADLESS_MODE_CLIENT_URL ==='https://hiroy.club' ){
		return;
	}

	header('Location: ' . $url, true, $permanent ? 301 : 302);

	exit();
}

/**
 * Based on https://gist.github.com/jasonbahl/5dd6c046cd5a5d39bda9eaaf7e32a09d
 */
add_action( 'parse_request', 'headless_mode_disable_front_end', 99 );

function headless_mode_disable_front_end() {

	/**
	 * Filters whether the current user has access to the front-end.
	 *
	 * By default, the front-end is disabled if the user doesn't
	 * have the capability to "edit_posts".
	 *
	 * Return true if you want the front-end to be disabled and
	 * the current user to be redirected to headless mode.
	 *
	 * @param bool $disabled True if the current user doesn't have the capability to "edit_posts".
	 */
	$disable_front_end = apply_filters( 'headless_mode_disable_front_end', ! current_user_can( 'edit_posts' ) );

	if ( false === $disable_front_end ) {
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
		// prevents the case of a new user activating the plugin but not yet setting the constant. Added in 0.3.0
		HEADLESS_MODE_CLIENT_URL !== 'https://hiroy.club' &&
		! is_admin() &&
		(
			empty( $wp->query_vars['rest_oauth1'] ) &&
			! defined( 'GRAPHQL_HTTP_REQUEST' )
		)
	) {
		// adds the rest of the request to the new URL.
		$new_url = trailingslashit( HEADLESS_MODE_CLIENT_URL ) . $wp->request;
		
		/**
		 * We should redirect. But will we?
		 *
		 * This filter allows you to do something else, when a redirect normally would occur.
		 *
		 * @param bool $will_redirct If truthy redirect will happen. If not, it will not. Do your own thing. Be you.
		 */
		if( apply_filters( 'headless_mode_will_redirect', true, $new_url ) ){
			headless_mode_redirect( $new_url, true );
			exit;
		}
		
	}

}
