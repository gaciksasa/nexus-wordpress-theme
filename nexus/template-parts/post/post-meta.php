<?php
/**
 * Template part: Post meta information.
 *
 * @package Nexus
 */

$nexus_show_date     = nexus_option( 'nexus_post_meta_date', true );
$nexus_show_author   = nexus_option( 'nexus_post_meta_author', true );
$nexus_show_category = nexus_option( 'nexus_post_meta_category', true );
$nexus_show_reading  = nexus_option( 'nexus_post_meta_reading_time', true );

$nexus_has_meta = $nexus_show_date || $nexus_show_author || $nexus_show_category || $nexus_show_reading;

if ( ! $nexus_has_meta ) {
	return;
}
?>

<div class="nexus-post-meta">

	<?php if ( $nexus_show_category ) : ?>
		<?php
		$nexus_categories = get_the_category();
		if ( $nexus_categories ) :
			?>
			<a href="<?php echo esc_url( get_category_link( $nexus_categories[0]->term_id ) ); ?>" class="nexus-post-meta__cat-badge">
				<?php echo esc_html( $nexus_categories[0]->name ); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $nexus_show_author ) : ?>
		<span class="nexus-post-meta__item nexus-post-meta__author">
			<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php echo esc_html( get_the_author() ); ?>
			</a>
		</span>
	<?php endif; ?>

	<?php if ( $nexus_show_date ) : ?>
		<span class="nexus-post-meta__item nexus-post-meta__date">
			<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
		</span>
	<?php endif; ?>

	<?php if ( $nexus_show_reading ) : ?>
		<span class="nexus-post-meta__item nexus-post-meta__reading-time">
			<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			<?php echo esc_html( nexus_reading_time() ); ?>
		</span>
	<?php endif; ?>

</div><!-- .nexus-post-meta -->
