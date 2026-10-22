document.addEventListener( 'DOMContentLoaded', function () {
	// Scroll-spy: highlight the active Table of Contents entry as its
	// matching <h2 id="..."> scrolls into the reading viewport.
	var rail = document.querySelector( '[data-blog-hub-article-rail]' );
	if ( rail ) {
		var tocLinks = rail.querySelectorAll( '[data-toc-target]' );

		// Repair pass: blog_hub_toc_from_content() injects id="" into plain
		// <h2> tags in the raw post content, but a page builder (e.g.
		// Elementor) can re-render the article body from its own stored
		// widget data afterward, discarding that injected id. When a TOC
		// link's target id isn't actually in the page, find the <h2> with
		// matching visible text inside the article body and assign the id
		// to it directly, so the link and scroll-spy both still work.
		var articleBody = document.querySelector( '.bh-article-content' );
		if ( articleBody ) {
			tocLinks.forEach( function ( link ) {
				var targetId = link.getAttribute( 'data-toc-target' );
				if ( document.getElementById( targetId ) ) {
					return;
				}
				var label = link.textContent.trim();
				var heading = Array.prototype.find.call(
					articleBody.querySelectorAll( 'h2' ),
					function ( h2 ) {
						return h2.textContent.trim() === label && ! h2.id;
					}
				);
				if ( heading ) {
					heading.id = targetId;
				}
			} );
		}

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
