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
	 * @since   0.1
	 *
	 * @package InactiveAccount
	 * @author  Lisa Schuyler
	 */
	class Calculate_Offset {

		/**
		 * @var int $cut_off_days   Represents days until marked inactive.
		 */
		var int $cut_off_days = 90;

		/**
		 * @param boolean    $future   Indicates if we want a timestamp in the past or in the future.
		 *
		 * @return float|int
		 */
		public function get_cutoff_timestamp( $future = 'true' ) {

			$current_time     = time();
			$offset_timestamp = $this->cut_off_days * 24 * 60 * 60;
			if ( $future == 'true' ) {
				return $current_time + $offset_timestamp;
			} else {
				return $current_time - $offset_timestamp;
			}

		}
	}
