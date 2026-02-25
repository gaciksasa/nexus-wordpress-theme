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
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nexus-logo-text" rel="home">
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

	<?php if ( nexus_option( 'nexus_header_search', true ) ) : ?>
	<div class="nexus-mobile-nav__search">
		<?php get_search_form(); ?>
	</div>
	<?php endif; ?>

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

	<div class="nexus-mobile-nav__footer">
		<?php if ( nexus_option( 'nexus_dark_mode_enabled', true ) ) : ?>
			<button
				class="nexus-mobile-nav__dark-toggle nexus-header__dark-toggle"
				aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'nexus' ); ?>"
				aria-pressed="false"
			>
				<?php echo nexus_icon( 'moon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo nexus_icon( 'sun' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		<?php endif; ?>

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="nexus-mobile-nav__cart">
				<?php echo nexus_icon( 'shopping-bag' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'Cart', 'nexus' ); ?></span>
				<?php $nexus_cart_count = WC()->cart->get_cart_contents_count(); ?>
				<?php if ( $nexus_cart_count > 0 ) : ?>
					<span class="nexus-cart-count"><?php echo esc_html( $nexus_cart_count ); ?></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
	</div>

</nav>

<?php // Overlay for mobile menu backdrop. ?>
<div class="nexus-overlay nexus-mobile-nav__overlay" aria-hidden="true" hidden></div>
