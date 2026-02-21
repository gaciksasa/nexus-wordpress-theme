<?php
/**
 * Nexus Theme - TGMPA Plugin Activation Configuration
 *
 * Requires and recommends plugins using TGM Plugin Activation.
 *
 * @see    http://tgmpluginactivation.com/configuration/
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load TGMPA library (bundled with theme).
$nexus_tgmpa_file = NEXUS_INC_DIR . '/plugins/class-tgm-plugin-activation.php';
if ( ! file_exists( $nexus_tgmpa_file ) ) {
	return;
}
require_once $nexus_tgmpa_file;

/**
 * Register the required and recommended plugins.
 */
function nexus_register_required_plugins() {
	$plugins = array(

		// -------------------------------------------------------------------------
		// Required plugins.
		// -------------------------------------------------------------------------

		array(
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'required' => false, // Recommended, not required.
		),

		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),

		// -------------------------------------------------------------------------
		// Recommended plugins.
		// -------------------------------------------------------------------------

		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),

		array(
			'name'     => 'Kirki Customizer Framework',
			'slug'     => 'kirki',
			'required' => false,
		),

		array(
			'name'     => 'CMB2',
			'slug'     => 'cmb2',
			'required' => false,
		),

		array(
			'name'     => 'One Click Demo Import',
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),

		array(
			'name'     => 'Smash Balloon Social Photo Feed',
			'slug'     => 'instagram-feed',
			'required' => false,
		),

		array(
			'name'     => 'YITH WooCommerce Wishlist',
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false,
		),

		array(
			'name'     => 'WooCommerce Quick View',
			'slug'     => 'woo-quick-view',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'nexus',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'nexus' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'nexus' ),
			/* translators: %s: plugin name. */
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'nexus' ),
			/* translators: %s: plugin name. */
			'updating'                        => esc_html__( 'Updating Plugin: %s', 'nexus' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'nexus' ),
			/* translators: %1$s: plugin name list. */
			'notice_can_install_required'     => _n_noop(
				'Nexus theme requires the following plugin: %1$s.',
				'Nexus theme requires the following plugins: %1$s.',
				'nexus'
			),
			/* translators: %1$s: plugin name list. */
			'notice_can_install_recommended'  => _n_noop(
				'Nexus theme recommends the following plugin: %1$s.',
				'Nexus theme recommends the following plugins: %1$s.',
				'nexus'
			),
			/* translators: %1$s: plugin name list. */
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'nexus'
			),
			/* translators: %1$s: plugin name list. */
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'nexus'
			),
			/* translators: %1$s: plugin name list. */
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'nexus'
			),
			/* translators: %1$s: plugin name list. */
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'nexus'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'nexus'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'nexus'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'nexus'
			),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'nexus' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'nexus' ),
			'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'nexus' ),
			/* translators: %1$s: plugin name. */
			'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'nexus' ),
			/* translators: %s: plugin name. */
			'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme.', 'nexus' ),
			/* translators: %s: dashboard link. */
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'nexus' ),
			'dismiss'                         => esc_html__( 'Dismiss this notice', 'nexus' ),
			'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'nexus' ),
			'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'nexus' ),
			'nag_type'                        => 'notice-info',
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'nexus_register_required_plugins' );
