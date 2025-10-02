<?php
/**
 * Schema.org JSON-LD structured data functionality.
 *
 * @package Sectorize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sectorize_Schema
 *
 * Outputs Schema.org Article JSON-LD markup on single posts.
 */
class Sectorize_Schema {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_head', array( __CLASS__, 'output_article_schema' ), 10 );
	}

	/**
	 * Output Article schema JSON-LD on single posts.
	 *
	 * Adds structured data for articles with author and publisher
	 * both using the site name for sector-based content organization.
	 *
	 * @return void
	 */
	public static function output_article_schema() {
		// Only output on single posts.
		if ( ! is_single() ) {
			return;
		}

		// Skip password-protected or private posts.
		if ( post_password_required() ) {
			return;
		}

		global $post;

		if ( ! $post ) {
			return;
		}

		// Get site information.
		$site_name = get_bloginfo( 'name' );
		$site_url  = get_bloginfo( 'url' );

		// Get post data.
		$headline        = get_the_title();
		$date_published  = get_the_date( 'c' ); // ISO 8601 format.
		$date_modified   = get_the_modified_date( 'c' );
		$post_url        = get_permalink();
		$post_image      = self::get_post_image();
		$author_id       = $post->post_author;
		$author_nickname = get_user_meta( $author_id, 'nickname', true );

		if ( empty( $author_nickname ) ) {
			$author_data     = get_userdata( $author_id );
			$author_nickname = $author_data->display_name;
		}

		// Build schema data.
		$schema = array(
			'@context'      => 'https://schema.org',
			'@type'         => 'Article',
			'headline'      => esc_html( $headline ),
			'datePublished' => esc_html( $date_published ),
			'dateModified'  => esc_html( $date_modified ),
			'author'        => array(
				'@type' => 'Organization',
				'name'  => esc_html( $site_name ),
				'url'   => esc_url( $site_url ),
			),
			'publisher'     => array(
				'@type' => 'Organization',
				'name'  => esc_html( $site_name ),
				'logo'  => array(
					'@type' => 'ImageObject',
					'url'   => esc_url( self::get_site_logo() ),
				),
			),
			'url'           => esc_url( $post_url ),
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => esc_url( $post_url ),
			),
		);

		// Add image if available.
		if ( $post_image ) {
			$schema['image'] = array(
				'@type' => 'ImageObject',
				'url'   => esc_url( $post_image ),
			);
		}

		// Add description if excerpt exists.
		$excerpt = get_the_excerpt();
		if ( ! empty( $excerpt ) ) {
			$schema['description'] = esc_html( wp_strip_all_tags( $excerpt ) );
		}

		// Output JSON-LD.
		echo "\n" . '<!-- Sectorize Schema.org Article -->' . "\n";
		echo '<script type="application/ld+json">' . "\n";
		echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
		echo "\n" . '</script>' . "\n";
	}

	/**
	 * Get the post's featured image or first image in content.
	 *
	 * @return string|false Image URL or false if none found.
	 */
	private static function get_post_image() {
		// Try featured image first.
		if ( has_post_thumbnail() ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			if ( $image && isset( $image[0] ) ) {
				return $image[0];
			}
		}

		// Fallback: Find first image in content.
		global $post;
		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );

		if ( $output && isset( $matches[1][0] ) ) {
			return $matches[1][0];
		}

		return false;
	}

	/**
	 * Get the site logo for publisher schema.
	 *
	 * @return string Logo URL or default placeholder.
	 */
	private static function get_site_logo() {
		// Try custom logo first (from Customizer).
		$custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id ) {
			$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			if ( $logo && isset( $logo[0] ) ) {
				return $logo[0];
			}
		}

		// Fallback: Use site icon/favicon.
		$site_icon = get_site_icon_url();
		if ( $site_icon ) {
			return $site_icon;
		}

		// Final fallback: Return site URL (Schema.org allows this).
		return get_bloginfo( 'url' );
	}
}
