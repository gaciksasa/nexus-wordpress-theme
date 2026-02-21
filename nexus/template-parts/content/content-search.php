<?php
/**
 * Template part: Search result item.
 *
 * @package Nexus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'nexus-post nexus-post--search' ); ?>>

	<header class="nexus-post__header">
		<?php the_title( sprintf( '<h2 class="nexus-post__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="nexus-post__meta">
				<?php echo esc_html( get_the_date() ); ?>
			</div>
		<?php endif; ?>
	</header>

	<div class="nexus-post__excerpt">
		<?php the_excerpt(); ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
