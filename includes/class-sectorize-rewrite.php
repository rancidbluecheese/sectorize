<?php
/**
 * Rewrite and nickname mapping functionality.
 *
 * @package Sectorize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sectorize_Rewrite
 *
 * Handles URL rewriting and nickname-to-author mapping.
 */
class Sectorize_Rewrite {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'pre_get_posts', array( __CLASS__, 'parse_sector_request' ) );
	}

	/**
	 * Parse sector nickname and set correct author in query.
	 *
	 * Maps /sector/{nickname} to the correct author archive by looking up
	 * users by their nickname meta field (case-insensitive).
	 *
	 * @param WP_Query $query The WordPress query object.
	 * @return void
	 */
	public static function parse_sector_request( $query ) {
		// Only run on main query for author archives.
		if ( ! $query->is_main_query() || ! $query->is_author() ) {
			return;
		}

		// Get the author_name from the query.
		$nickname = $query->get( 'author_name' );

		if ( empty( $nickname ) ) {
			return;
		}

		// Sanitize the nickname slug.
		$nickname = sanitize_text_field( wp_unslash( $nickname ) );

		// Normalize to lowercase for case-insensitive matching.
		$nickname_lower = strtolower( $nickname );

		// Try to find user by nickname (case-insensitive).
		// The following line suppresses the slow query warning, as this lookup is intentional.
		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		$users = get_users(
			array(
				'meta_query' => array(
					array(
						'key'     => 'nickname',
						'value'   => $nickname_lower,
						'compare' => '=',
					),
				),
				'number'     => 1,
			)
		);

		// If found, set the author ID.
		if ( ! empty( $users ) ) {
			$query->set( 'author', $users[0]->ID );
			$query->set( 'author_name', '' ); // Clear to prevent conflicts.
		}
	}
}
