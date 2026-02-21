<?php
/**
 * Template part: Mobile navigation drawer.
 *
 * @package Nexus
 */

?>

<nav
	id="nexus-mobile-menu"
	class="nexus-mobile-nav"
	role="navigation"
	aria-label="<?php esc_attr_e( 'Mobile Navigation', 'nexus' ); ?>"
	hidden
>
	<div class="nexus-mobile-nav__header">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		<?php endif; ?>

		<button
			class="nexus-mobile-nav__close"
			aria-label="<?php esc_attr_e( 'Close Mobile Menu', 'nexus' ); ?>"
		>
			<?php echo nexus_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</button>
	</div>

	<div class="nexus-mobile-nav__body">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'mobile',
				'menu_id'        => 'nexus-mobile-menu-list',
				'menu_class'     => 'nexus-mobile-menu',
				'container'      => false,
				'fallback_cb'    => function () {
					// Fall back to primary menu on mobile.
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'nexus-mobile-menu-list',
							'menu_class'     => 'nexus-mobile-menu',
							'container'      => false,
						)
					);
				},
			)
		);
		?>
	</div>

	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
	<div class="nexus-mobile-nav__footer">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="nexus-mobile-nav__cart">
			<?php echo nexus_icon( 'shopping-bag' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span><?php esc_html_e( 'Cart', 'nexus' ); ?></span>
			<span class="nexus-cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
		</a>
	</div>
	<?php endif; ?>

</nav>

<?php // Overlay for mobile menu backdrop. ?>
<div class="nexus-overlay nexus-mobile-nav__overlay" aria-hidden="true" hidden></div>
