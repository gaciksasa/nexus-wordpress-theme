/**
 * Nexus Theme - WooCommerce JavaScript
 *
 * Handles: off-canvas cart, grid/list view toggle, AJAX add to cart feedback.
 *
 * @package Nexus
 */

( function ( $ ) {
	'use strict';

	const data = window.nexusWooData || {};

	$( document ).ready( function () {
		initOffcanvasCart();
		initShopViewToggle();
		initAddToCartFeedback();
	} );

	// =========================================================================
	// Off-Canvas Cart
	// =========================================================================
	function initOffcanvasCart() {
		const cart        = document.getElementById( 'nexus-offcanvas-cart' );
		const overlay     = document.querySelector( '.nexus-offcanvas-cart__overlay' );
		const closeBtn    = cart && cart.querySelector( '.nexus-offcanvas-cart__close' );
		const cartTrigger = document.querySelector( '.nexus-header__cart' );

		if ( ! cart ) return;

		function openCart( e ) {
			if ( e ) {
				e.preventDefault();
			}
			cart.hidden = false;
			requestAnimationFrame( () => {
				cart.classList.add( 'is-open' );
				if ( overlay ) {
					overlay.hidden = false;
					overlay.classList.add( 'is-visible' );
				}
			} );
			document.body.style.overflow = 'hidden';
			cart.setAttribute( 'aria-hidden', 'false' );
		}

		function closeCart() {
			cart.classList.remove( 'is-open' );
			if ( overlay ) overlay.classList.remove( 'is-visible' );
			document.body.style.overflow = '';
			cart.setAttribute( 'aria-hidden', 'true' );

			cart.addEventListener( 'transitionend', function handler() {
				cart.hidden = true;
				if ( overlay ) overlay.hidden = true;
				cart.removeEventListener( 'transitionend', handler );
			} );
		}

		if ( cartTrigger ) {
			cartTrigger.addEventListener( 'click', openCart );
		}

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeCart );
		}

		if ( overlay ) {
			overlay.addEventListener( 'click', closeCart );
		}

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && cart.classList.contains( 'is-open' ) ) {
				closeCart();
			}
		} );

		// Open cart after AJAX add to cart.
		$( document.body ).on( 'added_to_cart', function () {
			openCart( null );
		} );
	}

	// =========================================================================
	// Shop Grid/List View Toggle
	// =========================================================================
	function initShopViewToggle() {
		const viewBtns   = document.querySelectorAll( '.nexus-shop-view-btn' );
		const productList = document.querySelector( '.products' );

		if ( ! viewBtns.length || ! productList ) return;

		// Restore saved view.
		try {
			const savedView = localStorage.getItem( 'nexusShopView' ) || 'grid';
			setView( savedView, false );
		} catch ( e ) {}

		viewBtns.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				const view = this.dataset.view || 'grid';
				setView( view, true );
			} );
		} );

		function setView( view, save ) {
			viewBtns.forEach( function ( b ) {
				const isActive = b.dataset.view === view;
				b.classList.toggle( 'is-active', isActive );
				b.setAttribute( 'aria-pressed', isActive ? 'true' : 'false' );
			} );

			productList.classList.toggle( 'nexus-products--list', view === 'list' );
			productList.classList.toggle( 'nexus-products--grid', view === 'grid' );

			if ( save ) {
				try {
					localStorage.setItem( 'nexusShopView', view );
				} catch ( e ) {}
			}
		}
	}

	// =========================================================================
	// AJAX Add to Cart Feedback Toast
	// =========================================================================
	function initAddToCartFeedback() {
		$( document.body ).on( 'added_to_cart', function () {
			showToast( data.strings && data.strings.addedToCart || 'Added to cart!' );
		} );
	}

	function showToast( message ) {
		const existing = document.querySelector( '.nexus-toast' );
		if ( existing ) existing.remove();

		const toast = document.createElement( 'div' );
		toast.className = 'nexus-toast';
		toast.setAttribute( 'role', 'status' );
		toast.setAttribute( 'aria-live', 'polite' );
		toast.textContent = message;

		document.body.appendChild( toast );

		requestAnimationFrame( () => toast.classList.add( 'is-visible' ) );

		setTimeout( () => {
			toast.classList.remove( 'is-visible' );
			toast.addEventListener( 'transitionend', () => toast.remove(), { once: true } );
		}, 3000 );
	}

} )( jQuery );
