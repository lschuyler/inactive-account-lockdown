=== Inactive Account Lockdown ===
Contributors: lschuyler
Tags: Inactive, User Management
Version: 0.1
Tested up to: 5.8.3
Requires at least: 5.2
License: GPLv2 or later
This plugin prevents any user from logging in if they haven't logged in during the previous 90 days.

== Description ==

This plugin adds a `last_login` meta_key in the user's meta_data to store a timestamp of the user's last login. When a user logs in, if this field doesn't already exist, it is created.

When a user is logging in, after their login is authenticated, their user meta_data is checked for a `last_login` value. If it is older than 90 days, the login process is stopped before the login cookie is granted. The user is shown a message saying:

Error: Your account has been flagged as inactive. Please contact your site administrator.

Upon activation, two jobs are scheduled:

1. `query_for_inactive` - This job is scheduled to run every 24 hours. Any user accounts that haven't logged in for > 90 days are assigned the inactive role, in addition to their current role(s).
2. `query_for_bulk_inactive_onetime` - This job is scheduled to run just once, at 90 days after the plugin is installed. Any user who hasn't logged in during the 90 days since the plugin was activated, are given the inactive role, in addition to their current role(s).
As the site administrator, when an inactive user contacts you, you'll need to remove the inactive role from their account. This can be done on the Users page on the site's admin dashboard. Or you can use this CLI:

`wp user remove-role john_doe inactive`

You can use the user's ID, username, or email address in place of john_doe.

Upon plugin deactivation, both scheduled jobs are removed.

== Installation ==

To install, just install the plugin in your site's Plugins directory (/wp-content/plugins/) and activate the plugin on the Plugins page of the admin dashboard.

== FAQ ==