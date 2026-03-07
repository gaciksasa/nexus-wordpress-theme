<?php
/**
 * Nexus Theme - Custom Navigation Walker
 *
 * Extends Walker_Nav_Menu to add dropdown and mega menu support
 * with proper ARIA attributes.
 *
 * Mega menu is activated by adding the CSS class "mega-menu" to a
 * top-level menu item in Appearance → Menus. Its direct children
 * become column headings, and grandchildren become the column links.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Walker_Nav_Menu
 */
class Nexus_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Track whether the current top-level item is a mega menu.
	 *
	 * @var bool
	 */
	private $is_mega = false;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   An array of arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );

		if ( 0 === $depth && $this->is_mega ) {
			// Mega menu panel: depth-0 children will be columns.
			$output .= "\n{$indent}<div class=\"nexus-mega-menu\" role=\"menu\">\n";
			$output .= "{$indent}\t<div class=\"nexus-mega-menu__inner\">\n";
		} elseif ( 1 === $depth && $this->is_mega ) {
			// Mega column link list (depth-1 children of a mega parent).
			$output .= "\n{$indent}<ul class=\"nexus-mega-menu__links\" role=\"menu\">\n";
		} elseif ( 0 === $depth ) {
			$output .= "\n{$indent}<ul class=\"nexus-dropdown\" role=\"menu\">\n";
		} else {
			$output .= "\n{$indent}<ul class=\"nexus-dropdown nexus-dropdown--sub\" role=\"menu\">\n";
		}
	}

	/**
	 * Ends the list after the elements are added.
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   An array of arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );

		if ( 0 === $depth && $this->is_mega ) {
			$output .= "{$indent}\t</div>\n";
			$output .= "{$indent}</div>\n";
		} elseif ( 1 === $depth && $this->is_mega ) {
			$output .= "{$indent}</ul>\n";
		} else {
			$output .= "{$indent}</ul>\n";
		}
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Passed by reference.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item/index.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'nexus-menu-item';
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_mega_item = in_array( 'mega-menu', $classes, true );

		if ( $has_children ) {
			$classes[] = 'nexus-menu-item--has-dropdown';
		}

		// Track mega state for start_lvl/end_lvl.
		if ( 0 === $depth && $is_mega_item ) {
			$this->is_mega = true;
			$classes[]     = 'nexus-menu-item--mega';
		} elseif ( 0 === $depth && ! $is_mega_item ) {
			$this->is_mega = false;
		}

		// Depth-1 items inside a mega menu are column headings.
		$is_mega_col = ( 1 === $depth && $this->is_mega );
		if ( $is_mega_col ) {
			$classes[] = 'nexus-mega-menu__col';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$el_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$el_id = $el_id ? ' id="' . esc_attr( $el_id ) . '"' : '';

		$role = $depth > 0 ? ' role="none"' : '';

		if ( $is_mega_col ) {
			// Column wrapper: use a <div> instead of <li>.
			$output .= $indent . '<div' . $el_id . $class_names . '>';
		} else {
			$output .= $indent . '<li' . $el_id . $class_names . $role . '>';
		}

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';

		if ( '_blank' === $atts['target'] ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}

		$atts['href'] = ! empty( $item->url ) ? $item->url : '';

		if ( $has_children && ! $is_mega_col ) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['role']          = 'menuitem';
		} elseif ( $depth > 0 ) {
			$atts['role'] = 'menuitem';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
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

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		// Custom fields (icon, image, badge, description).
		$menu_icon        = ! empty( $item->nexus_icon ) ? $item->nexus_icon : '';
		$menu_image       = ! empty( $item->nexus_image ) ? $item->nexus_image : '';
		$menu_badge       = ! empty( $item->nexus_badge ) ? $item->nexus_badge : '';
		$menu_badge_color = ! empty( $item->nexus_badge_color ) ? $item->nexus_badge_color : 'primary';
		$menu_desc        = ! empty( $item->nexus_desc ) ? $item->nexus_desc : '';

		// Build icon HTML.
		$icon_html = '';
		if ( $menu_icon ) {
			$icon_html = '<span class="nexus-menu-icon" aria-hidden="true">' . nexus_icon( $menu_icon ) . '</span>';
		}

		// Build image HTML.
		$image_html = '';
		if ( $menu_image ) {
			$img_url = wp_get_attachment_image_url( $menu_image, 'thumbnail' );
			if ( $img_url ) {
				$image_html = '<span class="nexus-menu-image"><img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $title ) . '"></span>';
			}
		}

		// Build badge HTML.
		$badge_html = '';
		if ( $menu_badge ) {
			$badge_html = '<span class="nexus-menu-badge nexus-menu-badge--' . esc_attr( $menu_badge_color ) . '">' . esc_html( $menu_badge ) . '</span>';
		}

		// Build description HTML.
		$desc_html = '';
		if ( $menu_desc ) {
			$desc_html = '<span class="nexus-menu-desc">' . esc_html( $menu_desc ) . '</span>';
		}

		$item_output = $args->before;

		if ( $is_mega_col ) {
			// Column heading with optional icon/image.
			$heading_content = $icon_html . esc_html( $title );

			if ( ! empty( $item->url ) && '#' !== trim( $item->url ) ) {
				$item_output .= '<a' . $attributes . ' class="nexus-mega-menu__col-link">';
				$item_output .= $args->link_before . $heading_content . $args->link_after;
				$item_output .= '</a>';
			} else {
				$item_output .= '<h5 class="nexus-mega-menu__col-title">' . $heading_content . '</h5>';
			}

			// Column image (displayed as header image for the column).
			if ( $image_html ) {
				$item_output .= '<div class="nexus-mega-menu__col-image">' . $image_html . '</div>';
			}

			// Column description from custom field or WP description field.
			$col_desc = $menu_desc ? $menu_desc : ( ! empty( $item->description ) ? $item->description : '' );
			if ( $col_desc ) {
				$item_output .= '<p class="nexus-mega-menu__col-desc">' . esc_html( $col_desc ) . '</p>';
			}
		} elseif ( $depth >= 2 && $this->is_mega ) {
			// Mega menu grandchild links: icon + text + badge + description layout.
			$item_output .= '<a' . $attributes . '>';

			if ( $image_html || $icon_html ) {
				$item_output .= '<span class="nexus-mega-link__visual">';
				$item_output .= $image_html ? $image_html : $icon_html;
				$item_output .= '</span>';
			}

			$item_output .= '<span class="nexus-mega-link__content">';
			$item_output .= '<span class="nexus-mega-link__title">';
			$item_output .= $args->link_before . $title . $args->link_after;
			if ( $badge_html ) {
				$item_output .= ' ' . $badge_html;
			}
			$item_output .= '</span>';

			if ( $desc_html ) {
				$item_output .= $desc_html;
			}
			$item_output .= '</span>';

			$item_output .= '</a>';
		} else {
			// Regular menu items.
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $icon_html;
			$item_output .= $args->link_before . $title . $args->link_after;

			if ( $badge_html ) {
				$item_output .= ' ' . $badge_html;
			}

			// Add dropdown arrow for items with children (not mega columns).
			if ( $has_children ) {
				$item_output .= '<span class="nexus-dropdown-arrow" aria-hidden="true">';
				$item_output .= nexus_icon( 'arrow-down' );
				$item_output .= '</span>';
			}

			$item_output .= '</a>';

			// Description below the link for regular dropdowns.
			if ( $desc_html && $depth > 0 ) {
				$item_output .= $desc_html;
			}
		}

		$item_output .= $args->after;

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output.
	 *
	 * @param string   $output Passed by reference.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$is_mega_col = ( 1 === $depth && $this->is_mega );

		if ( $is_mega_col ) {
			$output .= "</div>\n";
		} else {
			$output .= "</li>\n";
		}
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

/**
 * Enable the "Description" field for menu items in Appearance → Menus.
 * This is used for mega menu column descriptions.
 *
 * @param array $columns Menu item columns.
 * @return array
 */
function nexus_nav_menu_columns( $columns ) {
	$columns['description'] = esc_html__( 'Description', 'nexus' );
	return $columns;
}
add_filter( 'manage_nav-menus_columns', 'nexus_nav_menu_columns' );
