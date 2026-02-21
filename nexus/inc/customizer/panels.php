<?php
/**
 * Nexus Theme - Kirki Customizer Panels & Sections
 *
 * Registers all Kirki Customizer panels, sections, and fields.
 * Requires Kirki Framework plugin.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

// -------------------------------------------------------------------------
// Register Kirki configuration.
// -------------------------------------------------------------------------
Kirki::add_config(
	'nexus_theme',
	array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

// -------------------------------------------------------------------------
// Register Panels.
// -------------------------------------------------------------------------
Kirki::add_panel(
	'nexus_panel_general',
	array(
		'priority' => 10,
		'title'    => esc_html__( 'General Settings', 'nexus' ),
	)
);

Kirki::add_panel(
	'nexus_panel_header',
	array(
		'priority' => 20,
		'title'    => esc_html__( 'Header', 'nexus' ),
	)
);

Kirki::add_panel(
	'nexus_panel_typography',
	array(
		'priority' => 30,
		'title'    => esc_html__( 'Typography', 'nexus' ),
	)
);

Kirki::add_panel(
	'nexus_panel_colors',
	array(
		'priority' => 40,
		'title'    => esc_html__( 'Colors', 'nexus' ),
	)
);

Kirki::add_panel(
	'nexus_panel_footer',
	array(
		'priority' => 50,
		'title'    => esc_html__( 'Footer', 'nexus' ),
	)
);

Kirki::add_panel(
	'nexus_panel_blog',
	array(
		'priority' => 60,
		'title'    => esc_html__( 'Blog', 'nexus' ),
	)
);

Kirki::add_panel(
	'nexus_panel_shop',
	array(
		'priority'        => 70,
		'title'           => esc_html__( 'WooCommerce', 'nexus' ),
		'active_callback' => function () {
			return class_exists( 'WooCommerce' );
		},
	)
);

// -------------------------------------------------------------------------
// General Settings — Section: Site Identity.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_general',
	array(
		'title'    => esc_html__( 'General', 'nexus' ),
		'panel'    => 'nexus_panel_general',
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_preloader',
		'label'    => esc_html__( 'Enable Preloader', 'nexus' ),
		'section'  => 'nexus_section_general',
		'default'  => false,
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_back_to_top',
		'label'    => esc_html__( 'Enable Back to Top Button', 'nexus' ),
		'section'  => 'nexus_section_general',
		'default'  => true,
		'priority' => 20,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'select',
		'settings' => 'nexus_default_layout',
		'label'    => esc_html__( 'Default Page Layout', 'nexus' ),
		'section'  => 'nexus_section_general',
		'default'  => 'right-sidebar',
		'priority' => 30,
		'choices'  => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'nexus' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'nexus' ),
			'full-width'    => esc_html__( 'Full Width', 'nexus' ),
		),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'number',
		'settings' => 'nexus_excerpt_length',
		'label'    => esc_html__( 'Excerpt Length (words)', 'nexus' ),
		'section'  => 'nexus_section_general',
		'default'  => 25,
		'priority' => 40,
		'choices'  => array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1,
		),
	)
);

// -------------------------------------------------------------------------
// Header Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_header',
	array(
		'title'    => esc_html__( 'Header Style', 'nexus' ),
		'panel'    => 'nexus_panel_header',
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'radio-image',
		'settings' => 'nexus_header_style',
		'label'    => esc_html__( 'Default Header Style', 'nexus' ),
		'section'  => 'nexus_section_header',
		'default'  => 'default',
		'priority' => 10,
		'choices'  => array(
			'default'     => NEXUS_ASSETS_URI . '/images/customizer/header-default.png',
			'transparent' => NEXUS_ASSETS_URI . '/images/customizer/header-transparent.png',
			'centered'    => NEXUS_ASSETS_URI . '/images/customizer/header-centered.png',
			'minimal'     => NEXUS_ASSETS_URI . '/images/customizer/header-minimal.png',
		),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_header_sticky',
		'label'    => esc_html__( 'Sticky Header', 'nexus' ),
		'section'  => 'nexus_section_header',
		'default'  => true,
		'priority' => 20,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_header_topbar',
		'label'    => esc_html__( 'Show Top Bar', 'nexus' ),
		'section'  => 'nexus_section_header',
		'default'  => false,
		'priority' => 30,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'            => 'text',
		'settings'        => 'nexus_topbar_left_text',
		'label'           => esc_html__( 'Top Bar Left Content', 'nexus' ),
		'description'     => esc_html__( 'HTML is allowed (phone, email, etc.)', 'nexus' ),
		'section'         => 'nexus_section_header',
		'default'         => '',
		'priority'        => 40,
		'active_callback' => array(
			array(
				'setting'  => 'nexus_header_topbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_header_search',
		'label'    => esc_html__( 'Show Search Icon', 'nexus' ),
		'section'  => 'nexus_section_header',
		'default'  => true,
		'priority' => 50,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_header_cart',
		'label'    => esc_html__( 'Show Cart Icon', 'nexus' ),
		'section'  => 'nexus_section_header',
		'default'  => true,
		'priority' => 60,
	)
);

// -------------------------------------------------------------------------
// Title Bar Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_title_bar',
	array(
		'title'    => esc_html__( 'Title Bar', 'nexus' ),
		'panel'    => 'nexus_panel_header',
		'priority' => 20,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_title_bar_breadcrumb',
		'label'    => esc_html__( 'Show Breadcrumb in Title Bar', 'nexus' ),
		'section'  => 'nexus_section_title_bar',
		'default'  => true,
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'color',
		'settings' => 'nexus_title_bar_bg',
		'label'    => esc_html__( 'Title Bar Background Color', 'nexus' ),
		'section'  => 'nexus_section_title_bar',
		'default'  => '#f8f9fa',
		'priority' => 20,
		'choices'  => array( 'alpha' => false ),
	)
);

// -------------------------------------------------------------------------
// Colors Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_colors_brand',
	array(
		'title'    => esc_html__( 'Brand Colors', 'nexus' ),
		'panel'    => 'nexus_panel_colors',
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'      => 'color',
		'settings'  => 'nexus_primary_color',
		'label'     => esc_html__( 'Primary Color', 'nexus' ),
		'section'   => 'nexus_section_colors_brand',
		'default'   => '#1a1a2e',
		'priority'  => 10,
		'transport' => 'postMessage',
		'choices'   => array( 'alpha' => false ),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'      => 'color',
		'settings'  => 'nexus_secondary_color',
		'label'     => esc_html__( 'Secondary / Accent Color', 'nexus' ),
		'section'   => 'nexus_section_colors_brand',
		'default'   => '#e94560',
		'priority'  => 20,
		'transport' => 'postMessage',
		'choices'   => array( 'alpha' => false ),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'color',
		'settings' => 'nexus_body_text_color',
		'label'    => esc_html__( 'Body Text Color', 'nexus' ),
		'section'  => 'nexus_section_colors_brand',
		'default'  => '#1a1a2e',
		'priority' => 30,
		'choices'  => array( 'alpha' => false ),
	)
);

// -------------------------------------------------------------------------
// Dark Mode Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_dark_mode',
	array(
		'title'    => esc_html__( 'Dark Mode', 'nexus' ),
		'panel'    => 'nexus_panel_colors',
		'priority' => 20,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'        => 'toggle',
		'settings'    => 'nexus_dark_mode_enabled',
		'label'       => esc_html__( 'Enable Dark Mode Toggle', 'nexus' ),
		'description' => esc_html__( 'Adds a dark mode toggle button to the header. Respects user\'s system preference.', 'nexus' ),
		'section'     => 'nexus_section_dark_mode',
		'default'     => false,
		'priority'    => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'            => 'color',
		'settings'        => 'nexus_dark_mode_bg',
		'label'           => esc_html__( 'Dark Mode Background', 'nexus' ),
		'section'         => 'nexus_section_dark_mode',
		'default'         => '#0d0d0d',
		'priority'        => 20,
		'active_callback' => array(
			array(
				'setting'  => 'nexus_dark_mode_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'            => 'color',
		'settings'        => 'nexus_dark_mode_text',
		'label'           => esc_html__( 'Dark Mode Text Color', 'nexus' ),
		'section'         => 'nexus_section_dark_mode',
		'default'         => '#e0e0e0',
		'priority'        => 30,
		'active_callback' => array(
			array(
				'setting'  => 'nexus_dark_mode_enabled',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

// -------------------------------------------------------------------------
// Typography Section: Body.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_typography_body',
	array(
		'title'    => esc_html__( 'Body Typography', 'nexus' ),
		'panel'    => 'nexus_panel_typography',
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'      => 'typography',
		'settings'  => 'nexus_typography_body',
		'label'     => esc_html__( 'Body Font', 'nexus' ),
		'section'   => 'nexus_section_typography_body',
		'default'   => array(
			'font-family'    => 'Inter',
			'variant'        => '400',
			'font-size'      => '16px',
			'line-height'    => '1.6',
			'letter-spacing' => '0em',
			'color'          => '#1a1a2e',
		),
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element' => 'body',
			),
		),
	)
);

// -------------------------------------------------------------------------
// Typography Section: Headings.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_typography_headings',
	array(
		'title'    => esc_html__( 'Headings Typography', 'nexus' ),
		'panel'    => 'nexus_panel_typography',
		'priority' => 20,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'      => 'typography',
		'settings'  => 'nexus_typography_headings',
		'label'     => esc_html__( 'Headings Font', 'nexus' ),
		'section'   => 'nexus_section_typography_headings',
		'default'   => array(
			'font-family' => 'Poppins',
			'variant'     => '700',
			'color'       => '#1a1a2e',
		),
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element' => 'h1, h2, h3, h4, h5, h6',
			),
		),
	)
);

// -------------------------------------------------------------------------
// Footer Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_footer_general',
	array(
		'title'    => esc_html__( 'Footer General', 'nexus' ),
		'panel'    => 'nexus_panel_footer',
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_footer_widgets',
		'label'    => esc_html__( 'Show Footer Widget Area', 'nexus' ),
		'section'  => 'nexus_section_footer_general',
		'default'  => true,
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'color',
		'settings' => 'nexus_footer_bg_color',
		'label'    => esc_html__( 'Footer Background Color', 'nexus' ),
		'section'  => 'nexus_section_footer_general',
		'default'  => '#1a1a2e',
		'priority' => 20,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'        => 'textarea',
		'settings'    => 'nexus_footer_copyright',
		'label'       => esc_html__( 'Copyright Text', 'nexus' ),
		'description' => esc_html__( 'Use {year} to display the current year. HTML allowed.', 'nexus' ),
		'section'     => 'nexus_section_footer_general',
		'default'     => '&copy; {year} Your Site. All Rights Reserved.',
		'priority'    => 30,
	)
);

// -------------------------------------------------------------------------
// Blog Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_blog',
	array(
		'title'    => esc_html__( 'Blog Settings', 'nexus' ),
		'panel'    => 'nexus_panel_blog',
		'priority' => 10,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'select',
		'settings' => 'nexus_blog_layout',
		'label'    => esc_html__( 'Blog Layout', 'nexus' ),
		'section'  => 'nexus_section_blog',
		'default'  => 'right-sidebar',
		'priority' => 10,
		'choices'  => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'nexus' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'nexus' ),
			'full-width'    => esc_html__( 'Full Width', 'nexus' ),
		),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'select',
		'settings' => 'nexus_blog_style',
		'label'    => esc_html__( 'Blog Post Style', 'nexus' ),
		'section'  => 'nexus_section_blog',
		'default'  => 'grid',
		'priority' => 20,
		'choices'  => array(
			'grid'    => esc_html__( 'Grid', 'nexus' ),
			'list'    => esc_html__( 'List', 'nexus' ),
			'masonry' => esc_html__( 'Masonry', 'nexus' ),
		),
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_related_posts',
		'label'    => esc_html__( 'Show Related Posts', 'nexus' ),
		'section'  => 'nexus_section_blog',
		'default'  => true,
		'priority' => 30,
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'     => 'toggle',
		'settings' => 'nexus_author_bio',
		'label'    => esc_html__( 'Show Author Bio Box', 'nexus' ),
		'section'  => 'nexus_section_blog',
		'default'  => true,
		'priority' => 40,
	)
);

// Post meta visibility settings.
foreach ( array( 'date', 'author', 'category', 'reading_time' ) as $nexus_meta_item ) {
	Kirki::add_field(
		'nexus_theme',
		array(
			'type'     => 'toggle',
			'settings' => 'nexus_post_meta_' . $nexus_meta_item,
			/* translators: %s: meta item name */
			'label'    => sprintf( esc_html__( 'Show Post %s', 'nexus' ), ucfirst( str_replace( '_', ' ', $nexus_meta_item ) ) ),
			'section'  => 'nexus_section_blog',
			'default'  => true,
			'priority' => 50,
		)
	);
}

