document.addEventListener( 'DOMContentLoaded', function () {
	document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( link ) {
		link.addEventListener( 'click', function ( e ) {
			var targetId = this.getAttribute( 'href' ).slice( 1 );
			var target = document.getElementById( targetId );
			if ( target ) {
				e.preventDefault();
				target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			}
		} );
	} );

	var navToggle = document.querySelector( '.bh-nav__toggle' );
	var navMenu = document.getElementById( 'bh-primary-menu' );
	if ( navToggle && navMenu ) {
		navToggle.addEventListener( 'click', function () {
			var isOpen = navMenu.classList.toggle( 'is-open' );
			navToggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
		navMenu.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', function () {
				navMenu.classList.remove( 'is-open' );
				navToggle.setAttribute( 'aria-expanded', 'false' );
			} );
		} );
	}
} );
