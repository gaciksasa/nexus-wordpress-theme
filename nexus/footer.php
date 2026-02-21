<?php
/**
 * Footer template.
 *
 * @package Nexus
 */

	/**
	 * Hook: nexus_before_footer
	 *
	 * @hooked nothing by default
	 */
	do_action( 'nexus_before_footer' );
?>

	<footer id="nexus-footer" class="nexus-footer" role="contentinfo">

		<?php
		// Footer widget columns.
		if ( nexus_option( 'nexus_footer_widgets', true ) ) :
			get_template_part( 'template-parts/global/footer-widgets' );
		endif;

		// Footer bottom bar.
		get_template_part( 'template-parts/global/footer-bottom' );
		?>

	</footer><!-- #nexus-footer -->

	<?php
	// Back to top button.
	if ( nexus_option( 'nexus_back_to_top', true ) ) :
		?>
		<button
			class="nexus-back-to-top"
			aria-label="<?php esc_attr_e( 'Back to top', 'nexus' ); ?>"
			hidden
		>
			<?php echo nexus_icon( 'arrow-up' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</button>
	<?php endif; ?>

</div><!-- #nexus-page -->

<?php wp_footer(); ?>

</body>
</html>
