<?php
/**
 * Nexus Theme - Main Theme Class
 *
 * Singleton class that manages the theme instance.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Theme
 *
 * Main theme singleton. Use Nexus_Theme::instance() to get the instance.
 */
final class Nexus_Theme {

	/**
	 * The single instance of the class.
	 *
	 * @var Nexus_Theme
	 */
	private static $instance = null;

	/**
	 * Theme version.
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Returns the single instance of the class.
	 *
	 * @return Nexus_Theme
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor — intentionally private.
	 */
	private function __construct() {
		$this->version = NEXUS_VERSION;
		$this->init_hooks();
	}

	/**
	 * Prevent cloning.
	 */
	private function __clone() {}

	/**
	 * Prevent unserialization.
	 *
	 * @throws \Exception Always.
	 */
	public function __wakeup() {
		throw new \Exception( 'Cannot unserialize singleton.' );
	}

	/**
	 * Registers core hooks.
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'on_init' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		add_filter( 'wp_title', array( $this, 'wp_title' ), 10, 2 );
	}

	/**
	 * Fires on WordPress init.
	 */
	public function on_init() {
		// Nothing here yet — reserved for future init-time tasks.
	}

	/**
	 * Adds custom classes to the body element.
	 *
	 * @param array $classes Existing body classes.
	 * @return array Modified body classes.
	 */
	public function body_classes( $classes ) {
		// Add page layout class.
		$layout    = nexus_get_layout();
		$classes[] = 'nexus-layout--' . sanitize_html_class( $layout );

		// Add header style class.
		$header_style = nexus_get_header_style();
		$classes[]    = 'nexus-header--' . sanitize_html_class( $header_style );

		// Add dark mode class.
		if ( nexus_option( 'nexus_dark_mode_enabled', false ) ) {
			$classes[] = 'nexus-dark-mode-enabled';
		}

		// Add Elementor page class.
		if ( function_exists( '\Elementor\Plugin::$instance' ) ) {
			$post_id = get_the_ID();
			if ( $post_id && \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id ) ) {
				$classes[] = 'nexus-elementor-page';
			}
		}

		// Remove superfluous classes added by WordPress.
		$classes = array_diff( $classes, array( 'no-sidebar' ) );

		// Add sidebar class.
		if ( nexus_has_sidebar() ) {
			$classes[] = 'nexus-has-sidebar';
		} else {
			$classes[] = 'nexus-no-sidebar';
		}

		return $classes;
	}

	/**
	 * Sets the excerpt length.
	 *
	 * @return int
	 */
	public function excerpt_length() {
		return (int) nexus_option( 'nexus_excerpt_length', 25 );
	}

	/**
	 * Customizes the excerpt "more" string.
	 *
	 * @param string $more Existing more string.
	 * @return string
	 */
	public function excerpt_more( $more ) {
		return sprintf(
			' &hellip; <a class="nexus-read-more" href="%s">%s</a>',
			esc_url( get_permalink() ),
			esc_html__( 'Read more', 'nexus' )
		);
	}

	/**
	 * Filters the page title.
	 *
	 * @param string $title    Page title.
	 * @param string $sep      Title separator.
	 * @return string
	 */
	public function wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}
		global $page, $paged;

		// Add the site name.
		$title .= get_bloginfo( 'name', 'display' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			/* translators: %s: page number */
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'nexus' ), max( $paged, $page ) );
		}

		return $title;
	}
}

// Initialize the theme.
Nexus_Theme::instance();
