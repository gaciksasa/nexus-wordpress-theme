<?php
/**
 * Nexus Theme - Custom Nav Menu Item Fields
 *
 * Adds custom fields (icon, image, badge, description) to nav menu items
 * via Appearance → Menus. Uses wp_nav_menu_item_custom_fields (WP 5.4+).
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Nav_Menu_Fields
 *
 * Registers and handles custom fields for navigation menu items.
 */
class Nexus_Nav_Menu_Fields {

	/**
	 * Meta key prefix.
	 *
	 * @var string
	 */
	const PREFIX = '_nexus_menu_';

	/**
	 * Instance.
	 *
	 * @var Nexus_Nav_Menu_Fields|null
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Nexus_Nav_Menu_Fields
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		// Add fields to the menu item editor.
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_fields' ), 10, 5 );

		// Save custom fields.
		add_action( 'wp_update_nav_menu_item', array( $this, 'save_fields' ), 10, 3 );

		// Enqueue admin assets for the media uploader.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		// Pass custom meta to the front-end menu item object.
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_nav_menu_item' ) );
	}

	/**
	 * Returns the list of available SVG icons from the theme sprite.
	 *
	 * @return array Icon slug => label.
	 */
	public static function get_icon_options() {
		$icons = array(
			''              => __( '— None —', 'nexus' ),
			'arrow-right'   => 'Arrow Right',
			'arrow-down'    => 'Arrow Down',
			'check'         => 'Check',
			'star'          => 'Star',
			'heart'         => 'Heart',
			'user'          => 'User',
			'users'         => 'Users',
			'home'          => 'Home',
			'mail'          => 'Mail',
			'phone'         => 'Phone',
			'map-pin'       => 'Map Pin',
			'clock'         => 'Clock',
			'calendar'      => 'Calendar',
			'search'        => 'Search',
			'settings'      => 'Settings',
			'grid'          => 'Grid',
			'layers'        => 'Layers',
			'image'         => 'Image',
			'video'         => 'Video',
			'file'          => 'File',
			'folder'        => 'Folder',
			'code'          => 'Code',
			'terminal'      => 'Terminal',
			'palette'       => 'Palette',
			'briefcase'     => 'Briefcase',
			'shopping-cart'  => 'Shopping Cart',
			'shopping-bag'   => 'Shopping Bag',
			'tag'           => 'Tag',
			'bolt'          => 'Bolt',
			'shield'        => 'Shield',
			'globe'         => 'Globe',
			'link'          => 'Link',
			'chart'         => 'Chart',
			'trending-up'   => 'Trending Up',
			'megaphone'     => 'Megaphone',
			'rocket'        => 'Rocket',
			'puzzle'        => 'Puzzle',
			'book'          => 'Book',
			'graduation-cap' => 'Graduation Cap',
			'headphones'    => 'Headphones',
			'camera'        => 'Camera',
			'pen'           => 'Pen',
			'database'      => 'Database',
			'server'        => 'Server',
			'cloud'         => 'Cloud',
			'lock'          => 'Lock',
			'key'           => 'Key',
			'eye'           => 'Eye',
			'thumb-up'      => 'Thumb Up',
			'award'         => 'Award',
			'zap'           => 'Zap',
			'play'          => 'Play',
			'download'      => 'Download',
			'share'         => 'Share',
			'external-link' => 'External Link',
			'plus'          => 'Plus',
			'menu'          => 'Menu',
			'sun'           => 'Sun',
			'moon'          => 'Moon',
		);

		/**
		 * Filter the available icon options for nav menu items.
		 *
		 * @param array $icons Icon slug => label.
		 */
		return apply_filters( 'nexus_nav_menu_icon_options', $icons );
	}

