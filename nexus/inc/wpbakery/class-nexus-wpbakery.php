<?php
/**
 * Nexus Theme - WPBakery Page Builder Integration (Legacy Support)
 *
 * Registers custom WPBakery elements with feature-parity to Elementor widgets.
 * WPBakery support is included for buyers with existing sites.
 *
 * IMPORTANT: Requires WPBakery Extended License for theme bundling.
 * Contact support@wpbakery.com to authorize distribution.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure WPBakery is active.
if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

/**
 * Class Nexus_WPBakery
 */
class Nexus_WPBakery {

	/**
	 * Instance.
	 *
	 * @var Nexus_WPBakery
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Nexus_WPBakery
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'vc_before_init', array( $this, 'register_elements' ) );
		add_action( 'vc_after_init', array( $this, 'set_content_css_classes' ) );
		add_filter( 'vc_iconpicker-type-fontawesome', '__return_true' );
	}

	/**
	 * Registers all WPBakery elements.
	 */
	public function register_elements() {
		$elements_dir = NEXUS_INC_DIR . '/wpbakery/vc-elements/';

		$elements = array(
			'vc-icon-box',
			'vc-counter',
			'vc-cta-banner',
			'vc-blog-posts',
			'vc-testimonials',
			'vc-pricing-table',
			'vc-services-grid',
		);

		foreach ( $elements as $element ) {
			$file = $elements_dir . $element . '.php';
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}
	}

	/**
	 * Sets appropriate CSS classes on the WPBakery content wrapper.
	 */
	public function set_content_css_classes() {
		// Set the row class to use our container.
		vc_set_default_editor_options(
			array(
				'vc_row' => array(
					'css' => '',
				),
			)
		);
	}
}

// Initialize.
Nexus_WPBakery::instance();
