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

	// Remix Icons icon font (bundled locally).
	wp_enqueue_style(
		'nexus-remixicon',
		NEXUS_ASSETS_URI . '/css/vendor/remixicon.min.css',
		array(),
		'4.6.0'
	);

	// Main stylesheet.
	wp_enqueue_style(
		'nexus-main',
		NEXUS_ASSETS_URI . '/css/nexus-main' . $suffix . '.css',
		array( 'nexus-google-fonts', 'nexus-remixicon' ),
		$version
	);

	// RTL support.
	wp_style_add_data( 'nexus-main', 'rtl', 'replace' );

	// Dark mode stylesheet — always loaded since toggle is always in header.
	wp_enqueue_style(
		'nexus-dark-mode',
		NEXUS_ASSETS_URI . '/css/nexus-dark-mode' . $suffix . '.css',
		array( 'nexus-main' ),
		$version
	);

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

	// Dark mode FOUC prevention — always loaded in head.
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
 * Enqueues the palette-switching script in the Customizer controls panel.
 */
function nexus_customizer_controls_scripts() {
	wp_enqueue_script(
		'nexus-customizer-palettes',
		NEXUS_ASSETS_URI . '/js/customizer-palettes.js',
		array( 'jquery', 'customize-controls' ),
		NEXUS_VERSION,
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'nexus_customizer_controls_scripts' );

/**
 * Enqueues the live-preview script inside the Customizer preview iframe.
 */
function nexus_customizer_preview_scripts() {
	wp_enqueue_script(
		'nexus-customizer-preview',
		NEXUS_ASSETS_URI . '/js/customizer-preview.js',
		array( 'customize-preview' ),
		NEXUS_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'nexus_customizer_preview_scripts' );

/**
 * Converts a hex color to comma-separated RGB values.
 *
 * @param string $hex Hex color string (e.g. '#1a1a2e').
 * @return string Comma-separated RGB (e.g. '26, 26, 46').
 */
function nexus_hex_to_rgb( $hex ) {
	$hex = ltrim( $hex, '#' );
	if ( strlen( $hex ) === 3 ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	return "{$r}, {$g}, {$b}";
}

/**
 * Lightens a hex color by a given amount.
 *
 * @param string $hex    Hex color (e.g. '#0f172a').
 * @param int    $amount Amount to lighten each channel (0-255).
 * @return string Hex color.
 */
function nexus_lighten_hex( $hex, $amount ) {
	$hex = ltrim( $hex, '#' );
	if ( strlen( $hex ) === 3 ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = min( 255, hexdec( substr( $hex, 0, 2 ) ) + $amount );
	$g = min( 255, hexdec( substr( $hex, 2, 2 ) ) + $amount );
	$b = min( 255, hexdec( substr( $hex, 4, 2 ) ) + $amount );
	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Darkens a hex color by a given amount.
 *
 * @param string $hex    Hex color (e.g. '#f8f9fa').
 * @param int    $amount Amount to darken each channel (0-255).
 * @return string Hex color.
 */
function nexus_darken_hex( $hex, $amount ) {
	$hex = ltrim( $hex, '#' );
	if ( strlen( $hex ) === 3 ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$r = max( 0, hexdec( substr( $hex, 0, 2 ) ) - $amount );
	$g = max( 0, hexdec( substr( $hex, 2, 2 ) ) - $amount );
	$b = max( 0, hexdec( substr( $hex, 4, 2 ) ) - $amount );
	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Outputs inline critical CSS variables.
 * This prevents layout shift before main stylesheet loads.
 */
function nexus_output_critical_css() {
	$primary_color   = nexus_option( 'nexus_primary_color', '#1a1a2e' );
	$secondary_color = nexus_option( 'nexus_secondary_color', '#e94560' );
	$accent_color    = nexus_option( 'nexus_accent_color', '#0f3460' );
	$dark_color      = nexus_option( 'nexus_dark_color', '#16213e' );
	$light_color     = nexus_option( 'nexus_light_color', '#f8f9fa' );
	$font_body       = nexus_option( 'nexus_font_body', 'Inter' );
	$font_heading    = nexus_option( 'nexus_font_heading', 'Poppins' );

	$footer_bg_color = nexus_option( 'nexus_footer_bg_color', $primary_color );
	$primary_rgb     = nexus_hex_to_rgb( $primary_color );
	$secondary_rgb   = nexus_hex_to_rgb( $secondary_color );

	// Derive dark mode surfaces from the palette dark color.
	$dm_bg      = nexus_darken_hex( $dark_color, 10 );
	$dm_surface = $dark_color;
	$dm_muted   = nexus_lighten_hex( $dark_color, 4 );
	$dm_header  = $dm_bg;
	$dm_footer  = nexus_darken_hex( $dark_color, 20 );

	$css = sprintf(
		':root {
			--nexus-color-primary: %1$s;
			--nexus-color-secondary: %2$s;
			--nexus-color-accent: %3$s;
			--nexus-color-dark: %4$s;
			--nexus-color-light: %5$s;
			--nexus-primary: %1$s;
			--nexus-secondary: %2$s;
			--nexus-primary-rgb: %6$s;
			--nexus-secondary-rgb: %7$s;
			--nexus-heading-color: %1$s;
			--nexus-text-color: %1$s;
			--nexus-bg-subtle: %5$s;
			--nexus-bg-dark: %1$s;
			--nexus-footer-bg: %10$s;
			--nexus-font-body: "%8$s", -apple-system, BlinkMacSystemFont, sans-serif;
			--nexus-font-heading: "%9$s", -apple-system, BlinkMacSystemFont, sans-serif;
		}
		html.nexus-dark {
			--nexus-dm-bg: %11$s;
			--nexus-dm-surface: %12$s;
			--nexus-dm-muted: %13$s;
			--nexus-dm-header: %14$s;
			--nexus-dm-footer: %15$s;
		}',
		sanitize_hex_color( $primary_color ),    // 1.
		sanitize_hex_color( $secondary_color ),  // 2.
		sanitize_hex_color( $accent_color ),     // 3.
		sanitize_hex_color( $dark_color ),       // 4.
		sanitize_hex_color( $light_color ),      // 5.
		esc_attr( $primary_rgb ),                // 6.
		esc_attr( $secondary_rgb ),              // 7.
		esc_attr( $font_body ),                  // 8.
		esc_attr( $font_heading ),               // 9.
		sanitize_hex_color( $footer_bg_color ),  // 10.
		sanitize_hex_color( $dm_bg ),            // 11.
		sanitize_hex_color( $dm_surface ),       // 12.
		sanitize_hex_color( $dm_muted ),         // 13.
		sanitize_hex_color( $dm_header ),        // 14.
		sanitize_hex_color( $dm_footer )         // 15.
	);

	wp_add_inline_style( 'nexus-main', $css );
}
add_action( 'wp_enqueue_scripts', 'nexus_output_critical_css', 20 );

/**
 * Inline the dark mode script to prevent Flash of Incorrect Theme (FOIT).
 * Must load before any CSS is applied.
 */
function nexus_inline_dark_mode_script() {
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
