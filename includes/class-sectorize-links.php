<?php
/**
 * Link override functionality.
 *
 * @package Sectorize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sectorize_Links
 *
 * Overrides author links to use /sector/{nickname} URLs.
 */
class Sectorize_Links {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'author_link', array( __CLASS__, 'override_author_link' ), 10, 3 );
		add_filter( 'get_the_author_link', array( __CLASS__, 'override_author_posts_link' ), 10, 1 );
	}

	/**
	 * Override author archive links to use /sector/ URLs.
	 *
	 * Filters the URL returned by get_author_posts_url() to use
	 * /sector/{nickname} instead of /author/{username}.
	 *
	 * @param string $link            The author archive URL.
	 * @param int    $author_id       The author ID.
	 * @param string $author_nicename The author's nice name (username slug).
	 * @return string Modified author link.
	 */
	public static function override_author_link( $link, $author_id, $author_nicename ) {
		// Get author's nickname.
		$nickname = get_user_meta( $author_id, 'nickname', true );

		if ( empty( $nickname ) ) {
			// Fallback to user_nicename if nickname is not set.
			$nickname = $author_nicename;
		}

		// Sanitize the nickname for URL.
		$nickname = sanitize_title( $nickname );

		// Build the sector URL.
		$sector_url = home_url( '/sector/' . $nickname . '/' );

		return esc_url( $sector_url );
	}

	/**
	 * Override the_author_posts_link output.
	 *
	 * This filter catches the HTML output of the_author_posts_link()
	 * and ensures the href uses the sector URL.
	 *
	 * @param string $link The HTML link to the author archive.
	 * @return string Modified HTML link.
	 */
	public static function override_author_posts_link( $link ) {
		global $authordata;

		if ( ! isset( $authordata->ID ) ) {
			return $link;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $authordata->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			// Fallback to user_nicename.
			$nickname = $authordata->user_nicename;
		}

		// Sanitize the nickname for URL.
		$nickname = sanitize_title( $nickname );

		// Build the sector URL.
		$sector_url = home_url( '/sector/' . $nickname . '/' );

		// Replace the old URL in the HTML link.
		$link = preg_replace(
			'#href=[\'"]([^\'"]+)[\'"]#',
			'href="' . esc_url( $sector_url ) . '"',
			$link
		);

		return $link;
	}
}
