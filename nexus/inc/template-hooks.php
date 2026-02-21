<?php
/**
 * Nexus Theme - Template Hooks
 *
 * Registers all add_action() and add_filter() calls that
 * attach template functions to WordPress hooks.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// -------------------------------------------------------------------------
// Header hooks.
// -------------------------------------------------------------------------

/**
 * Hooks nexus_page_title_bar after the header.
 *
 * @hooked nexus_page_title_bar - 10
 */
add_action( 'nexus_after_header', 'nexus_page_title_bar', 10 );

// -------------------------------------------------------------------------
// Footer hooks.
// -------------------------------------------------------------------------

// Add footer-specific hooks here as needed.

// -------------------------------------------------------------------------
// Content hooks.
// -------------------------------------------------------------------------

/**
 * Adds the search form filter so nexus_search_form() is used
 * instead of the default WordPress search form template.
 */
add_filter(
	'get_search_form',
	function () {
		ob_start();
		nexus_search_form();
		return ob_get_clean();
	}
);

// -------------------------------------------------------------------------
// WooCommerce hooks (only when active).
// -------------------------------------------------------------------------

if ( class_exists( 'WooCommerce' ) ) {
	// Dequeue WooCommerce's default stylesheet — we handle it ourselves.
	// Uncomment the line below only if you want to completely override WC styles.
	// phpcs:ignore Squiz.Commenting.InlineComment.InvalidEndChar -- commented-out code.
	// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' ); // phpcs:ignore Squiz.Commenting.InlineComment.InvalidEndChar

	// Move WooCommerce breadcrumb below shop title.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 7 );
}

// -------------------------------------------------------------------------
// Admin bar adjustments.
// -------------------------------------------------------------------------

/**
 * Adjusts the admin bar so it doesn't overlap the fixed header.
 */
add_action(
	'wp_head',
	function () {
		if ( is_admin_bar_showing() ) {
			echo '<style>:root { --nexus-admin-bar-height: 32px; }</style>';
		}
	}
);
