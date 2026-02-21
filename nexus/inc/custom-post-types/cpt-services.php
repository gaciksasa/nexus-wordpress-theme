<?php
/**
 * Nexus Theme - Services Custom Post Type
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Services CPT.
 */
function nexus_register_services_cpt() {
	$labels = array(
		'name'               => esc_html_x( 'Services', 'post type general name', 'nexus' ),
		'singular_name'      => esc_html_x( 'Service', 'post type singular name', 'nexus' ),
		'menu_name'          => esc_html_x( 'Services', 'admin menu', 'nexus' ),
		'add_new'            => esc_html__( 'Add New', 'nexus' ),
		'add_new_item'       => esc_html__( 'Add New Service', 'nexus' ),
		'edit_item'          => esc_html__( 'Edit Service', 'nexus' ),
		'all_items'          => esc_html__( 'All Services', 'nexus' ),
		'not_found'          => esc_html__( 'No services found.', 'nexus' ),
		'not_found_in_trash' => esc_html__( 'No services found in Trash.', 'nexus' ),
	);

	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => true,
		'capability_type' => 'post',
		'has_archive'     => true,
		'hierarchical'    => false,
		'menu_position'   => 8,
		'menu_icon'       => 'dashicons-star-filled',
		'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'rewrite'         => array( 'slug' => 'services' ),
	);

	register_post_type( 'nexus_service', $args );
}
add_action( 'init', 'nexus_register_services_cpt' );
