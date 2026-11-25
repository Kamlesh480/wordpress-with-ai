/* Landing pages (/lp/…): product index scroll-spy + click-to-load video. */
(function () {
	'use strict';

	// Product index: highlight the section currently in view.
	var links = Array.prototype.slice.call(document.querySelectorAll('[data-bh-lp-toc]'));
	if (links.length) {
		var sections = links
			.map(function (a) { return document.getElementById(a.getAttribute('data-bh-lp-toc')); })
			.filter(Boolean);
		var current = null;
		var update = function () {
			var id = sections.length ? sections[0].id : null;
			for (var i = 0; i < sections.length; i++) {
				if (sections[i].getBoundingClientRect().top < 160) {
					id = sections[i].id;
				}
			}
			if (id === current) {
				return;
			}
			current = id;
			links.forEach(function (a) {
				var on = a.getAttribute('data-bh-lp-toc') === id;
				a.classList.toggle('is-active', on);
				if (on) {
					a.setAttribute('aria-current', 'location');
				} else {
					a.removeAttribute('aria-current');
				}
			});
		};
		var ticking = false;
		window.addEventListener('scroll', function () {
			if (!ticking) {
				ticking = true;
				window.requestAnimationFrame(function () { ticking = false; update(); });
			}
		}, { passive: true });
		update();
	}

	// Video: load the YouTube player only when the visitor clicks play.
	document.querySelectorAll('[data-bh-lp-video]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var iframe = document.createElement('iframe');
			iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(btn.getAttribute('data-bh-lp-video')) + '?autoplay=1&rel=0';
			iframe.title = 'Product video';
			iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
			iframe.allowFullscreen = true;
			btn.replaceWith((function () {
				var wrap = document.createElement('div');
				wrap.className = 'bh-lp-video';
				wrap.appendChild(iframe);
				return wrap;
			})());
		});
	});
})();
