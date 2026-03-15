<?php
/**
 * License admin page and notices.
 *
 * @package Nexus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Nexus_License_Admin
 */
class Nexus_License_Admin {

	/**
	 * Initialize hooks.
	 */
	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu_page' ) );
		add_action( 'admin_post_nexus_license_activate', array( __CLASS__, 'handle_activate' ) );
		add_action( 'admin_post_nexus_license_deactivate', array( __CLASS__, 'handle_deactivate' ) );
		add_action( 'admin_notices', array( __CLASS__, 'activation_notice' ) );
	}

	/**
	 * Register the admin menu page under Appearance.
	 */
	public static function add_menu_page(): void {
		add_theme_page(
			esc_html__( 'Nexus License', 'nexus' ),
			esc_html__( 'Nexus License', 'nexus' ),
			'manage_options',
			'nexus-license',
			array( __CLASS__, 'render_page' )
		);
	}

	/**
	 * Render the license admin page.
	 */
	public static function render_page(): void {
		$is_active     = nexus_is_activated();
		$purchase_code = nexus_get_purchase_code();
		$license_data  = nexus_get_license_data();

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Nexus License', 'nexus' ); ?></h1>

			<?php settings_errors( 'nexus_license' ); ?>

			<?php if ( $is_active ) : ?>
				<div class="nexus-license-status nexus-license-active" style="background: #d4edda; border-left: 4px solid #28a745; padding: 12px 16px; margin: 20px 0;">
					<p>
						<strong><?php esc_html_e( 'Status: Active', 'nexus' ); ?></strong><br>
						<?php
						printf(
							/* translators: %s: censored purchase code. */
							esc_html__( 'Purchase code: %s', 'nexus' ),
							'<code>' . esc_html( self::censor_code( $purchase_code ) ) . '</code>'
						);
						?>
						<br>
						<?php
						if ( ! empty( $license_data['license_type'] ) ) {
							printf(
								/* translators: %s: license type (regular or extended). */
								esc_html__( 'License type: %s', 'nexus' ),
								esc_html( ucfirst( $license_data['license_type'] ) )
							);
						}
						?>
					</p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'nexus_license_deactivate', 'nexus_license_nonce' ); ?>
						<input type="hidden" name="action" value="nexus_license_deactivate">
						<?php submit_button( esc_html__( 'Deactivate License', 'nexus' ), 'secondary', 'submit', false ); ?>
					</form>
				</div>
			<?php else : ?>
				<div class="nexus-license-status nexus-license-inactive" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px 16px; margin: 20px 0;">
					<p><strong><?php esc_html_e( 'Theme is not activated.', 'nexus' ); ?></strong></p>
					<p><?php esc_html_e( 'Enter your license key to unlock demo imports, auto-updates, and bundled plugins.', 'nexus' ); ?></p>
				</div>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="max-width: 600px;">
					<?php wp_nonce_field( 'nexus_license_activate', 'nexus_license_nonce' ); ?>
					<input type="hidden" name="action" value="nexus_license_activate">
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="nexus_purchase_code"><?php esc_html_e( 'License Key', 'nexus' ); ?></label>
							</th>
							<td>
								<input type="text" id="nexus_purchase_code" name="purchase_code"
									class="regular-text" placeholder="GD-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
									pattern="(GD-)?[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}"
									required>
								<p class="description">
									<?php
									printf(
										/* translators: %s: ThemeForest help URL. */
										esc_html__( 'Enter a GacikDesign license key (GD-xxx) or your Envato purchase code. Find your purchase code in %s.', 'nexus' ),
										'<a href="https://help.market.envato.com/hc/en-us/articles/202822600" target="_blank" rel="noopener">' . esc_html__( 'your Envato account', 'nexus' ) . '</a>'
									);
									?>
								</p>
							</td>
						</tr>
					</table>
					<?php submit_button( esc_html__( 'Activate License', 'nexus' ) ); ?>
				</form>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Handle activation form submission.
	 */
	public static function handle_activate(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized.', 'nexus' ) );
		}

		check_admin_referer( 'nexus_license_activate', 'nexus_license_nonce' );

		$purchase_code = sanitize_text_field( wp_unslash( $_POST['purchase_code'] ?? '' ) );

		if ( empty( $purchase_code ) ) {
			add_settings_error( 'nexus_license', 'empty_code', esc_html__( 'Please enter a purchase code.', 'nexus' ), 'error' );
			set_transient( 'settings_errors', get_settings_errors(), 30 );
			wp_safe_redirect( admin_url( 'themes.php?page=nexus-license&settings-updated=true' ) );
			exit;
		}

		$client = Nexus_License_Client::instance();
		$result = $client->activate( $purchase_code );

		if ( is_wp_error( $result ) ) {
			add_settings_error( 'nexus_license', 'activation_error', $result->get_error_message(), 'error' );
		} else {
			add_settings_error( 'nexus_license', 'activated', esc_html__( 'Theme activated successfully!', 'nexus' ), 'success' );
		}

		set_transient( 'settings_errors', get_settings_errors(), 30 );
		wp_safe_redirect( admin_url( 'themes.php?page=nexus-license&settings-updated=true' ) );
		exit;
	}

	/**
	 * Handle deactivation form submission.
	 */
	public static function handle_deactivate(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized.', 'nexus' ) );
		}

		check_admin_referer( 'nexus_license_deactivate', 'nexus_license_nonce' );

		$client = Nexus_License_Client::instance();
		$client->deactivate();

		add_settings_error( 'nexus_license', 'deactivated', esc_html__( 'License deactivated.', 'nexus' ), 'info' );
		set_transient( 'settings_errors', get_settings_errors(), 30 );
		wp_safe_redirect( admin_url( 'themes.php?page=nexus-license&settings-updated=true' ) );
		exit;
	}

	/**
	 * Show a persistent admin notice if the theme is not activated.
	 */
	public static function activation_notice(): void {
		if ( nexus_is_activated() ) {
			return;
		}

		// Only show on non-license admin pages.
		$screen = get_current_screen();
		if ( $screen && 'appearance_page_nexus-license' === $screen->id ) {
			return;
		}

		// Allow dismissal for 7 days.
		$dismissed = get_transient( 'nexus_license_notice_dismissed' );
		if ( $dismissed ) {
			return;
		}

		printf(
			'<div class="notice notice-warning is-dismissible"><p>%s <a href="%s">%s</a></p></div>',
			esc_html__( 'Nexus theme is not activated. Enter your purchase code to unlock demo imports and auto-updates.', 'nexus' ),
			esc_url( admin_url( 'themes.php?page=nexus-license' ) ),
			esc_html__( 'Activate now', 'nexus' )
		);
	}

	/**
	 * Censor a purchase code for display.
	 *
	 * @param string $code The purchase code.
	 * @return string Censored code.
	 */
	private static function censor_code( string $code ): string {
		if ( strlen( $code ) < 12 ) {
			return '****';
		}
		return substr( $code, 0, 8 ) . '-****-****-****-' . substr( $code, -4 );
	}
}
