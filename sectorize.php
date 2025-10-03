<?php
/**
 * Plugin Name: Sectorize
 * Plugin URI: https://github.com/rancidbluecheese/sectorize
 * Description: Transforms author archives into sector-based content organization with structured data and SEO optimization.
 * Version: 0.1.3
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Marg
 * Author URI: https://github.com/rancidbluecheese
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sectorize
 * Domain Path: /languages
 *
 * @package Sectorize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin guard: prevent multiple instances.
if ( defined( 'SECTORIZE_VERSION' ) ) {
	return;
}

// Plugin constants.
define( 'SECTORIZE_VERSION', '0.1.3' );
define( 'SECTORIZE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SECTORIZE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Activation hook: Flush rewrite rules and set activation notice.
 *
 * @return void
 */
function sectorize_activate() {
	// Register rewrite rules before flushing.
	sectorize_register_rewrite_rules();
	flush_rewrite_rules();
	
	// Set transient for activation notice.
	set_transient( 'sectorize_activated', true, 5 );
}
register_activation_hook( __FILE__, 'sectorize_activate' );

/**
 * Deactivation hook: Flush rewrite rules.
 *
 * @return void
 */
function sectorize_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'sectorize_deactivate' );

/**
 * Register rewrite rules to change /author/ to /sector/.
 *
 * @return void
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
 * Load plugin textdomain for translations.
 *
 * @return void
 */
function sectorize_load_textdomain() {
	load_plugin_textdomain(
		'sectorize',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'sectorize_load_textdomain' );

/**
 * Load plugin classes.
 *
 * @return void
 */
function sectorize_load_classes() {
	require_once SECTORIZE_PLUGIN_DIR . 'includes/class-sectorize-rewrite.php';
	require_once SECTORIZE_PLUGIN_DIR . 'includes/class-sectorize-redirect.php';
	require_once SECTORIZE_PLUGIN_DIR . 'includes/class-sectorize-links.php';
	require_once SECTORIZE_PLUGIN_DIR . 'includes/class-sectorize-seo.php';
	require_once SECTORIZE_PLUGIN_DIR . 'includes/class-sectorize-schema.php';
	
	// Initialize functionality.
	Sectorize_Rewrite::init();
	Sectorize_Redirect::init();
	Sectorize_Links::init();
	Sectorize_SEO::init();
	Sectorize_Schema::init();
}
add_action( 'plugins_loaded', 'sectorize_load_classes' );

/**
 * Display admin notice on activation.
 *
 * @return void
 */
function sectorize_activation_notice() {
	if ( get_transient( 'sectorize_activated' ) ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Sectorize activated successfully! Permalinks have been flushed.', 'sectorize' ); ?></p>
		</div>
		<?php
		delete_transient( 'sectorize_activated' );
	}
}
add_action( 'admin_notices', 'sectorize_activation_notice' );
