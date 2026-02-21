<?php
/**
 * Nexus Theme - Team Members Custom Post Type
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Team Members CPT.
 */
function nexus_register_team_cpt() {
	$labels = array(
		'name'               => esc_html_x( 'Team Members', 'post type general name', 'nexus' ),
		'singular_name'      => esc_html_x( 'Team Member', 'post type singular name', 'nexus' ),
		'menu_name'          => esc_html_x( 'Team', 'admin menu', 'nexus' ),
		'add_new'            => esc_html__( 'Add New', 'nexus' ),
		'add_new_item'       => esc_html__( 'Add Team Member', 'nexus' ),
		'edit_item'          => esc_html__( 'Edit Team Member', 'nexus' ),
		'all_items'          => esc_html__( 'All Team Members', 'nexus' ),
		'not_found'          => esc_html__( 'No team members found.', 'nexus' ),
		'not_found_in_trash' => esc_html__( 'No team members found in Trash.', 'nexus' ),
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
		'menu_position'   => 7,
		'menu_icon'       => 'dashicons-groups',
		'supports'        => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
	);

	register_post_type( 'nexus_team', $args );

	// Department taxonomy for team members.
	register_taxonomy(
		'nexus_team_department',
		array( 'nexus_team' ),
		array(
			'hierarchical' => true,
			'labels'       => array(
				'name'          => esc_html_x( 'Departments', 'taxonomy general name', 'nexus' ),
				'singular_name' => esc_html_x( 'Department', 'taxonomy singular name', 'nexus' ),
				'menu_name'     => esc_html__( 'Departments', 'nexus' ),
			),
			'show_ui'      => true,
			'show_in_rest' => true,
			'query_var'    => true,
			'rewrite'      => array( 'slug' => 'department' ),
		)
	);
}
add_action( 'init', 'nexus_register_team_cpt' );
