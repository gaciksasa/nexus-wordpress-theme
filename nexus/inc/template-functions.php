<?php
/**
 * Nexus Theme - Template Functions
 *
 * Functions used across templates. These are display helpers
 * that render HTML directly or return markup strings.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs the SVG icon sprite (loaded once in header.php).
 * Icons are referenced via <use href="#icon-name">.
 */
function nexus_output_svg_sprite() {
	$sprite_file = NEXUS_ASSETS_DIR . '/images/icons/nexus-icons.svg';

	if ( file_exists( $sprite_file ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$sprite = file_get_contents( $sprite_file );
		echo '<div style="display:none;" aria-hidden="true">' . $sprite . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Outputs the page title bar (hero area below header).
 * Hooked to nexus_after_header at priority 10.
 */
function nexus_page_title_bar() {
	// Don't show on front page or pages built with Elementor full-width template.
	if ( is_front_page() ) {
		return;
	}

	$hide_title_bar = nexus_meta( '_nexus_hide_title_bar' );
	if ( $hide_title_bar ) {
		return;
	}

	$page_title      = nexus_get_page_title();
	$show_breadcrumb = nexus_option( 'nexus_title_bar_breadcrumb', true );
	$bg_image_id     = nexus_meta( '_nexus_title_bar_bg' );
	$bg_style        = $bg_image_id ? ' style="background-image: url(' . esc_url( wp_get_attachment_url( $bg_image_id ) ) . ');"' : '';
	?>

	<div class="nexus-title-bar"<?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="nexus-container">
			<div class="nexus-title-bar__inner">
				<h1 class="nexus-title-bar__title"><?php echo esc_html( $page_title ); ?></h1>
				<?php if ( $show_breadcrumb ) : ?>
					<?php nexus_breadcrumb(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php
}

/**
 * Returns the page title based on the current context.
 *
 * @return string
 */
function nexus_get_page_title() {
	if ( is_singular() ) {
		return get_the_title();
	} elseif ( is_archive() ) {
		return get_the_archive_title();
	} elseif ( is_search() ) {
		return sprintf(
			/* translators: %s: search query */
			esc_html__( 'Search: %s', 'nexus' ),
			get_search_query()
		);
	} elseif ( is_404() ) {
		return esc_html__( 'Page Not Found', 'nexus' );
	}
	return get_bloginfo( 'name' );
}

/**
 * Outputs pagination with accessible markup.
 *
 * @param array $args Optional array of arguments to pass to the_posts_pagination().
 */
function nexus_pagination( $args = array() ) {
	$defaults = array(
		'mid_size'           => 2,
		'prev_text'          => sprintf(
			'<span aria-hidden="true">%s</span><span class="screen-reader-text">%s</span>',
			nexus_icon( 'arrow-left' ),
			esc_html__( 'Previous', 'nexus' )
		),
		'next_text'          => sprintf(
			'<span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span>',
			esc_html__( 'Next', 'nexus' ),
			nexus_icon( 'arrow-right' )
		),
		'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'nexus' ) . '</span>',
	);

	the_posts_pagination( wp_parse_args( $args, $defaults ) );
}

/**
 * Renders the theme's search form.
 * Can be used as an alternative to get_search_form().
 *
 * @param array $args Optional arguments.
 */
function nexus_search_form( $args = array() ) {
	$defaults = array(
		'placeholder' => esc_attr__( 'Search&hellip;', 'nexus' ),
		'button_text' => esc_html__( 'Search', 'nexus' ),
		'class'       => 'nexus-search-form',
	);
	$args     = wp_parse_args( $args, $defaults );
	?>
	<form
		role="search"
		method="get"
		class="<?php echo esc_attr( $args['class'] ); ?>"
		action="<?php echo esc_url( home_url( '/' ) ); ?>"
	>
		<label for="nexus-search-field" class="screen-reader-text">
			<?php esc_html_e( 'Search for:', 'nexus' ); ?>
		</label>
		<div class="nexus-search-form__inner">
			<input
				type="search"
				id="nexus-search-field"
				class="nexus-search-form__field"
				placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				name="s"
				autocomplete="off"
			>
			<button type="submit" class="nexus-search-form__submit">
				<?php echo nexus_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="screen-reader-text"><?php echo esc_html( $args['button_text'] ); ?></span>
			</button>
		</div>
	</form>
	<?php
}

/**
 * Outputs a "Load More" button for AJAX pagination.
 *
 * @param int $max_pages Maximum number of pages.
 */
/**
 * Adds 'nexus-transparent-header' body class on pages with a hero slider.
 * This triggers the CSS transparent-header overlay pattern.
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function nexus_transparent_header_body_class( array $classes ): array {
	// Transparent header is opt-in via Customizer — disabled by default.
	// To re-enable: set nexus_transparent_header option to true via Kirki.
	if ( nexus_option( 'nexus_transparent_header', false ) ) {
		$classes[] = 'nexus-transparent-header';
	}
	return $classes;
}
add_filter( 'body_class', 'nexus_transparent_header_body_class' );

function nexus_load_more_button( $max_pages = 0 ) {
	global $wp_query;
	$max = ! empty( $max_pages ) ? $max_pages : $wp_query->max_num_pages;

	if ( $max <= 1 ) {
		return;
	}
	?>
	<div class="nexus-load-more">
		<button
			class="nexus-btn nexus-btn--outline nexus-load-more__btn"
			data-max-pages="<?php echo esc_attr( $max ); ?>"
			data-current-page="1"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'nexus-load-more' ) ); ?>"
		>
			<?php esc_html_e( 'Load More', 'nexus' ); ?>
		</button>
	</div>
	<?php
}
