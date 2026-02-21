<?php
/**
 * Nexus Theme - WooCommerce Integration
 *
 * Hooks, filters, and template overrides for WooCommerce.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_WooCommerce
 */
class Nexus_WooCommerce {

	/**
	 * Instance.
	 *
	 * @var Nexus_WooCommerce
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Nexus_WooCommerce
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
		$this->hooks();
	}

	/**
	 * Registers all WooCommerce hooks.
	 */
	private function hooks() {
		// Remove default WooCommerce wrappers.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Add theme wrappers.
		add_action( 'woocommerce_before_main_content', array( $this, 'output_content_wrapper' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'output_content_wrapper_end' ), 10 );

		// Remove default sidebar from WooCommerce hook.
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_action( 'woocommerce_sidebar', array( $this, 'output_shop_sidebar' ), 10 );

		// Adjust columns per row.
		add_filter( 'loop_shop_columns', array( $this, 'loop_columns' ) );

		// Adjust products per page.
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ) );

		// AJAX add to cart fragments for mini-cart.
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_count_fragment' ) );

		// Remove product count from shop page.
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_controls_bar' ), 20 );

		// Add off-canvas cart.
		add_action( 'wp_footer', array( $this, 'output_offcanvas_cart' ) );

		// Enqueue WooCommerce-specific scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Opens the WooCommerce main content wrapper.
	 */
	public function output_content_wrapper() {
		$layout = nexus_option( 'nexus_shop_layout', 'right-sidebar' );
		?>
		<div class="nexus-container">
		<?php if ( 'full-width' !== $layout ) : ?>
			<div class="nexus-content-area nexus-layout--<?php echo esc_attr( $layout ); ?>">
				<div class="nexus-primary">
		<?php endif; ?>
		<?php
	}

	/**
	 * Closes the WooCommerce main content wrapper.
	 */
	public function output_content_wrapper_end() {
		$layout = nexus_option( 'nexus_shop_layout', 'right-sidebar' );
		if ( 'full-width' !== $layout ) :
			?>
				</div><!-- .nexus-primary -->
			</div><!-- .nexus-content-area -->
			<?php
		endif;
		?>
		</div><!-- .nexus-container -->
		<?php
	}

	/**
	 * Outputs the shop sidebar.
	 */
	public function output_shop_sidebar() {
		$layout = nexus_option( 'nexus_shop_layout', 'right-sidebar' );

		if ( 'full-width' === $layout ) {
			return;
		}

		if ( is_active_sidebar( 'sidebar-shop' ) ) {
			?>
			<aside id="nexus-shop-sidebar" class="nexus-sidebar nexus-sidebar--shop widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Shop Sidebar', 'nexus' ); ?>">
				<?php dynamic_sidebar( 'sidebar-shop' ); ?>
			</aside>
			<?php
		}
	}

	/**
	 * Returns the number of product columns per row.
	 *
	 * @return int
	 */
	public function loop_columns() {
		return (int) nexus_option( 'nexus_shop_columns', 3 );
	}

	/**
	 * Returns the number of products per page.
	 *
	 * @return int
	 */
	public function products_per_page() {
		$per_row = $this->loop_columns();
		$rows    = (int) nexus_option( 'nexus_shop_rows', 3 );
		return $per_row * $rows;
	}

	/**
	 * Updates the cart count badge via AJAX fragment.
	 *
	 * @param array $fragments Existing fragments.
	 * @return array
	 */
	public function cart_count_fragment( $fragments ) {
		$count = WC()->cart->get_cart_contents_count();

		ob_start();
		?>
		<span class="nexus-cart-count" aria-live="polite"><?php echo esc_html( $count ); ?></span>
		<?php
		$fragments['span.nexus-cart-count'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Outputs the custom shop controls bar (result count + ordering).
	 */
	public function shop_controls_bar() {
		?>
		<div class="nexus-shop-controls">
			<div class="nexus-shop-controls__count">
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="nexus-shop-controls__right">
				<div class="nexus-shop-view-toggle" role="group" aria-label="<?php esc_attr_e( 'Product view', 'nexus' ); ?>">
					<button
						class="nexus-shop-view-btn is-active"
						data-view="grid"
						aria-label="<?php esc_attr_e( 'Grid view', 'nexus' ); ?>"
						aria-pressed="true"
					>
						<?php echo nexus_icon( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
					<button
						class="nexus-shop-view-btn"
						data-view="list"
						aria-label="<?php esc_attr_e( 'List view', 'nexus' ); ?>"
						aria-pressed="false"
					>
						<?php echo nexus_icon( 'list' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				</div>
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Outputs the off-canvas cart drawer in the footer.
	 */
	public function output_offcanvas_cart() {
		if ( ! nexus_option( 'nexus_header_cart', true ) ) {
			return;
		}
		?>
		<div
			id="nexus-offcanvas-cart"
			class="nexus-offcanvas-cart"
			role="dialog"
			aria-label="<?php esc_attr_e( 'Shopping Cart', 'nexus' ); ?>"
			aria-modal="true"
			hidden
		>
			<div class="nexus-offcanvas-cart__header">
				<h3 class="nexus-offcanvas-cart__title">
					<?php esc_html_e( 'Your Cart', 'nexus' ); ?>
					<span class="nexus-cart-count nexus-offcanvas-cart__count">
						<?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
					</span>
				</h3>
				<button
					class="nexus-offcanvas-cart__close"
					aria-label="<?php esc_attr_e( 'Close Cart', 'nexus' ); ?>"
				>
					<?php echo nexus_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</div>

			<div class="nexus-offcanvas-cart__body">
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>

		<div class="nexus-overlay nexus-offcanvas-cart__overlay" aria-hidden="true" hidden></div>
		<?php
	}

	/**
	 * Enqueues WooCommerce-specific frontend assets.
	 */
	public function enqueue_assets() {
		if ( ! is_shop() && ! is_product_category() && ! is_product_tag() && ! is_product() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
			return;
		}

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_style(
			'nexus-woocommerce',
			NEXUS_ASSETS_URI . '/css/nexus-woocommerce' . $suffix . '.css',
			array( 'nexus-main' ),
			NEXUS_VERSION
		);

		wp_enqueue_script(
			'nexus-woocommerce',
			NEXUS_ASSETS_URI . '/js/nexus-woocommerce' . $suffix . '.js',
			array( 'jquery', 'wc-cart-fragments' ),
			NEXUS_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_localize_script(
			'nexus-woocommerce',
			'nexusWooData',
			array(
				'ajaxUrl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'       => wp_create_nonce( 'nexus-woo' ),
				'cartUrl'     => esc_url( wc_get_cart_url() ),
				'checkoutUrl' => esc_url( wc_get_checkout_url() ),
				'strings'     => array(
					'addedToCart'      => esc_html__( 'Added to cart!', 'nexus' ),
					'viewCart'         => esc_html__( 'View Cart', 'nexus' ),
					'continueShopping' => esc_html__( 'Continue Shopping', 'nexus' ),
				),
			)
		);
	}
}

// Initialize.
Nexus_WooCommerce::instance();
