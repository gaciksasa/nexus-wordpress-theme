<?php
/**
 * Template Name: Full Width (No Sidebar)
 * Template Post Type: page, post
 *
 * Full-width layout — header and footer visible, no sidebar, content spans 100%.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="nexus-main">

	<?php
	/**
	 * Fires before page content area.
	 *
	 * @hooked nexus_page_title_bar - 10
	 */
	do_action( 'nexus_before_page_content' );
	?>

	<div class="nexus-container">
		<div class="nexus-content-area nexus-content-area--full">

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'nexus-page-content' ); ?>>
					<?php
					/**
					 * Fires before the page entry content.
					 *
					 * @hooked nexus_page_featured_image - 10
					 */
					do_action( 'nexus_before_page_entry_content' );

					the_content();

					wp_link_pages(
						array(
							'before' => '<nav class="nexus-page-links" aria-label="' . esc_attr__( 'Page navigation', 'nexus' ) . '"><span class="nexus-page-links__label">' . esc_html__( 'Pages:', 'nexus' ) . '</span>',
							'after'  => '</nav>',
						)
					);
					?>
				</article>

			<?php endwhile; ?>

		</div>
	</div>

</main>

<?php
get_footer();
