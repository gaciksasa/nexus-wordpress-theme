<?php
/**
 * Template part: Footer bottom bar.
 *
 * @package Nexus
 */

$nexus_copyright = nexus_option(
	'nexus_footer_copyright',
	sprintf(
		/* translators: 1: copyright symbol, 2: current year, 3: site name */
		esc_html__( '%1$s %2$s %3$s. All Rights Reserved.', 'nexus' ),
		'&copy;',
		gmdate( 'Y' ),
		get_bloginfo( 'name' )
	)
);
?>

<div class="nexus-footer-bottom">
	<div class="nexus-container">
		<div class="nexus-footer-bottom__inner">

			<div class="nexus-footer-bottom__copyright">
				<?php echo wp_kses_post( $nexus_copyright ); ?>
			</div>

			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav
					class="nexus-footer-bottom__nav"
					aria-label="<?php esc_attr_e( 'Footer Navigation', 'nexus' ); ?>"
				>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'nexus-footer-menu',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>

		</div><!-- .nexus-footer-bottom__inner -->
	</div><!-- .nexus-container -->
</div><!-- .nexus-footer-bottom -->
