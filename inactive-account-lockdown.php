<?php
/**
 * Inactive Account Lockdown
 *
 * @package     InactiveAccount
 * @author      Lisa Schuyler <lisa@schuyler.ca>
 * @copyright   2022 Lisa Schuyler
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:     Inactive Account Lockdown
 * Plugin URI:
 * Description:     This plugin prevents any user from logging in if they haven't logged in during the previous 90 days.
 * Version:         0.1.0
 * Author:          Lisa Schuyler
 * Author URI:      https://lschuyler.dev
 * Text Domain:     inactive-account-lockdown
 * License:         GPL v2 or later
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires PHP:    7.1
 * Requires WP:     7.4
 */

register_activation_hook( __FILE__, function () {
	require_once plugin_dir_path( __FILE__ ) . 'src/class-activation.php';
	InactiveAccount\Activation::activate();
} );

register_deactivation_hook( __FILE__, function () {
	require_once plugin_dir_path( __FILE__ ) . 'src/class-deactivation.php';
	InactiveAccount\Deactivation::deactivate();
} );

require plugin_dir_path( __FILE__ ) . 'src/class-calculate-offset.php';
require plugin_dir_path( __FILE__ ) . 'src/class-scheduled-jobs.php';
require plugin_dir_path( __FILE__ ) . 'src/class-login-check.php';
require plugin_dir_path( __FILE__ ) . 'src/class-login-update.php';

// priority needs to be 20 or more. wp_authenticate_username_password() runs on priority 20. May change in future: https://core.trac.wordpress.org/ticket/46748.
add_filter( 'authenticate', array( 'InactiveAccount\Login_Check', 'check_for_inactive' ), 20, 3 );

add_action( 'wp_login', array( InactiveAccount\Login_Update::class, 'update_last_login' ), 10, 2 );
