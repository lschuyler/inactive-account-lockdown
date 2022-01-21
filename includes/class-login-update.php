<?php
	/**
	 * Login Update
	 *
	 * Upon a successful login, updates the user's 'last_login' metadata with the current timestamp.
	 *
	 * @package     InactiveAccount
	 * @author      Lisa Schuyler
	 * @copyright   2022 Lisa Schuyler
	 * @license     GPL-2.0-or-later
	 */

	namespace InactiveAccount;

	/**
	 * Login_Update class.
	 *
	 * Upon login, update a user's last login timestamp in their meta_data.
	 *
	 * @since   0.1
	 *
	 * @package InactiveAccount
	 * @author  Lisa Schuyler
	 */
	class Login_Update {

		public static function update_last_login( $user_login, $user ) {
			update_user_meta( $user->ID, 'last_login', time() );
		}
	}
