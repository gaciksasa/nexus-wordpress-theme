<?php
/**
 * Demo import proxy — replaces local demo URLs with license-gated server URLs.
 *
 * @package Nexus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Nexus_Demo_Proxy
 */
class Nexus_Demo_Proxy {

	/**
	 * Initialize hooks.
	 */
	public static function init(): void {
		add_filter( 'nexus_demo_list', array( __CLASS__, 'filter_demo_list' ) );
	}

	/**
	 * Filter the demo list.
	 *
	 * If the theme is activated, replace local demo file URLs with
	 * authenticated server URLs. If not activated, return an empty array
	 * to prevent demo import.
	 *
	 * @param array $demos The demo list.
	 * @return array Filtered demo list.
	 */
	public static function filter_demo_list( array $demos ): array {
		if ( ! nexus_is_activated() ) {
			return array();
		}

		$client     = Nexus_License_Client::instance();
		$site_token = $client->get_site_token();

		if ( empty( $site_token ) ) {
			return array();
		}

		$base_url = Nexus_License_Client::API_URL . '/api/v1/' . Nexus_License_Client::PRODUCT_SLUG;

		foreach ( $demos as $key => &$demo ) {
			// Build a signed download URL for the demo.
			$demo_slug = $demo['slug'] ?? $key;
			$timestamp = (string) time();
			$body      = '';
			$signature = hash_hmac( 'sha256', $timestamp . '|' . $body, $site_token );

			$download_url = add_query_arg(
				array(
					'signature' => $signature,
					'timestamp' => $timestamp,
					'token'     => $site_token,
				),
				$base_url . '/download-demo/' . $demo_slug
			);

			// Replace local file URLs with server URLs.
			$demo['import_file_url']            = $download_url;
			$demo['import_widget_file_url']     = $download_url;
			$demo['import_customizer_file_url'] = $download_url;
		}

		return $demos;
	}
}
