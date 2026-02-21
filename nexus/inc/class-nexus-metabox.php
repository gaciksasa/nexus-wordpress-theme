<?php
/**
 * Nexus Theme - CMB2 Meta Boxes
 *
 * Per-page/post option controls using CMB2 library.
 * Controls: header style, page layout, title bar visibility, custom CSS.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if CMB2 is available.
if ( ! class_exists( 'CMB2' ) ) {
	return;
}

/**
 * Class Nexus_Metabox
 *
 * Registers all CMB2 meta boxes for the theme.
 */
class Nexus_Metabox {

	/**
	 * Instance.
	 *
	 * @var Nexus_Metabox
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Nexus_Metabox
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'register_metaboxes' ) );
	}

	/**
	 * Registers all meta boxes.
	 */
	public function register_metaboxes() {
		$this->register_page_options();
		$this->register_header_options();
		$this->register_portfolio_meta();
		$this->register_team_meta();
		$this->register_testimonial_meta();
	}

	/**
	 * Page/post layout and display options.
	 */
	private function register_page_options() {
		$cmb = new_cmb2_box(
			array(
				'id'           => 'nexus_page_options',
				'title'        => esc_html__( 'Page Options', 'nexus' ),
				'object_types' => array( 'page', 'post' ),
				'context'      => 'side',
				'priority'     => 'low',
				'show_names'   => true,
			)
		);

		$cmb->add_field(
			array(
				'name'    => esc_html__( 'Page Layout', 'nexus' ),
				'id'      => '_nexus_page_layout',
				'type'    => 'select',
				'default' => 'default',
				'options' => array(
					'default'       => esc_html__( 'Default (from Customizer)', 'nexus' ),
					'right-sidebar' => esc_html__( 'Right Sidebar', 'nexus' ),
					'left-sidebar'  => esc_html__( 'Left Sidebar', 'nexus' ),
					'full-width'    => esc_html__( 'Full Width', 'nexus' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'nexus' ),
				),
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Hide Page Title', 'nexus' ),
				'id'   => '_nexus_hide_title',
				'type' => 'checkbox',
				'desc' => esc_html__( 'Check to hide the page title on this page.', 'nexus' ),
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Hide Title Bar', 'nexus' ),
				'id'   => '_nexus_hide_title_bar',
				'type' => 'checkbox',
				'desc' => esc_html__( 'Check to hide the breadcrumb/title bar section.', 'nexus' ),
			)
		);

		$cmb->add_field(
			array(
				'name'    => esc_html__( 'Title Bar Background Image', 'nexus' ),
				'id'      => '_nexus_title_bar_bg',
				'type'    => 'file',
				'options' => array(
					'url' => false,
				),
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Has Slider', 'nexus' ),
				'id'   => '_nexus_has_slider',
				'type' => 'checkbox',
				'desc' => esc_html__( 'Enable to load Swiper.js assets on this page.', 'nexus' ),
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Custom CSS', 'nexus' ),
				'id'   => '_nexus_custom_css',
				'type' => 'textarea_code',
				'desc' => esc_html__( 'Custom CSS for this page only. Do not include &lt;style&gt; tags.', 'nexus' ),
			)
		);
	}

	/**
	 * Per-page header style override.
	 */
	private function register_header_options() {
		$cmb = new_cmb2_box(
			array(
				'id'           => 'nexus_header_options',
				'title'        => esc_html__( 'Header Options', 'nexus' ),
				'object_types' => array( 'page', 'post' ),
				'context'      => 'side',
				'priority'     => 'low',
			)
		);

		$cmb->add_field(
			array(
				'name'    => esc_html__( 'Header Style', 'nexus' ),
				'id'      => '_nexus_header_style',
				'type'    => 'select',
				'default' => 'default',
				'options' => array(
					'default'     => esc_html__( 'Default (from Customizer)', 'nexus' ),
					'transparent' => esc_html__( 'Transparent', 'nexus' ),
					'centered'    => esc_html__( 'Centered Logo', 'nexus' ),
					'minimal'     => esc_html__( 'Minimal', 'nexus' ),
					'hidden'      => esc_html__( 'Hidden', 'nexus' ),
				),
			)
		);
	}

