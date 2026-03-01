/**
 * Nexus Theme - Customizer Live Preview.
 *
 * Runs inside the preview iframe. Updates CSS custom properties in real time
 * when color settings change via postMessage transport.
 *
 * @package Nexus
 */

/* global wp */
( function() {
	'use strict';

	/**
	 * Helper: convert hex (#rrggbb) to "r, g, b" string for rgba() usage.
	 */
	function hexToRgb( hex ) {
		hex = hex.replace( /^#/, '' );
		var r = parseInt( hex.substring( 0, 2 ), 16 );
		var g = parseInt( hex.substring( 2, 4 ), 16 );
		var b = parseInt( hex.substring( 4, 6 ), 16 );
		return r + ', ' + g + ', ' + b;
	}

	/**
	 * Map of Customizer setting → CSS custom properties to update.
	 */
	var colorBindings = {
		nexus_primary_color: [
			'--nexus-color-primary',
			'--nexus-primary',
			'--nexus-heading-color',
			'--nexus-bg-dark'
		],
		nexus_secondary_color: [
			'--nexus-color-secondary',
			'--nexus-secondary'
		],
		nexus_accent_color: [
			'--nexus-color-accent'
		],
		nexus_dark_color: [
			'--nexus-color-dark'
		],
		nexus_light_color: [
			'--nexus-color-light',
			'--nexus-bg-subtle'
		]
	};

	// Bind each color setting to live-update CSS custom properties.
	Object.keys( colorBindings ).forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( newVal ) {
				var root = document.documentElement;

				colorBindings[ setting ].forEach( function( prop ) {
					root.style.setProperty( prop, newVal );
				} );

				// Update RGB variants for rgba() usage.
				if ( setting === 'nexus_primary_color' ) {
					root.style.setProperty( '--nexus-primary-rgb', hexToRgb( newVal ) );
				}
				if ( setting === 'nexus_secondary_color' ) {
					root.style.setProperty( '--nexus-secondary-rgb', hexToRgb( newVal ) );
				}
			} );
		} );
	} );

} )();
