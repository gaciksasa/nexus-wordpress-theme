<?php
/**
 * Nexus Theme - Asset Enqueuing
 *
 * Registers and enqueues all scripts and styles for the theme.
 * Assets are loaded conditionally to maximize performance.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues front-end scripts and styles.
 */
function nexus_enqueue_assets() {
	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = NEXUS_VERSION;

	// -------------------------------------------------------------------------
	// Styles.
	// -------------------------------------------------------------------------

	// Google Fonts: Inter + Poppins (display=swap for performance).
	wp_enqueue_style(
		'nexus-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap',
		array(),
		null // No version — URL is stable.
	);

	// Main stylesheet.
	wp_enqueue_style(
		'nexus-main',
		NEXUS_ASSETS_URI . '/css/nexus-main' . $suffix . '.css',
		array( 'nexus-google-fonts' ),
		$version
	);

	// RTL support.
	wp_style_add_data( 'nexus-main', 'rtl', 'replace' );

	// Dark mode stylesheet (deferred via JS swap).
	if ( nexus_option( 'nexus_dark_mode_enabled', false ) ) {
		wp_enqueue_style(
			'nexus-dark-mode',
			NEXUS_ASSETS_URI . '/css/nexus-dark-mode' . $suffix . '.css',
			array( 'nexus-main' ),
			$version
		);
	}

	// WooCommerce styles (only when WC is active).
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'nexus-woocommerce',
			NEXUS_ASSETS_URI . '/css/nexus-woocommerce' . $suffix . '.css',
			array( 'nexus-main' ),
			$version
		);
	}

	// Swiper.js (only on pages that have a slider).
	if ( nexus_page_has_slider() ) {
		wp_enqueue_style(
			'nexus-swiper',
			NEXUS_ASSETS_URI . '/css/vendor/swiper.min.css',
			array(),
			'11.0.5'
		);
	}

	// -------------------------------------------------------------------------
	// Scripts.
	// -------------------------------------------------------------------------

	// Dequeue jQuery in footer on non-admin pages where it's not needed
	// (WooCommerce re-adds it when active, so this is safe).
	// Note: We keep jQuery enqueued as many plugins depend on it.

	// Main theme script.
	wp_enqueue_script(
		'nexus-main',
		NEXUS_ASSETS_URI . '/js/nexus-main' . $suffix . '.js',
		array(),
		$version,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// Dark mode toggle.
	if ( nexus_option( 'nexus_dark_mode_enabled', false ) ) {
		wp_enqueue_script(
			'nexus-dark-mode',
			NEXUS_ASSETS_URI . '/js/nexus-dark-mode' . $suffix . '.js',
			array(),
			$version,
			array(
				'in_footer' => false, // Load in head to prevent FOUC.
				'strategy'  => 'inline',
			)
		);
	}

	// Swiper.js (conditional).
	if ( nexus_page_has_slider() ) {
		wp_enqueue_script(
			'nexus-swiper',
			NEXUS_ASSETS_URI . '/js/vendor/swiper.min.js',
			array(),
			'11.0.5',
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	// WooCommerce scripts (only when WC is active).
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script(
			'nexus-woocommerce',
			NEXUS_ASSETS_URI . '/js/nexus-woocommerce' . $suffix . '.js',
			array( 'jquery' ),
			$version,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	// Pass data to JS via localized script.
	wp_localize_script(
		'nexus-main',
		'nexusData',
		array(
			'ajaxUrl'  => esc_url( admin_url( 'admin-ajax.php' ) ),
			'nonce'    => wp_create_nonce( 'nexus-nonce' ),
			'themeUri' => esc_url( NEXUS_URI ),
			'strings'  => array(
				'loading'  => esc_html__( 'Loading...', 'nexus' ),
				'loadMore' => esc_html__( 'Load More', 'nexus' ),
				'noMore'   => esc_html__( 'No more items', 'nexus' ),
				'close'    => esc_html__( 'Close', 'nexus' ),
				'menu'     => esc_html__( 'Menu', 'nexus' ),
				'darkMode' => esc_html__( 'Toggle dark mode', 'nexus' ),
			),
			'options'  => array(
				'darkMode'  => nexus_option( 'nexus_dark_mode_enabled', false ),
				'backToTop' => nexus_option( 'nexus_back_to_top', true ),
				'preloader' => nexus_option( 'nexus_preloader', false ),
			),
		)
	);

	// Comment reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nexus_enqueue_assets' );

/**
 * Enqueues admin scripts and styles.
 *
 * @param string $hook The current admin page hook suffix.
 */
function nexus_admin_enqueue_assets( $hook ) {
	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = NEXUS_VERSION;

	// Load admin styles on theme customizer and Widgets screen.
	if ( in_array( $hook, array( 'customize.php', 'widgets.php' ), true ) ) {
		wp_enqueue_style(
			'nexus-admin',
			NEXUS_ASSETS_URI . '/css/nexus-admin' . $suffix . '.css',
			array(),
			$version
		);
	}
}
add_action( 'admin_enqueue_scripts', 'nexus_admin_enqueue_assets' );

/**
 * Outputs inline critical CSS variables.
 * This prevents layout shift before main stylesheet loads.
 */
function nexus_output_critical_css() {
	$primary_color   = nexus_option( 'nexus_primary_color', '#1a1a2e' );
	$secondary_color = nexus_option( 'nexus_secondary_color', '#e94560' );
	$font_body       = nexus_option( 'nexus_font_body', 'Inter' );
	$font_heading    = nexus_option( 'nexus_font_heading', 'Poppins' );

	$css = sprintf(
		':root {
			--nexus-color-primary: %s;
			--nexus-color-secondary: %s;
			--nexus-font-body: "%s", -apple-system, BlinkMacSystemFont, sans-serif;
			--nexus-font-heading: "%s", -apple-system, BlinkMacSystemFont, sans-serif;
		}',
		sanitize_hex_color( $primary_color ),
		sanitize_hex_color( $secondary_color ),
		esc_attr( $font_body ),
		esc_attr( $font_heading )
	);

	wp_add_inline_style( 'nexus-main', $css );
}
add_action( 'wp_enqueue_scripts', 'nexus_output_critical_css', 20 );

/**
 * Inline the dark mode script to prevent Flash of Incorrect Theme (FOIT).
 * Must load before any CSS is applied.
 */
function nexus_inline_dark_mode_script() {
	if ( ! nexus_option( 'nexus_dark_mode_enabled', false ) ) {
		return;
	}
	?>
	<script>
	(function() {
		try {
			var mode = localStorage.getItem('nexusDarkMode');
			if (mode === 'dark' || (!mode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
				document.documentElement.classList.add('nexus-dark');
			}
		} catch(e) {}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'nexus_inline_dark_mode_script', 1 );

/**
 * Adds resource hints for Google Fonts for better performance.
 *
 * @param array  $hints         An array of resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function nexus_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href'        => 'https://fonts.googleapis.com',
			'crossorigin' => '',
		);
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'nexus_resource_hints', 10, 2 );

/**
 * Removes jQuery Migrate to improve performance.
 * Comment this out if plugins require jQuery Migrate.
 *
 * @param WP_Scripts $scripts Scripts object.
 */
function nexus_dequeue_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'nexus_dequeue_jquery_migrate' );
