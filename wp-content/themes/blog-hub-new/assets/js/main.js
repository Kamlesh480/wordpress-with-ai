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

	initHeader();
	initMobileMenu();
	initBackToTop();
} );

/**
 * Sticky header: adds a shadow once the page has scrolled, and wires up the
 * desktop Products/Areas/Blog dropdowns (hover on pointer devices, click/
 * Enter for keyboard + touch so nothing is mouse-only).
 */
function initHeader() {
	var header = document.querySelector( '[data-bh-header]' );
	if ( ! header ) {
		return;
	}

	var onScroll = function () {
		header.classList.toggle( 'is-scrolled', window.scrollY > 10 );
	};
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();

	var items = header.querySelectorAll( '.bh-menu__item--dropdown' );
	items.forEach( function ( item ) {
		var toggle = item.querySelector( '.bh-menu__toggle' );
		if ( ! toggle ) {
			return;
		}
		var close = function () {
			item.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		};
		var open = function () {
			items.forEach( function ( other ) {
				if ( other !== item ) {
					other.classList.remove( 'is-open' );
					var otherToggle = other.querySelector( '.bh-menu__toggle' );
					if ( otherToggle ) {
						otherToggle.setAttribute( 'aria-expanded', 'false' );
					}
				}
			} );
			item.classList.add( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'true' );
		};
		toggle.addEventListener( 'click', function () {
			if ( item.classList.contains( 'is-open' ) ) {
				close();
			} else {
				open();
			}
		} );
		item.addEventListener( 'mouseenter', open );
		item.addEventListener( 'mouseleave', close );
		item.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) {
				close();
				toggle.focus();
			}
		} );
	} );

	document.addEventListener( 'click', function ( e ) {
		items.forEach( function ( item ) {
			if ( ! item.contains( e.target ) ) {
				item.classList.remove( 'is-open' );
				var toggle = item.querySelector( '.bh-menu__toggle' );
				if ( toggle ) {
					toggle.setAttribute( 'aria-expanded', 'false' );
				}
			}
		} );
	} );
}

/**
 * Mobile slide-in panel: open/close via the burger + close buttons and the
 * backdrop, plus the stacked Products/Areas/Blog sub-lists toggling open
 * in place (no flyouts on small screens).
 */
function initMobileMenu() {
	var burger   = document.querySelector( '[data-bh-burger]' );
	var panel    = document.querySelector( '[data-bh-mobile-menu]' );
	var backdrop = document.querySelector( '[data-bh-backdrop]' );
	var closeBtn = document.querySelector( '[data-bh-close]' );
	if ( ! burger || ! panel ) {
		return;
	}

	var open = function () {
		panel.hidden = false;
		if ( backdrop ) {
			backdrop.hidden = false;
		}
		requestAnimationFrame( function () {
			panel.classList.add( 'is-open' );
		} );
		burger.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';
	};
	var close = function () {
		panel.classList.remove( 'is-open' );
		burger.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = '';
		setTimeout( function () {
			panel.hidden = true;
			if ( backdrop ) {
				backdrop.hidden = true;
			}
		}, 250 );
	};

	burger.addEventListener( 'click', open );
	if ( closeBtn ) {
		closeBtn.addEventListener( 'click', close );
	}
	if ( backdrop ) {
		backdrop.addEventListener( 'click', close );
	}
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && panel.classList.contains( 'is-open' ) ) {
			close();
		}
	} );

	panel.querySelectorAll( '.bh-mobile-menu__toggle' ).forEach( function ( toggle ) {
		var sublist = document.getElementById( toggle.getAttribute( 'aria-controls' ) );
		if ( ! sublist ) {
			return;
		}
		toggle.addEventListener( 'click', function () {
			var isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
			sublist.hidden = isOpen;
		} );
	} );

	panel.querySelectorAll( '.bh-mobile-menu__link:not(.bh-mobile-menu__toggle)' ).forEach( function ( link ) {
		link.addEventListener( 'click', close );
	} );
}

/**
 * Footer "back to top" button: hidden until the page has scrolled.
 */
function initBackToTop() {
	var btn = document.querySelector( '[data-bh-to-top]' );
	if ( ! btn ) {
		return;
	}
	var onScroll = function () {
		btn.hidden = window.scrollY < 400;
	};
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();
	btn.addEventListener( 'click', function () {
		var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		window.scrollTo( { top: 0, behavior: reduce ? 'auto' : 'smooth' } );
	} );
}
