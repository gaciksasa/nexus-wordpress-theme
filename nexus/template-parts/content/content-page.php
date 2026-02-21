<?php
/**
 * Template part: Static page content.
 *
 * @package Nexus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'nexus-page' ); ?>>

	<?php if ( ! nexus_meta( '_nexus_hide_title' ) ) : ?>
		<header class="nexus-page__header">
			<?php the_title( '<h1 class="nexus-page__title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<div class="nexus-page__content entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="nexus-page-links">' . esc_html__( 'Pages:', 'nexus' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .nexus-page__content -->

</article><!-- #post-<?php the_ID(); ?> -->
