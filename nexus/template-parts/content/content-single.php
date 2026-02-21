<?php
/**
 * Template part: Single post content.
 *
 * @package Nexus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'nexus-post nexus-post--single' ); ?>>

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
				<span class="nexus-post__tags-label"><?php esc_html_e( 'Tagged:', 'nexus' ); ?></span>
				<?php echo $nexus_tags_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/post/post-author-bio' ); ?>

	</footer><!-- .nexus-post__footer -->

</article><!-- #post-<?php the_ID(); ?> -->
