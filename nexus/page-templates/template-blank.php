<?php
/**
 * Template Name: Blank (No Header/Footer)
 * Template Post Type: page
 *
 * A fully blank canvas — header and footer are hidden.
 * Useful for landing pages, splash pages, and Elementor full-page designs.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'nexus-template-blank' ); ?>>
<?php wp_body_open(); ?>

<main id="nexus-blank-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</main>

<?php wp_footer(); ?>
</body>
</html>
