<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Nexus
 */

get_header();
?>

<main id="nexus-primary-content" class="nexus-main">
	<div class="nexus-container">
		<div class="nexus-content-area nexus-layout--right-sidebar">
			<div class="nexus-primary">

				<?php if ( have_posts() ) : ?>

					<header class="nexus-page-header">
						<h1 class="nexus-page-title">
							<?php
							printf(
								/* translators: %s: search query */
								esc_html__( 'Search Results for: %s', 'nexus' ),
								'<span>' . esc_html( get_search_query() ) . '</span>'
							);
							?>
						</h1>
					</header><!-- .nexus-page-header -->

					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<?php get_template_part( 'template-parts/content/content', 'search' ); ?>
					<?php endwhile; ?>

					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => sprintf(
								'<span aria-hidden="true">&laquo;</span><span class="screen-reader-text">%s</span>',
								esc_html__( 'Previous page', 'nexus' )
							),
							'next_text' => sprintf(
								'<span class="screen-reader-text">%s</span><span aria-hidden="true">&raquo;</span>',
								esc_html__( 'Next page', 'nexus' )
							),
						)
					);
					?>

				<?php else : ?>

					<div class="nexus-no-results">
						<h2><?php esc_html_e( 'Nothing Found', 'nexus' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'nexus' ); ?></p>
						<?php get_search_form(); ?>
					</div>

				<?php endif; ?>

			</div><!-- .nexus-primary -->
			<?php get_sidebar(); ?>
		</div><!-- .nexus-content-area -->
	</div><!-- .nexus-container -->
</main><!-- #nexus-primary-content -->

<?php get_footer(); ?>
