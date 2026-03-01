<?php
/**
 * Nexus Theme - Elementor Integration
 *
 * Bootstraps all custom Elementor widgets, categories,
 * and compatibility layer with the theme.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Elementor
 *
 * Singleton. Use Nexus_Elementor::instance() to access.
 */
final class Nexus_Elementor {

	/**
	 * Minimum Elementor version required.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	/**
	 * Minimum PHP version required.
	 */
	const MINIMUM_PHP_VERSION = '8.0';

	/**
	 * Instance.
	 *
	 * @var Nexus_Elementor
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Nexus_Elementor
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
		// Themes load after plugins_loaded fires, so we must call init() directly
		// if that hook has already run. Otherwise fall back to the hook (edge cases).
		if ( did_action( 'plugins_loaded' ) ) {
			$this->init();
		} else {
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}
	}

	/**
	 * Initializes Elementor integration after plugins are loaded.
	 */
	public function init() {
		// Check Elementor is active.
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Check Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_elementor_version' ) );
			return;
		}

		// Check PHP version.
		if ( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_php_version' ) );
			return;
		}

		// Register widget category.
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );

		// Register widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		// Enqueue widget-specific assets.
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );

		// Theme builder (header/footer) support.
		add_action( 'elementor/theme/register_locations', array( $this, 'register_theme_locations' ) );

		// Override Container widget defaults (zero padding, full width).
		add_action( 'elementor/element/container/section_layout_container/before_section_end', array( $this, 'update_container_defaults' ) );
		add_action( 'elementor/element/container/section_layout/before_section_end', array( $this, 'update_container_padding_default' ) );
	}

	/**
	 * Registers custom Elementor widget categories.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_categories( $elements_manager ) {
		$elements_manager->add_category(
			'nexus-elements',
			array(
				'title' => esc_html__( 'Nexus Elements', 'nexus' ),
				'icon'  => 'eicon-global-widget',
			)
		);

		$elements_manager->add_category(
			'nexus-blocks',
			array(
				'title' => esc_html__( 'Nexus Blocks', 'nexus' ),
				'icon'  => 'eicon-inner-section',
			)
		);

		$elements_manager->add_category(
			'nexus-woocommerce',
			array(
				'title' => esc_html__( 'Nexus WooCommerce', 'nexus' ),
				'icon'  => 'eicon-woocommerce',
			)
		);
	}

	/**
	 * Registers custom Elementor widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		$widget_dir = NEXUS_INC_DIR . '/elementor/widgets/';

		$widgets = array(
			'widget-hero-slider'    => 'Nexus_Widget_Hero_Slider',
			'widget-portfolio-grid' => 'Nexus_Widget_Portfolio_Grid',
			'widget-testimonials'   => 'Nexus_Widget_Testimonials',
			'widget-team-members'   => 'Nexus_Widget_Team_Members',
			'widget-services-grid'  => 'Nexus_Widget_Services_Grid',
			'widget-pricing-table'  => 'Nexus_Widget_Pricing_Table',
			'widget-counter'        => 'Nexus_Widget_Counter',
			'widget-icon-box'       => 'Nexus_Widget_Icon_Box',
			'widget-blog-posts'     => 'Nexus_Widget_Blog_Posts',
			'widget-cta-banner'        => 'Nexus_Widget_CTA_Banner',
			'widget-row-with-image'    => 'Nexus_Widget_Row_With_Image',
			'widget-video-popup'       => 'Nexus_Widget_Video_Popup',
			'widget-blog-cards'        => 'Nexus_Widget_Blog_Cards',
			'widget-image-cards-grid'       => 'Nexus_Widget_Image_Cards_Grid',
			'widget-testimonials-slider'    => 'Nexus_Widget_Testimonials_Slider',
			'widget-feature-list'           => 'Nexus_Widget_Feature_List',
			'widget-image-cards-scroller'   => 'Nexus_Widget_Image_Cards_Scroller',
			'widget-content-carousel'       => 'Nexus_Widget_Content_Carousel',
			'widget-team-grid'              => 'Nexus_Widget_Team_Grid',
		);

		// WooCommerce-specific widgets.
		if ( class_exists( 'WooCommerce' ) ) {
			$widgets['widget-product-carousel'] = 'Nexus_Widget_Product_Carousel';
		}

		foreach ( $widgets as $file => $class ) {
			$file_path = $widget_dir . $file . '.php';
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
				if ( class_exists( $class ) ) {
					$widgets_manager->register( new $class() );
				}
			}
		}
	}

	/**
	 * Enqueues Elementor widget styles.
	 */
	public function enqueue_styles() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_style(
			'nexus-elementor',
			NEXUS_ASSETS_URI . '/css/nexus-elementor' . $suffix . '.css',
			array(),
			NEXUS_VERSION
		);
	}

	/**
	 * Registers Elementor widget scripts and styles (not enqueued — loaded conditionally).
	 */
	public function register_scripts() {
		wp_register_style(
			'nexus-swiper',
			NEXUS_ASSETS_URI . '/css/vendor/swiper.min.css',
			array(),
			'11.0.5'
		);

		wp_register_script(
			'nexus-swiper',
			NEXUS_ASSETS_URI . '/js/vendor/swiper.min.js',
			array(),
			'11.0.5',
			array( 'in_footer' => true )
		);

		wp_register_script(
			'nexus-isotope',
			NEXUS_ASSETS_URI . '/js/vendor/isotope.pkgd.min.js',
			array(),
			'3.0.6',
			array( 'in_footer' => true )
		);
	}

	/**
	 * Registers Elementor Theme Builder locations (header, footer, etc.).
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $location_manager Theme Builder location manager.
	 */
	public function register_theme_locations( $location_manager ) {
		$location_manager->register_all_core_location();
	}

	/**
	 * Sets Container widget content width default to full width.
	 *
	 * @param \Elementor\Element_Base $element The element.
	 */
	public function update_container_defaults( $element ) {
		$element->update_control(
			'content_width',
			array( 'default' => 'full' )
		);
	}

	/**
	 * Sets Container widget padding default to 0.
	 *
	 * @param \Elementor\Element_Base $element The element.
	 */
	public function update_container_padding_default( $element ) {
		$element->update_responsive_control(
			'padding',
			array(
				'default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
			)
		);
	}

	/**
	 * Admin notice: Elementor version too old.
	 */
	public function admin_notice_elementor_version() {
		printf(
			'<div class="notice notice-warning"><p>%s</p></div>',
			sprintf(
				/* translators: 1: theme name, 2: required version, 3: current version */
				esc_html__( '"%1$s" requires Elementor version %2$s or higher. You are running version %3$s.', 'nexus' ),
				'<strong>' . esc_html__( 'Nexus Theme', 'nexus' ) . '</strong>',
				esc_html( self::MINIMUM_ELEMENTOR_VERSION ),
				esc_html( ELEMENTOR_VERSION )
			)
		);
	}

	/**
	 * Admin notice: PHP version too old.
	 */
	public function admin_notice_php_version() {
		printf(
			'<div class="notice notice-warning"><p>%s</p></div>',
			sprintf(
				/* translators: 1: theme name, 2: required PHP version, 3: current PHP version */
				esc_html__( '"%1$s" requires PHP version %2$s or higher. You are running version %3$s.', 'nexus' ),
				'<strong>' . esc_html__( 'Nexus Theme', 'nexus' ) . '</strong>',
				esc_html( self::MINIMUM_PHP_VERSION ),
				esc_html( PHP_VERSION )
			)
		);
	}
}

// Initialize.
Nexus_Elementor::instance();
