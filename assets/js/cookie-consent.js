/**
 * Cookie consent banner: show once until accepted or dismissed (localStorage).
 */
(function () {
	var cfg = window.hotelierCookieConsent || {};
	var STORAGE_KEY = cfg.storageKey || 'hotelier_cookies_accepted';
	var BANNER_ID = cfg.bannerId || 'hotelier-cookie-banner';
	var banner = document.getElementById(BANNER_ID);

	if (!banner || window.localStorage.getItem(STORAGE_KEY)) {
		return;
	}

	banner.removeAttribute('hidden');
	banner.offsetHeight;
	banner.classList.add('is-visible');

	function dismissBanner() {
		window.localStorage.setItem(STORAGE_KEY, '1');
		banner.classList.remove('is-visible');

		var finalized = false;
		function finishHide() {
			if (finalized) {
				return;
			}
			finalized = true;
			banner.setAttribute('hidden', '');
		}

		banner.addEventListener(
			'transitionend',
			function (e) {
				if (e.target === banner) {
					finishHide();
				}
			},
			{ once: true }
		);
		window.setTimeout(finishHide, 500);
	}

	var accept = banner.querySelector('.cookie-banner__accept');
	var closeBtn = banner.querySelector('.cookie-banner__close');
	if (accept) {
		accept.addEventListener('click', dismissBanner);
	}
	if (closeBtn) {
		closeBtn.addEventListener('click', dismissBanner);
	}
})();
