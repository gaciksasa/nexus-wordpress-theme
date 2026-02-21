<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nexus
 */

if ( ! is_active_sidebar( 'sidebar-primary' ) ) {
	return;
}
?>

<aside id="nexus-sidebar" class="nexus-sidebar widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Primary Sidebar', 'nexus' ); ?>">
	<?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside><!-- #nexus-sidebar -->
