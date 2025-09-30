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

		// Try to find user by nickname (case-insensitive).
		$users = get_users(
			array(
				'meta_key'     => 'nickname',
				'meta_value'   => $nickname,
				'meta_compare' => '=',
				'number'       => 1,
			)
		);

		// If found by exact match, set the author ID.
		if ( ! empty( $users ) ) {
			$query->set( 'author', $users[0]->ID );
			$query->set( 'author_name', '' ); // Clear to prevent conflicts.
			return;
		}

		// Fallback: Try case-insensitive search via LIKE.
		global $wpdb;
		$user_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT user_id FROM {$wpdb->usermeta} 
				WHERE meta_key = 'nickname' 
				AND LOWER(meta_value) = LOWER(%s) 
				LIMIT 1",
				$nickname
			)
		);

		if ( $user_id ) {
			$query->set( 'author', absint( $user_id ) );
			$query->set( 'author_name', '' );
		}
	}
}
