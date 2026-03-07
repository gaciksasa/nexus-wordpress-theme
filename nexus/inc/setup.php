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

// -------------------------------------------------------------------------
// Default demo navigation (runs once on theme activation).
// -------------------------------------------------------------------------

/**
 * Creates a demo primary navigation menu with a mega menu example.
 * Runs on `after_switch_theme` so the user sees a working navigation
 * immediately after activating the theme.
 */
function nexus_create_default_menus() {

	// Bail if primary menu is already assigned.
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		return;
	}

	// Check if menu already exists.
	$menu_name = 'Primary Navigation';
	$menu_obj  = wp_get_nav_menu_object( $menu_name );

	if ( $menu_obj ) {
		// Menu exists but not assigned — just assign it.
		set_theme_mod( 'nav_menu_locations', array_merge(
			$locations,
			array( 'primary' => $menu_obj->term_id )
		) );
		return;
	}

	$menu_id = wp_create_nav_menu( $menu_name );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	// Helper: create a menu item with optional Nexus custom meta.
	$prefix = '_nexus_menu_';
	$add    = function ( $title, $url = '#', $parent = 0, $order = 0, $classes = array(), $meta = array() ) use ( $menu_id, $prefix ) {
		$item_id = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $title,
				'menu-item-url'       => $url,
				'menu-item-status'    => 'publish',
				'menu-item-type'      => 'custom',
				'menu-item-parent-id' => $parent,
				'menu-item-position'  => $order,
				'menu-item-classes'   => implode( ' ', $classes ),
			)
		);

		if ( ! is_wp_error( $item_id ) && ! empty( $meta ) ) {
			foreach ( $meta as $key => $value ) {
				update_post_meta( $item_id, $prefix . $key, $value );
			}
		}

		return $item_id;
	};

	// --- Home ---
	$home_url = home_url( '/' );
	$add( 'Home', $home_url, 0, 1, array(), array( 'icon' => 'home' ) );

	// --- Pages (mega menu) ---
	$pages_id = $add( 'Pages', '#', 0, 2, array( 'mega-menu' ) );

	// Column 1: Company.
	$col1 = $add( 'Company', '#', $pages_id, 1, array(), array( 'icon' => 'briefcase', 'desc' => 'Learn about our team and values' ) );
	$add( 'About Us', '#', $col1, 1, array(), array( 'icon' => 'users', 'desc' => 'Our story and mission' ) );
	$add( 'Our Team', '#', $col1, 2, array(), array( 'icon' => 'users' ) );
	$add( 'Careers', '#', $col1, 3, array(), array( 'icon' => 'briefcase', 'badge' => 'Hiring', 'badge_color' => 'success' ) );
	$add( 'Contact', '#', $col1, 4, array(), array( 'icon' => 'mail' ) );

	// Column 2: Services.
	$col2 = $add( 'Services', '#', $pages_id, 2, array(), array( 'icon' => 'settings', 'desc' => 'What we offer' ) );
	$add( 'Web Design', '#', $col2, 1, array(), array( 'icon' => 'palette', 'desc' => 'Beautiful, responsive designs' ) );
	$add( 'Development', '#', $col2, 2, array(), array( 'icon' => 'code' ) );
	$add( 'SEO & Marketing', '#', $col2, 3, array(), array( 'icon' => 'trending-up' ) );
	$add( 'Consulting', '#', $col2, 4, array(), array( 'icon' => 'megaphone' ) );

	// Column 3: Portfolio.
	$col3 = $add( 'Portfolio', '#', $pages_id, 3, array(), array( 'icon' => 'layers', 'desc' => 'Our recent projects' ) );
	$add( 'Case Studies', '#', $col3, 1, array(), array( 'icon' => 'file', 'desc' => 'In-depth project reviews' ) );
	$add( 'Recent Work', '#', $col3, 2, array(), array( 'icon' => 'image', 'badge' => 'New', 'badge_color' => 'secondary' ) );
	$add( 'Clients', '#', $col3, 3, array(), array( 'icon' => 'heart' ) );

	// Column 4: Support.
	$col4 = $add( 'Support', '#', $pages_id, 4, array(), array( 'icon' => 'shield', 'desc' => 'Help and documentation' ) );
	$add( 'Help Center', '#', $col4, 1, array(), array( 'icon' => 'book', 'desc' => 'Browse support articles' ) );
	$add( 'Documentation', '#', $col4, 2, array(), array( 'icon' => 'file' ) );
	$add( 'FAQ', '#', $col4, 3, array(), array( 'icon' => 'check' ) );
	$add( 'Status Page', '#', $col4, 4, array(), array( 'icon' => 'globe' ) );

	// --- Features (mega menu) ---
	$features_id = $add( 'Features', '#', 0, 3, array( 'mega-menu' ) );

	// Column 1: Platform.
	$fcol1 = $add( 'Platform', '#', $features_id, 1, array(), array( 'icon' => 'grid', 'desc' => 'Core platform tools' ) );
	$add( 'Analytics Dashboard', '#', $fcol1, 1, array(), array( 'icon' => 'chart', 'desc' => 'Real-time data insights', 'badge' => 'Popular', 'badge_color' => 'primary' ) );
	$add( 'Reporting Tools', '#', $fcol1, 2, array(), array( 'icon' => 'trending-up' ) );
	$add( 'API Platform', '#', $fcol1, 3, array(), array( 'icon' => 'code', 'badge' => 'New', 'badge_color' => 'success' ) );
	$add( 'Integrations', '#', $fcol1, 4, array(), array( 'icon' => 'link' ) );

	// Column 2: Solutions.
	$fcol2 = $add( 'Solutions', '#', $features_id, 2, array(), array( 'icon' => 'rocket', 'desc' => 'Tailored for your needs' ) );
	$add( 'For Startups', '#', $fcol2, 1, array(), array( 'icon' => 'zap', 'desc' => 'Launch faster' ) );
	$add( 'For Enterprise', '#', $fcol2, 2, array(), array( 'icon' => 'server', 'desc' => 'Scale with confidence' ) );
	$add( 'For Agencies', '#', $fcol2, 3, array(), array( 'icon' => 'users', 'desc' => 'Manage multiple clients' ) );

	// Column 3: Resources.
	$fcol3 = $add( 'Resources', '#', $features_id, 3, array(), array( 'icon' => 'book', 'desc' => 'Learn and grow' ) );
	$add( 'Blog', '#', $fcol3, 1, array(), array( 'icon' => 'pen' ) );
	$add( 'Webinars', '#', $fcol3, 2, array(), array( 'icon' => 'video', 'badge' => 'Live', 'badge_color' => 'danger' ) );
	$add( 'Guides', '#', $fcol3, 3, array(), array( 'icon' => 'book' ) );
	$add( 'Templates', '#', $fcol3, 4, array(), array( 'icon' => 'folder', 'badge' => 'Hot', 'badge_color' => 'warning' ) );

	// --- Blog (regular) ---
	$add( 'Blog', '#', 0, 4 );

	// --- Shop (regular dropdown) ---
	$shop_id = $add( 'Shop', '#', 0, 5 );
	$add( 'All Products', '#', $shop_id, 1, array(), array( 'icon' => 'shopping-bag' ) );
	$add( 'Categories', '#', $shop_id, 2, array(), array( 'icon' => 'grid' ) );
	$add( 'Sale', '#', $shop_id, 3, array(), array( 'icon' => 'tag', 'badge' => 'Sale', 'badge_color' => 'danger' ) );

	// --- Contact (regular) ---
	$add( 'Contact', '#', 0, 6, array(), array( 'icon' => 'mail' ) );

	// Assign to primary location.
	set_theme_mod( 'nav_menu_locations', array_merge(
		$locations,
		array( 'primary' => $menu_id )
	) );
}
add_action( 'after_switch_theme', 'nexus_create_default_menus' );
