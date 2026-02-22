<?php
/**
 * Template part: Default content (post excerpt for blog archive).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nexus
 */

// Placeholder accent colors for posts without a featured image.
$nexus_ph_colors = array( '#6366f1', '#f43f5e', '#0ea5e9', '#10b981', '#f59e0b' );
$nexus_ph_color  = $nexus_ph_colors[ get_the_ID() % count( $nexus_ph_colors ) ];

$nexus_cat  = null;
$nexus_cats = get_the_category();
if ( $nexus_cats ) {
	$nexus_cat = $nexus_cats[0];
}

$nexus_wc = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) );
$nexus_rt = max( 1, (int) ceil( $nexus_wc / 200 ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'nexus-post-card' ); ?>>

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
			<span class="nexus-post-card__sep" aria-hidden="true">&middot;</span>
			<span class="nexus-post-card__author">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo esc_html( get_the_author() ); ?>
				</a>
			</span>
		</div>

		<h2 class="nexus-post-card__title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<div class="nexus-post-card__excerpt">
			<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 20, '&hellip;' ) ); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="nexus-post-card__more">
			<?php esc_html_e( 'Read More', 'nexus' ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
		</a>

	</div><!-- .nexus-post-card__body -->

</article><!-- #post-<?php the_ID(); ?> -->
