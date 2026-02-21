<?php
/**
 * Nexus Theme - Portfolio Custom Post Type
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Portfolio CPT.
 */
function nexus_register_portfolio_cpt() {
	$labels = array(
		'name'                  => esc_html_x( 'Portfolio', 'post type general name', 'nexus' ),
		'singular_name'         => esc_html_x( 'Portfolio Item', 'post type singular name', 'nexus' ),
		'menu_name'             => esc_html_x( 'Portfolio', 'admin menu', 'nexus' ),
		'name_admin_bar'        => esc_html_x( 'Portfolio Item', 'add new on admin bar', 'nexus' ),
		'add_new'               => esc_html__( 'Add New', 'nexus' ),
		'add_new_item'          => esc_html__( 'Add New Portfolio Item', 'nexus' ),
		'new_item'              => esc_html__( 'New Portfolio Item', 'nexus' ),
		'edit_item'             => esc_html__( 'Edit Portfolio Item', 'nexus' ),
		'view_item'             => esc_html__( 'View Portfolio Item', 'nexus' ),
		'all_items'             => esc_html__( 'All Portfolio Items', 'nexus' ),
		'search_items'          => esc_html__( 'Search Portfolio', 'nexus' ),
		'parent_item_colon'     => esc_html__( 'Parent Portfolio:', 'nexus' ),
		'not_found'             => esc_html__( 'No portfolio items found.', 'nexus' ),
		'not_found_in_trash'    => esc_html__( 'No portfolio items found in Trash.', 'nexus' ),
		'featured_image'        => esc_html__( 'Portfolio Thumbnail', 'nexus' ),
		'set_featured_image'    => esc_html__( 'Set portfolio thumbnail', 'nexus' ),
		'remove_featured_image' => esc_html__( 'Remove portfolio thumbnail', 'nexus' ),
		'use_featured_image'    => esc_html__( 'Use as portfolio thumbnail', 'nexus' ),
		'archives'              => esc_html__( 'Portfolio Archives', 'nexus' ),
		'items_list'            => esc_html__( 'Portfolio list', 'nexus' ),
		'items_list_navigation' => esc_html__( 'Portfolio list navigation', 'nexus' ),
		'filter_items_list'     => esc_html__( 'Filter portfolio list', 'nexus' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
	);

	register_post_type( 'nexus_portfolio', $args );

	// Register Portfolio Category taxonomy.
	$tax_labels = array(
		'name'              => esc_html_x( 'Portfolio Categories', 'taxonomy general name', 'nexus' ),
		'singular_name'     => esc_html_x( 'Portfolio Category', 'taxonomy singular name', 'nexus' ),
		'search_items'      => esc_html__( 'Search Portfolio Categories', 'nexus' ),
		'all_items'         => esc_html__( 'All Categories', 'nexus' ),
		'parent_item'       => esc_html__( 'Parent Category', 'nexus' ),
		'parent_item_colon' => esc_html__( 'Parent Category:', 'nexus' ),
		'edit_item'         => esc_html__( 'Edit Category', 'nexus' ),
		'update_item'       => esc_html__( 'Update Category', 'nexus' ),
		'add_new_item'      => esc_html__( 'Add New Category', 'nexus' ),
		'new_item_name'     => esc_html__( 'New Category Name', 'nexus' ),
		'menu_name'         => esc_html__( 'Categories', 'nexus' ),
		'not_found'         => esc_html__( 'No categories found.', 'nexus' ),
	);

	register_taxonomy(
		'nexus_portfolio_category',
		array( 'nexus_portfolio' ),
		array(
			'hierarchical'      => true,
			'labels'            => $tax_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'portfolio-category' ),
		)
	);

	// Register Portfolio Tag taxonomy.
	$tag_labels = array(
		'name'          => esc_html_x( 'Portfolio Tags', 'taxonomy general name', 'nexus' ),
		'singular_name' => esc_html_x( 'Portfolio Tag', 'taxonomy singular name', 'nexus' ),
		'menu_name'     => esc_html__( 'Tags', 'nexus' ),
	);

	register_taxonomy(
		'nexus_portfolio_tag',
		array( 'nexus_portfolio' ),
		array(
			'hierarchical' => false,
			'labels'       => $tag_labels,
			'show_ui'      => true,
			'show_in_rest' => true,
			'query_var'    => true,
			'rewrite'      => array( 'slug' => 'portfolio-tag' ),
		)
	);
}
add_action( 'init', 'nexus_register_portfolio_cpt' );
