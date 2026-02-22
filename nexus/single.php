<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Nexus
 */

get_header();
?>

<div id="nexus-reading-progress" role="progressbar" aria-label="<?php esc_attr_e( 'Reading progress', 'nexus' ); ?>" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
	<div class="nexus-reading-progress__fill"></div>
</div>

<main id="nexus-primary-content" class="nexus-main">
	<div class="nexus-container">
		<?php if ( nexus_has_sidebar() ) : ?>
		<div class="nexus-content-area nexus-layout--<?php echo esc_attr( nexus_get_layout() ); ?>">
			<div class="nexus-primary">
		<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', 'single' );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'nexus' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'nexus' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// Related posts.
			if ( nexus_option( 'nexus_related_posts', true ) ) :
				get_template_part( 'template-parts/post/post-related' );
			endif;

			// Comments.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

		<?php if ( nexus_has_sidebar() ) : ?>
			</div><!-- .nexus-primary -->
			<?php get_sidebar(); ?>
		</div><!-- .nexus-content-area -->
		<?php endif; ?>
	</div><!-- .nexus-container -->
</main><!-- #nexus-primary-content -->

<?php get_footer(); ?>
