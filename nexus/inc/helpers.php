<?php
/**
 * Nexus Theme - Global Helper Functions
 *
 * Utility functions available throughout the theme.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the Kirki customizer value for a given setting.
 *
 * @param string $setting Setting key.
 * @param mixed  $default Default value if not set.
 * @return mixed
 */
function nexus_option( $setting, $default = '' ) {
	if ( class_exists( 'Kirki' ) ) {
		return get_theme_mod( $setting, $default );
	}
	return get_theme_mod( $setting, $default );
}

/**
 * Checks if a specific feature is enabled in theme options.
 *
 * @param string $feature Feature key.
 * @return bool
 */
function nexus_is_enabled( $feature ) {
	return (bool) nexus_option( $feature, false );
}

/**
 * Returns the page-level metabox value via CMB2.
 *
 * @param string $key     Meta key.
 * @param int    $post_id Post/page ID (defaults to current post).
 * @param mixed  $default Default value.
 * @return mixed
 */
function nexus_meta( $key, $post_id = null, $default = '' ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	$value = get_post_meta( $post_id, $key, true );
	return ( '' !== $value ) ? $value : $default;
}

/**
 * Checks whether the current page has a slider configured.
 * Used for conditional Swiper.js loading.
 *
 * Detects:
 * - Manual `_nexus_has_slider` post meta (set via metabox).
 * - Elementor pages containing slider-type Nexus widgets.
 *
 * @return bool
 */
function nexus_page_has_slider() {
	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	// Manual override via post meta.
	$has_slider = nexus_meta( '_nexus_has_slider', $post_id, false );

	// Auto-detect: scan Elementor data for Swiper-powered widgets.
	if ( ! $has_slider ) {
		$cache_key  = 'nexus_has_slider_' . $post_id;
		$from_cache = wp_cache_get( $cache_key, 'nexus' );

		if ( false !== $from_cache ) {
			$has_slider = $from_cache;
		} else {
			$elementor_data = get_post_meta( $post_id, '_elementor_data', true );
			if ( $elementor_data ) {
				// Widget types that rely on Swiper.js.
				$slider_widgets = array( 'nexus-hero-slider', 'nexus-testimonials', 'nexus-product-carousel' );
				foreach ( $slider_widgets as $widget_type ) {
					if ( false !== strpos( $elementor_data, '"' . $widget_type . '"' ) ) {
						$has_slider = true;
						break;
					}
				}
			}
			wp_cache_set( $cache_key, $has_slider, 'nexus', HOUR_IN_SECONDS );
		}
	}

	return (bool) apply_filters( 'nexus_page_has_slider', $has_slider, $post_id );
}

/**
 * Returns the current header style.
 *
 * @return string Header style slug: 'default' | 'transparent' | 'centered' | 'minimal'.
 */
function nexus_get_header_style() {
	$page_style    = nexus_meta( '_nexus_header_style' );
	$default_style = nexus_option( 'nexus_header_style', 'default' );

	return ( $page_style && 'default' !== $page_style ) ? $page_style : $default_style;
}

/**
 * Returns the current page layout.
 *
 * @return string Layout: 'default' | 'full-width' | 'left-sidebar' | 'right-sidebar' | 'no-sidebar'.
 */
function nexus_get_layout() {
	$page_layout    = nexus_meta( '_nexus_page_layout' );
	$default_layout = nexus_option( 'nexus_default_layout', 'right-sidebar' );

	if ( $page_layout && 'default' !== $page_layout ) {
		return $page_layout;
	}

	if ( is_singular( 'post' ) ) {
		return nexus_option( 'nexus_blog_layout', 'right-sidebar' );
	}

	if ( function_exists( 'is_shop' ) && ( is_singular( 'product' ) || is_shop() || is_product_category() || is_product_tag() ) ) {
		return nexus_option( 'nexus_shop_layout', 'right-sidebar' );
	}

	return $default_layout;
}

/**
 * Checks whether the current page should show the sidebar.
 *
 * @return bool
 */
function nexus_has_sidebar() {
	$layout = nexus_get_layout();
	return in_array( $layout, array( 'left-sidebar', 'right-sidebar' ), true );
}

/**
 * Outputs the correct sidebar for the current context.
 */
function nexus_get_sidebar() {
	if ( function_exists( 'is_shop' ) && ( is_singular( 'product' ) || is_shop() || is_product_category() || is_product_tag() ) ) {
		get_sidebar( 'shop' );
	} else {
		get_sidebar();
	}
}

/**
 * Returns an SVG icon markup (from the inline sprite).
 *
 * @param string $icon  Icon name (matches the symbol id in nexus-icons.svg).
 * @param array  $attrs Additional attributes (class, width, height, etc.).
 * @return string SVG markup.
 */
