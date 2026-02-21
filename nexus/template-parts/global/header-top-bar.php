<?php
/**
 * Template part: Header top bar.
 *
 * @package Nexus
 */

$nexus_topbar_left  = nexus_option( 'nexus_topbar_left_text', '' );
$nexus_topbar_right = nexus_option( 'nexus_topbar_right_text', '' );
?>

<div class="nexus-topbar">
	<div class="nexus-container">
		<div class="nexus-topbar__inner">

			<?php if ( $nexus_topbar_left ) : ?>
				<div class="nexus-topbar__left">
					<?php echo wp_kses_post( $nexus_topbar_left ); ?>
				</div>
			<?php endif; ?>

			<?php if ( has_nav_menu( 'topbar' ) || $nexus_topbar_right ) : ?>
				<div class="nexus-topbar__right">
					<?php if ( $nexus_topbar_right ) : ?>
						<span class="nexus-topbar__text"><?php echo wp_kses_post( $nexus_topbar_right ); ?></span>
					<?php endif; ?>

					<?php
					if ( has_nav_menu( 'topbar' ) ) :
						wp_nav_menu(
							array(
								'theme_location' => 'topbar',
								'menu_class'     => 'nexus-topbar__menu',
								'container'      => false,
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);
					endif;
					?>
				</div>
			<?php endif; ?>

		</div><!-- .nexus-topbar__inner -->
	</div><!-- .nexus-container -->
</div><!-- .nexus-topbar -->
