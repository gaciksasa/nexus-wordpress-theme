<?php
/**
 * Template part: Related posts.
 *
 * @package Nexus
 */

$nexus_related_count = (int) nexus_option( 'nexus_related_posts_count', 3 );

$nexus_related = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $nexus_related_count,
		'post__not_in'        => array( get_the_ID() ),
		'category__in'        => wp_get_post_categories( get_the_ID() ),
		'orderby'             => 'rand',
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $nexus_related->have_posts() ) {
	return;
}
?>

<div class="nexus-related-posts">
	<h3 class="nexus-related-posts__title">
		<?php esc_html_e( 'Related Posts', 'nexus' ); ?>
	</h3>

	<div class="nexus-related-posts__grid">
		<?php
		while ( $nexus_related->have_posts() ) :
			$nexus_related->the_post();
			?>
			<article class="nexus-related-post">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="nexus-related-post__thumbnail">
						<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php
							the_post_thumbnail(
								'nexus-thumbnail',
								array(
									'loading' => 'lazy',
									'alt'     => the_title_attribute( array( 'echo' => false ) ),
								)
							);
							?>
						</a>
					</div>
				<?php endif; ?>
				<div class="nexus-related-post__body">
					<time class="nexus-related-post__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</time>
					<h4 class="nexus-related-post__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h4>
				</div>
			</article>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div><!-- .nexus-related-posts__grid -->
</div><!-- .nexus-related-posts -->
