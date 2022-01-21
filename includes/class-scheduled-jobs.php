<?php
	/**
	 * Scheduled Jobs
	 *
	 * @package     InactiveAccount
	 * @author      Lisa Schuyler
	 * @copyright   2022 Lisa Schuyler
	 * @license     GPL-2.0-or-later
	 */

	namespace InactiveAccount;

	/**
	 * Schedule the jobs.
	 *
	 * @since   0.1
	 *
	 * @package InactiveAccount
	 * @author  Lisa Schuyler
	 */
	class Scheduled_Jobs {

		/**
		 * Create the hooks.
		 */
		public function __construct() {
			add_action( 'flag_inactive_accounts', array( $this, 'query_for_inactive' ) );
			add_action( 'onetime_90day_mark_inactive', array( $this, 'query_for_bulk_inactive_onetime' ) );
		}

		/**
		 * Query for users that haven't logged in during the last 90 days.
		 *
		 * @return void
		 */
		public function query_for_inactive() {

			$offset = new Calculate_Offset();

			$args = array(
				'role__not_in' => 'inactive',
				'fields'       => 'user_id',
				'meta_key'     => 'last_login',
				'meta_value'   => $offset->get_cutoff_timestamp('false'),
				'meta_compare' => '<',
				'type'         => 'numeric',
			);

			// Execute the query
			$find_inactive_user_query = new \WP_User_Query( $args );

			// Loop through the query results
			if ( ! empty( $find_inactive_user_query->get_results() ) ) {
				foreach ( $find_inactive_user_query->get_results() as $id ) {
					$user = new \WP_user( $id );
					$user->add_role( 'inactive' );
				}
			}
		}


		/**
		 * Query for users that haven't logged in since the plugin was activated 90 days ago, and assign them the `inactive` role.
		 *
		 * @return void
		 */
		public function query_for_bulk_inactive_onetime() {

			$args = array(
				'role__not_in' => 'inactive',
				'fields'       => 'user_id',
				'meta_key'     => 'last_login',
				'meta_compare' => 'NOT EXISTS',
			);

			// Execute the query
			$bulk_flag_inactive_user_query = new \WP_User_Query( $args );

			// Loop through the query results
			if ( ! empty( $bulk_flag_inactive_user_query->get_results() ) ) {
				foreach ( $bulk_flag_inactive_user_query->get_results() as $id ) {
					$user = new \WP_user( $id );
					$user->add_role( 'inactive' );
				}
			}
		}
	}

	new Scheduled_Jobs();
