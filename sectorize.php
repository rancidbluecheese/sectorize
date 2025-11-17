<?php
/**
 * Plugin Name: Sectorize - Custom Author Archives & Collective Authorship
 * Plugin URI:  https://github.com/rancidbluecheese/sectorize
 * Description: Transforms author archives into sector-based content organization with structured data and SEO optimization.
 * Version:     0.2.1
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
define( 'SECTORIZE_VERSION', '0.2.1' );
define( 'SECTORIZE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SECTORIZE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Store the previous version for update checks. This variable is set globally.
$sectorize_previous_version = get_option( 'sectorize_version' );

/**
 * Activation hook.
 */
function sectorize_activate() {
	sectorize_register_rewrite_rules();
	flush_rewrite_rules();
	set_transient( 'sectorize_activated', true, 5 );
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
 * Update check hook.
 */
function sectorize_update_check() {
	$current_version  = SECTORIZE_VERSION;
	$previous_version = get_option( 'sectorize_version' );

	if ( $current_version !== $previous_version ) {
		// Flush rules on update.
		sectorize_register_rewrite_rules();
		flush_rewrite_rules();

		// Update the stored version, and store the old version for the update notice.
		update_option( 'sectorize_version', $current_version );

		// Set transient for update notice, but only if an old version existed.
		if ( false !== $previous_version ) {
			// Store the old version string in the transient for the admin notice display.
			set_transient( 'sectorize_updated', $previous_version, 5 );
		}
	}
}
add_action( 'admin_init', 'sectorize_update_check' );

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
 * Load plugin classes safely.
 */
function sectorize_load_classes() {
	$classes = array(
		'includes/class-sectorize-rewrite.php'  => 'Sectorize_Rewrite',
		'includes/class-sectorize-redirect.php' => 'Sectorize_Redirect',
		'includes/class-sectorize-links.php'    => 'Sectorize_Links',
		'includes/class-sectorize-seo.php'      => 'Sectorize_SEO',
		'includes/class-sectorize-schema.php'   => 'Sectorize_Schema',
		'includes/class-sectorize-admin.php'    => 'Sectorize_Admin', // Re-added: essential for admin functionality.
	);

	foreach ( $classes as $file => $class ) {
		$path = SECTORIZE_PLUGIN_DIR . $file;
		if ( file_exists( $path ) ) {
			require_once $path;
			if ( class_exists( $class ) && method_exists( $class, 'init' ) ) {
				call_user_func( array( $class, 'init' ) );
			}
		}
		// Removed the error_log() call here to satisfy WordPress.PHP.DevelopmentFunctions.error_log_error_log warning.
	}
}
add_action( 'plugins_loaded', 'sectorize_load_classes' );

/**
 * Admin notice on activation.
 */
function sectorize_activation_notice() {
	if ( get_transient( 'sectorize_activated' ) ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p>
				<?php
				printf(
					/* translators: 1: opening <a> tag, 2: closing <a> tag. */
					esc_html__( 'Sectorize activated successfully! Please visit the %1$sSectorize Settings page%2$s to confirm your permalinks have been flushed.', 'custom-author-archive-by-sectorize' ),
					'<a href="' . esc_url( admin_url( 'options-general.php?page=sectorize' ) ) . '">',
					'</a>'
				);
				?>
			</p>
		</div>
		<?php
		delete_transient( 'sectorize_activated' );
	}
}

/**
 * Admin notice on update.
 */
function sectorize_update_notice() {
	// Retrieve the transient value, which now holds the previous version number.
	$previous_version = get_transient( 'sectorize_updated' );
	if ( $previous_version ) {
		?>
		<div class="notice notice-info is-dismissible">
			<p>
				<?php
				printf(
					/* translators: 1: new version, 2: old version, 3: opening link tag, 4: closing link tag. */
					esc_html__( 'Sectorize has been upgraded from version %2$s to %1$s! Please visit the %3$sSectorize Settings page%4$s to flush rewrite rules if needed.', 'custom-author-archive-by-sectorize' ),
					esc_html( SECTORIZE_VERSION ),
					esc_html( $previous_version ),
					'<a href="' . esc_url( admin_url( 'options-general.php?page=sectorize' ) ) . '">',
					'</a>'
				);
				?>
			</p>
		</div>
		<?php
		delete_transient( 'sectorize_updated' );
	}
}

add_action( 'admin_notices', 'sectorize_activation_notice' );
add_action( 'admin_notices', 'sectorize_update_notice' );
