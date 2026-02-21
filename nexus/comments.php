<?php
/**
 * The template for displaying comments.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nexus
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="nexus-comments" class="nexus-comments-area">

	<?php if ( have_comments() ) : ?>

		<h2 class="nexus-comments-title">
			<?php
			$nexus_comment_count = get_comments_number();
			if ( '1' === $nexus_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'nexus' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $nexus_comment_count, 'comments title', 'nexus' ) ),
					number_format_i18n( $nexus_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .nexus-comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="nexus-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
					'walker'      => new Nexus_Walker_Comment(),
				)
			);
			?>
		</ol><!-- .nexus-comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note.
	if ( ! comments_open() ) :
		?>
		<p class="nexus-no-comments"><?php esc_html_e( 'Comments are closed.', 'nexus' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_form'          => 'nexus-comment-form',
			'class_submit'        => 'nexus-btn nexus-btn--primary',
			'title_reply'         => esc_html__( 'Leave a Comment', 'nexus' ),
			'title_reply_before'  => '<h2 id="reply-title" class="nexus-comment-reply-title">',
			'title_reply_after'   => '</h2>',
			'label_submit'        => esc_html__( 'Post Comment', 'nexus' ),
			'comment_notes_after' => '',
		)
	);
	?>

</div><!-- #nexus-comments -->
