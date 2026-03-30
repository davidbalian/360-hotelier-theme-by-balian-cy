/**
 * FAQ accordions: height animation using @chenglou/pretext (avoids DOM measurement reflow).
 */
import { clearCache, prepare, layout } from '@chenglou/pretext';

const DURATION_MS = 380;
const EASE = 'cubic-bezier(0.22, 1, 0.36, 1)';

/** @type {WeakMap<Element, { text: string, font: string, prepared: ReturnType<typeof prepare> }>} */
let preparedCache = new WeakMap();

function fontString( el ) {
	const cs = getComputedStyle( el );
	return `${ cs.fontStyle } ${ cs.fontWeight } ${ cs.fontSize } ${ cs.fontFamily }`;
}

function lineHeightPx( el ) {
	const cs = getComputedStyle( el );
	const fs = parseFloat( cs.fontSize ) || 16;
	const lh = cs.lineHeight;
	if ( lh === 'normal' ) {
		return Math.round( fs * 1.45 );
	}
	const n = parseFloat( lh );
	return Number.isFinite( n ) ? n : Math.round( fs * 1.45 );
}

function getPrepared( inner ) {
	const text = inner.innerText.replace( /\r\n/g, '\n' ).trim();
	const font = fontString( inner );
	const prev = preparedCache.get( inner );
	if ( prev && prev.text === text && prev.font === font ) {
		return prev.prepared;
	}
	const prepared = prepare( text, font );
	preparedCache.set( inner, { text, font, prepared } );
	return prepared;
}

function measureContentHeight( inner ) {
	const w = inner.clientWidth;
	if ( w <= 0 ) {
		return 0;
	}
	const lh = lineHeightPx( inner );
	const prep = getPrepared( inner );
	const { height } = layout( prep, w, lh );
	return Math.max( 0, Math.ceil( height ) );
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
		const inner = item.querySelector( '.hotel-faq__answer-inner' );
		if ( ! trigger || ! panel || ! inner ) {
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
				const h = measureContentHeight( inner );
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

			const target = measureContentHeight( inner );
			panel.style.height = '0px';
			void panel.offsetHeight;
			requestAnimationFrame( () => {
				panel.style.height = `${ target }px`;
			} );
			setOpen( true );
		} );

		panel.addEventListener( 'transitionend', ( e ) => {
			if ( e.propertyName !== 'height' ) {
				return;
			}
			if ( item.classList.contains( 'is-open' ) ) {
				panel.style.height = 'auto';
			}
		} );
	} );

	let resizeTimer = 0;
	window.addEventListener( 'resize', () => {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( () => {
			root.querySelectorAll( '[data-hotel-faq-item].is-open' ).forEach( ( openItem ) => {
				const p = openItem.querySelector( '.hotel-faq__panel' );
				const inn = openItem.querySelector( '.hotel-faq__answer-inner' );
				if ( p && inn ) {
					p.style.height = `${ measureContentHeight( inn ) }px`;
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
		clearCache();
		preparedCache = new WeakMap();
		document.querySelectorAll( '[data-hotel-faq-item].is-open' ).forEach( ( openItem ) => {
			const p = openItem.querySelector( '.hotel-faq__panel' );
			const inn = openItem.querySelector( '.hotel-faq__answer-inner' );
			if ( p && inn ) {
				p.style.height = `${ measureContentHeight( inn ) }px`;
			}
		} );
	} );
}
