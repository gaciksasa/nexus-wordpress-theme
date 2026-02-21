<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#page
 *
 * @package Nexus
 */

get_header();
?>

<main id="nexus-primary-content" class="nexus-main">
	<div class="nexus-container">
		<?php if ( nexus_has_sidebar() ) : ?>
		<div class="nexus-content-area nexus-layout--<?php echo esc_attr( nexus_get_layout() ); ?>">
			<div class="nexus-primary">
		<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
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
