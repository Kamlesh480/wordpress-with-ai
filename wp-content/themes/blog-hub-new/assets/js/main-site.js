document.addEventListener( 'DOMContentLoaded', function () {
	// "Our Clients" logo carousel: shows a fixed-size window of logos,
	// shifted by one on each Previous/Next click. No external library —
	// just re-renders which slice of the full logo list is visible.
	var carousel = document.querySelector( '[data-blog-hub-clients]' );
	if ( ! carousel ) {
		return;
	}

	// The dots row is a sibling of the carousel strip (sits below it as its
	// own row), not a descendant, so it has to be found from their shared
	// parent <section> rather than via carousel.querySelector().
	var scope     = carousel.parentElement || carousel;
	var track     = carousel.querySelector( '[data-clients-track]' );
	var dotsWrap  = scope.querySelector( '[data-clients-dots]' );
	var prevBtn   = carousel.querySelector( '[data-clients-prev]' );
	var nextBtn   = carousel.querySelector( '[data-clients-next]' );
	var logos     = Array.prototype.slice.call( track.children );
	var visible   = parseInt( carousel.getAttribute( 'data-visible-count' ), 10 ) || 5;
	var total     = logos.length;
	var start     = 0;

	if ( total <= visible ) {
		if ( prevBtn ) {
			prevBtn.style.display = 'none';
		}
		if ( nextBtn ) {
			nextBtn.style.display = 'none';
		}
		return;
	}

	function render() {
		logos.forEach( function ( logo, i ) {
			var offset       = ( i - start + total ) % total;
			logo.style.display = offset < visible ? '' : 'none';
			logo.style.order   = offset;
		} );

		if ( dotsWrap ) {
			Array.prototype.forEach.call( dotsWrap.children, function ( dot, i ) {
				dot.classList.toggle( 'is-active', i === start );
			} );
		}
	}

	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', function () {
			start = ( start - 1 + total ) % total;
			render();
		} );
	}
	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', function () {
			start = ( start + 1 ) % total;
			render();
		} );
	}

	track.style.display = 'flex';
	render();
} );
