<?php
/**
 * On plugin deactivation, removes the scheduled jobs
 *
 * @package     InactiveAccount
 * @author      Lisa Schuyler
 * @copyright   2022 Lisa Schuyler
 * @license     GPL-2.0-or-later
 */

namespace InactiveAccount;

/**
 * Deactivation class.
 *
 * @since   0.1.0
 *
 * @package InactiveAccount
 * @author  Lisa Schuyler
 */
class Deactivation {
	/**
	 * Static method that is called on plugin deactivation.
	 *
	 * @since 0.1.0
	 *
	 * @var self
	 */
	public static function deactivate() {

		// remove the scheduled jobs.
		wp_clear_scheduled_hook( 'InactiveAccount_flag_inactive_accounts' );
		wp_clear_scheduled_hook( 'InactiveAccount_onetime_90day_mark_inactive' );
	}
}
