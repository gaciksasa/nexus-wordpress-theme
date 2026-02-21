<?php
/**
 * Nexus Theme - WooCommerce Single Product Template
 *
 * @package Nexus
 * @see     https://woocommerce.com/document/template-structure/
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );
?>

<div class="nexus-page-title-bar nexus-page-title-bar--product">
	<div class="nexus-container">
		<?php woocommerce_breadcrumb(); ?>
	</div>
</div>

<div class="nexus-single-product-page">
	<div class="nexus-container">

		<?php
		/**
		 * Hook: woocommerce_before_main_content
		 *
		 * @hooked woocommerce_output_content_wrapper - 10
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
		?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; ?>

		<?php
		/**
		 * Hook: woocommerce_after_main_content
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10
		 */
		do_action( 'woocommerce_after_main_content' );
		?>

	</div>
</div>

<?php
get_footer( 'shop' );
