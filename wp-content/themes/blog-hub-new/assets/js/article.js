document.addEventListener( 'DOMContentLoaded', function () {
	// Scroll-spy: highlight the active Table of Contents entry as its
	// matching <h2 id="..."> scrolls into the reading viewport.
	var rail = document.querySelector( '[data-blog-hub-article-rail]' );
	if ( rail ) {
		var tocLinks = rail.querySelectorAll( '[data-toc-target]' );
		var headings = Array.prototype.map
			.call( tocLinks, function ( link ) {
				return document.getElementById( link.getAttribute( 'data-toc-target' ) );
			} )
			.filter( Boolean );

		if ( headings.length && 'IntersectionObserver' in window ) {
			var setActive = function ( id ) {
				tocLinks.forEach( function ( link ) {
					link.classList.toggle( 'is-active', link.getAttribute( 'data-toc-target' ) === id );
				} );
			};

			var observer = new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							setActive( entry.target.id );
						}
					} );
				},
				{ rootMargin: '-20% 0px -70% 0px' }
			);

			headings.forEach( function ( el ) {
				observer.observe( el );
			} );
		}
	}

	// Back-to-top button: fade in after scrolling past one viewport height.
	var backToTop = document.querySelector( '[data-blog-hub-back-to-top]' );
	if ( backToTop ) {
		var toggleVisibility = function () {
			backToTop.classList.toggle( 'is-visible', window.scrollY > window.innerHeight );
		};
		window.addEventListener( 'scroll', toggleVisibility, { passive: true } );
		toggleVisibility();

		backToTop.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}
} );
