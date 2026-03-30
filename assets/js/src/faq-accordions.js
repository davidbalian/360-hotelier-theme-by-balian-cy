/**
 * FAQ accordions: animate panel height using a single off-screen layout read.
 *
 * Plain-text layout (e.g. @chenglou/pretext) cannot match block margins, list
 * rhythm, and wrapper padding; undershooting causes mid-animation clipping and
 * a snap when switching to height: auto. scrollHeight on the panel after a
 * width-locked auto-height pass matches the real layout.
 */

const DURATION_MS = 380;
const EASE = 'cubic-bezier(0.22, 1, 0.36, 1)';

/**
 * Natural height of the panel including .hotel-faq__panel-inner padding and
 * block margins — one layout pass, visually hidden.
 *
 * @param {HTMLElement} panel
 * @param {HTMLElement} item
 * @returns {number}
 */
function measurePanelNaturalHeight( panel, item ) {
	const widthPx = Math.round( item.getBoundingClientRect().width );
	const prev = {
		overflow: panel.style.overflow,
		visibility: panel.style.visibility,
		position: panel.style.position,
		left: panel.style.left,
		width: panel.style.width,
		height: panel.style.height,
	};

	panel.style.overflow = 'visible';
	panel.style.visibility = 'hidden';
	panel.style.position = 'absolute';
	panel.style.left = '-9999px';
	panel.style.width = `${ widthPx }px`;
	panel.style.height = 'auto';

	const h = Math.ceil( panel.scrollHeight );

	panel.style.overflow = prev.overflow;
	panel.style.visibility = prev.visibility;
	panel.style.position = prev.position;
	panel.style.left = prev.left;
	panel.style.width = prev.width;
	panel.style.height = prev.height;
	void panel.offsetHeight;

	return Math.max( 0, h );
}

/**
 * Pixel height to animate from when closing (handles inline height "auto").
 *
 * @param {HTMLElement} panel
 * @returns {number}
 */
function readAnimatedHeightPx( panel ) {
	const inline = panel.style.height;
	if ( inline && inline !== 'auto' && inline.endsWith( 'px' ) ) {
		const n = parseFloat( inline );
		if ( Number.isFinite( n ) ) {
			return Math.ceil( n );
		}
	}
	return Math.ceil( panel.scrollHeight );
}

function prefersReducedMotion() {
	return window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
}

/**
 * @param {HTMLElement} root
 */
function initHotelierFaq( root ) {
	const items = root.querySelectorAll( '[data-hotel-faq-item]' );

	items.forEach( ( item ) => {
		const trigger = item.querySelector( '.hotel-faq__trigger' );
		const panel = item.querySelector( '.hotel-faq__panel' );
		if ( ! trigger || ! panel ) {
			return;
		}

		panel.style.overflow = 'hidden';
		panel.style.height = '0px';
		if ( ! prefersReducedMotion() ) {
			panel.style.transitionProperty = 'height';
			panel.style.transitionDuration = `${ DURATION_MS }ms`;
			panel.style.transitionTimingFunction = EASE;
		}

		function setOpen( open ) {
			item.classList.toggle( 'is-open', open );
			trigger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			panel.setAttribute( 'aria-hidden', open ? 'false' : 'true' );
		}

		trigger.addEventListener( 'click', () => {
			const isOpen = item.classList.contains( 'is-open' );

			if ( isOpen ) {
				if ( prefersReducedMotion() ) {
					setOpen( false );
					panel.style.height = '0px';
					return;
				}
				const h = readAnimatedHeightPx( panel );
				panel.style.height = `${ h }px`;
				void panel.offsetHeight;
				requestAnimationFrame( () => {
					panel.style.height = '0px';
				} );
				setOpen( false );
				return;
			}

			if ( prefersReducedMotion() ) {
				setOpen( true );
				panel.style.height = 'auto';
				return;
			}

			const target = measurePanelNaturalHeight( panel, item );
			panel.style.height = '0px';
			void panel.offsetHeight;
			requestAnimationFrame( () => {
				panel.style.height = `${ target }px`;
			} );
			setOpen( true );
		} );
	} );

	let resizeTimer = 0;
	window.addEventListener( 'resize', () => {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( () => {
			root.querySelectorAll( '[data-hotel-faq-item].is-open' ).forEach( ( openItem ) => {
				const p = openItem.querySelector( '.hotel-faq__panel' );
				if ( p ) {
					const h = measurePanelNaturalHeight( p, openItem );
					p.style.height = `${ h }px`;
				}
			} );
		}, 120 );
	} );
}

function initAll() {
	document.querySelectorAll( '[data-hotel-faq]' ).forEach( ( el ) => {
		initHotelierFaq( el );
	} );
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initAll );
} else {
	initAll();
}

if ( document.fonts && document.fonts.ready ) {
	document.fonts.ready.then( () => {
		document.querySelectorAll( '[data-hotel-faq-item].is-open' ).forEach( ( openItem ) => {
			const p = openItem.querySelector( '.hotel-faq__panel' );
			if ( p ) {
				p.style.height = `${ measurePanelNaturalHeight( p, openItem ) }px`;
			}
		} );
	} );
}
