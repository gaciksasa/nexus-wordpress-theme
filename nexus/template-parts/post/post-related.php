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

// Placeholder accent colors for posts without a featured image.
$nexus_ph_colors = array( '#6366f1', '#f43f5e', '#0ea5e9', '#10b981', '#f59e0b' );
$nexus_ph_idx    = 0;
?>

<section class="nexus-related-posts">

	<h3 class="nexus-related-posts__title">
		<?php esc_html_e( 'You Might Also Like', 'nexus' ); ?>
	</h3>

	<div class="nexus-related-posts__grid nexus-blog-grid">

		<?php
		while ( $nexus_related->have_posts() ) :
			$nexus_related->the_post();

			$nexus_cat      = null;
			$nexus_cats     = get_the_category();
			if ( $nexus_cats ) {
				$nexus_cat = $nexus_cats[0];
			}

			$nexus_wc       = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) );
			$nexus_rt       = max( 1, (int) ceil( $nexus_wc / 200 ) );
			$nexus_ph_color = $nexus_ph_colors[ $nexus_ph_idx % count( $nexus_ph_colors ) ];
			++$nexus_ph_idx;
			?>

			<article class="nexus-post-card">

				<div class="nexus-post-card__thumb">

					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="nexus-post-card__thumb-link" tabindex="-1" aria-hidden="true">
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
					<?php else : ?>
						<a href="<?php the_permalink(); ?>"
						   class="nexus-post-card__thumb-link nexus-post-card__thumb-placeholder"
						   style="--ph-color: <?php echo esc_attr( $nexus_ph_color ); ?>;"
						   tabindex="-1"
						   aria-hidden="true">
							<span class="nexus-post-card__thumb-initial">
								<?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?>
							</span>
						</a>
					<?php endif; ?>

					<?php if ( $nexus_cat ) : ?>
						<a href="<?php echo esc_url( get_category_link( $nexus_cat->term_id ) ); ?>"
						   class="nexus-post-card__cat-badge">
							<?php echo esc_html( $nexus_cat->name ); ?>
						</a>
					<?php endif; ?>

					<span class="nexus-post-card__time">
						<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						<?php
						printf(
							/* translators: %d: reading time in minutes */
							esc_html__( '%d min', 'nexus' ),
							$nexus_rt
						);
						?>
					</span>

					<span class="nexus-post-card__img-overlay" aria-hidden="true"></span>

				</div><!-- .nexus-post-card__thumb -->

				<div class="nexus-post-card__body">

					<div class="nexus-post-card__meta">
						<span class="nexus-post-card__date">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</span>
					</div>

					<h4 class="nexus-post-card__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h4>

					<a href="<?php the_permalink(); ?>" class="nexus-post-card__more">
						<?php esc_html_e( 'Read More', 'nexus' ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
					</a>

				</div><!-- .nexus-post-card__body -->

			</article>

		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>

	</div><!-- .nexus-related-posts__grid -->

</section><!-- .nexus-related-posts -->
