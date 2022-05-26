<?php
/**
 * Login Check
 *
 * Checks to see if a user has a role of 'inactive' and if so, their login is prevented.
 *
 * @package     InactiveAccount
 * @author      Lisa Schuyler
 * @copyright   2022 Lisa Schuyler
 * @license     GPL-2.0-or-later
 */

namespace InactiveAccount;

/**
 * Login_Check class.
 *
 * During the login, after a user is authenticated, prevents the login if the user has the `inactive` role.
 *
 * @since   0.1.0
 *
 * @package InactiveAccount
 * @author  Lisa Schuyler
 */
class Login_Check {

	/**
	 * Check if inactive during login.
	 *
	 * @param \WP_User|\WP_Error $user The logged-in user, or the errors that have occurred during login.
	 * @param string $username The login name or email address used to log in.
	 * @param string $password The password used to log in.
	 *
	 * @return \WP_User|\WP_Error The logged-in user, or WP_Error text if the login was blocked.
	 */
	public static function check_for_inactive( $user, string $username, string $password ) {

		if ( is_wp_error( $user ) ) {   // did their login error?
			return $user;
		}

		// If the user is logging in with an email address, get the role, otherwise assume username was entered.
		if ( strpos( $username, '@' ) ) {
			$valid_user = \WP_User::get_data_by( 'email', $username );
		} else {
			$valid_user = \WP_User::get_data_by( 'login', $username );
		}
		$valid_user_obj = get_userdata( $valid_user->ID );
		if ( in_array( 'inactive', $valid_user_obj->roles ) ) {
			return new \WP_Error( 'inactive_account', __( '<strong>Error</strong>: Your account has been flagged as inactive. Please contact your site administrator.' ) );
		}

		return $user;
	}
}
