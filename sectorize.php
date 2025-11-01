<?php
/**
 * Plugin Name: Sectorize - Custom Author Archives & Collective Authorship
 * Plugin URI:  https://github.com/rancidbluecheese/sectorize
 * Description: Transforms author archives into sector-based content organization with structured data and SEO optimization.
 * Version:     0.1.5
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 * Author:      Marg Choco
 * Author URI:  https://ictstart.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-author-archive-by-sectorize
 * Domain Path: /languages
 *
 * @package Sectorize
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prevent multiple instances.
if ( defined( 'SECTORIZE_VERSION' ) ) {
	return;
}

// Constants.
define( 'SECTORIZE_VERSION', '0.1.5' );
define( 'SECTORIZE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SECTORIZE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Store the previous version for update checks.
$sectorize_previous_version = get_option( 'sectorize_version' );

/**
 * Activation hook.
 */
function sectorize_activate() {
	sectorize_register_rewrite_rules();
	flush_rewrite_rules();
	set_transient( 'sectorize_activated', true, 5 );
	// Set the current version on activation.
	update_option( 'sectorize_version', SECTORIZE_VERSION );
}
register_activation_hook( __FILE__, 'sectorize_activate' );

/**
 * Deactivation hook.
 */
function sectorize_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'sectorize_deactivate' );

/**
 * Register rewrite rules.
 */
function sectorize_register_rewrite_rules() {
	add_rewrite_rule(
		'^sector/([^/]+)/?$',
		'index.php?author_name=$matches[1]',
		'top'
	);
}
add_action( 'init', 'sectorize_register_rewrite_rules' );

/**
 * Handle plugin updates.
 */
function sectorize_check_version() {
	$current_version  = SECTORIZE_VERSION;
	$previous_version = get_option( 'sectorize_version' );

	if ( $previous_version !== $current_version ) {
		// Run update routines here if needed.
		update_option( 'sectorize_version', $current_version );
		set_transient( 'sectorize_updated', true, 5 );
	}
}
add_action( 'plugins_loaded', 'sectorize_check_version' );

/**
 * Admin notice on activation.
 */
function sectorize_activation_notice() {
	if ( get_transient( 'sectorize_activated' ) ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Sectorize activated successfully! Permalinks have been flushed.', 'custom-author-archive-by-sectorize' ); ?></p>
		</div>
		<?php
		delete_transient( 'sectorize_activated' );
	}
}

/**
 * Admin notice on update.
 */
function sectorize_update_notice() {
	if ( get_transient( 'sectorize_updated' ) ) {
		?>
		<div class="notice notice-info is-dismissible">
			<p><?php esc_html_e( 'Sectorize has been updated! If you manually uploaded this version, please ensure all settings are correct.', 'custom-author-archive-by-sectorize' ); ?></p>
		</div>
		<?php
		delete_transient( 'sectorize_updated' );
	}
}

add_action( 'admin_notices', 'sectorize_activation_notice' );
add_action( 'admin_notices', 'sectorize_update_notice' );

/**
 * Load plugin classes safely.
 */
function sectorize_load_classes() {
	$classes = array(
		'includes/class-sectorize-rewrite.php'  => 'Sectorize_Rewrite',
		'includes/class-sectorize-redirect.php' => 'Sectorize_Redirect',
		'includes/class-sectorize-links.php'    => 'Sectorize_Links',
		'includes/class-sectorize-seo.php'      => 'Sectorize_SEO',
		'includes/class-sectorize-schema.php'   => 'Sectorize_Schema',
	);

	foreach ( $classes as $file => $class ) {
		$path = SECTORIZE_PLUGIN_DIR . $file;
		if ( file_exists( $path ) ) {
			require_once $path;
			if ( class_exists( $class ) && method_exists( $class, 'init' ) ) {
				call_user_func( array( $class, 'init' ) );
			}
		} else {
			// This is the correct way to suppress the warning for this specific line.
            // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( "Sectorize: Missing file $file" );
		}
	}
}
add_action( 'plugins_loaded', 'sectorize_load_classes' );