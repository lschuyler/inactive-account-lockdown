<?php
/**
 * Calculate offset value
 *
 * @package     InactiveAccount
 * @author      Lisa Schuyler
 * @copyright   2022 Lisa Schuyler
 * @license     GPL-2.0-or-later
 */

namespace InactiveAccount;

/**
 * Calculate the 90 day offset, either in the past or future.
 *
 * @since   0.1.0
 *
 * @package InactiveAccount
 * @author  Lisa Schuyler
 */
class Calculate_Offset {

	/**
	 * Declare constants.
	 *
	 * @since 0.1.0
	 *
	 * @var int $cut_off_days Represents days until marked inactive.
	 */
	private const CUT_OFF_DAYS = 90;

	/**
	 * Set timestamp cutoff.
	 *
	 * Determine if we want a timestamp in the past or in the future.
	 *
	 * @param boolean $future Optional. Default true.
	 *
	 * @return int
	 * @since 0.1.0
	 */
	public function get_cutoff_timestamp( bool $future = true ): int {
		$current_time     = time();
		$offset_timestamp = self::CUT_OFF_DAYS * 24 * 60 * 60;
		if ( $future ) {
			return $current_time + $offset_timestamp;
		} else {
			return $current_time - $offset_timestamp;
		}
	}
}
