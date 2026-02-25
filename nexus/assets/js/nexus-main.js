/**
 * Nexus Theme - Main JavaScript
 *
 * Core interactions: mobile menu, sticky header, back to top,
 * dark mode toggle, search popup, dropdown keyboard nav.
 *
 * @package Nexus
 */

( function () {
	'use strict';

	// Wait for DOM ready.
	document.addEventListener( 'DOMContentLoaded', init );

	const data = window.nexusData || {};

	function init() {
		initStickyHeader();
		initMobileMenu();
		initDropdownKeyboard();
		initSearchPopup();
		initBackToTop();
		initPreloader();
		initDarkMode();
		initReadingProgress();
	}

	// =========================================================================
	// Sticky Header
	// =========================================================================
	function initStickyHeader() {
		const header = document.getElementById( 'nexus-masthead' );
		if ( ! header ) return;

		let lastScroll = 0;

		const onScroll = () => {
			const scrollY = window.scrollY || window.pageYOffset;

			if ( scrollY > 80 ) {
				header.classList.add( 'is-sticky' );
			} else {
				header.classList.remove( 'is-sticky' );
			}

			lastScroll = scrollY;
		};

		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	// =========================================================================
	// Mobile Menu
	// =========================================================================
	function initMobileMenu() {
		const hamburger = document.querySelector( '.nexus-hamburger' );
		const mobileNav = document.getElementById( 'nexus-mobile-menu' );
		const overlay   = document.querySelector( '.nexus-mobile-nav__overlay' );
		const closeBtn  = document.querySelector( '.nexus-mobile-nav__close' );

		if ( ! hamburger || ! mobileNav ) return;

		function openMenu() {
			mobileNav.hidden = false;
			mobileNav.classList.add( 'is-open' );
			hamburger.setAttribute( 'aria-expanded', 'true' );

			if ( overlay ) {
				overlay.hidden = false;
				requestAnimationFrame( () => overlay.classList.add( 'is-visible' ) );
			}

			document.body.style.overflow = 'hidden';
			mobileNav.focus();
		}

		function closeMenu() {
			mobileNav.classList.remove( 'is-open' );
			hamburger.setAttribute( 'aria-expanded', 'false' );

			if ( overlay ) {
				overlay.classList.remove( 'is-visible' );
				overlay.addEventListener( 'transitionend', () => {
					overlay.hidden = true;
				}, { once: true } );
			}

			document.body.style.overflow = '';
			hamburger.focus();

			mobileNav.addEventListener( 'transitionend', () => {
				mobileNav.hidden = true;
			}, { once: true } );
		}

		hamburger.addEventListener( 'click', openMenu );

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeMenu );
		}

		if ( overlay ) {
			overlay.addEventListener( 'click', closeMenu );
		}

		// Close on Escape key.
		document.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Escape' && mobileNav.classList.contains( 'is-open' ) ) {
				closeMenu();
			}
		} );
	}

	// =========================================================================
	// Dropdown keyboard navigation (ARIA menubar pattern)
	// =========================================================================
	function initDropdownKeyboard() {
		const menuItems = document.querySelectorAll( '.nexus-menu-item--has-dropdown > a' );

		menuItems.forEach( ( toggle ) => {
			const dropdown = toggle.nextElementSibling;
			if ( ! dropdown ) return;

			toggle.addEventListener( 'keydown', ( e ) => {
				if ( e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ' ) {
					e.preventDefault();
					toggle.setAttribute( 'aria-expanded', 'true' );
					const firstItem = dropdown.querySelector( 'a' );
					if ( firstItem ) firstItem.focus();
				}
			} );

			dropdown.addEventListener( 'keydown', ( e ) => {
				if ( e.key === 'Escape' ) {
					toggle.setAttribute( 'aria-expanded', 'false' );
					toggle.focus();
				}
			} );

			// Close on outside click.
			document.addEventListener( 'click', ( e ) => {
				if ( ! toggle.closest( '.nexus-menu-item--has-dropdown' ).contains( e.target ) ) {
					toggle.setAttribute( 'aria-expanded', 'false' );
				}
			} );
		} );
	}

	// =========================================================================
	// Search Popup
	// =========================================================================
	function initSearchPopup() {
		const toggleBtn  = document.querySelector( '.nexus-header__search-toggle' );
		const popup      = document.getElementById( 'nexus-search-popup' );
		const closeBtn   = popup && popup.querySelector( '.nexus-search-popup__close' );
		const searchInput = popup && popup.querySelector( 'input[type="search"]' );

		if ( ! toggleBtn || ! popup ) return;

		function openSearch() {
			popup.hidden = false;
			toggleBtn.setAttribute( 'aria-expanded', 'true' );
			requestAnimationFrame( () => popup.classList.add( 'is-open' ) );
			if ( searchInput ) {
				searchInput.focus();
			}
		}

		function closeSearch() {
			popup.classList.remove( 'is-open' );
			toggleBtn.setAttribute( 'aria-expanded', 'false' );
			popup.addEventListener( 'transitionend', () => {
				popup.hidden = true;
			}, { once: true } );
			toggleBtn.focus();
		}

		toggleBtn.addEventListener( 'click', openSearch );

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeSearch );
		}

		// Close on overlay click.
		popup.addEventListener( 'click', ( e ) => {
			if ( e.target === popup ) closeSearch();
		} );

		document.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Escape' && popup.classList.contains( 'is-open' ) ) {
				closeSearch();
			}
		} );
	}

	// =========================================================================
	// Back to Top Button
	// =========================================================================
	function initBackToTop() {
		if ( ! data.options || ! data.options.backToTop ) return;

		const btn = document.querySelector( '.nexus-back-to-top' );
		if ( ! btn ) return;

		window.addEventListener( 'scroll', () => {
			if ( window.scrollY > 400 ) {
				btn.hidden = false;
			} else {
				btn.hidden = true;
			}
		}, { passive: true } );

		btn.addEventListener( 'click', () => {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}

	// =========================================================================
	// Preloader
	// =========================================================================
	function initPreloader() {
		if ( ! data.options || ! data.options.preloader ) return;

		const preloader = document.getElementById( 'nexus-preloader' );
		if ( ! preloader ) return;

		window.addEventListener( 'load', () => {
			preloader.classList.add( 'is-loaded' );
			preloader.addEventListener( 'transitionend', () => {
				preloader.remove();
			}, { once: true } );
		} );
	}

	// =========================================================================
	// Dark Mode Toggle
	// =========================================================================
	function initDarkMode() {
		const toggles = document.querySelectorAll( '.nexus-header__dark-toggle' );
		if ( ! toggles.length ) return;

		function isDark() {
			return document.documentElement.classList.contains( 'nexus-dark' );
		}

		function setDark( dark ) {
			document.documentElement.classList.toggle( 'nexus-dark', dark );
			toggles.forEach( ( btn ) => {
				btn.setAttribute( 'aria-pressed', dark ? 'true' : 'false' );
			} );
			try {
				localStorage.setItem( 'nexusDarkMode', dark ? 'dark' : 'light' );
			} catch ( e ) {}
		}

		toggles.forEach( ( btn ) => {
			btn.setAttribute( 'aria-pressed', isDark() ? 'true' : 'false' );
			btn.addEventListener( 'click', () => {
				setDark( ! isDark() );
			} );
		} );
	}

	// =========================================================================
	// Reading Progress Bar
	// =========================================================================
	function initReadingProgress() {
		const bar = document.getElementById( 'nexus-reading-progress' );
		if ( ! bar ) return;

		const fill = bar.querySelector( '.nexus-reading-progress__fill' );
		if ( ! fill ) return;

		const update = () => {
			const scrollTop  = window.scrollY || window.pageYOffset;
			const docHeight  = document.documentElement.scrollHeight - window.innerHeight;
			const progress   = docHeight > 0 ? ( scrollTop / docHeight ) * 100 : 0;
			const clamped    = Math.min( 100, Math.max( 0, progress ) );
			fill.style.width = clamped + '%';
			bar.setAttribute( 'aria-valuenow', Math.round( clamped ) );
		};

		window.addEventListener( 'scroll', update, { passive: true } );
		update();
	}

} )();
