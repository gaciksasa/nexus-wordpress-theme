<?php
/**
 * Template part: No content found.
 *
 * @package Nexus
 */

?>

<section class="nexus-no-results">

	<header class="nexus-no-results__header">
		<h1 class="nexus-page-title"><?php esc_html_e( 'Nothing Here', 'nexus' ); ?></h1>
	</header>

	<div class="nexus-no-results__content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			printf(
				'<p>%s</p>',
				sprintf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'nexus' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				)
			);
		elseif ( is_search() ) :
			?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nexus' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'nexus' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>

</section><!-- .nexus-no-results -->
