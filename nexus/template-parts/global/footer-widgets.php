<?php
/**
 * Template part: Footer widget columns.
 *
 * @package Nexus
 */

// Count active footer widget areas.
$nexus_active_footers = array();
for ( $nexus_i = 1; $nexus_i <= 4; $nexus_i++ ) {
	if ( is_active_sidebar( 'footer-' . $nexus_i ) ) {
		$nexus_active_footers[] = $nexus_i;
	}
}

if ( empty( $nexus_active_footers ) ) {
	return;
}

$nexus_columns      = count( $nexus_active_footers );
$nexus_column_class = 'nexus-footer-widgets--cols-' . $nexus_columns;
?>

<div class="nexus-footer-widgets <?php echo esc_attr( $nexus_column_class ); ?>">
	<div class="nexus-container">
		<div class="nexus-footer-widgets__grid">
			<?php foreach ( $nexus_active_footers as $nexus_footer_num ) : ?>
				<div class="nexus-footer-widget-col">
					<?php dynamic_sidebar( 'footer-' . $nexus_footer_num ); ?>
				</div>
			<?php endforeach; ?>
		</div><!-- .nexus-footer-widgets__grid -->
	</div><!-- .nexus-container -->
</div><!-- .nexus-footer-widgets -->
