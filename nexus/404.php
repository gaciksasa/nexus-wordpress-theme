<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Nexus
 */

get_header();
?>

<main id="nexus-primary-content" class="nexus-main">
	<div class="nexus-container">
		<section class="nexus-error-404">

			<div class="nexus-404-content">
				<div class="nexus-404-number" aria-hidden="true">404</div>
				<h1 class="nexus-404-title"><?php esc_html_e( 'Oops! Page Not Found.', 'nexus' ); ?></h1>
				<p class="nexus-404-text">
					<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'nexus' ); ?>
				</p>

				<div class="nexus-404-search">
					<?php get_search_form(); ?>
				</div>

				<div class="nexus-404-actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nexus-btn nexus-btn--primary">
						<?php esc_html_e( 'Back to Home', 'nexus' ); ?>
					</a>
				</div>
			</div>

		</section><!-- .nexus-error-404 -->
	</div><!-- .nexus-container -->
</main><!-- #nexus-primary-content -->

<?php get_footer(); ?>
