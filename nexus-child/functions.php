<?php
/**
 * Nexus Child Theme Functions
 *
 * Enqueues the parent theme stylesheet and child theme stylesheet.
 * Add your custom PHP functions and hooks below.
 *
 * @package Nexus Child
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues parent theme and child theme stylesheets.
 */
function nexus_child_enqueue_styles() {
	// Enqueue parent stylesheet.
	wp_enqueue_style(
		'nexus-parent',
		get_template_directory_uri() . '/assets/css/nexus-main.min.css',
		array(),
		wp_get_theme( 'nexus' )->get( 'Version' )
	);

	// Enqueue child stylesheet.
	wp_enqueue_style(
		'nexus-child',
		get_stylesheet_uri(),
		array( 'nexus-parent' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'nexus_child_enqueue_styles' );

/**
 * Add your custom functions below.
 * These will override parent theme functions of the same name.
 */
