/**
 * Nexus Theme - Customizer Palette Switching Logic.
 *
 * Loaded only in the Customizer controls panel.
 *
 * @package Nexus
 */

/* global wp */
( function( $ ) {
	'use strict';

	var palettes = {
		'default': {
			primary:   '#1a1a2e',
			secondary: '#e94560',
			accent:    '#0f3460',
			dark:      '#16213e',
			light:     '#f8f9fa'
		},
		'ocean-breeze': {
			primary:   '#1b2a4a',
			secondary: '#2196f3',
			accent:    '#00bcd4',
			dark:      '#0d1b2a',
			light:     '#f0f7ff'
		},
		'forest-green': {
			primary:   '#1b3a2d',
			secondary: '#4caf50',
			accent:    '#81c784',
			dark:      '#0d2618',
			light:     '#f1f8f2'
		},
		'royal-purple': {
			primary:   '#2d1b4e',
			secondary: '#9c27b0',
			accent:    '#ce93d8',
			dark:      '#1a0e30',
			light:     '#f5f0f9'
		},
		'sunset-warm': {
			primary:   '#2d1f1a',
			secondary: '#ff6f00',
			accent:    '#ffab40',
			dark:      '#1a120d',
			light:     '#fff8f0'
		},
		'slate-modern': {
			primary:   '#1e293b',
			secondary: '#3b82f6',
			accent:    '#6366f1',
			dark:      '#0f172a',
			light:     '#f1f5f9'
		},
		'corporate-blue': {
			primary:   '#003366',
			secondary: '#0066cc',
			accent:    '#4a90d9',
			dark:      '#00244d',
			light:     '#f4f7fb'
		},
		'executive-dark': {
			primary:   '#1c1c1c',
			secondary: '#c8a961',
			accent:    '#8b7d3c',
			dark:      '#111111',
			light:     '#f7f6f3'
		},
		'consulting-gold': {
			primary:   '#2c3e50',
			secondary: '#d4a843',
			accent:    '#1abc9c',
			dark:      '#1a252f',
			light:     '#faf8f4'
		}
	};

	var colorMap = {
		primary:   'nexus_primary_color',
		secondary: 'nexus_secondary_color',
		accent:    'nexus_accent_color',
		dark:      'nexus_dark_color',
		light:     'nexus_light_color'
	};

	/**
	 * Apply a palette's colors to all 5 color controls.
	 */
	function applyPalette( paletteKey ) {
		var palette = palettes[ paletteKey ];
		if ( ! palette ) {
			return;
		}

		$.each( colorMap, function( key, setting ) {
			var control = wp.customize.control( setting );
			if ( control ) {
				wp.customize( setting ).set( palette[ key ] );
			}
		} );
	}

	wp.customize.bind( 'ready', function() {

		// When palette selector changes, apply that palette's colors.
		wp.customize( 'nexus_color_palette', function( setting ) {
			setting.bind( function( newValue ) {
				applyPalette( newValue );
			} );
		} );

		// Reset button — resets colors to current palette defaults.
		$( document ).on( 'click', '#nexus-palette-reset', function( e ) {
			e.preventDefault();
			var currentPalette = wp.customize( 'nexus_color_palette' ).get();
			applyPalette( currentPalette );
		} );
	} );

}( jQuery ) );
