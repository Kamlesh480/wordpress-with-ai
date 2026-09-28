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
} );