function nexus_icon( $icon, $attrs = array() ) {
	$defaults = array(
		'class'       => 'nexus-icon nexus-icon--' . esc_attr( $icon ),
		'width'       => '1em',
		'height'      => '1em',
		'aria-hidden' => 'true',
		'focusable'   => 'false',
	);
	$attrs    = wp_parse_args( $attrs, $defaults );

	$attr_str = '';
	foreach ( $attrs as $key => $val ) {
		$attr_str .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
	}

	return sprintf(
		'<svg%s><use href="#icon-%s"></use></svg>',
		$attr_str,
		esc_attr( $icon )
	);
}

/**
 * Returns breadcrumb markup.
 * Supports Yoast SEO, RankMath, SEOPress, and native fallback.
 */
function nexus_breadcrumb() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="nexus-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'nexus' ) . '">', '</nav>' );
		return;
	}

	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		echo '<nav class="nexus-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'nexus' ) . '">';
		rank_math_the_breadcrumbs();
		echo '</nav>';
		return;
	}

	// Native fallback.
	$breadcrumb = nexus_get_breadcrumb_fallback();
	if ( $breadcrumb ) {
		echo '<nav class="nexus-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'nexus' ) . '">';
		echo '<ol class="nexus-breadcrumb__list">';
		echo wp_kses_post( $breadcrumb );
		echo '</ol>';
		echo '</nav>';
	}
}

/**
 * Generates a simple breadcrumb fallback when no SEO plugin is active.
 *
 * @return string
 */
function nexus_get_breadcrumb_fallback() {
	if ( is_front_page() ) {
		return '';
	}

	$output = '<li class="nexus-breadcrumb__item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'nexus' ) . '</a></li>';

	if ( is_single() || is_page() ) {
		$output .= '<li class="nexus-breadcrumb__item nexus-breadcrumb__item--current" aria-current="page">' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_archive() ) {
		$output .= '<li class="nexus-breadcrumb__item nexus-breadcrumb__item--current" aria-current="page">' . esc_html( get_the_archive_title() ) . '</li>';
	} elseif ( is_search() ) {
		$output .= '<li class="nexus-breadcrumb__item nexus-breadcrumb__item--current" aria-current="page">' . esc_html__( 'Search Results', 'nexus' ) . '</li>';
	} elseif ( is_404() ) {
		$output .= '<li class="nexus-breadcrumb__item nexus-breadcrumb__item--current" aria-current="page">' . esc_html__( '404 - Not Found', 'nexus' ) . '</li>';
	}

	return $output;
}

/**
 * Returns the reading time estimate for a post.
 *
 * @param int $post_id Post ID.
 * @return string e.g. "5 min read"
 */
function nexus_reading_time( $post_id = null ) {
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = (int) ceil( $word_count / 200 );

	return sprintf(
		/* translators: %d: number of minutes */
		_n( '%d min read', '%d min read', $minutes, 'nexus' ),
		$minutes
	);
}

/**
 * Truncates a string to a given number of words.
 *
 * @param string $text  The text to truncate.
 * @param int    $limit Word limit.
 * @param string $more  String to append when truncated.
 * @return string
 */
function nexus_excerpt_by_words( $text, $limit = 20, $more = '&hellip;' ) {
	$words = explode( ' ', wp_strip_all_tags( $text ) );
	if ( count( $words ) <= $limit ) {
		return $text;
	}
	return implode( ' ', array_slice( $words, 0, $limit ) ) . $more;
}

/**
 * Returns a placeholder image URL.
 *
 * @param int    $width  Width in pixels.
 * @param int    $height Height in pixels.
 * @param string $text   Optional label text.
 * @return string
 */
function nexus_placeholder_image( $width = 600, $height = 400, $text = '' ) {
	return NEXUS_ASSETS_URI . '/images/placeholder.png';
}

/**
 * Checks whether the current screen is the Elementor editor.
 *
 * @return bool
 */
function nexus_is_elementor_editor() {
	return ( isset( $_GET['elementor-preview'] ) || ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) ); // phpcs:ignore WordPress.Security.NonceVerification
}

/**
 * Returns a sanitized class list as a string.
 *
 * @param array $classes Array of class names.
 * @return string
 */
function nexus_class( $classes ) {
	$clean = array_map( 'sanitize_html_class', array_filter( (array) $classes ) );
	return implode( ' ', $clean );
}

/**
 * Outputs the shop view toggle (grid/list) buttons.
 *
 * Called in WooCommerce archive-product.php.
 * JS in nexus-woocommerce.js persists preference via localStorage.
 */
function nexus_shop_view_toggle() {
	?>
	<div class="nexus-view-toggle" role="group" aria-label="<?php esc_attr_e( 'View mode', 'nexus' ); ?>">
		<button
			class="nexus-view-toggle__btn is-active"
			data-view="grid"
			aria-label="<?php esc_attr_e( 'Grid view', 'nexus' ); ?>"
			aria-pressed="true"
		>
			<i class="ri ri-layout-grid-line" aria-hidden="true"></i>
		</button>
		<button
			class="nexus-view-toggle__btn"
			data-view="list"
			aria-label="<?php esc_attr_e( 'List view', 'nexus' ); ?>"
			aria-pressed="false"
		>
			<i class="ri ri-list-check" aria-hidden="true"></i>
		</button>
	</div>
	<?php
}
