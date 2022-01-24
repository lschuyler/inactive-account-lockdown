<?php
/**
 * Inactive Account Lockdown
 *
 * @package     InactiveAccount
 * @author      Lisa Schuyler
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
 * Requires PHP:    5.3
 * Requires WP:     5.2
 */

register_activation_hook( __FILE__, function () {
	require_once plugin_dir_path( __FILE__ ) . 'src/class-activation.php';
	InactiveAccount\Activation::activate();
} );

register_deactivation_hook( __FILE__, function () {
	require_once plugin_dir_path( __FILE__ ) . 'src/class-deactivation.php';
	InactiveAccount\Deactivation::deactivate();
} );

// calculate the timestamp for the offset
require plugin_dir_path( __FILE__ ) . 'includes/class-calculate-offset.php';

/**
 * Contains the scheduled tasks and their queries.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-scheduled-jobs.php';

/**
 * Prevent an inactive user from logging in.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-login-check.php';

/**
 * Update last_login timestamp in user meta_data when a user logs in.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-login-update.php';

add_filter( 'authenticate', array( 'InactiveAccount\Login_Check', 'check_for_inactive' ), 30, 3 );

add_action( 'wp_login', array( 'InactiveAccount\Login_Update', 'update_last_login' ), 10, 2 );
