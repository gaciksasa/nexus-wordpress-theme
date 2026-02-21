<?php
/**
 * Nexus Theme - Custom Navigation Walker
 *
 * Extends Walker_Nav_Menu to add Bootstrap-compatible dropdown
 * and mega menu support with proper ARIA attributes.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Walker_Nav_Menu
 *
 * Custom walker that adds:
 * - Dropdown indicator arrows
 * - ARIA attributes (aria-haspopup, aria-expanded)
 * - Mega menu support via 'mega-menu' CSS class on menu item
 */
class Nexus_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   An array of arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );

		if ( 0 === $depth ) {
			$output .= "\n{$indent}<ul class=\"nexus-dropdown\" role=\"menu\">\n";
		} else {
			$output .= "\n{$indent}<ul class=\"nexus-dropdown nexus-dropdown--sub\" role=\"menu\">\n";
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   An array of arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "{$indent}</ul>\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output            Passed by reference.
	 * @param WP_Post  $item              Menu item data object.
	 * @param int      $depth             Depth of menu item.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $id                Current item/index.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'nexus-menu-item';
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_mega      = in_array( 'mega-menu', $classes, true );

		if ( $has_children ) {
			$classes[] = 'nexus-menu-item--has-dropdown';
		}

		if ( 0 === $depth && $is_mega ) {
			$classes[] = 'nexus-menu-item--mega';
		}

		/**
		 * Filter the list of CSS classes for the current nav menu item.
		 *
		 * @param array    $classes Array of CSS classes.
		 * @param WP_Post  $item    Menu item data object.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @param string   $menu_id The ID attribute applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$role = $depth > 0 ? ' role="none"' : '';

		$output .= $indent . '<li' . $id . $class_names . $role . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';

		if ( '_blank' === $atts['target'] ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}

		$atts['href'] = ! empty( $item->url ) ? $item->url : '';

		if ( $has_children ) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';

			if ( 0 === $depth ) {
				$atts['role'] = 'menuitem';
			} else {
				$atts['role'] = 'menuitem';
			}
		} elseif ( $depth > 0 ) {
			$atts['role'] = 'menuitem';
		}

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @param array    $atts   An array of attributes.
		 * @param WP_Post  $item   The current menu item.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 * @param int      $depth  Depth of menu item.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filter a menu item's title.
		 *
		 * @param string   $title  The menu item's title.
		 * @param WP_Post  $item   The current menu item.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 * @param int      $depth  Depth of menu item.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;

		// Add dropdown arrow for items with children.
		if ( $has_children ) {
			$item_output .= '<span class="nexus-dropdown-arrow" aria-hidden="true">';
			$item_output .= nexus_icon( 'arrow-down' );
			$item_output .= '</span>';
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Fallback for wp_nav_menu() when no menu is assigned.
 *
 * @param array $args Array of wp_nav_menu() arguments.
 */
function nexus_nav_fallback( $args ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	echo '<ul class="nexus-menu nexus-menu--fallback">';
	echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">';
	esc_html_e( '+ Add a Navigation Menu', 'nexus' );
	echo '</a></li>';
	echo '</ul>';
}
