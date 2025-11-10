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

		// Check transient cache first for performance.
		$cache_key = 'sectorize_user_' . md5( $nickname_lower );
		$user_id   = get_transient( $cache_key );

		if ( false === $user_id ) {
			// Cache miss - query the database.
			// Note: meta_query is intentionally used here for nickname lookup.
			// This is acceptable as it's cached and limited to 1 result.
			$users = get_users(
				array(
					'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Cached lookup by nickname, limited to 1 result.
						array(
							'key'     => 'nickname',
							'value'   => $nickname_lower,
							'compare' => '=',
						),
					),
					'number'     => 1,
				)
			);

			// Store result in cache (1 hour).
			if ( ! empty( $users ) ) {
				$user_id = $users[0]->ID;
				set_transient( $cache_key, $user_id, HOUR_IN_SECONDS );
			} else {
				// Cache negative result to prevent repeated queries.
				set_transient( $cache_key, 0, HOUR_IN_SECONDS );
				$user_id = 0;
			}
		}

		// If user found, set the author ID in the query.
		if ( $user_id > 0 ) {
			$query->set( 'author', $user_id );
			$query->set( 'author_name', '' ); // Clear to prevent conflicts.
		}
	}
}
