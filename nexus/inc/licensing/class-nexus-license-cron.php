<?php
/**
 * License verification cron job — runs twice daily.
 *
 * @package Nexus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Nexus_License_Cron
 */
class Nexus_License_Cron {

	const HOOK = 'nexus_license_verify';

	/**
	 * Initialize hooks.
	 */
	public static function init(): void {
		add_action( self::HOOK, array( __CLASS__, 'run_verification' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'schedule' ) );
		add_action( 'switch_theme', array( __CLASS__, 'unschedule' ) );
	}

	/**
	 * Schedule the cron event if not already scheduled.
	 */
	public static function schedule(): void {
		if ( ! wp_next_scheduled( self::HOOK ) ) {
			wp_schedule_event( time(), 'twicedaily', self::HOOK );
		}
	}

	/**
	 * Remove the cron event on theme switch.
	 */
	public static function unschedule(): void {
		$timestamp = wp_next_scheduled( self::HOOK );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, self::HOOK );
		}
	}

	/**
	 * Run the license verification.
	 *
	 * Fail-open: if the server is unreachable, the license stays active.
	 * Only auto-deactivates on explicit 403 (blocked/revoked).
	 */
	public static function run_verification(): void {
		if ( ! nexus_is_activated() ) {
			return;
		}

		$client = Nexus_License_Client::instance();
		$result = $client->verify();

		// On WP_Error — check if it's a definitive rejection.
		if ( is_wp_error( $result ) ) {
			$code = $result->get_error_code();

			// Server unreachable or timeout — fail open, do nothing.
			if ( in_array( $code, array( 'http_request_failed', 'invalid_response' ), true ) ) {
				return;
			}

			// 403 = blocked/revoked, 404 = not found — auto-deactivate.
			if ( in_array( $code, array( 'http_403', 'http_404' ), true ) ) {
				// The client already clears local data on these errors.
				do_action( 'nexus_license_auto_deactivated', $result );
			}
		}
	}
}
