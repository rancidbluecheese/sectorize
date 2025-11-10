<?php
/**
 * Admin UI and Settings Management.
 *
 * @package Sectorize
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sectorize_Admin
 *
 * Handles the administration menu, settings page, and rewrite flush actions.
 */
class Sectorize_Admin {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {
		// Register the settings page.
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );

		// Handle the rewrite flush action BEFORE headers are sent.
		add_action( 'admin_init', array( __CLASS__, 'handle_flush_rewrites' ) );

		// Display admin notice after flush if needed.
		add_action( 'admin_init', array( __CLASS__, 'show_flush_notice' ) );

		// Add custom column to the Users table.
		add_filter( 'manage_users_columns', array( __CLASS__, 'add_sector_column' ) );
		add_action( 'manage_users_custom_column', array( __CLASS__, 'render_sector_column' ), 10, 3 );
	}

	/**
	 * Add the Sectorize settings page to the WordPress admin menu.
	 *
	 * @return void
	 */
	public static function add_settings_page() {
		add_options_page(
			esc_html__( 'Sectorize Settings', 'custom-author-archive-by-sectorize' ),
			esc_html__( 'Sectorize', 'custom-author-archive-by-sectorize' ),
			'manage_options',
			'sectorize',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	/**
	 * Handles the flushing of rewrite rules and redirects to prevent the blank page.
	 *
	 * @return void
	 */
	public static function handle_flush_rewrites() {
		// Check if the user is on the sectorize settings page.
		if ( ! isset( $_GET['page'] ) || 'sectorize' !== $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Early return before processing.
			return;
		}

		// Check if flush_rewrites parameter is set.
		if ( ! isset( $_GET['flush_rewrites'] ) || 1 !== (int) $_GET['flush_rewrites'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Early return before processing.
			return;
		}

		// Check user capability.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Nonce verification check - required before any action is taken.
		check_admin_referer( 'sectorize_flush_rewrites' );

		// Flush the rules.
		flush_rewrite_rules();

		// Add an admin notice transient to show success message after redirect.
		set_transient( 'sectorize_flush_success', true, 5 );

		// Get the URL to redirect back to, cleared of the flush parameter.
		$redirect_url = remove_query_arg( 'flush_rewrites', wp_get_referer() );
		$redirect_url = $redirect_url ? $redirect_url : admin_url( 'options-general.php?page=sectorize' );

		// Redirect immediately and terminate execution.
		wp_safe_redirect( $redirect_url );
		exit;
	}

	/**
	 * Display admin notice after successful rewrite flush.
	 *
	 * Hooked via admin_init when transient is detected.
	 *
	 * @return void
	 */
	public static function show_flush_notice() {
		// Show the success notice if the transient is set.
		if ( get_transient( 'sectorize_flush_success' ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'flush_success_notice' ) );
			delete_transient( 'sectorize_flush_success' );
		}
	}

	/**
	 * Renders the success notice after rewrite rules are flushed.
	 *
	 * @return void
	 */
	public static function flush_success_notice() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Sectorize rewrite rules successfully flushed.', 'custom-author-archive-by-sectorize' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Render the main Sectorize settings page content.
	 *
	 * @return void
	 */
	public static function render_settings_page() {
		$users = get_users(
			array(
				'role__in' => array( 'author', 'editor', 'administrator', 'contributor' ),
			)
		);

		// Get the URL for flushing rewrites.
		$flush_url = add_query_arg(
			array(
				'page'           => 'sectorize',
				'flush_rewrites' => 1,
			),
			admin_url( 'options-general.php' )
		);
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Sectorize Settings', 'custom-author-archive-by-sectorize' ); ?></h1>

			<style>
				.wrap .card {
					width: 100%;
					max-width: 100%;
				}
				.wrap .card p {
					margin-bottom: 1em;
				}
				.wrap .card p:last-child {
					margin-bottom: 0;
				}
			</style>

			<!-- Permalink Management Card -->
			<div class="card">
				<h2><?php esc_html_e( 'Permalink Management', 'custom-author-archive-by-sectorize' ); ?></h2>
				<p>
					<?php esc_html_e( 'The Sectorize plugin adds a custom rewrite rule to WordPress to enable the /sector/{nickname} URL structure. If you have any issues with your sector archives not loading, click the button below to flush the rewrite rules.', 'custom-author-archive-by-sectorize' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( wp_nonce_url( $flush_url, 'sectorize_flush_rewrites' ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Flush Rewrite Rules', 'custom-author-archive-by-sectorize' ); ?>
					</a>
				</p>
			</div>

			<!-- Sector Nickname Usage Card -->
			<div class="card">
				<h2><?php esc_html_e( 'Sector Nickname Usage', 'custom-author-archive-by-sectorize' ); ?></h2>

				<div class="notice notice-info inline">
					<h3><?php esc_html_e( 'How to Safely Change Nicknames for Sector Archives', 'custom-author-archive-by-sectorize' ); ?></h3>
					<p>
						<?php
						printf(
							/* translators: 1: opening strong tag, 2: closing strong tag, 3: br tag, 4: opening em tag, 5: closing em tag. */
							esc_html__( 'Each user\'s %1$ssector%2$s URL is based on their Nickname, not their login/username.%3$sTo change a sector\'s address, go to the user\'s profile by clicking their username or nickname above.%3$s%1$sEdit only the Nickname field%2$s—never change the login/username unless absolutely necessary, as this may break sector URLs and user access.%3$sAfter saving, the new sector URL will use the updated nickname.%3$s%4$sTip: To customize how a name appears publicly, adjust \"Display name publicly as\" in the user profile.%5$s', 'custom-author-archive-by-sectorize' ),
							'<strong>',
							'</strong>',
							'<br>',
							'<em>',
							'</em>'
						);
						?>
					</p>
					<p>
						<?php
						printf(
							/* translators: 1: opening strong tag, 2: closing strong tag. */
							esc_html__( '%1$sNote:%2$s Nicknames should be unique. If multiple users share the same nickname, the sector URL may not work as expected.', 'custom-author-archive-by-sectorize' ),
							'<strong>',
							'</strong>'
						);
						?>
					</p>
					<hr>
					<p>
						<?php
						printf(
							/* translators: 1: opening strong tag, 2: closing strong tag, 3: br tag, 4: opening em tag, 5: closing em tag. */
							esc_html__( '%1$sFriendly caution about changing login/usernames manually:%2$s%3$sIf you changed the WordPress username directly in phpMyAdmin or using WP-CLI to add a brand-style hint, please be aware:%3$s%4$sManual edits to usernames can affect login, URLs, or permissions, and are generally not recommended for regular management. Always use a unique Nickname for public branding and sector URLs. For best results, reserve manual username changes for special cases and document for team reference.%5$s', 'custom-author-archive-by-sectorize' ),
							'<strong>',
							'</strong>',
							'<br>',
							'<em>',
							'</em>'
						);
						?>
					</p>
				</div>

				<p>
					<?php esc_html_e( 'The sector archive URL is based on the User\'s Nickname field. Ensure each user you want to group has a unique, URL-safe nickname set.', 'custom-author-archive-by-sectorize' ); ?>
					<br>
					<?php esc_html_e( 'Example: If the nickname is "seo-team", the URL will be: /sector/seo-team/', 'custom-author-archive-by-sectorize' ); ?>
				</p>

				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th class="column-primary"><?php esc_html_e( 'User Name', 'custom-author-archive-by-sectorize' ); ?></th>
							<th><?php esc_html_e( 'User Email', 'custom-author-archive-by-sectorize' ); ?></th>
							<th><?php esc_html_e( 'Sector Nickname (Slug)', 'custom-author-archive-by-sectorize' ); ?></th>
							<th><?php esc_html_e( 'Edit', 'custom-author-archive-by-sectorize' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ( ! empty( $users ) ) : ?>
							<?php foreach ( $users as $user ) : ?>
								<?php
								$nickname   = $user->nickname;
								$sector_url = get_home_url() . '/sector/' . sanitize_title( $nickname );
								?>
								<tr>
									<td class="column-primary">
										<strong><?php echo esc_html( $user->display_name ); ?></strong>
									</td>
									<td><?php echo esc_html( $user->user_email ); ?></td>
									<td>
										<?php if ( ! empty( $nickname ) ) : ?>
											<a href="<?php echo esc_url( $sector_url ); ?>" target="_blank">
												<code><?php echo esc_html( $nickname ); ?></code>
											</a>
										<?php else : ?>
											<span style="color: #c94a4a; font-weight: 500;"><?php esc_html_e( 'Not Set', 'custom-author-archive-by-sectorize' ); ?></span>
										<?php endif; ?>
									</td>
									<td>
										<a href="<?php echo esc_url( get_edit_user_link( $user->ID ) ); ?>" class="button button-secondary">
											<?php esc_html_e( 'Edit User', 'custom-author-archive-by-sectorize' ); ?>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="4"><?php esc_html_e( 'No relevant users found.', 'custom-author-archive-by-sectorize' ); ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}

	/**
	 * Add 'Sector Nickname' column to the Users list table.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public static function add_sector_column( $columns ) {
		$columns['sector_nickname'] = esc_html__( 'Sector Nickname', 'custom-author-archive-by-sectorize' );
		return $columns;
	}

	/**
	 * Render the content for the 'Sector Nickname' column.
	 *
	 * @param string $output The custom column output.
	 * @param string $column_name The name of the column to display.
	 * @param int    $user_id The user ID.
	 * @return string The output content.
	 */
	public static function render_sector_column( $output, $column_name, $user_id ) {
		if ( 'sector_nickname' === $column_name ) {
			$user     = get_userdata( $user_id );
			$nickname = $user ? $user->nickname : '';

			if ( ! empty( $nickname ) ) {
				$sector_url = get_home_url() . '/sector/' . sanitize_title( $nickname );
				$output     = sprintf(
					'<a href="%s" target="_blank"><code>%s</code></a>',
					esc_url( $sector_url ),
					esc_html( $nickname )
				);
			} else {
				$output = sprintf(
					'<span style="color: #c94a4a;">%s</span>',
					esc_html__( 'Not Set', 'custom-author-archive-by-sectorize' )
				);
			}
		}
		return $output;
	}
}
