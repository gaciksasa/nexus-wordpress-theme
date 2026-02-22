<?php
/**
 * Template part: Single post content.
 *
 * @package Nexus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'nexus-post', 'nexus-post--single', 'nexus-single-post' ) ); ?>>

	<header class="nexus-post__header">

		<?php get_template_part( 'template-parts/post/post-meta' ); ?>

		<?php the_title( '<h1 class="nexus-post__title">', '</h1>' ); ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="nexus-post__hero-image">
				<?php
				the_post_thumbnail(
					'nexus-wide',
					array(
						'loading' => 'eager',
						'alt'     => the_title_attribute( array( 'echo' => false ) ),
					)
				);
				?>
			</div>
		<?php endif; ?>

	</header><!-- .nexus-post__header -->

	<div class="nexus-post__content entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'nexus' ),
					array( 'span' => array( 'class' => array() ) )
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="nexus-page-links">' . esc_html__( 'Pages:', 'nexus' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .nexus-post__content -->

	<footer class="nexus-post__footer">

		<?php
		$nexus_tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'nexus' ) );
		if ( $nexus_tags_list ) :
			?>
			<div class="nexus-post__tags">
				<span class="nexus-post__tags-label">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
					<?php esc_html_e( 'Tags:', 'nexus' ); ?>
				</span>
				<?php echo $nexus_tags_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/post/post-share' ); ?>

		<?php get_template_part( 'template-parts/post/post-author-bio' ); ?>

	</footer><!-- .nexus-post__footer -->

</article><!-- #post-<?php the_ID(); ?> -->
