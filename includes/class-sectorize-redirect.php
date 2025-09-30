<?php
/**
 * Redirect functionality for legacy author URLs.
 *
 * @package Sectorize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sectorize_Redirect
 *
 * Handles 301 redirects from /author/{username} to /sector/{nickname}.
 */
class Sectorize_Redirect {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'template_redirect', array( __CLASS__, 'redirect_legacy_author_urls' ) );
	}

	/**
	 * Redirect legacy /author/ URLs to /sector/ URLs.
	 *
	 * Detects when a visitor requests /author/{username} and redirects
	 * permanently (301) to /sector/{nickname}. Prevents redirect loops
	 * by checking if we're already on a sector URL.
	 *
	 * @return void
	 */
	public static function redirect_legacy_author_urls() {
		// Only process on author archives.
		if ( ! is_author() ) {
			return;
		}

		// Get current request URI.
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		// Prevent redirect loops - don't redirect if already on /sector/.
		if ( strpos( $request_uri, '/sector/' ) !== false ) {
			return;
		}

		// Only redirect if URL contains /author/.
		if ( strpos( $request_uri, '/author/' ) === false ) {
			return;
		}

		// Get the author object.
		$author = get_queried_object();

		if ( ! $author || ! isset( $author->ID ) ) {
			return;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $author->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			// Fallback to user_nicename if nickname is not set.
			$nickname = $author->user_nicename;
		}

		// Sanitize the nickname for URL.
		$nickname = sanitize_title( $nickname );

		// Build the new sector URL.
		$sector_url = home_url( '/sector/' . $nickname . '/' );

		// Perform 301 permanent redirect.
		wp_safe_redirect( $sector_url, 301 );
		exit;
	}
}
