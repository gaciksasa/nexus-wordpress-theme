<?php
/**
 * Nexus Theme - Testimonials Custom Post Type
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Testimonials CPT.
 */
function nexus_register_testimonials_cpt() {
	$labels = array(
		'name'               => esc_html_x( 'Testimonials', 'post type general name', 'nexus' ),
		'singular_name'      => esc_html_x( 'Testimonial', 'post type singular name', 'nexus' ),
		'menu_name'          => esc_html_x( 'Testimonials', 'admin menu', 'nexus' ),
		'add_new'            => esc_html__( 'Add New', 'nexus' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial', 'nexus' ),
		'edit_item'          => esc_html__( 'Edit Testimonial', 'nexus' ),
		'view_item'          => esc_html__( 'View Testimonial', 'nexus' ),
		'all_items'          => esc_html__( 'All Testimonials', 'nexus' ),
		'search_items'       => esc_html__( 'Search Testimonials', 'nexus' ),
		'not_found'          => esc_html__( 'No testimonials found.', 'nexus' ),
		'not_found_in_trash' => esc_html__( 'No testimonials found in Trash.', 'nexus' ),
	);

	$args = array(
		'labels'          => $labels,
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => true,
		'capability_type' => 'post',
		'has_archive'     => false,
		'hierarchical'    => false,
		'menu_position'   => 6,
		'menu_icon'       => 'dashicons-format-quote',
		'supports'        => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
	);

	register_post_type( 'nexus_testimonial', $args );
}
add_action( 'init', 'nexus_register_testimonials_cpt' );
