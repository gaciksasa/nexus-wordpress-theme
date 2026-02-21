/**
 * Nexus Theme - Dark Mode Inline Script
 *
 * This script runs BEFORE any CSS is applied to prevent
 * Flash of Incorrect Theme (FOIT). It reads localStorage
 * and applies the dark class immediately.
 *
 * This file is inlined in the <head> via wp_head hook.
 *
 * @package Nexus
 */
( function () {
	try {
		var mode = localStorage.getItem( 'nexusDarkMode' );
		if ( mode === 'dark' || ( ! mode && window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches ) ) {
			document.documentElement.classList.add( 'nexus-dark' );
		}
	} catch ( e ) {}
} )();