// -------------------------------------------------------------------------
// WooCommerce Section.
// -------------------------------------------------------------------------
Kirki::add_section(
	'nexus_section_shop',
	array(
		'title'           => esc_html__( 'Shop Settings', 'nexus' ),
		'panel'           => 'nexus_panel_shop',
		'priority'        => 10,
		'active_callback' => function () {
			return class_exists( 'WooCommerce' );
		},
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'            => 'select',
		'settings'        => 'nexus_shop_layout',
		'label'           => esc_html__( 'Shop Layout', 'nexus' ),
		'section'         => 'nexus_section_shop',
		'default'         => 'right-sidebar',
		'priority'        => 10,
		'choices'         => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'nexus' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'nexus' ),
			'full-width'    => esc_html__( 'Full Width (No Sidebar)', 'nexus' ),
		),
		'active_callback' => function () {
			return class_exists( 'WooCommerce' );
		},
	)
);

Kirki::add_field(
	'nexus_theme',
	array(
		'type'            => 'slider',
		'settings'        => 'nexus_shop_columns',
		'label'           => esc_html__( 'Products per Row', 'nexus' ),
		'section'         => 'nexus_section_shop',
		'default'         => 3,
		'priority'        => 20,
		'choices'         => array(
			'min'  => 2,
			'max'  => 5,
			'step' => 1,
		),
		'active_callback' => function () {
			return class_exists( 'WooCommerce' );
		},
	)
);