	/**
	 * Renders custom fields in the menu item editor.
	 *
	 * @param int      $item_id Menu item ID.
	 * @param WP_Post  $menu_item Menu item data object.
	 * @param int      $depth Depth of menu item.
	 * @param stdClass $args An object of menu item args.
	 * @param int      $current_object_id Nav menu ID.
	 */
	public function render_fields( $item_id, $menu_item, $depth, $args, $current_object_id ) {
		$icon        = get_post_meta( $item_id, self::PREFIX . 'icon', true );
		$image_id    = get_post_meta( $item_id, self::PREFIX . 'image', true );
		$badge       = get_post_meta( $item_id, self::PREFIX . 'badge', true );
		$badge_color = get_post_meta( $item_id, self::PREFIX . 'badge_color', true );
		$desc        = get_post_meta( $item_id, self::PREFIX . 'desc', true );

		$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : '';

		if ( empty( $badge_color ) ) {
			$badge_color = 'primary';
		}
		?>
		<div class="nexus-menu-fields" style="clear:both; padding: 12px 0 0; border-top: 1px dashed #ddd; margin-top: 10px;">
			<p class="description" style="margin-bottom: 8px;">
				<strong><?php esc_html_e( 'Nexus — Enhanced Menu Options', 'nexus' ); ?></strong>
			</p>

			<?php // Icon select. ?>
			<p class="field-nexus-icon description description-wide">
				<label for="edit-menu-item-nexus-icon-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Icon', 'nexus' ); ?>
					<select
						id="edit-menu-item-nexus-icon-<?php echo esc_attr( $item_id ); ?>"
						name="nexus_menu_icon[<?php echo esc_attr( $item_id ); ?>]"
						class="widefat"
					>
						<?php foreach ( self::get_icon_options() as $slug => $label ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $icon, $slug ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>
			</p>

			<?php // Image upload. ?>
			<p class="field-nexus-image description description-wide">
				<label for="edit-menu-item-nexus-image-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Image', 'nexus' ); ?>
				</label>
				<span class="nexus-menu-image-preview" style="display:block; margin: 4px 0;">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" style="max-width: 60px; height: auto; border-radius: 4px;">
					<?php endif; ?>
				</span>
				<input
					type="hidden"
					id="edit-menu-item-nexus-image-<?php echo esc_attr( $item_id ); ?>"
					name="nexus_menu_image[<?php echo esc_attr( $item_id ); ?>]"
					value="<?php echo esc_attr( $image_id ); ?>"
					class="nexus-menu-image-id"
				>
				<button
					type="button"
					class="button nexus-menu-image-upload"
					data-target="#edit-menu-item-nexus-image-<?php echo esc_attr( $item_id ); ?>"
				>
					<?php esc_html_e( 'Select Image', 'nexus' ); ?>
				</button>
				<button
					type="button"
					class="button nexus-menu-image-remove"
					data-target="#edit-menu-item-nexus-image-<?php echo esc_attr( $item_id ); ?>"
					style="<?php echo $image_id ? '' : 'display:none;'; ?>"
				>
					<?php esc_html_e( 'Remove', 'nexus' ); ?>
				</button>
			</p>

			<?php // Badge text. ?>
			<p class="field-nexus-badge description description-wide">
				<label for="edit-menu-item-nexus-badge-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Badge Text', 'nexus' ); ?>
					<input
						type="text"
						id="edit-menu-item-nexus-badge-<?php echo esc_attr( $item_id ); ?>"
						name="nexus_menu_badge[<?php echo esc_attr( $item_id ); ?>]"
						value="<?php echo esc_attr( $badge ); ?>"
						class="widefat"
						placeholder="<?php esc_attr_e( 'e.g. New, Hot, Sale', 'nexus' ); ?>"
					>
				</label>
			</p>

			<?php // Badge color. ?>
			<p class="field-nexus-badge-color description description-wide">
				<label for="edit-menu-item-nexus-badge-color-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Badge Color', 'nexus' ); ?>
					<select
						id="edit-menu-item-nexus-badge-color-<?php echo esc_attr( $item_id ); ?>"
						name="nexus_menu_badge_color[<?php echo esc_attr( $item_id ); ?>]"
						class="widefat"
					>
						<option value="primary" <?php selected( $badge_color, 'primary' ); ?>><?php esc_html_e( 'Primary', 'nexus' ); ?></option>
						<option value="secondary" <?php selected( $badge_color, 'secondary' ); ?>><?php esc_html_e( 'Secondary', 'nexus' ); ?></option>
						<option value="accent" <?php selected( $badge_color, 'accent' ); ?>><?php esc_html_e( 'Accent', 'nexus' ); ?></option>
						<option value="success" <?php selected( $badge_color, 'success' ); ?>><?php esc_html_e( 'Success (Green)', 'nexus' ); ?></option>
						<option value="warning" <?php selected( $badge_color, 'warning' ); ?>><?php esc_html_e( 'Warning (Orange)', 'nexus' ); ?></option>
						<option value="danger" <?php selected( $badge_color, 'danger' ); ?>><?php esc_html_e( 'Danger (Red)', 'nexus' ); ?></option>
					</select>
				</label>
			</p>

			<?php // Short description. ?>
			<p class="field-nexus-desc description description-wide">
				<label for="edit-menu-item-nexus-desc-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Short Description', 'nexus' ); ?>
					<input
						type="text"
						id="edit-menu-item-nexus-desc-<?php echo esc_attr( $item_id ); ?>"
						name="nexus_menu_desc[<?php echo esc_attr( $item_id ); ?>]"
						value="<?php echo esc_attr( $desc ); ?>"
						class="widefat"
						placeholder="<?php esc_attr_e( 'Short description below the link text', 'nexus' ); ?>"
					>
				</label>
			</p>
		</div>
		<?php
	}

	/**
	 * Saves custom fields when a menu item is updated.
	 *
	 * @param int   $menu_id         ID of the updated menu.
	 * @param int   $menu_item_db_id ID of the updated menu item.
	 * @param array $args            An array of arguments used to update a menu item.
	 */
	public function save_fields( $menu_id, $menu_item_db_id, $args ) {
		// Icon.
		if ( isset( $_POST['nexus_menu_icon'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$icon = sanitize_text_field( wp_unslash( $_POST['nexus_menu_icon'][ $menu_item_db_id ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			update_post_meta( $menu_item_db_id, self::PREFIX . 'icon', $icon );
		}

		// Image.
		if ( isset( $_POST['nexus_menu_image'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$image = absint( $_POST['nexus_menu_image'][ $menu_item_db_id ] ); // phpcs:ignore WordPress.Security.NonceVerification
			update_post_meta( $menu_item_db_id, self::PREFIX . 'image', $image );
		}

		// Badge.
		if ( isset( $_POST['nexus_menu_badge'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$badge = sanitize_text_field( wp_unslash( $_POST['nexus_menu_badge'][ $menu_item_db_id ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			update_post_meta( $menu_item_db_id, self::PREFIX . 'badge', $badge );
		}

		// Badge color.
		if ( isset( $_POST['nexus_menu_badge_color'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$allowed = array( 'primary', 'secondary', 'accent', 'success', 'warning', 'danger' );
			$color   = sanitize_text_field( wp_unslash( $_POST['nexus_menu_badge_color'][ $menu_item_db_id ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			if ( ! in_array( $color, $allowed, true ) ) {
				$color = 'primary';
			}
			update_post_meta( $menu_item_db_id, self::PREFIX . 'badge_color', $color );
		}

		// Description.
		if ( isset( $_POST['nexus_menu_desc'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$desc = sanitize_text_field( wp_unslash( $_POST['nexus_menu_desc'][ $menu_item_db_id ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			update_post_meta( $menu_item_db_id, self::PREFIX . 'desc', $desc );
		}
	}

	/**
	 * Enqueue admin scripts for the Menus page (media uploader).
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_admin_assets( $hook_suffix ) {
		if ( 'nav-menus.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_media();

		$inline_js = <<<'JS'
(function($){
	$(document).on('click','.nexus-menu-image-upload',function(e){
		e.preventDefault();
		var btn = $(this),
			target = btn.data('target'),
			input = $(target),
			preview = btn.closest('.field-nexus-image').find('.nexus-menu-image-preview'),
			removeBtn = btn.siblings('.nexus-menu-image-remove');

		var frame = wp.media({
			title: 'Select Menu Item Image',
			button: { text: 'Use This Image' },
			multiple: false,
			library: { type: 'image' }
		});

		frame.on('select',function(){
			var attachment = frame.state().get('selection').first().toJSON();
			input.val(attachment.id);
			var url = attachment.sizes && attachment.sizes.thumbnail
				? attachment.sizes.thumbnail.url
				: attachment.url;
			preview.html('<img src="'+url+'" style="max-width:60px;height:auto;border-radius:4px;">');
			removeBtn.show();
		});

		frame.open();
	});

	$(document).on('click','.nexus-menu-image-remove',function(e){
		e.preventDefault();
		var btn = $(this),
			target = btn.data('target'),
			input = $(target),
			preview = btn.closest('.field-nexus-image').find('.nexus-menu-image-preview');
		input.val('');
		preview.html('');
		btn.hide();
	});
})(jQuery);
JS;

		wp_register_script( 'nexus-nav-menu-fields', false, array( 'jquery' ), NEXUS_VERSION, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_script( 'nexus-nav-menu-fields' );
		wp_add_inline_script( 'nexus-nav-menu-fields', $inline_js );
	}

	/**
	 * Attach custom meta to the nav menu item object for front-end use.
	 *
	 * @param WP_Post $menu_item The menu item object.
	 * @return WP_Post
	 */
	public function setup_nav_menu_item( $menu_item ) {
		if ( isset( $menu_item->ID ) ) {
			$menu_item->nexus_icon        = get_post_meta( $menu_item->ID, self::PREFIX . 'icon', true );
			$menu_item->nexus_image       = get_post_meta( $menu_item->ID, self::PREFIX . 'image', true );
			$menu_item->nexus_badge       = get_post_meta( $menu_item->ID, self::PREFIX . 'badge', true );
			$menu_item->nexus_badge_color = get_post_meta( $menu_item->ID, self::PREFIX . 'badge_color', true );
			$menu_item->nexus_desc        = get_post_meta( $menu_item->ID, self::PREFIX . 'desc', true );
		}
		return $menu_item;
	}
}

// Initialize.
Nexus_Nav_Menu_Fields::instance();
