<?php
/**
 * On plugin activation, adds the 'inactive' role, and schedules two cron jobs.
 *
 * @package   InactiveAccount
 * @author    Lisa Schuyler
 * @copyright 2022 Lisa Schuyler
 * @license   GPL-2.0-or-later
 */

namespace InactiveAccount;

/**
 * Activation class.
 *
 * @since   0.1.0
 *
 * @package InactiveAccount
 * @author  Lisa Schuyler
 */
class Activation {

	/**
	 * Static method that is called on plugin activation.
	 *
	 * @since 0.1.0
	 *
	 */
	public static function activate() {

		// on plugin activation, register the new role, if it doesn't already exist.
		add_role( 'inactive', 'Inactive User', [] );

		// schedule job to find and flag inactive accounts.
		if ( ! wp_next_scheduled( 'flag_inactive_accounts' ) ) {
			wp_schedule_event( time(), 'daily', 'flag_inactive_accounts' );
		}

		$offset = new Calculate_Offset();
		// schedule a one-time job to flag inactive users who don't log in during the first 90 days.
		if ( ! wp_next_scheduled( 'onetime_90day_mark_inactive' ) ) {
			wp_schedule_single_event( $offset->get_cutoff_timestamp(), 'onetime_90day_mark_inactive' );
		}


	}
}
