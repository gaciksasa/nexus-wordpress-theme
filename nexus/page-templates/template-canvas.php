<?php
/**
 * Template Name: Canvas (With Header/Footer)
 * Template Post Type: page
 *
 * Full-canvas Elementor template — outputs page content without any wrapper
 * containers so Elementor sections can be 100% wide, but still includes the
 * theme header (navigation) and footer.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="nexus-canvas-main" class="nexus-main nexus-main--canvas">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<?php get_footer(); ?>
