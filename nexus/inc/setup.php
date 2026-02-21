<?php
/**
 * Nexus Theme Setup
 *
 * Registers theme supports, navigation menus, image sizes,
 * widget areas, and other core WordPress features.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nexus_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function nexus_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'nexus', NEXUS_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title tag.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register custom image sizes.
		add_image_size( 'nexus-thumbnail', 380, 280, true );
		add_image_size( 'nexus-medium', 600, 450, true );
		add_image_size( 'nexus-large', 900, 600, true );
		add_image_size( 'nexus-wide', 1200, 600, true );
		add_image_size( 'nexus-hero', 1920, 900, true );
		add_image_size( 'nexus-square', 500, 500, true );
		add_image_size( 'nexus-portrait', 480, 640, true );

		// Register nav menus.
		register_nav_menus(
			array(
				'primary'   => esc_html__( 'Primary Navigation', 'nexus' ),
				'secondary' => esc_html__( 'Secondary Navigation', 'nexus' ),
				'footer'    => esc_html__( 'Footer Navigation', 'nexus' ),
				'mobile'    => esc_html__( 'Mobile Navigation', 'nexus' ),
				'topbar'    => esc_html__( 'Top Bar Navigation', 'nexus' ),
			)
		);

		// Switch default core markup to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'nexus_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 80,
				'width'       => 220,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/nexus-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental link color control.
		add_theme_support( 'link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Add support for custom units.
		add_theme_support( 'custom-units' );

		// Template editing mode for FSE.
		add_theme_support( 'block-template-parts' );

		// WooCommerce support.
		nexus_add_woocommerce_support();
	}
}
add_action( 'after_setup_theme', 'nexus_setup' );

/**
 * Registers WooCommerce theme support.
 */
function nexus_add_woocommerce_support() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 380,
			'single_image_width'    => 600,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 2,
				'max_rows'        => 8,
				'default_columns' => 3,
				'min_columns'     => 2,
				'max_columns'     => 5,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Registers widget areas (sidebars).
 */
function nexus_widgets_init() {
	// Primary sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Sidebar', 'nexus' ),
			'id'            => 'sidebar-primary',
			'description'   => esc_html__( 'Add widgets here to appear in the primary sidebar.', 'nexus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Shop sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'nexus' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Add widgets here to appear in the WooCommerce shop sidebar.', 'nexus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Footer widget areas.
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer column number */
				'name'          => sprintf( esc_html__( 'Footer Column %d', 'nexus' ), $i ),
				'id'            => 'footer-' . $i,
				/* translators: %d: footer column number */
				'description'   => sprintf( esc_html__( 'Add widgets here to appear in footer column %d.', 'nexus' ), $i ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Header widget area (for top bar content).
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Top Bar', 'nexus' ),
			'id'            => 'header-topbar',
			'description'   => esc_html__( 'Add widgets here to appear in the top bar area of the header.', 'nexus' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title screen-reader-text">',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', 'nexus_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nexus_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nexus_content_width', 780 );
}
add_action( 'after_setup_theme', 'nexus_content_width', 0 );

/**
 * Adds custom image sizes to the media uploader.
 *
 * @param array $sizes Array of image sizes.
 * @return array Modified array of image sizes.
 */
function nexus_custom_image_sizes( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'nexus-thumbnail' => esc_html__( 'Nexus Thumbnail', 'nexus' ),
			'nexus-medium'    => esc_html__( 'Nexus Medium', 'nexus' ),
			'nexus-large'     => esc_html__( 'Nexus Large', 'nexus' ),
			'nexus-wide'      => esc_html__( 'Nexus Wide', 'nexus' ),
			'nexus-hero'      => esc_html__( 'Nexus Hero', 'nexus' ),
			'nexus-square'    => esc_html__( 'Nexus Square', 'nexus' ),
			'nexus-portrait'  => esc_html__( 'Nexus Portrait', 'nexus' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'nexus_custom_image_sizes' );

/**
 * Declare compatibility with WooCommerce HPOS (High-Performance Order Storage).
 */
function nexus_declare_woocommerce_hpos_compatibility() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
			'custom_order_tables',
			NEXUS_DIR . '/functions.php',
			true
		);
	}
}
add_action( 'before_woocommerce_init', 'nexus_declare_woocommerce_hpos_compatibility' );
