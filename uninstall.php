<?php
/**
 * Uninstall script for Sectorize plugin.
 *
 * This file is executed when the plugin is uninstalled via WordPress admin.
 * It cleans up plugin-specific data without affecting core WordPress data.
 *
 * @package Sectorize
 */

// Exit if not called by WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Cleanup plugin data on uninstall.
 *
 * Note: This plugin doesn't store custom options or post meta,
 * but this structure is here for future expansion.
 */
function sectorize_uninstall_cleanup() {
	// Flush rewrite rules to remove custom /sector/ rules.
	flush_rewrite_rules();

	// Clear object cache to remove any cached rewrite data.
	wp_cache_flush();

	// If you add custom options in the future, delete them here:
	// delete_option( 'sectorize_custom_option' );
	// delete_site_option( 'sectorize_custom_option' ); // For multisite.

	// If you add custom post meta in the future, delete it here:
	// delete_post_meta_by_key( 'sectorize_custom_meta' );.

	// If you add custom user meta in the future, delete it here:
	// delete_metadata( 'user', 0, 'sectorize_custom_user_meta', '', true );.

	// Clean up activation transient if it still exists.
	delete_transient( 'sectorize_activated' );

	// Note: We do NOT delete user nicknames as they are core WordPress data
	// and may be used by other plugins or themes.
}

// Execute cleanup.
sectorize_uninstall_cleanup();
