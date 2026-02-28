<?php
/**
 * Header template.
 *
 * @package Nexus
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="nexus-page" class="nexus-page-wrapper">

	<?php
	// Skip to content link — required for accessibility.
	?>
	<a class="nexus-skip-link screen-reader-text" href="#nexus-primary-content">
		<?php esc_html_e( 'Skip to content', 'nexus' ); ?>
	</a>

	<?php
	// Output SVG icon sprite (hidden — referenced via <use> tags).
	nexus_output_svg_sprite();

	// Preloader (conditional).
	if ( nexus_option( 'nexus_preloader', false ) ) :
		get_template_part( 'template-parts/global/preloader' );
	endif;
	?>

	<header id="nexus-masthead" class="nexus-header nexus-header--<?php echo esc_attr( nexus_get_header_style() ); ?>" role="banner">

		<?php
		// Top bar (optional).
		if ( nexus_option( 'nexus_header_topbar', false ) ) :
			get_template_part( 'template-parts/global/header-top-bar' );
		endif;

		// Main navigation — load variant template for centered/split styles.
		$nexus_header_style = nexus_get_header_style();
		if ( 'centered' === $nexus_header_style ) :
			get_template_part( 'template-parts/global/header-nav-centered' );
		elseif ( 'split' === $nexus_header_style ) :
			get_template_part( 'template-parts/global/header-nav-split' );
		else :
			get_template_part( 'template-parts/global/header-nav' );
		endif;

		// Mobile navigation.
		get_template_part( 'template-parts/global/header-mobile' );
		?>

	</header><!-- #nexus-masthead -->

	<?php
	/**
	 * Hook: nexus_after_header
	 *
	 * @hooked nexus_page_title_bar - 10
	 */
	do_action( 'nexus_after_header' );
	?>
