<?php
/**
 * Template part: Default content (post excerpt for blog archive).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nexus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'nexus-post nexus-post--card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="nexus-post__thumbnail">
			<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php
				the_post_thumbnail(
					'nexus-medium',
					array(
						'loading' => 'lazy',
						'alt'     => the_title_attribute( array( 'echo' => false ) ),
					)
				);
				?>
			</a>
		</div>
	<?php endif; ?>

	<div class="nexus-post__body">

		<?php get_template_part( 'template-parts/post/post-meta' ); ?>

		<h2 class="nexus-post__title">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h2>

		<div class="nexus-post__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="nexus-btn nexus-btn--outline nexus-post__read-more">
			<?php esc_html_e( 'Read More', 'nexus' ); ?>
		</a>

	</div><!-- .nexus-post__body -->

</article><!-- #post-<?php the_ID(); ?> -->
