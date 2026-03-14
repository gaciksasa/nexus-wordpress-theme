<?php
/**
 * Theme auto-updater — checks GacikDesign API for new versions.
 *
 * @package Nexus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Nexus_Auto_Updater
 */
class Nexus_Auto_Updater {

	/**
	 * Initialize hooks.
	 */
	public static function init(): void {
		add_filter( 'pre_set_site_transient_update_themes', array( __CLASS__, 'check_for_update' ) );
		add_filter( 'upgrader_package_options', array( __CLASS__, 'inject_download_url' ) );
	}

	/**
	 * Check the license server for a theme update.
	 *
	 * @param mixed $transient The update_themes transient.
	 * @return mixed Modified transient.
	 */
	public static function check_for_update( $transient ) {
		if ( ! nexus_is_activated() ) {
			return $transient;
		}

		// Avoid repeated checks in the same request.
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$client     = Nexus_License_Client::instance();
		$site_token = $client->get_site_token();

		if ( empty( $site_token ) ) {
			return $transient;
		}

		// Build a signed check-update URL.
		$base_url  = Nexus_License_Client::API_URL . '/api/v1/' . Nexus_License_Client::PRODUCT_SLUG . '/check-update';
		$timestamp = (string) time();
		$body      = '';
		$signature = hash_hmac( 'sha256', $timestamp . '|' . $body, $site_token );

		$url = add_query_arg( 'current_version', NEXUS_VERSION, $base_url );

		$response = wp_remote_get(
			$url,
			array(
				'timeout' => 15,
				'headers' => array(
					'X-Gacik-Signature' => $signature,
					'X-Gacik-Timestamp' => $timestamp,
					'X-Gacik-Token'     => $site_token,
				),
			)
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return $transient;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $data['has_update'] ) || empty( $data['latest_version'] ) ) {
			return $transient;
		}

		$theme_slug = get_option( 'template' );

		$transient->response[ $theme_slug ] = array(
			'theme'       => $theme_slug,
			'new_version' => $data['latest_version'],
			'url'         => '',
			'package'     => '', // Will be injected by inject_download_url.
		);

		// Store the latest version for reference.
		$license_data                   = nexus_get_license_data();
		$license_data['latest_version'] = $data['latest_version'];
		update_option( 'nexus_license_data', $license_data );

		return $transient;
	}

	/**
	 * Inject the authenticated download URL when WordPress downloads the update.
	 *
	 * @param array $options Upgrader options.
	 * @return array Modified options.
	 */
	public static function inject_download_url( array $options ): array {
		if ( empty( $options['hook_extra']['theme'] ) ) {
			return $options;
		}

		$theme_slug = get_option( 'template' );

		if ( $options['hook_extra']['theme'] !== $theme_slug ) {
			return $options;
		}

		if ( ! nexus_is_activated() ) {
			return $options;
		}

		$client     = Nexus_License_Client::instance();
		$site_token = $client->get_site_token();

		if ( empty( $site_token ) ) {
			return $options;
		}

		// Build a signed download URL.
		$url       = Nexus_License_Client::API_URL . '/api/v1/' . Nexus_License_Client::PRODUCT_SLUG . '/download-update';
		$timestamp = (string) time();
		$body      = '';
		$signature = hash_hmac( 'sha256', $timestamp . '|' . $body, $site_token );

		$options['package'] = add_query_arg(
			array(
				'signature' => $signature,
				'timestamp' => $timestamp,
				'token'     => $site_token,
			),
			$url
		);

		return $options;
	}
}
