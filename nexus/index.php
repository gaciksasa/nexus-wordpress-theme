<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="nexus-page-header">
					<h1 class="nexus-page-title"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php $nexus_blog_style = nexus_option( 'nexus_blog_style', 'grid' ); ?>
			<div class="nexus-blog-grid nexus-blog--<?php echo esc_attr( $nexus_blog_style ); ?>">

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
			<?php endwhile; ?>

			</div><!-- .nexus-blog-grid -->

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => sprintf(
						'<span aria-hidden="true">&laquo;</span> <span class="screen-reader-text">%s</span>',
						esc_html__( 'Previous page', 'nexus' )
					),
					'next_text' => sprintf(
						'<span class="screen-reader-text">%s</span> <span aria-hidden="true">&raquo;</span>',
						esc_html__( 'Next page', 'nexus' )
					),
				)
			);
			?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
		<?php endif; ?>

		<?php if ( nexus_has_sidebar() ) : ?>
			</div><!-- .nexus-primary -->
			<?php nexus_get_sidebar(); ?>
		</div><!-- .nexus-content-area -->
		<?php endif; ?>
	</div><!-- .nexus-container -->
</main><!-- #nexus-primary-content -->

<?php get_footer(); ?>
