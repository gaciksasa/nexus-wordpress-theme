<?php
/**
 * Template part: Author bio box.
 *
 * @package Nexus
 */

if ( ! nexus_option( 'nexus_author_bio', true ) ) {
	return;
}

$nexus_author_description = get_the_author_meta( 'description' );

if ( ! $nexus_author_description ) {
	return;
}
?>

<div class="nexus-author-bio">
	<div class="nexus-author-bio__avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => 'nexus-author-bio__img' ) ); ?>
	</div>
	<div class="nexus-author-bio__info">
		<h4 class="nexus-author-bio__name">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php echo esc_html( get_the_author() ); ?>
			</a>
		</h4>
		<p class="nexus-author-bio__description">
			<?php echo wp_kses_post( $nexus_author_description ); ?>
		</p>
	</div>
</div><!-- .nexus-author-bio -->
