<?php
/**
 * Nexus Theme Functions
 *
 * This file is intentionally kept thin. All functionality is delegated to
 * files within the /inc directory to keep things organized and maintainable.
 *
 * @package Nexus
 * @version 1.0.0
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define theme constants.
define( 'NEXUS_VERSION', '1.0.0' );
define( 'NEXUS_DIR', get_parent_theme_file_path() );
define( 'NEXUS_URI', get_parent_theme_file_uri() );
define( 'NEXUS_ASSETS_URI', NEXUS_URI . '/assets' );
define( 'NEXUS_ASSETS_DIR', NEXUS_DIR . '/assets' );
define( 'NEXUS_INC_DIR', NEXUS_DIR . '/inc' );
define( 'NEXUS_MIN_WP', '6.3' );
define( 'NEXUS_MIN_PHP', '8.0' );

// Load the master include file.
require_once NEXUS_INC_DIR . '/init.php';
