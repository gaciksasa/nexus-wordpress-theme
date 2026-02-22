<?php
/**
 * Template part: Author bio box.
 *
 * @package Nexus
 */

if ( ! nexus_option( 'nexus_author_bio', true ) ) {
	return;
}

$nexus_author_description = get_the_author_meta( 'description' );

if ( ! $nexus_author_description ) {
	return;
}

$nexus_author_id      = get_the_author_meta( 'ID' );
$nexus_author_name    = get_the_author();
$nexus_author_url     = get_author_posts_url( $nexus_author_id );
$nexus_author_website = get_the_author_meta( 'user_url' );
?>

<div class="nexus-author-bio">

	<div class="nexus-author-bio__avatar">
		<?php echo get_avatar( $nexus_author_id, 96, '', '', array( 'class' => 'nexus-author-bio__img' ) ); ?>
	</div>

	<div class="nexus-author-bio__info">

		<div class="nexus-author-bio__header">
			<h4 class="nexus-author-bio__name">
				<a href="<?php echo esc_url( $nexus_author_url ); ?>">
					<?php echo esc_html( $nexus_author_name ); ?>
				</a>
			</h4>
			<?php if ( $nexus_author_website ) : ?>
				<a href="<?php echo esc_url( $nexus_author_website ); ?>" class="nexus-author-bio__website" target="_blank" rel="noopener noreferrer">
					<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
					<?php esc_html_e( 'Website', 'nexus' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<p class="nexus-author-bio__description">
			<?php echo wp_kses_post( $nexus_author_description ); ?>
		</p>

		<a href="<?php echo esc_url( $nexus_author_url ); ?>" class="nexus-author-bio__all-posts">
			<?php
			printf(
				/* translators: %s: author display name */
				esc_html__( 'All posts by %s', 'nexus' ),
				esc_html( $nexus_author_name )
			);
			?>
			<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
		</a>

	</div><!-- .nexus-author-bio__info -->

</div><!-- .nexus-author-bio -->
