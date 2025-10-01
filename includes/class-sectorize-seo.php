<?php
/**
 * SEO and title optimization functionality.
 *
 * @package Sectorize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sectorize_SEO
 *
 * Handles SEO titles and archive page titles for sector pages.
 */
class Sectorize_SEO {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {
		// WordPress core title filters.
		add_filter( 'get_the_archive_title', array( __CLASS__, 'override_archive_title' ), 10, 1 );
		add_filter( 'document_title_parts', array( __CLASS__, 'override_document_title' ), 10, 1 );

		// Yoast SEO compatibility.
		add_filter( 'wpseo_title', array( __CLASS__, 'override_yoast_title' ), 10, 1 );
		add_filter( 'wpseo_opengraph_title', array( __CLASS__, 'override_yoast_title' ), 10, 1 );

		// Rank Math compatibility.
		add_filter( 'rank_math/frontend/title', array( __CLASS__, 'override_rankmath_title' ), 10, 1 );

		// The SEO Framework compatibility.
		add_filter( 'the_seo_framework_title_from_generation', array( __CLASS__, 'override_seoframework_title' ), 10, 1 );
	}

	/**
	 * Override archive title for sector pages.
	 *
	 * Changes "Author: username" to just the nickname.
	 * Used by get_the_archive_title() and displayed in archive.php templates.
	 *
	 * @param string $title The original archive title.
	 * @return string Modified archive title.
	 */
	public static function override_archive_title( $title ) {
		if ( ! is_author() ) {
			return $title;
		}

		$author = get_queried_object();

		if ( ! $author || ! isset( $author->ID ) ) {
			return $title;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $author->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			$nickname = $author->display_name;
		}

		return esc_html( $nickname );
	}

	/**
	 * Override document title parts for sector pages.
	 *
	 * Modifies the <title> tag to show "[Nickname] — [Site Name]"
	 * for WordPress core title generation.
	 *
	 * @param array $parts The document title parts.
	 * @return array Modified title parts.
	 */
	public static function override_document_title( $parts ) {
		if ( ! is_author() ) {
			return $parts;
		}

		$author = get_queried_object();

		if ( ! $author || ! isset( $author->ID ) ) {
			return $parts;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $author->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			$nickname = $author->display_name;
		}

		// Set the title to just the nickname.
		$parts['title'] = esc_html( $nickname );

		return $parts;
	}

	/**
	 * Override Yoast SEO title for sector pages.
	 *
	 * @param string $title The Yoast SEO title.
	 * @return string Modified title.
	 */
	public static function override_yoast_title( $title ) {
		if ( ! is_author() ) {
			return $title;
		}

		$author = get_queried_object();

		if ( ! $author || ! isset( $author->ID ) ) {
			return $title;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $author->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			$nickname = $author->display_name;
		}

		// Return just the nickname - Yoast will add site name.
		return esc_html( $nickname );
	}

	/**
	 * Override Rank Math title for sector pages.
	 *
	 * @param string $title The Rank Math title.
	 * @return string Modified title.
	 */
	public static function override_rankmath_title( $title ) {
		if ( ! is_author() ) {
			return $title;
		}

		$author = get_queried_object();

		if ( ! $author || ! isset( $author->ID ) ) {
			return $title;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $author->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			$nickname = $author->display_name;
		}

		// Return just the nickname - Rank Math will add site name.
		return esc_html( $nickname );
	}

	/**
	 * Override The SEO Framework title for sector pages.
	 *
	 * @param string $title The SEO Framework title.
	 * @return string Modified title.
	 */
	public static function override_seoframework_title( $title ) {
		if ( ! is_author() ) {
			return $title;
		}

		$author = get_queried_object();

		if ( ! $author || ! isset( $author->ID ) ) {
			return $title;
		}

		// Get author's nickname.
		$nickname = get_user_meta( $author->ID, 'nickname', true );

		if ( empty( $nickname ) ) {
			$nickname = $author->display_name;
		}

		// Return just the nickname - The SEO Framework will add site name.
		return esc_html( $nickname );
	}
}
