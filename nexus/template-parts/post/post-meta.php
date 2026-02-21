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
			<span class="nexus-post-meta__category">
				<a href="<?php echo esc_url( get_category_link( $nexus_categories[0]->term_id ) ); ?>">
					<?php echo esc_html( $nexus_categories[0]->name ); ?>
				</a>
			</span>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $nexus_show_author ) : ?>
		<span class="nexus-post-meta__author">
			<?php
			printf(
				/* translators: %s: author display name */
				esc_html__( 'By %s', 'nexus' ),
				'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
			);
			?>
		</span>
	<?php endif; ?>

	<?php if ( $nexus_show_date ) : ?>
		<time class="nexus-post-meta__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	<?php endif; ?>

	<?php if ( $nexus_show_reading ) : ?>
		<span class="nexus-post-meta__reading-time">
			<?php echo esc_html( nexus_reading_time() ); ?>
		</span>
	<?php endif; ?>

</div><!-- .nexus-post-meta -->
