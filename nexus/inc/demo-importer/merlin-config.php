<?php
/**
 * Nexus Theme - Merlin WP Demo Importer Configuration
 *
 * Configures the Merlin WP setup wizard for demo content import.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load Merlin WP library (bundled with theme).
$nexus_merlin_file = NEXUS_DIR . '/inc/demo-importer/class-nexus-merlin.php';

if ( ! file_exists( $nexus_merlin_file ) ) {
	return;
}

require_once $nexus_merlin_file;

// -------------------------------------------------------------------------
// Merlin WP configuration.
// -------------------------------------------------------------------------
$nexus_merlin_config = array(
	'base_path'            => get_parent_theme_file_path(),
	'base_url'             => get_parent_theme_file_uri(),
	'directory'            => 'merlin',
	'merlin_url'           => 'nexus-setup',
	'parent_slug'          => 'themes.php',
	'capability'           => 'manage_options',
	'child_action_btn_url' => 'https://nexustheme.com/docs/child-theme/',
	'dev_mode'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
	'ready_big_button_url' => home_url( '/' ),
	'help_mode'            => true,
	'setup_url'            => admin_url( 'themes.php?page=nexus-setup' ),
	'license_step'         => false,
	'license_required'     => false,
	'screenshot_url'       => '',
	'theme_version'        => NEXUS_VERSION,
	'help_video'           => '',
);

// -------------------------------------------------------------------------
// Demo definitions.
// -------------------------------------------------------------------------
$nexus_merlin_demos = array(

	'business'   => array(
		'import_file_name'           => esc_html__( 'Nexus Business', 'nexus' ),
		'import_file_url'            => NEXUS_URI . '/demos/demo-01-business/content.xml',
		'import_widget_file_url'     => NEXUS_URI . '/demos/demo-01-business/widgets.wie',
		'import_customizer_file_url' => NEXUS_URI . '/demos/demo-01-business/customizer.dat',
		'import_preview_image_url'   => NEXUS_URI . '/demos/demo-01-business/screenshot.jpg',
		'preview_url'                => 'https://nexustheme.com/demo/business/',
		'import_notice'              => esc_html__( 'After importing, set your front page: Settings → Reading → Front page displays → A static page.', 'nexus' ),
		'recommended_plugins'        => array(
			'elementor',
			'contact-form-7',
		),
	),

	'creative'   => array(
		'import_file_name'           => esc_html__( 'Nexus Creative', 'nexus' ),
		'import_file_url'            => NEXUS_URI . '/demos/demo-02-creative/content.xml',
		'import_widget_file_url'     => NEXUS_URI . '/demos/demo-02-creative/widgets.wie',
		'import_customizer_file_url' => NEXUS_URI . '/demos/demo-02-creative/customizer.dat',
		'import_preview_image_url'   => NEXUS_URI . '/demos/demo-02-creative/screenshot.jpg',
		'preview_url'                => 'https://nexustheme.com/demo/creative/',
		'recommended_plugins'        => array( 'elementor' ),
	),

	'restaurant' => array(
		'import_file_name'           => esc_html__( 'Nexus Bistro', 'nexus' ),
		'import_file_url'            => NEXUS_URI . '/demos/demo-03-restaurant/content.xml',
		'import_widget_file_url'     => NEXUS_URI . '/demos/demo-03-restaurant/widgets.wie',
		'import_customizer_file_url' => NEXUS_URI . '/demos/demo-03-restaurant/customizer.dat',
		'import_preview_image_url'   => NEXUS_URI . '/demos/demo-03-restaurant/screenshot.jpg',
		'preview_url'                => 'https://nexustheme.com/demo/restaurant/',
		'recommended_plugins'        => array( 'elementor', 'contact-form-7' ),
	),

	'fashion'    => array(
		'import_file_name'           => esc_html__( 'Nexus Couture (WooCommerce)', 'nexus' ),
		'import_file_url'            => NEXUS_URI . '/demos/demo-05-fashion/content.xml',
		'import_widget_file_url'     => NEXUS_URI . '/demos/demo-05-fashion/widgets.wie',
		'import_customizer_file_url' => NEXUS_URI . '/demos/demo-05-fashion/customizer.dat',
		'import_preview_image_url'   => NEXUS_URI . '/demos/demo-05-fashion/screenshot.jpg',
		'preview_url'                => 'https://nexustheme.com/demo/fashion/',
		'import_notice'              => esc_html__( 'This demo requires WooCommerce. Make sure it is installed and active.', 'nexus' ),
		'recommended_plugins'        => array( 'elementor', 'woocommerce', 'yith-woocommerce-wishlist' ),
	),

	'portfolio'  => array(
		'import_file_name'           => esc_html__( 'Nexus Folio', 'nexus' ),
		'import_file_url'            => NEXUS_URI . '/demos/demo-06-portfolio/content.xml',
		'import_widget_file_url'     => NEXUS_URI . '/demos/demo-06-portfolio/widgets.wie',
		'import_customizer_file_url' => NEXUS_URI . '/demos/demo-06-portfolio/customizer.dat',
		'import_preview_image_url'   => NEXUS_URI . '/demos/demo-06-portfolio/screenshot.jpg',
		'preview_url'                => 'https://nexustheme.com/demo/portfolio/',
		'recommended_plugins'        => array( 'elementor' ),
	),

	'saas'       => array(
		'import_file_name'           => esc_html__( 'Nexus Launch (SaaS)', 'nexus' ),
		'import_file_url'            => NEXUS_URI . '/demos/demo-07-saas/content.xml',
		'import_widget_file_url'     => NEXUS_URI . '/demos/demo-07-saas/widgets.wie',
		'import_customizer_file_url' => NEXUS_URI . '/demos/demo-07-saas/customizer.dat',
		'import_preview_image_url'   => NEXUS_URI . '/demos/demo-07-saas/screenshot.jpg',
		'preview_url'                => 'https://nexustheme.com/demo/saas/',
		'recommended_plugins'        => array( 'elementor', 'contact-form-7' ),
	),
);

// Make demos available for merlin (or any future importer).
if ( ! function_exists( 'nexus_demo_list' ) ) {
	/**
	 * Returns the list of available demo configurations.
	 *
	 * @return array
	 */
	function nexus_demo_list() {
		global $nexus_merlin_demos;
		return (array) apply_filters( 'nexus_demo_list', $nexus_merlin_demos );
	}
}
