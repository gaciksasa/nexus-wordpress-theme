<?php
/**
 * Core license client — communicates with the GacikDesign License API.
 *
 * @package Nexus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Nexus_License_Client
 */
class Nexus_License_Client {

	const API_URL      = 'https://api.gacikdesign.com';
	const PRODUCT_SLUG = 'nexus';

	/**
	 * Singleton instance.
	 *
	 * @var self|null
	 */
	private static ?self $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return self
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Private constructor.
	 */
	private function __construct() {}

	/**
	 * Activate a purchase code for this site.
	 *
	 * @param string $purchase_code Envato purchase code (UUID).
	 * @return array|WP_Error Activation result or error.
	 */
	public function activate( string $purchase_code ) {
		$body = array(
			'purchase_code' => $purchase_code,
			'domain'        => home_url(),
			'wp_version'    => get_bloginfo( 'version' ),
			'theme_version' => NEXUS_VERSION,
			'php_version'   => PHP_VERSION,
		);

		$response = $this->api_request(
			'/' . self::PRODUCT_SLUG . '/activate',
			$body,
			'POST',
			$purchase_code // Use purchase code as signing key for activation.
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( ! empty( $response['status'] ) && 'activated' === $response['status'] ) {
			update_option( 'nexus_purchase_code', $purchase_code );
			update_option( 'nexus_license_status', 'active' );
			update_option(
				'nexus_license_data',
				array(
					'site_token'      => $response['site_token'] ?? '',
					'license_type'    => $response['license_type'] ?? 'regular',
					'supported_until' => $response['supported_until'] ?? '',
					'activated_at'    => current_time( 'mysql' ),
				)
			);

			return $response;
		}

		return new WP_Error( 'activation_failed', $response['message'] ?? esc_html__( 'Activation failed.', 'nexus' ) );
	}

	/**
	 * Deactivate the current license for this site.
	 *
	 * @return array|WP_Error
	 */
	public function deactivate() {
		$purchase_code = nexus_get_purchase_code();
		$site_token    = $this->get_site_token();

		if ( empty( $purchase_code ) || empty( $site_token ) ) {
			// No active license — just clear local data.
			$this->clear_local_data();
			return array( 'status' => 'deactivated' );
		}

		$body = array(
			'purchase_code' => $purchase_code,
			'domain'        => home_url(),
		);

		$response = $this->api_request( '/' . self::PRODUCT_SLUG . '/deactivate', $body, 'POST', $site_token );

		// Clear local data regardless of server response.
		$this->clear_local_data();

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return $response;
	}

	/**
	 * Verify the current activation with the server.
	 *
	 * @return array|WP_Error
	 */
	public function verify() {
		$purchase_code = nexus_get_purchase_code();
		$site_token    = $this->get_site_token();

		if ( empty( $purchase_code ) || empty( $site_token ) ) {
			return new WP_Error( 'not_activated', esc_html__( 'Theme is not activated.', 'nexus' ) );
		}

		$body = array(
			'purchase_code' => $purchase_code,
			'domain'        => home_url(),
		);

		$response = $this->api_request( '/' . self::PRODUCT_SLUG . '/verify', $body, 'POST', $site_token );

		if ( is_wp_error( $response ) ) {
			$error_code = $response->get_error_code();

			// If blocked or deactivated, clear local data.
			if ( in_array( $error_code, array( 'http_403', 'http_404' ), true ) ) {
				$this->clear_local_data();
			}

			return $response;
		}

		// Update license data with latest info.
		if ( ! empty( $response['status'] ) && 'active' === $response['status'] ) {
			$data                     = get_option( 'nexus_license_data', array() );
			$data['license_type']     = $response['license_type'] ?? $data['license_type'] ?? 'regular';
			$data['supported_until']  = $response['supported_until'] ?? $data['supported_until'] ?? '';
			$data['latest_version']   = $response['latest_version'] ?? '';
			$data['last_verified_at'] = current_time( 'mysql' );
			update_option( 'nexus_license_data', $data );
		}

		return $response;
	}

	/**
	 * Get the site token from stored license data.
	 *
	 * @return string
	 */
	public function get_site_token(): string {
		$data = get_option( 'nexus_license_data', array() );
		return $data['site_token'] ?? '';
	}

	/**
	 * Clear all local license data.
	 */
	private function clear_local_data(): void {
		delete_option( 'nexus_purchase_code' );
		delete_option( 'nexus_license_data' );
		update_option( 'nexus_license_status', 'inactive' );
	}

	/**
	 * Make a signed API request.
	 *
	 * @param string $endpoint  API endpoint (relative, e.g. /nexus/activate).
	 * @param array  $body      Request body data.
	 * @param string $method    HTTP method.
	 * @param string $sign_key  Key to use for HMAC (purchase_code for activate, site_token otherwise).
	 * @return array|WP_Error   Decoded JSON response or error.
	 */
	private function api_request( string $endpoint, array $body = array(), string $method = 'POST', string $sign_key = '' ): array|WP_Error {
		$url       = self::API_URL . '/api/v1' . $endpoint;
		$json_body = wp_json_encode( $body );
		$timestamp = (string) time();

		// HMAC signature.
		$signature = hash_hmac( 'sha256', $timestamp . '|' . $json_body, $sign_key );

		$args = array(
			'method'  => $method,
			'timeout' => 30,
			'headers' => array(
				'Content-Type'     => 'application/json',
				'X-Gacik-Signature' => $signature,
				'X-Gacik-Timestamp' => $timestamp,
				'X-Gacik-Token'     => ( 'POST' !== $method || ! str_contains( $endpoint, '/activate' ) ) ? $sign_key : '',
			),
			'body'    => $json_body,
		);

		$response = wp_remote_request( $url, $args );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$code         = wp_remote_retrieve_response_code( $response );
		$decoded_body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! is_array( $decoded_body ) ) {
			return new WP_Error( 'invalid_response', esc_html__( 'Invalid response from license server.', 'nexus' ) );
		}

		if ( $code < 200 || $code >= 300 ) {
			return new WP_Error(
				'http_' . $code,
				$decoded_body['message'] ?? esc_html__( 'License server error.', 'nexus' ),
				$decoded_body
			);
		}

		return $decoded_body;
	}
}
