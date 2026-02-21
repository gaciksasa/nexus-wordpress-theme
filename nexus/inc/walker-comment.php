<?php
/**
 * Nexus Theme - Custom Comment Walker
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Walker_Comment
 *
 * Extends Walker_Comment to output theme-styled comment markup.
 */
class Nexus_Walker_Comment extends Walker_Comment {

	/**
	 * Output a single comment.
	 *
	 * @param WP_Comment $comment Comment object.
	 * @param int        $depth   Depth of the comment.
	 * @param array      $args    Array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'nexus-comment nexus-comment--parent' : 'nexus-comment', $comment ); ?>>

			<article id="div-comment-<?php comment_ID(); ?>" class="nexus-comment__body">

				<footer class="nexus-comment__meta">
					<div class="nexus-comment__avatar">
						<?php
						if ( $args['avatars'] ) {
							echo get_avatar( $comment, $args['avatar_size'] );
						}
						?>
					</div><!-- .nexus-comment__avatar -->

					<div class="nexus-comment__author-info">
						<h5 class="nexus-comment__author"><?php comment_author_link( $comment ); ?></h5>
						<div class="nexus-comment__date">
							<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php
									/* translators: 1: comment date, 2: comment time */
									printf( esc_html__( '%1$s at %2$s', 'nexus' ), esc_html( get_comment_date( '', $comment ) ), esc_html( get_comment_time() ) );
									?>
								</time>
							</a>
						</div>
					</div>

					<?php edit_comment_link( esc_html__( 'Edit', 'nexus' ), '<span class="nexus-comment__edit">', '</span>' ); ?>
				</footer><!-- .nexus-comment__meta -->

				<div class="nexus-comment__content">
					<?php if ( '0' === $comment->comment_approved ) : ?>
						<p class="nexus-comment__awaiting">
							<?php esc_html_e( 'Your comment is awaiting moderation.', 'nexus' ); ?>
						</p>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div><!-- .nexus-comment__content -->

				<div class="nexus-comment__reply">
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '',
								'after'     => '',
							)
						)
					);
					?>
				</div>

			</article><!-- .nexus-comment__body -->
		<?php
	}
}
