<?php
/**
 * Nexus Theme - WooCommerce Archive Product Template
 *
 * @package Nexus
 * @see     https://woocommerce.com/document/template-structure/
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );
?>

<div class="nexus-page-title-bar nexus-page-title-bar--shop">
	<div class="nexus-container">
		<?php woocommerce_breadcrumb(); ?>
		<h1 class="nexus-page-title-bar__title">
			<?php
			if ( is_search() ) {
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search results: %s', 'nexus' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
			} else {
				woocommerce_page_title();
			}
			?>
		</h1>
	</div>
</div>

<div class="nexus-shop-page">
	<div class="nexus-container">

		<?php
		/**
		 * Hook: woocommerce_before_main_content
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs)
		 * @hooked woocommerce_breadcrumb - 20 (removed in Nexus; breadcrumb above)
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
		?>

		<?php
		/**
		 * Hook: woocommerce_shop_loop_header.
		 *
		 * @since 8.6.0
		 * @hooked woocommerce_product_taxonomy_archive_header - 10
		 */
		do_action( 'woocommerce_shop_loop_header' );
		?>

		<?php if ( woocommerce_product_loop() ) : ?>

			<?php
			/**
			 * Hook: woocommerce_before_shop_loop
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
			?>

			<div class="nexus-shop-controls">
				<?php nexus_shop_view_toggle(); ?>
				<div class="nexus-shop-controls__meta">
					<?php woocommerce_result_count(); ?>
					<?php woocommerce_catalog_ordering(); ?>
				</div>
			</div>

			<div class="nexus-shop-sidebar-wrap">

				<?php
				$shop_layout = nexus_option( 'shop_layout', 'right-sidebar' );
				if ( 'left-sidebar' === $shop_layout ) {
					get_sidebar( 'shop' );
				}
				?>

				<main class="nexus-shop-main">
					<?php
					$shop_cols = absint( nexus_option( 'shop_columns', 3 ) );
					woocommerce_product_loop_start( array( 'class' => 'nexus-shop-grid products columns-' . $shop_cols ) );

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();
							/**
							 * Hook: woocommerce_shop_loop
							 */
							do_action( 'woocommerce_shop_loop' );
							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
					?>
				</main>

				<?php
				if ( 'right-sidebar' === $shop_layout ) {
					get_sidebar( 'shop' );
				}
				?>

			</div><!-- .nexus-shop-sidebar-wrap -->

		<?php else : ?>
			<?php
			/**
			 * Hook: woocommerce_no_products_found
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
			?>
		<?php endif; ?>

		<?php
		/**
		 * Hook: woocommerce_after_main_content
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs)
		 */
		do_action( 'woocommerce_after_main_content' );
		?>

	</div><!-- .nexus-container -->
</div><!-- .nexus-shop-page -->

<?php
get_footer( 'shop' );
