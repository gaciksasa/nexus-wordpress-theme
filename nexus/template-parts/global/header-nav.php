<?php
/**
 * Template part: Main header navigation.
 *
 * @package Nexus
 */

?>

<div class="nexus-header__main">
	<div class="nexus-container">
		<div class="nexus-header__inner">

			<?php // Logo. ?>
			<div class="nexus-header__logo">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nexus-logo-text" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
					$nexus_description = get_bloginfo( 'description', 'display' );
					if ( $description ) :
						?>
						<p class="nexus-site-description screen-reader-text"><?php echo esc_html( $nexus_description ); ?></p>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .nexus-header__logo -->

			<?php // Primary navigation. ?>
			<nav
				id="nexus-primary-nav"
				class="nexus-nav nexus-nav--primary"
				role="navigation"
				aria-label="<?php esc_attr_e( 'Primary Navigation', 'nexus' ); ?>"
			>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'nexus-primary-menu',
						'menu_class'     => 'nexus-menu nexus-menu--primary',
						'container'      => false,
						'walker'         => new Nexus_Walker_Nav_Menu(),
						'fallback_cb'    => 'nexus_nav_fallback',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
					)
				);
				?>
			</nav><!-- #nexus-primary-nav -->

			<?php // Header actions (search, dark mode, cart). ?>
			<div class="nexus-header__actions">

				<?php if ( nexus_option( 'nexus_header_search', true ) ) : ?>
					<button
						class="nexus-header__search-toggle"
						aria-label="<?php esc_attr_e( 'Toggle Search', 'nexus' ); ?>"
						aria-expanded="false"
						aria-controls="nexus-search-popup"
					>
						<?php echo nexus_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				<?php endif; ?>

				<?php if ( nexus_option( 'nexus_dark_mode_enabled', false ) ) : ?>
					<button
						class="nexus-header__dark-toggle"
						aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'nexus' ); ?>"
						aria-pressed="false"
					>
						<?php echo nexus_icon( 'sun' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo nexus_icon( 'moon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				<?php endif; ?>

				<?php if ( class_exists( 'WooCommerce' ) && nexus_option( 'nexus_header_cart', true ) ) : ?>
					<a
						href="<?php echo esc_url( wc_get_cart_url() ); ?>"
						class="nexus-header__cart"
						aria-label="<?php esc_attr_e( 'Shopping Cart', 'nexus' ); ?>"
					>
						<?php echo nexus_icon( 'shopping-bag' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span class="nexus-cart-count" aria-live="polite">
							<?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
						</span>
					</a>
				<?php endif; ?>

				<?php // Hamburger toggle (visible on mobile/tablet). ?>
				<button
					class="nexus-hamburger"
					aria-label="<?php esc_attr_e( 'Toggle Mobile Menu', 'nexus' ); ?>"
					aria-expanded="false"
					aria-controls="nexus-mobile-menu"
				>
					<span class="nexus-hamburger__bar" aria-hidden="true"></span>
					<span class="nexus-hamburger__bar" aria-hidden="true"></span>
					<span class="nexus-hamburger__bar" aria-hidden="true"></span>
				</button>

			</div><!-- .nexus-header__actions -->

		</div><!-- .nexus-header__inner -->
	</div><!-- .nexus-container -->
</div><!-- .nexus-header__main -->

<?php if ( nexus_option( 'nexus_header_search', true ) ) : ?>
<div id="nexus-search-popup" class="nexus-search-popup" role="dialog" aria-label="<?php esc_attr_e( 'Search', 'nexus' ); ?>" hidden>
	<div class="nexus-search-popup__inner">
		<button
			class="nexus-search-popup__close"
			aria-label="<?php esc_attr_e( 'Close Search', 'nexus' ); ?>"
		>
			<?php echo nexus_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</button>
		<?php get_search_form(); ?>
	</div>
</div>
<?php endif; ?>