	/**
	 * Portfolio item meta fields.
	 */
	private function register_portfolio_meta() {
		$cmb = new_cmb2_box(
			array(
				'id'           => 'nexus_portfolio_meta',
				'title'        => esc_html__( 'Portfolio Details', 'nexus' ),
				'object_types' => array( 'nexus_portfolio' ),
				'context'      => 'normal',
				'priority'     => 'high',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Client', 'nexus' ),
				'id'   => '_nexus_portfolio_client',
				'type' => 'text',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Date Completed', 'nexus' ),
				'id'   => '_nexus_portfolio_date',
				'type' => 'text_date',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Project URL', 'nexus' ),
				'id'   => '_nexus_portfolio_url',
				'type' => 'text_url',
				'desc' => esc_html__( 'Live project link (optional).', 'nexus' ),
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Services Used', 'nexus' ),
				'id'   => '_nexus_portfolio_services',
				'type' => 'text',
				'desc' => esc_html__( 'Comma-separated list (e.g. Design, Development, SEO)', 'nexus' ),
			)
		);

		$cmb->add_field(
			array(
				'name'    => esc_html__( 'Gallery Images', 'nexus' ),
				'id'      => '_nexus_portfolio_gallery',
				'type'    => 'file_list',
				'options' => array(
					'url' => false,
				),
			)
		);
	}

	/**
	 * Team member meta fields.
	 */
	private function register_team_meta() {
		$cmb = new_cmb2_box(
			array(
				'id'           => 'nexus_team_meta',
				'title'        => esc_html__( 'Team Member Details', 'nexus' ),
				'object_types' => array( 'nexus_team' ),
				'context'      => 'normal',
				'priority'     => 'high',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Job Title / Position', 'nexus' ),
				'id'   => '_nexus_team_position',
				'type' => 'text',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Email', 'nexus' ),
				'id'   => '_nexus_team_email',
				'type' => 'text_email',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Phone', 'nexus' ),
				'id'   => '_nexus_team_phone',
				'type' => 'text',
			)
		);

		foreach ( array( 'linkedin', 'twitter', 'facebook', 'instagram' ) as $social ) {
			$cmb->add_field(
				array(
					/* translators: %s: social network name */
					'name' => sprintf( esc_html__( '%s URL', 'nexus' ), ucfirst( $social ) ),
					'id'   => '_nexus_team_' . $social,
					'type' => 'text_url',
				)
			);
		}
	}

	/**
	 * Testimonial meta fields.
	 */
	private function register_testimonial_meta() {
		$cmb = new_cmb2_box(
			array(
				'id'           => 'nexus_testimonial_meta',
				'title'        => esc_html__( 'Testimonial Details', 'nexus' ),
				'object_types' => array( 'nexus_testimonial' ),
				'context'      => 'normal',
				'priority'     => 'high',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Client Name', 'nexus' ),
				'id'   => '_nexus_testimonial_name',
				'type' => 'text',
			)
		);

		$cmb->add_field(
			array(
				'name' => esc_html__( 'Client Position', 'nexus' ),
				'id'   => '_nexus_testimonial_position',
				'type' => 'text',
				'desc' => esc_html__( 'e.g. CEO, Acme Corp', 'nexus' ),
			)
		);

		$cmb->add_field(
			array(
				'name'    => esc_html__( 'Rating', 'nexus' ),
				'id'      => '_nexus_testimonial_rating',
				'type'    => 'select',
				'default' => '5',
				'options' => array(
					'5' => esc_html__( '5 Stars', 'nexus' ),
					'4' => esc_html__( '4 Stars', 'nexus' ),
					'3' => esc_html__( '3 Stars', 'nexus' ),
					'2' => esc_html__( '2 Stars', 'nexus' ),
					'1' => esc_html__( '1 Star', 'nexus' ),
				),
			)
		);
	}
}

// Initialize.
Nexus_Metabox::instance();
