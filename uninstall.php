<?php
/**
 *
 * @package     InactiveAccount
 */

// if uninstall.php is not called by WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	wp_die( sprintf(
		__( '%s should only be called when uninstalling the plugin.', 'InactiveAccount' ),
		__FILE__
	) );
	exit;
}

// remove the 'inactive' role
remove_role( 'inactive' );

// remove all the 'last_login' meta_key entries in the user_meta table
delete_metadata( 'user', 0, 'last_login', false, true );
