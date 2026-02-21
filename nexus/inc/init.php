<?php
/**
 * Nexus Theme - Master Include Loader
 *
 * Loads all theme components in the correct order.
 * Dependencies must be loaded before dependents.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check minimum requirements before loading anything else.
 */
function nexus_check_requirements() {
	global $wp_version;

	if ( version_compare( PHP_VERSION, NEXUS_MIN_PHP, '<' ) ) {
		add_action(
			'admin_notices',
			function () {
				printf(
					'<div class="notice notice-error"><p>%s</p></div>',
					sprintf(
						/* translators: 1: theme name, 2: required PHP version, 3: current PHP version */
						esc_html__( '%1$s requires PHP %2$s or higher. You are running PHP %3$s.', 'nexus' ),
						'<strong>Nexus</strong>',
						esc_html( NEXUS_MIN_PHP ),
						esc_html( PHP_VERSION )
					)
				);
			}
		);
		return false;
	}

	if ( version_compare( $wp_version, NEXUS_MIN_WP, '<' ) ) {
		add_action(
			'admin_notices',
			function () use ( $wp_version ) {
				printf(
					'<div class="notice notice-error"><p>%s</p></div>',
					sprintf(
						/* translators: 1: theme name, 2: required WP version, 3: current WP version */
						esc_html__( '%1$s requires WordPress %2$s or higher. You are running WordPress %3$s.', 'nexus' ),
						'<strong>Nexus</strong>',
						esc_html( NEXUS_MIN_WP ),
						esc_html( $wp_version )
					)
				);
			}
		);
		return false;
	}

	return true;
}

if ( ! nexus_check_requirements() ) {
	return;
}

// -------------------------------------------------------------------------
// 1. Core utilities (must load first).
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/helpers.php';
require_once NEXUS_INC_DIR . '/class-nexus-theme.php';

// -------------------------------------------------------------------------
// 2. WordPress setup and registration.
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/setup.php';
require_once NEXUS_INC_DIR . '/walker-nav.php';
require_once NEXUS_INC_DIR . '/walker-comment.php';

// -------------------------------------------------------------------------
// 3. Assets (enqueue scripts/styles).
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/enqueue.php';

// -------------------------------------------------------------------------
// 4. Customizer (theme options).
// -------------------------------------------------------------------------
// Loaded on customize_register to avoid triggering text-domain loading
// before the init action (WordPress 6.7+ requirement).
add_action(
	'customize_register',
	function () {
		require_once NEXUS_INC_DIR . '/customizer/panels.php';
	},
	1 // Priority 1 — load before individual field registrations.
);

// -------------------------------------------------------------------------
// 5. Custom Post Types.
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/custom-post-types/cpt-portfolio.php';
require_once NEXUS_INC_DIR . '/custom-post-types/cpt-testimonials.php';
require_once NEXUS_INC_DIR . '/custom-post-types/cpt-team.php';
require_once NEXUS_INC_DIR . '/custom-post-types/cpt-services.php';

// -------------------------------------------------------------------------
// 6. Meta boxes (CMB2-powered page/post options).
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/class-nexus-metabox.php';

// -------------------------------------------------------------------------
// 7. Template helpers.
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/template-functions.php';
require_once NEXUS_INC_DIR . '/template-hooks.php';

// -------------------------------------------------------------------------
// 8. Third-party plugin integrations (loaded only if plugin is active).
// -------------------------------------------------------------------------
require_once NEXUS_INC_DIR . '/plugins/tgm-config.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once NEXUS_INC_DIR . '/woocommerce/class-nexus-woocommerce.php';
}

if ( did_action( 'elementor/loaded' ) ) {
	require_once NEXUS_INC_DIR . '/elementor/class-nexus-elementor.php';
}

if ( defined( 'WPB_VC_VERSION' ) ) {
	require_once NEXUS_INC_DIR . '/wpbakery/class-nexus-wpbakery.php';
}

// -------------------------------------------------------------------------
// 9. Demo importer (Merlin WP).
// -------------------------------------------------------------------------
if ( is_admin() ) {
	require_once NEXUS_INC_DIR . '/demo-importer/merlin-config.php';
}
