/**
 * Cookie consent: essential-only until Accept; analytics cookie + gtag only after Accept.
 */
(function () {
	var cfg = window.hotelierCookieConsent || {};
	var CHOICE_ANALYTICS = 'analytics';
	var CHOICE_ESSENTIAL = 'essential';
	var choiceKey = cfg.choiceStorageKey || 'hotelier_cookie_banner_choice';
	var legacyKey = cfg.legacyStorageKey || 'hotelier_cookies_accepted';
	var BANNER_ID = cfg.bannerId || 'hotelier-cookie-banner';
	var cookieName = cfg.analyticsCookieName || 'hotelier_ga_consent';
	var cookieValue = cfg.analyticsCookieValue || '1';
	var maxAge = typeof cfg.analyticsCookieMaxAge === 'number' ? cfg.analyticsCookieMaxAge : 31536000;
	var measurementId = cfg.measurementId || '';

	if (window.localStorage.getItem(legacyKey) && !window.localStorage.getItem(choiceKey)) {
		window.localStorage.removeItem(legacyKey);
	}

	if (!window.localStorage.getItem(choiceKey)) {
		var escaped = cookieName.replace(/[$()*+.?[\\\]^{|}]/g, '\\$&');
		var match = document.cookie.match(new RegExp('(?:^|; )' + escaped + '=([^;]*)'));
		var fromCookie = match ? decodeURIComponent(match[1]) : '';
		if (fromCookie === cookieValue) {
			window.localStorage.setItem(choiceKey, CHOICE_ANALYTICS);
		}
	}

	var banner = document.getElementById(BANNER_ID);
	var existingChoice = window.localStorage.getItem(choiceKey);

	if (!banner || existingChoice) {
		return;
	}

	banner.removeAttribute('hidden');
	banner.offsetHeight;
	banner.classList.add('is-visible');

	function secureCookieSuffix() {
		return window.location.protocol === 'https:' ? '; Secure' : '';
	}

	function setAnalyticsCookie() {
		document.cookie =
			encodeURIComponent(cookieName) +
			'=' +
			encodeURIComponent(cookieValue) +
			'; Path=/; Max-Age=' +
			maxAge +
			'; SameSite=Lax' +
			secureCookieSuffix();
	}

	function clearAnalyticsCookie() {
		document.cookie =
			encodeURIComponent(cookieName) +
			'=; Path=/; Max-Age=0; SameSite=Lax' +
			secureCookieSuffix();
	}

	function injectGtag() {
		if (!measurementId || typeof window.gtag === 'function') {
			return;
		}
		var s = document.createElement('script');
		s.async = true;
		s.src =
			'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(measurementId);
		document.head.appendChild(s);
		var inline = document.createElement('script');
		inline.textContent =
			'window.dataLayer = window.dataLayer || [];\n' +
			'function gtag(){dataLayer.push(arguments);}\n' +
			'gtag(\'js\', new Date());\n' +
			'gtag(\'config\', ' +
			JSON.stringify(measurementId) +
			');\n';
		document.head.appendChild(inline);
	}

	function finishHide() {
		banner.classList.remove('is-visible');

		var finalized = false;
		function finish() {
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
					finish();
				}
			},
			{ once: true }
		);
		window.setTimeout(finish, 500);
	}

	function onAccept() {
		window.localStorage.setItem(choiceKey, CHOICE_ANALYTICS);
		setAnalyticsCookie();
		injectGtag();
		finishHide();
	}

	function onEssentialOnly() {
		window.localStorage.setItem(choiceKey, CHOICE_ESSENTIAL);
		clearAnalyticsCookie();
		finishHide();
	}

	var accept = banner.querySelector('.cookie-banner__accept');
	var reject = banner.querySelector('.cookie-banner__reject');
	var closeBtn = banner.querySelector('.cookie-banner__close');
	if (accept) {
		accept.addEventListener('click', onAccept);
	}
	if (reject) {
		reject.addEventListener('click', onEssentialOnly);
	}
	if (closeBtn) {
		closeBtn.addEventListener('click', onEssentialOnly);
	}
})();
