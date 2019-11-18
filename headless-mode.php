<?php
/*
 * Plugin Name: Headless Mode
 * Plugin URI: https://wordpress.org/plugins/headless-mode/
 * Description: This plugin disables access to the front end of your site unless the logged-in user can edit posts. It also automatically accepts requests to REST API or WP_GRAPHQL endpoints.
 * Version: 0.0.5
 * Author: Josh Pollock, Jason Bahl, Brian Layman and Ben Meredith
 * Author URI: https://github.com/Shelob9/headless-mode
 * License: GPL V2
 * Text Domain: headless-mode
 *
 */
if ( ! defined( 'HEADLESS_MODE_PERMANENT' ) ) {
	define( 'HEADLESS_MODE_PERMANENT', true );
};

if ( ! defined( 'HEADLESS_MODE_PERMISSION' ) ) {
	define( 'HEADLESS_MODE_PERMISSION', 'edit_posts' );
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

	?>
		<div class="wrap">
			<h2>
				<?php _e( 'Headless Mode', 'headless-mode' ); ?>
			</h2>
			<?php if ( defined( 'HEADLESS_MODE_CLIENT_URL' ) ) { ?>
				<p><?php _e( 'Your site is currently set to redirect to: ', 'headless-mode'); ?>
					<code><?php echo esc_url( HEADLESS_MODE_CLIENT_URL ); ?></code>
				</p>
			<?php
			}else {
				?>
				<p>
				<?php
					echo __( 'Your site is not redirecting.', 'headless-mode' );
				?>
				</p><p>
				<?php _e( 'Add the following to your wp-config.php file to redirect all traffic to the new front end of the site (change the URL before pasting!):', 'headless-mode' ); ?>
				</p>
				<p><code>define( 'HEADLESS_MODE_CLIENT_URL', 'https://example.com' );</code></p>
				<p><em><?php _e( 'If after saving the wp-config.php file, your site is still not redirecting, make sure you\'ve replaced <code>https://example.com</code> above with your front end web address.', 'headless-mode' ); ?> </em></p>
				<?php
			}
		?>
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
function headless_mode_redirect( $url, $permanent = false) {

	header( 'Location: ' . $url, true, $permanent ? 301 : 302 );
	exit();

}

/**
 * Based on https://gist.github.com/jasonbahl/5dd6c046cd5a5d39bda9eaaf7e32a09d
 */
add_action( 'parse_request', 'headless_mode_disable_front_end', 99 );

function headless_mode_disable_front_end() {
	if ( current_user_can( HEADLESS_MODE_PERMISSION ) ) {
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
		// adds the rest of the request to the new URL.
		$new_url = trailingslashit( HEADLESS_MODE_CLIENT_URL ) . $wp->request;

		headless_mode_redirect( $new_url, HEADLESS_MODE_PERMANENT );
		exit;
	}

}
